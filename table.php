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

// Retrieve uploaded files from the database, sorted by timestamp in descending order
$sql = "SELECT * FROM notices ORDER BY time_stamp DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notices</title>
    <link rel="shortcut icon" href="./images/logo.png" type="image/png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
    integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"> -->
</head>

<body>
<div class="navbar-top">
    <div class="nav-title">

      <a href="#">
        <div class="nav-logo"></div>
      </a>

      <div class="name">
        <p>R.C.SAHARIA TEACHERS' TRAINING COLLEGE, TANGLA</p>
      </div>


    </div>



    <div class="nav-div">
      <div class="email-icon">
        <i class="fa-solid fa-envelope"></i>
        <p class="email">rcsttc95@gmail.com</p>
      </div>

      <div class="phone-icon">
        <i class="fa-solid fa-phone"></i>
        <p class="phone">03711-255910</p>
      </div>
    </div>
  </div>


  <navbar>
    <nav class="navbar navbar-expand-lg">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01"
          aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">

          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item ">
              <a class="nav-link" href="index.html">Home</a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="about.html">About Us</a>
            </li>
            <li class="nav-item ">
              <a class="nav-link live" href="table.php">Notices</a>
            </li>
            <li class="nav-item ">
              <a class="nav-link" href="courses.html">Courses</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="facilities.html">Facilities</a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" href="gallery.html">Gallery</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="faculty.html">Staff</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="contact.html">Contact Us</a>
            </li>
          </ul>

        </div>
      </div>
    </nav>
  </navbar>

    <div class="container">
        <h1>Notices</h1>
        <?php
        if ($result->num_rows > 0) {
        ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>File</th>
                        <th>Date & Time of Upload</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        $filename = $row['filename'];
                        $filepath = $row['folder_path'] . $filename;
                        $timestamp = $row['time_stamp'];
                    ?>
                        <tr>
                            <td>
                                <a href="<?php echo $filepath; ?>" download target="_blank"><?php echo $filename; ?></a>
                            </td>
                            <td>
                                <?php echo $timestamp; ?>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        <?php
        } else {
            echo "No PDF files have been uploaded.";
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
<?php

// Close database connection
$conn->close();
?>
