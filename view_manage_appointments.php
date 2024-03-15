<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
}

// Fetch all records from the "appointments" table
$db = new Database();
$result = $db->executeQuery("SELECT * FROM appointments");

$records = [];
while ($row = $result->fetch_assoc()) {
    $records[] = $row;
}

// Handle delete button click
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    $deleteId = $_POST["delete"];
    $deleteQuery = "DELETE FROM appointments WHERE PID = '$deleteId'";
    $db->executeQuery($deleteQuery);
    header("Location: view_manage_appointments.php");
    exit();
}

// Handle search form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
    $searchPID = $_POST["searchPID"];
    $result = $db->executeQuery("SELECT * FROM appointments WHERE PID = '$searchPID'");
    $records = [];
    while ($row = $result->fetch_assoc()) {
        $records[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointments</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image:url("assets/img/backhome.jpeg");
            background-size: cover;
            background-position: center;
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
            background-color: #ff0000;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .delete-icon-inner {
            color: #ffffff;
        }

        .search-form {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <?php include_once('assets/includes/navbar.php'); ?>

    <div class="container">
        <h2>View Appointments</h2>

        <!-- Search Form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="search-form">
            <div class="form-group">
                <label for="searchPID">Search by Patient ID:</label>
                <input type="text" class="form-control" name="searchPID" required>
            </div>
            <button type="submit" class="btn btn-primary" name="search">Search</button>
        </form>

        <?php
        foreach ($records as $record) {
            echo '<div class="record-container">';
            echo '<span class="delete-icon" onclick="deleteRecord(\'' . $record['PID'] . '\')">';
            echo '<div class="delete-icon-inner">&#x2715;</div>';
            echo '</span>';
            echo '<strong>Patient ID:</strong> ' . $record['PID'] . '<br>';
            echo '<strong>Test Type:</strong> ' . $record['testType'] . '<br>';
            echo '<strong>Appointment Date:</strong> ' . $record['appointmentDate'] . '<br>';
            echo '<strong>Appointment Time:</strong> ' . $record['appointmentTime'] . '<br>';
            echo '<strong>Billing Email:</strong> ' . $record['billingEmail'] . '<br>';
            echo '</div>';
        }
        ?>

        <script>
            function deleteRecord(patientId) {
                if (confirm("Are you sure you want to delete this record?")) {
                    var form = document.createElement("form");
                    form.setAttribute("method", "post");
                    form.setAttribute("action", "view_manage_appointments.php");

                    var input = document.createElement("input");
                    input.setAttribute("type", "hidden");
                    input.setAttribute("name", "delete");
                    input.setAttribute("value", patientId);

                    form.appendChild(input);
                    document.body.appendChild(form);

                    form.submit();
                }
            }
        </script>
    </div>
    <br><br>
    <?php include_once('assets/includes/footer.php'); ?>
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
