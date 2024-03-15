<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .invalid-feedback,
        .empty-feedback {
            display: none;
        }

        .was-validated :placeholder-shown:invalid~.empty-feedback {
            display: block;
        }

        .was-validated :not(:placeholder-shown):invalid~.invalid-feedback {
            display: block;
        }

        .is-invalid,
        .was-validated :invalid {
            border-color: #dc3545;
        }
    </style>
</head>

<body>
    <?php include_once('assets/includes/navbar.php'); ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h1 class="my-3 text-3xl font-semibold text-gray-700 dark:text-gray-200">
                            Contact Us
                        </h1>
                        <p class="text-gray-400 dark:text-gray-400">
                            Fill up the form below to send us a message.
                        </p>
                    </div>
                    <div class="card-body">
                        <form action="https://api.web3forms.com/submit" method="POST" id="form" class="needs-validation" novalidate>
                            <input type="hidden" name="access_key" value="8daed13e-306b-40d0-9480-5b24a4f75e4c" />
                            <input type="hidden" name="subject" value="New Submission from Web3Forms" />
                            <input type="checkbox" name="botcheck" id="" style="display: none;" />

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="first_name">First Name</label>
                                    <input type="text" name="name" id="first_name" placeholder="John" required class="form-control" />
                                    <div class="empty-feedback invalid-feedback text-danger small mt-1">
                                        Please provide your first name.
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="lname">Last Name</label>
                                    <input type="text" name="last_name" id="lname" placeholder="Doe" required class="form-control" />
                                    <div class="empty-feedback invalid-feedback text-danger small mt-1">
                                        Please provide your last name.
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="email">Email Address</label>
                                    <input type="email" name="email" id="email" placeholder="you@company.com" required class="form-control" />
                                    <div class="empty-feedback text-danger small mt-1">
                                        Please provide your email address.
                                    </div>
                                    <div class="invalid-feedback text-danger small mt-1">
                                        Please provide a valid email address.
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" name="phone" id="phone" placeholder="+1 (555) 1234-567" required class="form-control" />
                                    <div class="empty-feedback invalid-feedback text-danger small mt-1">
                                        Please provide your phone number.
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="message">Your Message</label>
                                <textarea rows="5" name="message" id="message" placeholder="Your Message" class="form-control" required></textarea>
                                <div class="empty-feedback invalid-feedback text-danger small mt-1">
                                    Please enter your message.
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    Send Message
                                </button>
                            </div>

                            <p class="text-base text-center text-gray-400" id="result"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <?php include_once('assets/includes/footer.php'); ?>
    <!-- Include Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>
