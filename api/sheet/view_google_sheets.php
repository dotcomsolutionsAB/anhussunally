<!DOCTYPE html>
<html>
<head>
    <title>Google Sheets</title>
    <link rel="stylesheet" href="style.css"> <!-- Update to your actual stylesheet path -->
</head>
<body>
    <h2>Google Sheets List</h2>
    <button onclick="openModal()">Add</button>

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
                <th>Action</th>
            </tr>
            <?php
            // Include database connection
            include("../db_connection.php");

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
                    <td><?php echo $row['status'] == 1 ? 'Active' : 'Inactive'; ?></td>
                    <td>
                        <button onclick="syncGoogleSheet(<?php echo $row['id']; ?>)">Sync</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- JavaScript for Modal and Sync Button -->
    <script>
        // Function to open the modal
        function openModal() {
            document.getElementById("addModal").style.display = "block";
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById("addModal").style.display = "none";
        }

        // Function to sync Google Sheet
        function syncGoogleSheet(sheetId) {
            // Make an AJAX request to sync_google_sheet.php
            fetch(`sync_google_sheet.php?id=${sheetId}`)
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    // Reload the page to update the status
                    window.location.reload();
                })
                .catch(error => console.error('Error:', error));
        }

        // Close the modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById("addModal");
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
