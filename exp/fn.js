"use strict";

document.addEventListener("DOMContentLoaded", (event) => {
    // Check if the query string is empty
    // this means we are in intake mode
    if (!location.search) {
        const sites = ["WashU", "UChicago", "MPRC", "UMinnesota", "UCI"];
        const selectElement = document.getElementById("site");

        sites.forEach((site) => {
            const option = new Option(site, site);
            selectElement.add(option);
        });
    }
});

document.addEventListener("DOMContentLoaded", (event) => {
    // Check if the query string is empty
    // this means we are in intake mode
    if (!location.search) {
        const phenotypes = ["sz"];
        const selectElement2 = document.getElementById("phenotype");

        phenotypes.forEach((phenotype) => {
            const option = new Option(phenotype, phenotype);
            selectElement2.add(option);
        });
    }
});
