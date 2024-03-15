<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'assets/dbh/connector.php';

$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["pay"])) {
    $cardHolder = $_POST["cardHolder"];
    $cardNumber = $_POST["cardNumber"];
    $expiryDateInput = $_POST["expiryDate"];
    $cvc = $_POST["cvc"];

    // Validate each field
    if (empty($cardHolder) || empty($cardNumber) || empty($expiryDateInput) || empty($cvc)) {
        $errorMessage = "All fields are required. Please fill in all the details.";
    } else {
        // Process payment or record the card details as needed
        // Example: Insert payment details into the 'payments' table

        // Convert the input date to the correct MySQL format
        $expiryDate = DateTime::createFromFormat('m / y', $expiryDateInput);
        $expiryDateFormatted = $expiryDate ? $expiryDate->format('Y-m-d') : null;

        // Using prepared statement to prevent SQL injection
        $query = "INSERT INTO payments (cardHolder, cardNumber, expiryDate, cvc, amount) VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssd", $cardHolder, $cardNumber, $expiryDateFormatted, $cvc, $amount);

        // Adjust the 'd' in 'bind_param' to the appropriate type if 'amount' is not a double
        $amount = 100.00;  // Adjust the amount or add dynamic calculation

        if ($stmt->execute()) {
            // Success
            $_SESSION['payment_success'] = true; // Set the session variable to true
            $successMessage = "Payment successful. Your card details have been recorded.";
            // Redirect to make_appointment.php or wherever needed
            header("refresh:3;url=makeappointment.php"); // Redirect after 3 seconds
        } else {
            // Error
            $errorMessage = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Checkout Form</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">
    <link rel="stylesheet" href="assets/css/payment.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include_once('assets/includes/navbar.php'); ?>
    <div class="wrapper">
        <div class="payment">
            <div class="payment-logo">
                <p>p</p>
            </div>
            
            <h2>Payment Gateway</h2>
            <form action="" method="POST"> <!-- Remove the action attribute to submit to the same page -->
                <div class="form">
                    <?php if (!empty($successMessage)): ?>
                        <p><?php echo $successMessage; ?></p>
                        <p>Redirecting to make appointment...</p>
                        <script>
                            setTimeout(function() {
                                window.location.href = "makeappointment.php";
                            }, 3000); // Redirect after 3 seconds
                        </script>
                    <?php else: ?>
                        <?php if (!empty($errorMessage)): ?>
                            <p><?php echo $errorMessage; ?></p>
                        <?php endif; ?>
                        <div class="card space icon-relative">
                            <label class="label">Card holder:</label>
                            <input type="text" name="cardHolder" class="input" placeholder="Coding Market">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="card space icon-relative">
                            <label class="label">Card number:</label>
                            <input type="text" name="cardNumber" class="input" data-mask="0000 0000 0000 0000" placeholder="Card Number">
                            <i class="far fa-credit-card"></i>
                        </div>
                        <div class="card-grp space">
                            <div class="card-item icon-relative">
                                <label class="label">Expiry date:</label>
                                <input type="text" name="expiryDate" class="input" data-mask="00 / 00" placeholder="00 / 00">
                                <i class="far fa-calendar-alt"></i>
                            </div>
                            <div class="card-item icon-relative">
                                <label class="label">CVC:</label>
                                <input type="text" name="cvc" class="input" data-mask="000" placeholder="000">
                                <i class="fas fa-lock"></i>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn" name="pay">Pay</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
</body>
</html>
