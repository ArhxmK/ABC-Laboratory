<?php
session_start();

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

    public function getTestTypes() {
        $result = $this->executeQuery("SELECT test_type_name, price FROM test_type");
        $testTypes = [];

        while ($row = $result->fetch_assoc()) {
            $testTypes[] = $row;
        }

        return $testTypes;
    }
}

class Appointment {
    private $db;
    private $appointmentId;
    private $patientId;
    private $testType;
    private $appointmentDate;
    private $appointmentTime;
    private $billingEmail;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function executeQuery($query) {
        return $this->db->executeQuery($query);
    }

    public function getLastInsertedId() {
        return $this->db->getLastInsertedId();
    }

    public function scheduleAppointment($patientId, $testType, $appointmentDate, $appointmentTime, $billingEmail) {
        // Validate fields
        if (empty($patientId) || empty($testType) || empty($appointmentDate) || empty($appointmentTime) || empty($billingEmail)) {
            return false;
        }

        $this->patientId = $patientId;
        $this->testType = $testType;
        $this->appointmentDate = $appointmentDate;
        $this->appointmentTime = $appointmentTime;
        $this->billingEmail = $billingEmail;

        $query = "INSERT INTO appointments (PID, testType, appointmentDate, appointmentTime, billingEmail) 
                  VALUES ('$this->patientId', '$this->testType', '$this->appointmentDate', '$this->appointmentTime', '$this->billingEmail')";

        $result = $this->executeQuery($query);

        if ($result) {
            $this->appointmentId = $this->getLastInsertedId();
            return true;
        }

        return false;
    }

    public function sendAppointmentEmail($subject, $message, $toEmail, $apiKey) {
        $url = 'https://api.web3forms.com/submit';

        $postData = array(
            'apikey' => $apiKey,
            'subject' => $subject,
            'email_message' => $message,
            'email_to' => $toEmail,
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            // Handle error
            echo 'Curl error: ' . curl_error($ch);
        }

        curl_close($ch);

        // You can handle the response as needed
        return $response;
    }

    public function getAppointmentId() {
        return $this->appointmentId;
    }
}

$db = new Database();
$appointment = new Appointment($db);

$errorMessage = ''; // Initialize error message

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["schedule"])) {
    $patientId = $_POST["patientId"];
    $testType = $_POST["testType"];
    $appointmentDate = $_POST["appointmentDate"];
    $appointmentTime = $_POST["appointmentTime"];
    $billingEmail = $_POST["billingEmail"];

    if (empty($patientId) || empty($testType) || empty($appointmentDate) || empty($appointmentTime) || empty($billingEmail)) {
        $errorMessage = "All fields are required. Please fill in all the details.";
    } else {
        if ($appointment->scheduleAppointment($patientId, $testType, $appointmentDate, $appointmentTime, $billingEmail)) {
            $errorMessage = "Appointment scheduled successfully. Your Appointment ID is: A" . str_pad($appointment->getAppointmentId(), 3, '0', STR_PAD_LEFT);

            // Send email to billing address with appointment details
            $subject = "Appointment Details";
            $message = "Patient ID: $patientId\nTest Type: $testType\nAppointment Date: $appointmentDate\nAppointment Time: $appointmentTime\nBilling Email: $billingEmail";

            // Replace 'xl5a6RssDxN61rul' with your actual web3forms API key
            $apiKey = '8daed13e-306b-40d0-9480-5b24a4f75e4c';

            // Send email using web3forms API
            $appointment->sendAppointmentEmail($subject, $message, $billingEmail, $apiKey);
        } else {
            $errorMessage = "Appointment scheduling failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Appointment</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image:url("assets/img/backhome.jpeg");
            background-size: cover; /* Make the background image cover the entire container */
            background-position: center; /* Center the background image */
            background-repeat: no-repeat;   
        }
        .appointment-container {
            max-width: 1000px;
            margin: auto;
            margin-top: 50px;
            border: 2px solid #00008b;
            border-radius: 20px;
            padding: 20px;
            background-color: #fff;
            height: 800px;
        }
        .appointment-heading {
            text-align: center;
            color: #00008b;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .login-btn {
            display: block;
            text-align: left;
            color: ;
        }
    </style>
</head>
<body>
    <?php include_once('assets/includes/navbar.php'); ?>
    
    <div class="container">
        <div class="appointment-container">
            <div class="appointment-heading">Schedule Appointment</div>

            <?php
            if (isset($errorMessage)) {
                echo '<div class="alert alert-success" role="alert">' . $errorMessage . '</div>';
            }
            ?>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="patientId">Patient ID</label>
                    <input type="text" class="form-control" name="patientId" required>
                </div>
                <div class="form-group">
                    <label for="testType">Test Type</label>
                    <select class="form-control" name="testType" required>
                        <?php
                        $testTypes = $db->getTestTypes();
                        foreach ($testTypes as $type) {
                            echo '<option value="' . $type['test_type_name'] . '">' . $type['test_type_name'] . ' - $' . $type['price'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="appointmentDate">Appointment Date</label>
                    <input type="date" class="form-control" name="appointmentDate" required>
                </div>
                <div class="form-group">
                    <label for="appointmentTime">Appointment Time</label>
                    <input type="time" class="form-control" name="appointmentTime" required>
                </div>
                <div class="form-group">
                    <label for="billingEmail">Billing Email Address</label>
                    <input type="email" class="form-control" name="billingEmail" required>
                </div>
                <!-- Payment Button and Message Box -->
                <div class="form-group">
                    <?php
                    if (isset($_SESSION['payment_success']) && $_SESSION['payment_success'] === true) {
                        echo '<div class="alert alert-success" role="alert">Payment Successful!</div>';
                        unset($_SESSION['payment_success']); // Unset the session variable to avoid displaying the message again on page reload
                    }
                    ?>
                    <a href="paymentgateway.php" class="btn btn-primary">Make Payment</a>
                </div>
                <button type="submit" class="btn btn-success" name="schedule">Schedule Appointment</button>
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
