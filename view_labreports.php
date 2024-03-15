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

    public function getLabReportsByPID($pid) {
        $query = "SELECT lab_reports.*, appointments.PID
                  FROM lab_reports
                  INNER JOIN appointments ON lab_reports.appointment_id = appointments.appointmentId
                  WHERE appointments.PID = '$pid'";
        return $this->executeQuery($query);
    }
}

// Fetch all records from the "lab_reports" table
$db = new Database();
$labReports = [];
$searchPID = '';

// Handle search form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
    $searchPID = $_POST["searchPID"];
    $labReports = $db->getLabReportsByPID($searchPID);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Lab Reports</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url("assets/img/backhome.jpeg");
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

        .options {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .search-form {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <?php include_once('assets/includes/navbar.php'); ?>

    <div class="container">
        <h2>View Lab Reports</h2>

        <!-- Search Form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="search-form">
            <div class="form-group">
                <label for="searchPID">Search by Patient ID:</label>
                <input type="text" class="form-control" name="searchPID" value="<?php echo $searchPID; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="search">Search</button>
        </form>

        <?php
        foreach ($labReports as $labReport) {
            echo '<div class="record-container">';
            echo '<strong>Patient ID:</strong> ' . $labReport['PID'] . '<br>';
            echo '<strong>Lab Report File:</strong> ' . $labReport['lab_report_file'] . '<br>';
            echo '<strong>Created At:</strong> ' . $labReport['created_at'] . '<br>';
            echo '<div class="options">';
            echo '<a href="view_lab_report.php?filename=' . urlencode($labReport['lab_report_file']) . '" class="btn btn-info" target="_blank">View PDF</a>';
            echo '<a href="download_lab_report.php?filename=' . urlencode($labReport['lab_report_file']) . '" class="btn btn-success" download>Download PDF</a>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
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
