// Ensure the script runs after the DOM is fully loaded
document.addEventListener("DOMContentLoaded", () => {
    // Select the lookup button, lookup cities button and result div
    const lookupButton = document.getElementById("lookup");
    const lookupCitiesButton = document.getElementById("lookup-cities");
    const resultDiv = document.getElementById("result");

    // Function to fetch data
    function fetchData(queryParams) {
        const country = document.getElementById("country").value;
        const url = `world.php?country=${encodeURIComponent(country)}&${queryParams}`;

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.text();
            })
            .then(data => {
                resultDiv.innerHTML = data;
            })
            .catch(error => {
                resultDiv.textContent = `Error: ${error.message}`;
            });
    }

    // Add event listener for "Lookup" button (countries)
    lookupButton.addEventListener("click", () => {
        fetchData("lookup=country");
    });

    // Add event listener for "Lookup Cities" button
    lookupCitiesButton.addEventListener("click", () => {
        fetchData("lookup=cities");
    });
});

