document.addEventListener("DOMContentLoaded", function () {
    function fetchResults() {
        xhr = new XMLHttpRequest();
        xhr.open("GET", "../php/search_movies.php?" + new URLSearchParams(new FormData(document.getElementById("search-form"))), true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("results").innerHTML = xhr.responseText;

                clearFiltersBtn = document.getElementById("clear-filters");
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

    document.getElementById("search-form").addEventListener("input", fetchResults);
    document.getElementById("search-form").addEventListener("change", fetchResults);

    fetchResults();
});
