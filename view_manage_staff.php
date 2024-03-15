<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'abc_lab';

// Create a connection to the database
$conn = mysqli_connect($hostname, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

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
}

// Fetch all records from the staff table
$db = new Database();
$result = $db->executeQuery("SELECT * FROM staff");

$records = [];
while ($row = $result->fetch_assoc()) {
    $records[] = $row;
}

// Handle delete button click
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    $deleteId = $_POST["delete"];
    $deleteQuery = "DELETE FROM staff WHERE SID = '$deleteId'";
    $db->executeQuery($deleteQuery);
    header("Location: view_manage_staff.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Staff Records</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image:url("assets/img/backhome.jpeg");
            background-size: cover; /* Make the background image cover the entire container */
            background-position: center; /* Center the background image */
            background-repeat: no-repeat;   
        }

        .container {
            margin-top: 50px;
        }

        .record-container {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            background-color: #fff;
            position: relative;
        }

        .delete-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 30px;
            height: 30px;
            background-color: #ff0000; /* Red background color */
            border-radius: 50%; /* Make it a circle */
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 1; /* Ensures it's above the container content */
        }

        .delete-icon-inner {
            color: #ffffff; /* White color for the cross mark */
        }
    </style>
</head>

<body>
    <?php include_once('assets/includes/navbar.php'); ?>

    <div class="container">
        <h2>View Staff Records</h2>

        <?php
        foreach ($records as $record) {
            echo '<div class="record-container">';
            echo '<span class="delete-icon" onclick="deleteRecord(\'' . $record['SID'] . '\')">';
            echo '<div class="delete-icon-inner">&#x2715;</div>';
            echo '</span>';
            echo '<strong>Staff ID:</strong> ' . $record['SID'] . '<br>';
            echo '<strong>Staff Name:</strong> ' . $record['staffName'] . '<br>';
            echo '<strong>Age:</strong> ' . $record['age'] . '<br>';
            echo '<strong>NIC No:</strong> ' . $record['nicNo'] . '<br>';
            echo '<strong>Address:</strong> ' . $record['address'] . '<br>';
            echo '</div>';
        }
        ?>

        <script>
            function deleteRecord(staffId) {
                if (confirm("Are you sure you want to delete this record?")) {
                    var form = document.createElement("form");
                    form.setAttribute("method", "post");
                    form.setAttribute("action", "view_manage_staff.php");

                    var input = document.createElement("input");
                    input.setAttribute("type", "hidden");
                    input.setAttribute("name", "delete");
                    input.setAttribute("value", staffId);

                    form.appendChild(input);
                    document.body.appendChild(form);

                    form.submit();
                }
            }
        </script>
    </div>
    <br><br>
    <?php include_once('assets/includes/footer.php'); ?>
    <!-- Include Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>
