<?php
require 'assets/dbh/connector.php';

class Database {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function executeQuery($query) {
        return $this->conn->query($query);
    }

    public function getLastInsertedId() {
        return $this->conn->insert_id;
    }

    public function insertLabReport($appointmentId, $pid, $labReportFileName) {
        $stmt = $this->conn->prepare("INSERT INTO lab_reports (appointment_id, PID, lab_report_file) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $appointmentId, $pid, $labReportFileName);

        if ($stmt->execute()) {
            return true;
        } else {
            die("Error: " . $stmt->error);
        }
    }

    public function getAppointments() {
        $query = "SELECT * FROM appointments";
        $result = $this->executeQuery($query);

        if (!$result) {
            die("Error fetching appointments: " . $this->conn->error);
        }

        $appointments = array();

        while ($row = $result->fetch_assoc()) {
            $appointments[] = $row;
        }

        return $appointments;
    }
}

$errorMessage = '';
$successMessage = '';
$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submitLabReport"])) {
    $appointmentId = $_POST["appointmentId"];
    $pid = $_POST["pid"];  // Added line to retrieve PID

    // Example: Save PDF file to the server (you may need to implement file upload logic)
    $labReportFileName = basename($_FILES["labReportFile"]["name"]);
    move_uploaded_file($_FILES["labReportFile"]["tmp_name"], "uploads/" . $labReportFileName);

    // Insert lab report into the 'lab_reports' table
    if ($db->insertLabReport($appointmentId, $pid, $labReportFileName)) {
        $successMessage = "Lab Report Added Successfully!";
    } else {
        $errorMessage = "Failed to add lab report. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Report Submission</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image:url("assets/img/backhome.jpeg");
            background-size: cover;
            background-position: center;
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
        <div class="login-heading">Lab Report Submission</div>

        <?php
        if (isset($errorMessage)) {
        echo '<div class="alert alert-danger" role="alert">' . $errorMessage . '</div>';
        }

        if (!empty($successMessage)) {
        echo '<script>alert("' . $successMessage . '");</script>';
        }
        ?>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="appointmentId">Select Appointment</label>
                    <select class="form-control" name="appointmentId" required>
                        <?php
                        $appointments = $db->getAppointments();
                        foreach ($appointments as $appointment) {
                            echo '<option value="' . $appointment['appointmentId'] . '">' . $appointment['appointmentId'] . ' - ' . $appointment['PID'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="pid">Enter PID</label>
                    <input type="text" class="form-control" name="pid" required>
                </div>
                <div class="form-group">
                    <label for="labReportFile">Add Lab Report (PDF)</label>
                    <input type="file" class="form-control" name="labReportFile" required>
                </div>

                <button type="submit" class="btn btn-success" name="submitLabReport">Submit Lab Report</button>
            </form>
        </div>
    </div>
    <br><br>
    
    <?php include_once('assets/includes/footer.php'); ?>
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
