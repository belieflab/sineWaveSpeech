<?php
/**
 * One-off Pre/Post stimulus splitter for the monroeStudy sineWaveSpeech task.
 *
 * The new stimulus set arrives as three flat folders:
 *
 *   stim/intel/      84 sine-wave-speech files whose targets are judged intelligible
 *   stim/unintel/    84 sine-wave-speech files whose targets are judged unintelligible
 *   stim/unaltered/  333 clear originals (targets + distractors)
 *
 * Each degraded file encodes its provenance in the filename:
 *
 *   I_16_band_30_smooth_6_snr_T_BKBQ0102.WAV_D_BKBQ0204.WAV
 *                               ^target          ^distractor
 *
 * The task needs each visit (Pre / Post) to draw from a disjoint pool, and needs
 * the clear original of every tested target available in the same visit's folder
 * so the listening block can expose it. This script produces that layout:
 *
 *   stim/{intel,unintel}/{pre,post}/     the degraded stimuli, split by visit
 *   stim/unaltered/{pre,post}/           the clear originals of those targets
 *   stim/unaltered/distractors/          the clear originals of the distractors
 *                                        (not used by the task; kept for provenance)
 *   stim/dropped/                        degraded stimuli excluded from the study
 *                                        because their clear original is missing
 *
 * Split rule: within each condition, targets are grouped by BKB list (the first
 * two digits of BKBQnnxx, lists 01-21), sorted, and dealt alternately to Pre and
 * Post. The starting side flips after every odd-sized list so the leftovers do
 * not all accumulate on one side -- always starting on Pre yields a 45/37 split
 * for intel rather than 41/41.
 *
 * Usage:
 *   php split_pre_post.php --dry-run    report what would move, touch nothing
 *   php split_pre_post.php              perform the split
 *   php split_pre_post.php --verify     check the integrity of an existing split
 */

$root    = __DIR__;
$dryRun  = in_array('--dry-run', $argv, true);
$verify  = in_array('--verify', $argv, true);

// Targets with no clear original in stim/unaltered/. Confirmed absent, and
// dropped by decision: without the original there is nothing to expose in the
// listening block, which would leave those items uncontrolled.
const DROPPED_TARGETS = ['BKBQ0313', 'BKBQ1901', 'BKBQ0314'];

const CONDITIONS = ['intel', 'unintel'];
const VISITS     = ['pre', 'post'];

function fail(string $msg): void {
    fwrite(STDERR, "ERROR: {$msg}\n");
    exit(1);
}

/** List *.wav files (any case) directly inside $dir, sorted, basenames only. */
function wavFiles(string $dir): array {
    if (!is_dir($dir)) {
        return [];
    }
    $out = [];
    foreach (scandir($dir) as $entry) {
        if ($entry === '.' || $entry === '..') {
            continue;
        }
        if (!is_file($dir . DIRECTORY_SEPARATOR . $entry)) {
            continue; // skip nested directories
        }
        if (strtolower(pathinfo($entry, PATHINFO_EXTENSION)) !== 'wav') {
            continue;
        }
        $out[] = $entry;
    }
    sort($out, SORT_STRING);
    return $out;
}

/** BKBQ id of the target sentence, from either a degraded or a clear filename. */
function parseTargetId(string $filename): ?string {
    if (preg_match('/_T_(BKBQ\d+)\.wav_D_/i', $filename, $m)) {
        return strtoupper($m[1]);          // degraded: ..._T_BKBQ0102.WAV_D_BKBQ0204.WAV
    }
    if (preg_match('/^(BKBQ\d+)\.wav$/i', $filename, $m)) {
        return strtoupper($m[1]);          // clear: BKBQ0102.WAV
    }
    return null;
}

/** BKBQ id of the competing talker, or null for a clear file. */
function parseDistractorId(string $filename): ?string {
    if (preg_match('/_D_(BKBQ\d+)\.wav$/i', $filename, $m)) {
        return strtoupper($m[1]);
    }
    return null;
}

/** BKB list number, e.g. BKBQ0102 -> "01". */
function listOf(string $targetId): string {
    return substr($targetId, 4, 2);
}

function relative(string $path): string {
    return 'stim/' . ltrim(str_replace(__DIR__, '', $path), '/\\');
}

// ---------------------------------------------------------------- verify mode
if ($verify) {
    $problems = 0;
    $seenTargets = [];

    foreach (CONDITIONS as $cond) {
        $byVisit = [];
        foreach (VISITS as $visit) {
            $files   = wavFiles("{$root}/{$cond}/{$visit}");
            $targets = [];
            foreach ($files as $f) {
                $id = parseTargetId($f);
                if ($id === null) {
                    echo "  ! unparseable filename: {$cond}/{$visit}/{$f}\n";
                    $problems++;
                    continue;
                }
                $targets[] = $id;

                // the clear original must sit in the SAME visit folder
                if (!is_file("{$root}/unaltered/{$visit}/{$id}.WAV")) {
                    echo "  ! no unaltered/{$visit}/{$id}.WAV for {$cond}/{$visit}/{$f}\n";
                    $problems++;
                }
            }
            $byVisit[$visit] = $targets;
            printf("  %-8s %-5s %3d files\n", $cond, $visit, count($files));
        }

        $overlap = array_intersect($byVisit['pre'], $byVisit['post']);
        if ($overlap) {
            echo "  ! {$cond}: " . count($overlap) . " target(s) in BOTH visits: "
               . implode(', ', $overlap) . "\n";
            $problems++;
        }

        foreach ($byVisit as $visit => $targets) {
            foreach ($targets as $t) {
                if (isset($seenTargets[$t])) {
                    echo "  ! target {$t} appears in both {$seenTargets[$t]} and {$cond}/{$visit}\n";
                    $problems++;
                }
                $seenTargets[$t] = "{$cond}/{$visit}";
            }
        }
    }

    foreach (VISITS as $visit) {
        printf("  %-8s %-5s %3d files\n", 'unaltered', $visit, count(wavFiles("{$root}/unaltered/{$visit}")));
    }
    printf("  %-8s %-5s %3d files\n", 'unaltered', 'dist', count(wavFiles("{$root}/unaltered/distractors")));

    // stray files left at the top level of a condition folder would be invisible
    // to the task but signal an incomplete split
    foreach (['intel', 'unintel', 'unaltered'] as $dir) {
        $stray = wavFiles("{$root}/{$dir}");
        if ($stray) {
            echo "  ! " . count($stray) . " unsplit file(s) still at top level of {$dir}/\n";
            $problems++;
        }
    }

    // BKB list balance
    foreach (CONDITIONS as $cond) {
        $counts = [];
        foreach (VISITS as $visit) {
            foreach (wavFiles("{$root}/{$cond}/{$visit}") as $f) {
                $counts[listOf(parseTargetId($f))][$visit] = ($counts[listOf(parseTargetId($f))][$visit] ?? 0) + 1;
            }
        }
        ksort($counts);
        $line = [];
        foreach ($counts as $lst => $c) {
            $line[] = $lst . ':' . ($c['pre'] ?? 0) . '/' . ($c['post'] ?? 0);
        }
        echo "  {$cond} by BKB list (pre/post): " . implode('  ', $line) . "\n";
    }

    echo $problems === 0 ? "\nOK: split is consistent.\n" : "\n{$problems} problem(s) found.\n";
    exit($problems === 0 ? 0 : 1);
}

// ----------------------------------------------------------------- split mode
echo ($dryRun ? "DRY RUN -- nothing will be moved\n\n" : "Splitting stimuli\n\n");

// Index the clear originals by BKBQ id.
$unalteredFiles = wavFiles("{$root}/unaltered");
if (!$unalteredFiles) {
    fail("no .wav files at the top level of stim/unaltered/ -- already split? run --verify");
}
$clearById = [];
foreach ($unalteredFiles as $f) {
    $id = parseTargetId($f);
    if ($id === null) {
        fail("cannot parse a BKBQ id from unaltered/{$f}");
    }
    if (isset($clearById[$id])) {
        fail("duplicate clear original for {$id}: {$clearById[$id]} and {$f}");
    }
    $clearById[$id] = $f;
}
echo "  indexed " . count($clearById) . " clear originals\n";

// Parse the degraded stimuli.
$stimuli    = [];   // condition => [ ['file'=>, 'target'=>, 'distractor'=>], ... ]
$dropped    = [];
$distractors = [];
foreach (CONDITIONS as $cond) {
    $files = wavFiles("{$root}/{$cond}");
    if (!$files) {
        fail("no .wav files at the top level of stim/{$cond}/ -- already split? run --verify");
    }
    foreach ($files as $f) {
        $target     = parseTargetId($f);
        $distractor = parseDistractorId($f);
        if ($target === null || $distractor === null) {
            fail("cannot parse target/distractor from {$cond}/{$f}");
        }
        if (in_array($target, DROPPED_TARGETS, true)) {
            $dropped[] = ['cond' => $cond, 'file' => $f];
            continue;
        }
        if (!isset($clearById[$target])) {
            // Anything beyond the three known-missing ids is unexpected and must
            // not be silently tolerated -- it would break the listening block.
            fail("no clear original for target {$target} ({$cond}/{$f}); "
               . "add stim/unaltered/{$target}.WAV or add the id to DROPPED_TARGETS");
        }
        $stimuli[$cond][] = ['file' => $f, 'target' => $target, 'distractor' => $distractor];
        $distractors[$distractor] = true;
    }
    echo "  parsed " . count($stimuli[$cond]) . " {$cond} stimuli\n";
}

foreach ($dropped as $d) {
    echo "  dropped (no clear original): {$d['cond']}/{$d['file']}\n";
}

// Sanity: intel and unintel target sets must stay disjoint.
$intelTargets   = array_column($stimuli['intel'], 'target');
$unintelTargets = array_column($stimuli['unintel'], 'target');
$shared = array_intersect($intelTargets, $unintelTargets);
if ($shared) {
    fail("intel and unintel share " . count($shared) . " target(s): " . implode(', ', $shared));
}

// Deal each condition's targets to Pre / Post, stratified by BKB list.
$assignment = [];   // condition => visit => [stimulus, ...]
foreach (CONDITIONS as $cond) {
    $byList = [];
    foreach ($stimuli[$cond] as $s) {
        $byList[listOf($s['target'])][] = $s;
    }
    ksort($byList);

    $startWithPre = true;
    foreach ($byList as $lst => $items) {
        usort($items, fn($a, $b) => strcmp($a['target'], $b['target']));
        $toPre = $startWithPre;
        foreach ($items as $s) {
            $assignment[$cond][$toPre ? 'pre' : 'post'][] = $s;
            $toPre = !$toPre;
        }
        // An odd-sized list hands one extra item to whichever side started it.
        // Flip the start so the next odd list compensates.
        if (count($items) % 2 === 1) {
            $startWithPre = !$startWithPre;
        }
    }

    printf("  %s -> pre %d / post %d\n", $cond,
        count($assignment[$cond]['pre']), count($assignment[$cond]['post']));
}

// Build the full move list.
$moves = [];   // [from, to]
$clearNeeded = ['pre' => [], 'post' => []];

foreach (CONDITIONS as $cond) {
    foreach (VISITS as $visit) {
        foreach ($assignment[$cond][$visit] as $s) {
            $moves[] = ["{$root}/{$cond}/{$s['file']}", "{$root}/{$cond}/{$visit}/{$s['file']}"];
            $clearNeeded[$visit][$s['target']] = $clearById[$s['target']];
        }
    }
}

foreach (VISITS as $visit) {
    ksort($clearNeeded[$visit]);
    foreach ($clearNeeded[$visit] as $id => $f) {
        $moves[] = ["{$root}/unaltered/{$f}", "{$root}/unaltered/{$visit}/{$f}"];
    }
    printf("  unaltered -> %s %d\n", $visit, count($clearNeeded[$visit]));
}

// Everything left in unaltered/ is a distractor original: unused by the task,
// but kept so the stimulus set stays reconstructible.
$usedClear = array_merge(array_values($clearNeeded['pre']), array_values($clearNeeded['post']));
$leftover  = array_values(array_diff($unalteredFiles, $usedClear));
foreach ($leftover as $f) {
    $moves[] = ["{$root}/unaltered/{$f}", "{$root}/unaltered/distractors/{$f}"];
}
printf("  unaltered -> distractors %d\n", count($leftover));

// Quarantine the excluded stimuli so no .wav is left loose at the top level of a
// condition folder, where it would look like an incomplete split.
foreach ($dropped as $d) {
    $moves[] = ["{$root}/{$d['cond']}/{$d['file']}", "{$root}/dropped/{$d['file']}"];
}
printf("  dropped -> dropped/ %d\n", count($dropped));

echo "\n  " . count($moves) . " files to move\n";

if ($dryRun) {
    echo "\nDry run complete. Re-run without --dry-run to apply.\n";
    exit(0);
}

// Create the destination folders.
foreach (["{$root}/intel/pre", "{$root}/intel/post",
          "{$root}/unintel/pre", "{$root}/unintel/post",
          "{$root}/unaltered/pre", "{$root}/unaltered/post",
          "{$root}/unaltered/distractors",
          "{$root}/dropped"] as $dir) {
    if (!is_dir($dir) && !mkdir($dir, 0777, true)) {
        fail("could not create {$dir}");
    }
}

$moved = 0;
foreach ($moves as [$from, $to]) {
    if (!is_file($from)) {
        fail("source missing: " . relative($from));
    }
    if (is_file($to)) {
        fail("destination already exists: " . relative($to));
    }
    if (!rename($from, $to)) {
        fail("could not move " . relative($from) . " -> " . relative($to));
    }
    $moved++;
}
echo "  moved {$moved} files\n";

// Remove the stray empty scaffolding directories (stim/intel/post/pre etc.).
foreach (["{$root}/intel/post/pre", "{$root}/unintel/post/pre"] as $stray) {
    if (is_dir($stray) && count(scandir($stray)) === 2) {
        rmdir($stray);
        echo "  removed stray empty dir " . relative($stray) . "\n";
    }
}

echo "\nDone. Run `php split_pre_post.php --verify` to check the result.\n";
