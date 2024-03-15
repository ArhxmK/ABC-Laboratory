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

    public function getNextPatientId() {
        $result = $this->conn->query("SELECT MAX(PID) as maxId FROM patients");
        $row = $result->fetch_assoc();
        $maxId = $row['maxId'];

        if ($maxId) {
            // Increment the existing maximum ID
            $nextId = ++$maxId;
        } else {
            // If no records exist yet, start with P001
            $nextId = 'P001';
        }

        return $nextId;
    }
}

class Patient {
    private $db;
    private $patientId;
    private $patientName;
    private $age;
    private $nicNo;
    private $address;
    private $email; // Added field
    private $password;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function registerPatient($patientName, $age, $nicNo, $address, $email, $password) {
        // Validate fields
        if (empty($patientName) || empty($age) || empty($nicNo) || empty($address) || empty($email) || empty($password)) {
            return false;
        }

        $this->patientName = $patientName;
        $this->age = $age;
        $this->nicNo = $nicNo;
        $this->address = $address;
        $this->email = $email;  // Added line
        $this->password = password_hash($password, PASSWORD_DEFAULT);

        // Get the next available patient ID
        $nextPatientId = $this->db->getNextPatientId();

        $query = "INSERT INTO patients (PID, patientName, age, nicNo, address, email, password) 
                  VALUES ('$nextPatientId', '$this->patientName', '$this->age', '$this->nicNo', '$this->address', '$this->email', '$this->password')";

        $result = $this->db->executeQuery($query);

        if ($result) {
            $this->patientId = $nextPatientId;
            return true;
        }

        return false;
    }

    public function getPatientId() {
        return $this->patientId;
    }
}

// Example usage:

$db = new Database();
$patient = new Patient($db);

$errorMessage = ''; // Initialize error message

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $patientName = $_POST["patientName"];
    $age = $_POST["age"];
    $nicNo = $_POST["nicNo"];
    $address = $_POST["address"];
    $email = $_POST["email"];  // Added line
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];

    // Check if any field is empty
    if (empty($patientName) || empty($age) || empty($nicNo) || empty($address) || empty($email) || empty($password) || empty($confirmPassword)) {
        $errorMessage = "All fields are required. Please fill in all the details.";
    } elseif ($password !== $confirmPassword) {
        $errorMessage = "Passwords do not match. Please try again.";
    } else {
        if ($patient->registerPatient($patientName, $age, $nicNo, $address, $email, $password)) {
            $errorMessage = "Registration successful. Your Patient ID is: " . $patient->getPatientId();
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
    <title>Patient Registration</title>
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
            <div class="login-heading">Patient Registration</div>

            <?php
            if (isset($errorMessage)) {
                echo '<div class="alert alert-danger" role="alert">' . $errorMessage . '</div>';
            }
            ?>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="patientName">Patient Name</label>
                    <input type="text" class="form-control" name="patientName" required>
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
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" class="form-control" name="confirmPassword" required>
                </div>
                <button type="submit" class="btn btn-success" name="register">Register</button>
            </form>
            <br><br><br>
            <a href="appointment.php" class="create-account-btn">Already have an account? Sign in</a>
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
