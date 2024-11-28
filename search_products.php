<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Search</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS file -->
    <style>
        /* styles.css */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .search-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 10vw;
            height: 10vh;
            background: aqua;
            transition: all 0.5s ease-in-out;
            position: relative;
        }

        /* Search icon button (🔍 emoji) */
        #search-icon {
            font-size: 30px; /* Adjust size for visibility */
            cursor: pointer;
            transition: 0.3s;
        }

        /* The sliding search bar (initially hidden) */
        #search-bar {
            position: absolute;
            top: 0;
            right: -300px;
            width: 100%;
            max-width: 300px;
            padding: 15px;
            background-color: yellow;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            transition: right 0.5s;
            display: none; /* Hide the search bar initially */
        }

        #search-bar input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        #clear-icon {
            cursor: pointer;
            font-size: 18px;
            display: none;
            position: absolute;
            right: 40px;
            top: 15px;
        }

        /* Results container */
        #search-results {
            margin-top: 10px;
            max-height: 200px;
            overflow-y: auto;
        }

        .result-item {
            padding: 10px;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
        }

        .result-item:last-child {
            border-bottom: none;
        }

        .result-item img {
            width: 50px;
            height: auto;
            margin-right: 10px;
        }

        /* Media query for responsiveness */
        @media (max-width: 600px) {
            #search-bar {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="search-container">
        <!-- Search icon (🔍 emoji) -->
        <span id="search-icon" onclick="openSearchBar()">🔍</span>
        
        <!-- The search bar -->
        <div id="search-bar">
            <input type="text" id="search" placeholder="Search by SKU or Name..." onkeyup="searchProducts()">
            <span id="clear-icon" onclick="clearSearch()">&#10005;</span>
            <div id="search-results"></div> <!-- Where the search results will be displayed -->
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script> <!-- Link to external JS file -->
    <script>
        // Open the search bar and hide the search icon
        function openSearchBar() {
            document.getElementById('search-bar').style.right = '0'; // Slide the bar in from the right
            document.getElementById('search-bar').style.display = 'block'; // Show the search bar
            document.getElementById('search-icon').style.display = 'none'; // Hide the search icon
            document.querySelector('.search-container').style.width = '35vw'; // Expand container width
            document.querySelector('.search-container').style.height = '10vh'; // Keep container height
        }

        // Clear the search input
        function clearSearch() {
            document.getElementById('search').value = ''; // Clear the search input
            document.getElementById('clear-icon').style.display = 'none'; // Hide the clear icon
            document.getElementById('search-results').innerHTML = ''; // Clear search results
        }

        // Show or hide the clear icon based on input length
        function searchProducts() {
            let query = document.getElementById('search').value;

            if (query.length >= 2) { // Show the clear icon after typing 2 characters
                document.getElementById('clear-icon').style.display = 'block';
            } else {
                document.getElementById('clear-icon').style.display = 'none';
            }

            if (query.length >= 3) { // Start searching after 3 characters
                $.ajax({
                    url: 'search_api.php',
                    type: 'GET',
                    data: {
                        search_query: query
                    },
                    success: function(response) {
                        document.getElementById('search-results').innerHTML = response;
                    }
                });
            } else {
                document.getElementById('search-results').innerHTML = ''; // Clear results if search is too short
            }
        }
    </script>
</body>
</html>
