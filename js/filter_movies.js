document.addEventListener("DOMContentLoaded", function () {
    function fetchResults() {
        let xhr = new XMLHttpRequest();
        let formData = new FormData(document.getElementById("search-form"));
        let params = new URLSearchParams(formData);

        xhr.open("GET", "../php/search_movies.php?" + params, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById("movie-container").innerHTML = xhr.responseText;

                let clearFiltersBtn = document.getElementById("clear-filters");
                if (clearFiltersBtn) {
                    clearFiltersBtn.addEventListener("click", function () {
                        document.getElementById("search-form").reset();
                        fetchResults();
                    });
                }
            }
        };
        xhr.send();
    }

    let searchForm = document.getElementById("search-form");
    if (searchForm) {
        searchForm.addEventListener("input", fetchResults);
        searchForm.addEventListener("change", fetchResults);
    }

    fetchResults();
});
