# Sine Wave Speech (sws)

## Overview
For this task participants will hear audio clips and are asked to decide if they heard a complete sentence in the audio. They are instructed to press ‘1’ if they hear a complete sentence and ‘0’ if they did not. Following that portion, they are instructed to listen to some sentences and not respond. Then they will complete the first part of the task again. 

**Total run time: 10 minutes**

```
git clone --recurse-submodules -j4 git@github.com:belieflab/prl.git && cd prl &&
git submodule foreach --recursive 'git checkout $(git config -f $toplevel/.gitmodules submodule.$name.branch || echo main)'
```
