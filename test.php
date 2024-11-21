<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Personnel</title>
    <style>
        /* Basic styling for the search results */
        #suggestions {
            border: 1px solid #ddd;
            max-height: 200px;
            overflow-y: auto;
            margin-top: 5px;
        }
        #suggestions div {
            padding: 10px;
            cursor: pointer;
            background-color: #f9f9f9;
        }
        #suggestions div:hover {
            background-color: #e0e0e0;
        }
    </style>
</head>
<body>

    <h1>Search Personnel</h1>
    <input type="text" id="searchInput" placeholder="Search by first or last name" autocomplete="off">
    <div id="suggestions"></div> <!-- Display search results here -->

    <script>
        const searchInput = document.getElementById('searchInput');
        const suggestionsDiv = document.getElementById('suggestions');

        // Event listener for input field
        searchInput.addEventListener('input', function() {
            const query = searchInput.value.trim();
            
            // Clear suggestions if input is empty
            if (query.length === 0) {
                suggestionsDiv.innerHTML = '';
                return;
            }

            // Send request to the PHP script
            fetch(`admin/search_personnel.php?query=${encodeURIComponent(query)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json(); // Parse JSON from the response
                })
                .then(data => {
                    suggestionsDiv.innerHTML = ''; // Clear previous suggestions
                    if (data.error) {
                        suggestionsDiv.innerHTML = '<div>Error fetching data</div>';
                        console.error(data.error);
                    } else if (data.length > 0) {
                        // Display the search results
                        data.forEach(person => {
                            const div = document.createElement('div');
                            div.textContent = `${person.first_name} ${person.last_name}`;
                            div.addEventListener('click', () => {
                                searchInput.value = `${person.first_name} ${person.last_name}`; // Autofill the input
                                suggestionsDiv.innerHTML = ''; // Clear suggestions after selection
                            });
                            suggestionsDiv.appendChild(div);
                        });
                    } else {
                        suggestionsDiv.innerHTML = '<div>No matches found</div>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        });
    </script>

</body>
</html>
