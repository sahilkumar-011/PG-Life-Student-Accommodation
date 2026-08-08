// --- Filtering (gender + budget) and sorting (rent) ---
var currentGenderFilter = "none";

function getContainer() {
    return document.querySelector(".page-container");
}

function applyFiltersAndSort() {
    var container = getContainer();
    var cards = Array.from(document.getElementsByClassName("property-card"));

    var minBudget = parseFloat(document.getElementById("min-budget").value);
    var maxBudget = parseFloat(document.getElementById("max-budget").value);

    var visibleCount = 0;
    cards.forEach(function (card) {
        var gender = card.getAttribute("data-gender");
        var rent = parseFloat(card.getAttribute("data-rent"));

        var matchesGender = currentGenderFilter === "none" || gender === currentGenderFilter;
        var matchesMin = isNaN(minBudget) || rent >= minBudget;
        var matchesMax = isNaN(maxBudget) || rent <= maxBudget;

        if (matchesGender && matchesMin && matchesMax) {
            card.style.display = "";
            visibleCount++;
        } else {
            card.style.display = "none";
        }
    });

    document.getElementById("no-filtered-results").style.display = visibleCount === 0 ? "block" : "none";

    // Re-apply current sort after filtering
    if (container.dataset.sort === "desc") {
        sortCards(true);
    } else if (container.dataset.sort === "asc") {
        sortCards(false);
    }
}

function sortCards(descending) {
    var container = getContainer();
    var cards = Array.from(document.getElementsByClassName("property-card"));

    cards.sort(function (a, b) {
        var rentA = parseFloat(a.getAttribute("data-rent"));
        var rentB = parseFloat(b.getAttribute("data-rent"));
        return descending ? rentB - rentA : rentA - rentB;
    });

    cards.forEach(function (card) {
        container.appendChild(card);
    });
}

window.addEventListener("load", function () {
    var container = getContainer();

    // Gender filter buttons
    var genderButtons = document.querySelectorAll("[data-gender-filter]");
    genderButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            genderButtons.forEach(function (b) { b.classList.remove("btn-active"); });
            button.classList.add("btn-active");
            currentGenderFilter = button.getAttribute("data-gender-filter");
        });
    });

    // Apply / Clear buttons in the filter modal
    var applyButton = document.getElementById("apply-filters");
    if (applyButton) {
        applyButton.addEventListener("click", applyFiltersAndSort);
    }
    var clearButton = document.getElementById("clear-filters");
    if (clearButton) {
        clearButton.addEventListener("click", function () {
            currentGenderFilter = "none";
            genderButtons.forEach(function (b) { b.classList.remove("btn-active"); });
            document.querySelector('[data-gender-filter="none"]').classList.add("btn-active");
            document.getElementById("min-budget").value = "";
            document.getElementById("max-budget").value = "";
            applyFiltersAndSort();
        });
    }

    // Sort by rent
    var sortDesc = document.getElementById("sort-desc");
    var sortAsc = document.getElementById("sort-asc");
    if (sortDesc) {
        sortDesc.addEventListener("click", function () {
            container.dataset.sort = "desc";
            sortDesc.classList.add("sort-active");
            if (sortAsc) sortAsc.classList.remove("sort-active");
            sortCards(true);
        });
    }
    if (sortAsc) {
        sortAsc.addEventListener("click", function () {
            container.dataset.sort = "asc";
            sortAsc.classList.add("sort-active");
            if (sortDesc) sortDesc.classList.remove("sort-active");
            sortCards(false);
        });
    }

    var is_interested_images = document.getElementsByClassName("is-interested-image");
    Array.from(is_interested_images).forEach(element => {
        element.addEventListener("click", function (event) {
            var XHR = new XMLHttpRequest();
            var property_id = event.target.getAttribute("property_id");

            // On success
            XHR.addEventListener("load", toggle_interested_success);

            // On error
            XHR.addEventListener("error", on_error);

            // Set up request
            XHR.open("GET", "api/toggle_interested.php?property_id=" + property_id);

            // Initiate the request
            XHR.send();

            document.getElementById("loading").style.display = 'block';
            event.preventDefault();
        });
    });
});

var toggle_interested_success = function (event) {
    document.getElementById("loading").style.display = 'none';

    var response = JSON.parse(event.target.responseText);
    if (response.success) {
        var property_id = response.property_id;

        var is_interested_image = document.querySelectorAll(".property-id-" + property_id + " .is-interested-image")[0];
        var interested_user_count = document.querySelectorAll(".property-id-" + property_id + " .interested-user-count")[0];

        if (response.is_interested) {
            is_interested_image.classList.add("fas");
            is_interested_image.classList.remove("far");
            interested_user_count.innerHTML = parseFloat(interested_user_count.innerHTML) + 1;
        } else {
            is_interested_image.classList.add("far");
            is_interested_image.classList.remove("fas");
            interested_user_count.innerHTML = parseFloat(interested_user_count.innerHTML) - 1;
        }
    } else if (!response.success && !response.is_logged_in) {
        window.$("#login-modal").modal("show");
    }
};

