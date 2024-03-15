<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'assets/dbh/connector.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About ABC Laboratories</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image:url("assets/img/backhome.jpeg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;   
        }
        .about-container {
            max-width: 1000px;
            margin: auto;
            margin-top: 50px;
            border: 2px solid #00008b;
            border-radius: 20px;
            padding: 20px;
            background-color: #fff;
            height: 1200px;
            text-align: center;
        }
        .about-heading {
            color: #00008b;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .about-paragraph {
            text-align: justify;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <?php include_once('assets/includes/navbar.php'); ?>
    
    <div class="container">
        <div class="about-container">
            <div class="about-heading">About ABC Laboratories</div>

            <img src="assets/img/abc-logo.png" alt="ABC Laboratories Logo" style="max-width: 200px; margin-bottom: 20px;">

            <p class="about-paragraph">
                ABC Laboratories is a leading research and development institution dedicated to advancing scientific knowledge and innovation. With a commitment to excellence, we strive to make groundbreaking contributions to various fields, including biotechnology, chemistry, and pharmaceuticals.
            </p>

            <p class="about-paragraph">
                Our team of experienced scientists and researchers work collaboratively to address complex challenges and drive meaningful advancements in science and technology. Through cutting-edge research and state-of-the-art facilities, ABC Laboratories is at the forefront of shaping the future of scientific discovery.
            </p>

            <p class="about-paragraph">
    Founded in [Year], ABC Laboratories has emerged as a beacon of scientific excellence, pushing the boundaries of research and innovation in the realms of biotechnology, chemistry, and pharmaceuticals. Our journey began with a visionary commitment to fostering a culture of intellectual curiosity and collaboration, aiming to address the most pressing challenges in the scientific community. Over the years, we have cultivated a diverse team of brilliant minds, bringing together experts from various disciplines to create a dynamic and synergistic environment.

    At ABC Laboratories, our mission extends beyond the confines of conventional research. We are dedicated to conducting groundbreaking studies that not only advance scientific knowledge but also have a tangible impact on global health and well-being. Our state-of-the-art facilities house cutting-edge equipment and technologies, empowering our researchers to explore novel ideas and develop innovative solutions. The commitment to staying at the forefront of scientific discovery is ingrained in our DNA, driving us to continually invest in the latest advancements and methodologies.

    Collaboration is the cornerstone of our success. We actively engage in partnerships with leading academic institutions, industry experts, and governmental bodies to amplify the impact of our research. These collaborations enable us to leverage collective expertise, share resources, and tackle complex scientific challenges with a multidisciplinary approach. By fostering an ecosystem of knowledge exchange, we contribute not only to our own growth but also to the broader scientific community.

    Our research portfolio spans a wide array of areas, including drug development, molecular biology, environmental science, and beyond. From pioneering new treatments for prevalent diseases to unraveling the mysteries of the natural world, ABC Laboratories remains committed to pushing the boundaries of what is possible. We take pride in our track record of delivering results that have far-reaching implications, influencing industries and shaping the future of scientific exploration.

    As we look towards the future, ABC Laboratories is poised to continue its legacy of excellence. We are dedicated to nurturing the next generation of scientists, providing them with the tools, knowledge, and opportunities to make their mark on the world. Our commitment to ethical research practices, environmental sustainability, and social responsibility underscores our holistic approach to scientific advancement.

    Join us on this exciting journey of discovery and innovation. ABC Laboratories invites you to be a part of a community that thrives on curiosity, collaboration, and the relentless pursuit of knowledge. Together, we will continue to redefine the boundaries of what is possible in the ever-evolving landscape of scientific exploration.
</p>


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
