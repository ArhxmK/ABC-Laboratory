<?php
require 'assets/dbh/connector.php';

class Database {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function executeQuery($query) {
        return $this->conn->query($query);
    }

    public function getLastInsertedId() {
        return $this->conn->insert_id;
    }

    public function insertTestType($testTypeName, $price) {
        $stmt = $this->conn->prepare("INSERT INTO test_type (test_type_name, price) VALUES (?, ?)");
        $stmt->bind_param("ss", $testTypeName, $price);

        if ($stmt->execute()) {
            return true;
        } else {
            die("Error: " . $stmt->error);
        }
    }
}

$errorMessage = '';
$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $testTypeName = $_POST["testTypeName"];
    $testTypePrice = $_POST["testTypePrice"];

    if (empty($testTypeName) || empty($testTypePrice)) {
        $errorMessage = "All fields are required. Please fill in all the details.";
    } else {
        // Insert the test type into the 'test_type' table
        if ($db->insertTestType($testTypeName, $testTypePrice)) {
            $errorMessage = "Test type added successfully.";
        } else {
            $errorMessage = "Failed to add test type. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Type Registration</title>
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
            <div class="login-heading">Test Type Registration</div>

            <?php
            if (isset($errorMessage)) {
                echo '<div class="alert alert-danger" role="alert">' . $errorMessage . '</div>';
            }
            ?>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <!-- Add the new form fields for test type -->
                <div class="form-group">
                    <label for="testTypeName">Test Type Name</label>
                    <input type="text" class="form-control" name="testTypeName" required>
                </div>
                <div class="form-group">
                    <label for="testTypePrice">Price</label>
                    <input type="text" class="form-control" name="testTypePrice" required>
                </div>

                <button type="submit" class="btn btn-success" name="submit">Submit</button>
            </form>
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
