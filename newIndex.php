<?php

// Set database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "notics";

// Create Connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle file deletion
if (isset($_POST['delete'])) {
    $fileId = $_POST['file_id'];
    $deleteQuery = "DELETE FROM notices WHERE id = $fileId";
    if ($conn->query($deleteQuery) === TRUE) {
        unlink($_POST['file_path']); // Delete the physical file
        echo "File deleted successfully.";
    } else {
        echo "Error deleting file: " . $conn->error;
    }
}

// Check if file is uploaded
if (isset($_POST['submit'])) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["pdfFile"]["name"]);
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file is a PDF and less than 2MB
    if ($fileType != "pdf" || $_FILES["pdfFile"]["size"] > 2000000) {
        echo "Error: Only PDF files less than 2MB are allowed to upload.";
    } else {
        // Move uploaded file to uploads folder
        if (move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $targetFile)) {
            // Insert file information into database
            $filename = $_FILES["pdfFile"]["name"];
            $folder_path = $targetDir;
            $time_stamp = date('Y-m-d H:i:s');
            $sql = "INSERT INTO notices (filename, folder_path, time_stamp)
                   VALUES ('$filename','$folder_path', '$time_stamp')";

            if ($conn->query($sql) === TRUE) {
                echo "File uploaded successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error uploading file. ";
        }
    }
}

// Display uploaded files in a table
echo "<h2>Uploaded Files</h2>";
echo "<table class='table'>";
echo "<thead><tr><th>Filename</th><th>Folder Path</th><th>Timestamp</th><th>Action</th></tr></thead><tbody>";

$selectQuery = "SELECT id, filename, folder_path, time_stamp FROM notices";
$result = $conn->query($selectQuery);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['filename']}</td>";
        echo "<td>{$row['folder_path']}</td>";
        echo "<td>{$row['time_stamp']}</td>";
        echo "<td>
                  <form method='post'>
                    <input type='hidden' name='file_id' value='{$row['id']}'>
                    <input type='hidden' name='file_path' value='{$row['folder_path']}{$row['filename']}'>
                    <button type='submit' name='delete' class='btn btn-danger btn-sm'>Delete</button>
                  </form>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No files uploaded yet.</td></tr>";
}

echo "</tbody></table>";

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Upload Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Upload PDF File</h4>
            </div>

            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="pdfFile">Select PDF File:</label>
                        <input type="file" name="pdfFile" class="form-control-file" id="pdfFile">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary btn-block">Upload File</button>
                    <button type="reset" class="btn btn-warning btn-block">Reset</button>

                </form>
            </div>
        </div>
    </div>

</body>

</html>
