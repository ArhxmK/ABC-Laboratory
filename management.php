<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Management Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image:url("assets/img/backhome.jpeg");
            background-size: cover; /* Make the background image cover the entire container */
            background-position: center; /* Center the background image */
            background-repeat: no-repeat;   
        }
        .management-container {
            max-width: 1000px;
            margin: auto;
            margin-top: 50px;
            padding: 20px;
            background-color: #fff;
            text-align: center;
        }
        .management-heading {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #00008b;
        }
        .image-box {
            width: 200px;
            height: 200px;
            margin: 20px;
            display: inline-block;
            cursor: pointer;
        }
        .image-box img {
            width: 100%;
            height: 100%;
            border-radius: 20px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <?php include_once('assets/includes/navbar.php'); ?>
    
    <div class="container">
        <div class="management-container">
            <div class="management-heading">MANAGEMENT</div>
            <br><br>
            <div>
                <a href="adminlogin.php" class="image-box">
                    <img src="assets/img/admin.avif" alt="Admin Login">
                </a>
            </div>
            <br><br><br><br>
            <div>
                <a href="stafflogin.php" class="image-box">
                    <img src="assets/img/staff.png" alt="Staff Login">
                </a>
            </div>
        </div>
    </div>
    <br><br>
    <?php include_once('assets/includes/footer.php'); ?>
 <!-- Include Bootstrap JS and Popper.js -->
 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>

