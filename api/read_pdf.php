<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process PDFs</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Processing PDFs</h2>
    <ul id="progress-list"></ul>

    <script>
        $(document).ready(function () {
            var products = []; // Will store product IDs

            // Fetch all products needing processing
            $.ajax({
                url: "get_products.php",
                type: "GET",
                dataType: "json",
                success: function (data) {
                    if (data.length > 0) {
                        products = data;
                        processNext();
                    } else {
                        $("#progress-list").append("<li>No products found.</li>");
                    }
                }
            });

            function processNext() {
                if (products.length === 0) {
                    $("#progress-list").append("<li><strong>Processing Complete!</strong></li>");
                    return;
                }

                var productId = products.shift(); // Get next product ID

                $.ajax({
                    url: "process_pdf.php",
                    type: "POST",
                    data: { product_id: productId },
                    dataType: "json",
                    success: function (response) {
                        if (response.status === "success") {
                            $("#progress-list").append("<li style='color: green;'>" + response.message + "</li>");
                        } else {
                            $("#progress-list").append("<li style='color: red;'>Error: " + response.message + "</li>");
                        }
                        processNext(); // Process next item
                    },
                    error: function () {
                        $("#progress-list").append("<li style='color: red;'>Error processing product ID: " + productId + "</li>");
                        processNext(); // Continue with next
                    }
                });
            }
        });
    </script>
</body>
</html>
