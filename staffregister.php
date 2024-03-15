<?php
require 'assets/dbh/connector.php';

class Database {
    private $conn;

    public function __construct() {
        global $conn;  // Access the global connection variable
        $this->conn = $conn;
    }

    public function executeQuery($query) {
        return $this->conn->query($query);
    }

    public function getLastInsertedId() {
        return $this->conn->insert_id;
    }

    public function getNextStaffId() {
        $result = $this->conn->query("SELECT MAX(SID) as maxId FROM staff");
        $row = $result->fetch_assoc();
        $maxId = $row['maxId'];

        if ($maxId) {
            // Increment the existing maximum ID
            $nextId = ++$maxId;
        } else {
            // If no records exist yet, start with S001
            $nextId = 'S001';
        }

        return $nextId;
    }
}

class Staff {
    private $db;
    private $staffId;
    private $staffName;
    private $age;
    private $nicNo;
    private $address;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function registerStaff($staffName, $age, $nicNo, $address) {
        // Validate fields
        if (empty($staffName) || empty($age) || empty($nicNo) || empty($address)) {
            return false;
        }

        $this->staffName = $staffName;
        $this->age = $age;
        $this->nicNo = $nicNo;
        $this->address = $address;

        // Get the next available staff ID
        $nextStaffId = $this->db->getNextStaffId();

        $query = "INSERT INTO staff (SID, staffName, age, nicNo, address) 
                  VALUES ('$nextStaffId', '$this->staffName', '$this->age', '$this->nicNo', '$this->address')";

        $result = $this->db->executeQuery($query);

        if ($result) {
            $this->staffId = $nextStaffId;
            return true;
        }

        return false;
    }

    public function getStaffId() {
        return $this->staffId;
    }
}

// Example usage:

$db = new Database();
$staff = new Staff($db);

$errorMessage = ''; // Initialize error message

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $staffName = $_POST["staffName"];
    $age = $_POST["age"];
    $nicNo = $_POST["nicNo"];
    $address = $_POST["address"];

    // Check if any field is empty
    if (empty($staffName) || empty($age) || empty($nicNo) || empty($address)) {
        $errorMessage = "All fields are required. Please fill in all the details.";
    } else {
        if ($staff->registerStaff($staffName, $age, $nicNo, $address)) {
            $errorMessage = "Registration successful. Your Staff ID is: " . $staff->getStaffId();
        } else {
            $errorMessage = "Registration failed. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Registration</title>
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
            height: 1000px;
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
            <div class="login-heading">Staff Registration</div>

            <?php
            if (isset($errorMessage)) {
                echo '<div class="alert alert-danger" role="alert">' . $errorMessage . '</div>';
            }
            ?>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="staffName">Staff Name</label>
                    <input type="text" class="form-control" name="staffName" required>
                </div>
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="text" class="form-control" name="age" required>
                </div>
                <div class="form-group">
                    <label for="nicNo">NIC No</label>
                    <input type="text" class="form-control" name="nicNo" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" name="address" required>
                </div>
                <button type="submit" class="btn btn-success" name="register">Register</button>
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
