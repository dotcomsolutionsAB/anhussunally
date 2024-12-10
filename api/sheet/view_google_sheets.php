<!DOCTYPE html>
<html>
<head>
    <title>Google Sheets</title>
    <link rel="stylesheet" href="style.css"> <!-- Update to your actual stylesheet path -->
    <style>
        /* Styling for the message notifications */
        .message {
            position: fixed;
            padding: 10px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            display: none;
            z-index: 1000;
        }
        .top-right {
            top: 10px;
            right: 10px;
        }
        .top-left {
            top: 10px;
            left: 10px;
        }
    </style>
</head>
<body>
    
    <h2>Google Sheets List</h2>
    <div class="box" style="display: flex;">
        <button onclick="openModal()">Add</button>
        <button><a href="../../admin/dashboard.php" style=" text-decoration: none; cursor: pointer; color: white;">Dashboard</a></button>
    </div>

    <!-- Message Notifications -->
    <div id="syncMessage" class="message top-right"></div>
    <div id="uploadMessage" class="message top-left"></div>

    <!-- Modal for Adding Google Sheet -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Add Google Sheet</h2>
            <form action="add_google_sheet.php" method="post">
                <label for="sheet_name">Sheet Name:</label>
                <input type="text" id="sheet_name" name="sheet_name" required>
                <br><br>
                <label for="sheet_path">Sheet Path:</label>
                <input type="text" id="sheet_path" name="sheet_path" required>
                <br><br>
                <input type="submit" value="Add Google Sheet">
            </form>
        </div>
    </div>

    <!-- Table of Google Sheets -->
    <div class="div">
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Path</th>
                <th>Status</th>
                <th>Last Updated</th>
                <th>Action</th>
            </tr>
            <?php
            // Include database connection
            include("../../connection/db_connect.php");

            // Establish database connection
            $conn = new mysqli($host, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch all Google Sheets data
            $query = "SELECT * FROM google_sheet";
            $result = $conn->query($query);

            while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['path']); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td><?php echo htmlspecialchars($row['updated_at']); ?></td>
                    <td>
                        <button onclick="syncGoogleSheet(<?php echo $row['id']; ?>)">Sync</button>
                        <button onclick="uploadImages(<?php echo $row['id']; ?>)">Upload</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- JavaScript for Modal and Buttons -->
    <script>
        // Function to open the modal
        function openModal() {
            document.getElementById("addModal").style.display = "block";
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById("addModal").style.display = "none";
        }

        // Function to display messages
        function showMessage(message, elementId) {
            const messageElement = document.getElementById(elementId);
            messageElement.textContent = message;
            messageElement.style.display = "block";
            setTimeout(() => {
                messageElement.style.display = "none";
            }, 3000);
        }

        // Function to sync Google Sheet
        // function syncGoogleSheet(sheetId) {
        //     // First update the status
        //     fetch(`update_status.php?id=${sheetId}&status=0`)
        //         .then(response => response.text())
        //         .then(data => {
        //             if (data.includes("Status updated successfully")) {
        //                 // Now run the add_product.php script
        //                 return fetch(`add_product.php?id=${sheetId}`);
        //             } else {
        //                 throw new Error("Failed to update status");
        //             }
        //         })
        //         .then(response => response.text())
        //         .then(data => {
        //             showMessage(data, "syncMessage");
        //             window.location.reload();
        //         })
        //         .catch(error => {
        //             showMessage(error.message, "syncMessage");
        //         });
        // }

        function syncGoogleSheet(sheetId) {
            console.log("Syncing sheet with ID:", sheetId); // Debugging line
            fetch(`update_status.php?id=${sheetId}&status=0`)
                .then(response => response.text())
                .then(data => {
                    console.log("Response from update_status.php:", data); // Debugging line
                    if (data.includes("Status updated successfully")) {
                        return fetch(`../add_product.php?id=${sheetId}`);
                    } else {
                        throw new Error("Failed to update status");
                    }
                })
                .then(response => response.text())
                .then(data => {
                    console.log("Response from add_product.php:", data); // Debugging line
                    showMessage(data, "syncMessage");
                    window.location.reload();
                })
                .catch(error => {
                    console.error("Error:", error); // Debugging line
                    showMessage(error.message, "syncMessage");
                });
        }


        // Function to upload images
        function uploadImages(sheetId) {
            fetch(`../upload_images.php?id=${sheetId}`)
                .then(response => response.text())
                .then(data => {
                    showMessage(data, "uploadMessage");
                })
                .catch(error => {
                    showMessage("Failed to upload images: " + error.message, "uploadMessage");
                });
        }

        // Close the modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById("addModal");
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>

    <script>
        // Function to check the status and call add_products.php
        function checkAndRunAddProducts() {
            // Fetch the sheets with status == 0
            fetch('check_status.php')
                .then(response => response.json())
                .then(sheets => {
                    if (sheets.length > 0) {
                        sheets.forEach(sheet => {
                            // Run add_products.php for each sheet with status 0
                            fetch(`../add_products.php?id=${sheet.id}`)
                                .then(response => response.text())
                                .then(data => {
                                    console.log(`Sheet ID: ${sheet.id} - ${data}`);

                                    // After successful processing, update the status to 1
                                    return fetch(`update_status_auto.php?id=${sheet.id}&status=1`);
                                })
                                .then(response => response.text())
                                .then(updateMessage => {
                                    console.log(`Status updated for Sheet ID: ${sheet.id} - ${updateMessage}`);
                                })
                                .catch(error => {
                                    console.error(`Error processing Sheet ID: ${sheet.id} - ${error.message}`);
                                });
                        });
                    } else {
                        console.log("No sheets with status 0 found.");
                    }
                })
                .catch(error => {
                    console.error("Error checking status:", error);
                });
        }

        // Automatically run the checkAndRunAddProducts function every 2 minutes (120000 milliseconds)
        setInterval(checkAndRunAddProducts, 120000);

        // Initial call to run the function as soon as the page loads
        checkAndRunAddProducts();
    </script>

</body>
</html>
