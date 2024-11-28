<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Search</title>
    <style>
        /* Basic CSS for responsiveness */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .search-bar {
            width: 100%;
            max-width: 500px;
            margin: 20px auto;
            display: flex;
            justify-content: space-between;
        }

        .search-bar input {
            width: 85%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-bar button {
            width: 12%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        .results {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
        }

        .result-item {
            width: 100%;
            max-width: 300px;
            padding: 10px;
            margin: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .search-bar input, .search-bar button {
                width: 100%;
            }

            .result-item {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="search-bar">
        <input type="text" id="search-query" placeholder="Search by SKU or Name">
        <button onclick="searchProducts()">Search</button>
    </div>

    <div id="results" class="results">
        <!-- Search results will be displayed here -->
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function searchProducts() {
        var query = $('#search-query').val();

        if (query.length >= 3) {
            $.ajax({
                url: 'search_api.php',  // API endpoint
                method: 'GET',
                data: { search: query },
                success: function(response) {
                    $('#results').html('');  // Clear previous results
                    if (response.length > 0) {
                        response.forEach(function(product) {
                            $('#results').append(`
                                <div class="result-item">
                                    <h3>${product.name}</h3>
                                    <p>SKU: ${product.sku}</p>
                                    <p>Price: ${product.price}</p>
                                </div>
                            `);
                        });
                    } else {
                        $('#results').html('<p>No results found</p>');
                    }
                },
                error: function() {
                    alert('An error occurred while searching.');
                }
            });
        } else {
            $('#results').html('');
        }
    }

    // Optional: Trigger search when user types in the search box
    $('#search-query').on('input', function() {
        searchProducts();
    });
</script>

</body>
</html>
