<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'assets/dbh/connector.php';

class Authentication {
    private $conn; // Use the $conn variable from connector.php

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function authenticateUser($SID, $nicNo) {
        $sanitizedSID = mysqli_real_escape_string($this->conn, $SID);
    
        $hashedNicNo = $this->getHashedNicNo($sanitizedSID);
    
        // Directly compare NIC numbers
        if ($hashedNicNo === $nicNo) {
            return true;
        }
    
        return false;
    }
    private function getHashedNicNo($SID) {
        $query = "SELECT nicNo FROM staff WHERE SID = ?";
        $stmt = mysqli_prepare($this->conn, $query);
    
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $SID);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
    
            if (mysqli_stmt_num_rows($stmt) > 0) {
                mysqli_stmt_bind_result($stmt, $hashedNicNo);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_close($stmt);
                return $hashedNicNo;
            }
        }
    
        return null;
    }
}

// Example usage:
$authentication = new Authentication($conn);

$errorMessage = ''; // Initialize error message

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $SID = $_POST["SID"];
    $nicNo = $_POST["nicNo"];

    // Check if any field is empty
    if (empty($SID) || empty($nicNo)) {
        $errorMessage = "Both Staff ID and NIC NO are required. Please enter both.";
    } else {
        if ($authentication->authenticateUser($SID, $nicNo)) {
            // Redirect to services.php on successful login
            header("Location: staffhome.php");
            exit();
        } else {
            $errorMessage = "Staff ID or NIC NO don't match. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image:url("assets/img/backhome.jpeg");
            background-size: cover; /* Make the background image cover the entire container */
            background-position: center; /* Center the background image */
            background-repeat: no-repeat;   
        }
        .login-container {
            max-width: 1000px;
            margin: auto;
            margin-top: 50px;
            border: 2px solid #00008b;
            border-radius: 20px;
            padding: 20px;
            background-color: #fff;
            height: 700px;
        }
        .login-heading {
            text-align: center;
            color: #00008b;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .create-account-btn {
            display: block;
            text-align: left;
            color: #00008b;
        }
    </style>
</head>
<body>
    <?php include_once('assets/includes/navbar.php'); ?>
    
    <div class="container">
        <div class="login-container">
            <div class="login-heading">Sign In</div>

            <?php
            if (isset($errorMessage)) {
                echo '<div class="alert alert-danger" role="alert">' . $errorMessage . '</div>';
            }
            ?>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="SID">Staff ID</label>
                    <input type="text" class="form-control" name="SID" required>
                </div>
                <div class="form-group">
                    <label for="nicNo">NIC NO</label>
                    <input type="text" class="form-control" name="nicNo" required>
                </div>
                <button type="submit" class="btn btn-success" name="login">Sign In</button>
            </form>
            <br><br><br>
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
