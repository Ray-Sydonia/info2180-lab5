// Ensure the script runs after the DOM is fully loaded
document.addEventListener("DOMContentLoaded", () => {
    // Select the lookup button and result div
    const lookupButton = document.getElementById("lookup");
    const resultDiv = document.getElementById("result");

    // Add a click event listener to the lookup button
    lookupButton.addEventListener("click", () => {
        // Get the value entered in the country input field
        const country = document.getElementById("country").value;

        // Construct the URL for the AJAX request
        const url = `world.php?country=${encodeURIComponent(country)}`;

        // Perform the AJAX request using Fetch API
        fetch(url)
            .then(response => {
                // Check if the response is OK (status 200)
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.text(); // Parse response as text
            })
            .then(data => {
                // Insert the fetched data into the result div
                resultDiv.innerHTML = data;
            })
            .catch(error => {
                // Handle errors and display a message in the result div
                resultDiv.textContent = `Error: ${error.message}`;
            });
    });
});
