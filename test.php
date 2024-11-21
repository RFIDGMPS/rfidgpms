<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autocomplete Search</title>
    <style>
        .suggestions {
            border: 1px solid #ccc;
            max-height: 150px;
            overflow-y: auto;
        }
        .suggestions div {
            padding: 8px;
            cursor: pointer;
        }
        .suggestions div:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <label for="search">Search Person:</label>
    <input type="text" id="search" autocomplete="off" placeholder="Type a name...">
    <div id="suggestions" class="suggestions"></div>

    <script>
        const searchInput = document.getElementById('search');
        const suggestionsDiv = document.getElementById('suggestions');

        searchInput.addEventListener('input', () => {
            const query = searchInput.value.trim();
            if (query.length > 0) {
                fetch(`search_personnel.php?query=${encodeURIComponent(query)}`)
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        suggestionsDiv.innerHTML = '';
        if (data.error) {
            suggestionsDiv.innerHTML = '<div>Error fetching data</div>';
            console.error(data.error);
        } else if (data.length > 0) {
            data.forEach(person => {
                const div = document.createElement('div');
                div.textContent = `${person.first_name} ${person.last_name}`;
                div.addEventListener('click', () => {
                    searchInput.value = `${person.first_name} ${person.last_name}`;
                    suggestionsDiv.innerHTML = '';
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

            } else {
                suggestionsDiv.innerHTML = '';
            }
        });
    </script>
</body>
</html>
