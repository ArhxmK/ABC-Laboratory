<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet"> <!--navbar-->
     <!-- UNICONS -->
     <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Add this line to include Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-kzrGz6Z6BR/9tqM1vVzWbRJcn8lJFgU+2IeNjY3ADuDkXkRr+QjnJDlPHiWtrK+9Eq3p8Q6Q33Z5QoIiWdA5Wg==" crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Document</title>

    <style>
        
       /* ----- FEATURED BOX ----- */
.featured-box {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: auto;
    min-height: 100vh;
    background-image: url("assets/img/backhome.jpeg");
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    padding: 20px;
}

.featured-text {
    text-align: center;
    color: #000;
    max-width: 600px;
}
:root {
        --third-color: #00008b; /* Example color value */
        --color-white: #fff; /* Example color value */
        }

.featured-text-card span {
    background: var(--third-color);
    color: var(--color-white);
    padding: 3px 8px;
    font-size: 12px;
    border-radius: 5px;
}

.featured-name {
    font-size: 40px;
    font-weight: 600;
    margin-block: 20px;
}

.typedText {
    text-transform: capitalize;
    font-size: 30px;
}

.image {
    text-align: center;
    margin-top: 20px;
}

/* Limiting image width */
.image img {
    max-width: 100%; /* Ensure the image doesn't exceed its container */
    height: auto; /* Maintain aspect ratio */
    border-radius: 50%;
    animation: imgFloat 7s ease-in-out infinite;
}

@keyframes imgFloat {
    50% {
        transform: translateY(10px);
    }
}

/* Media query for larger screens */
@media (min-width: 1200px) {
    .image img {
        max-width: 300px; /* Adjust maximum width as needed for larger screens */
    }
}
    .social_icons{
    display: flex;
    margin-top: 5em;
    gap: 30px;
}
.icon{
    display: flex;
    justify-content: center;
    align-items: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    box-shadow: 0px 2px 5px 0px rgba(0, 0, 0, 0.25);
    cursor: pointer;
}
.icon:hover{
    color: var(--first-color);
}

    /* menu section */
.heading {
  text-align: center;
}
.heading span {
  color: var(--third-color);
  font-weight: 500;
}
.heading h2 {
  font-size: 100px(--h2-font);
}
.menu-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, auto));
  gap: 1.5rem;
  align-items: center;
}
.box {
  position: relative;
  margin-top: 2rem;
  height: auto;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  border-radius: 0.5rem;
  box-shadow: 0 2px 4px rgb(4 64 54 / 10%);
  padding: 10px;
}
.box-img {
  width: 200px;
  height: 200px;
}
.box-img img {
  width: 100%;
  height: 100%;
  object-fit: contain;
  object-position: center;
}
.box h2 {
  font-size: 1.2rem;
}
.box h3 {
  font-size: 1rem;
  font-weight: 400;
  margin: 4px 0 10px;
}
.box span {
  font-size: var(--p-font);
  font-weight: 500;
}
.box .bx {
  position: absolute;
  right: 0;
  top: 0;
  font-size: 20px;
  background: var(--main-color);
  border-radius: 0 0.5rem 0 0.5rem;
  padding: 5px 8px;
}
.box .bx:hover {
  background: #ff5e00;
}

.servives-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, auto));
  gap: 1.5rem;
  margin-top: 2rem;
}
.s-box {
  text-align: center;
}
.s-box img {
  width: 60px;
}
.s-box h3 {
  margin: 4px 0 10px;
}
.s-box p {
  font-size: 15px;
}

.welcome-text-box p {
        font-size: 16px; /* Adjust the font size as needed */
        text-align: center;
    }

    .welcome-text-box h2 {
        font-size: 30px; /* Adjust the heading font size as needed */
        text-align: center;
    }

.about-us{
    color: white; /* Set font color to white */
    background-image:url("assets/img/backgroundABC.jpeg");
    text-align: center;
}
.container {
        text-align: center;
    }
    .small-image {
        max-width: 100%; /* Adjust the width as needed */
        height: auto;
    }

    @media (min-width: 768px) {
        .small-image {
            max-width: 500px; /* Adjust the width as needed */
        }
    }

</style>
</head>

<body>
<?php include_once('assets/includes/navbar.php'); ?>
<div class="featured-box" id="home">
    <div class="featured-text">
        <div class="featured-text-card">
            <span>Welcome to ABC Laboratory</span>
        </div>
        <div class="featured-name">
            <p><span class="typedText"></span></p>
            <p>Experience the<br><span style="color: #00008b;">best</span> in <span style="color: #00008b;">healthcare.</span></p>
        </div>
        <br>
        <!-- Green color button for making appointments -->
<button class="make-appointments-btn" style="background-color: #00008b; color: white; padding: 10px 20px; font-size: 16px; cursor: pointer;" onclick="location.href='appointment.php';">
    Make Appointments
</button>
    </div>
    <div class="featured-image">
         <div class="image">
         <img src="assets/img/avatar.png" alt="avatar">
         </div>
</div>
</div>
<br><br>
<div class="welcome-text-box">
    <h2>Welcome to ABC Laboratories</h2>
    <p><strong>Dedicated to you</strong></p>

    <p><strong><span style="color: skyblue;">Compassion, Innovation & Excellence</span></strong></p>
    <p>Since our foundation in 1945, we have built a reputation for regional leadership in medical excellence and innovation, based on a simple philosophy: that improving the health of our community should be driven by passion as well as compassion.</p>

    <p>We offer a range of spacious modern rooms and are equipped with state-of-the-art critical care units. At Durdans, the best consultants, specialists, and employees are dedicated to providing exceptional clinical outcomes and the utmost customer satisfaction.</p>
</div>
</div>
<br><br><br><br>
    
<!-- About Us Section -->
<section class="about-us" id="about-us">
    <div class="main-container">
        <br><br>
        <!-- Heading and Paragraphs on the right -->
        <div class="custom-container">
            <h2>ABC Lab at your doorstep</h2>
            <br><br>
            <p style="font-size: 14px;">
            Unable to get to the hospital to get your tests done? Don’t worry. We now collect your blood and urine samples right from your home.
            </p>
            <button class="make-appointments-btn" style="background-color: green; color: white; padding: 10px 20px; font-size: 16px; cursor: pointer;" onclick="location.href='appointment.php';">
            Make Appointments
            </button>
            <br><br>
            <h2>For sample pickup call:</h2>
            <h2>0117431889</h2>
        </div>
    </div>
    <br>
</section>

<br><br><br>

    <!-- Service Section -->
    <section class="services" id="services">
        <div class="heading">
            <span>Services</span>
            <h2>We provide top-notch test services</h2>
        </div>

        <div class="servives-container">
            <!-- Box 1 -->
            <div class="s-box">
                <img src="https://images.pexels.com/photos/280453/pexels-photo-280453.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500.png" alt="">
                <h3>Full Blood Count(FBC)</h3>
                <p>Explore our Full Blood Count service for a comprehensive analysis of your blood components, ensuring proactive health insights.Accurate, efficient, and personalized diagnostics for your well-being.</p>
            </div>
            <!-- Box 2 -->
            <div class="s-box">
                <img src="https://images.pexels.com/photos/4391470/pexels-photo-4391470.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500.png" alt="">
                <h3>Blood Group</h3>
                <p>Discover your unique Blood Group with our swift and accurate testing service .Personalized insights for a proactive approach to your well-being. Effortless, essential, and enlightening.</p>
            </div>
            <!-- Box 3 -->
            <div class="s-box">
                <img src="https://images.pexels.com/photos/4393426/pexels-photo-4393426.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500.png" alt="">
                <h3>Kidney Profile</h3>
                <p>Elevate your health journey with our Kidney Profile service. Uncover comprehensive analyses for proactive well-being.Accurate diagnostics, personalized care – your key to renal vitality.</p>
            </div>
        </div>
    </section>
    <div class="container">
    <img class="small-image" src="assets/img/lab.png" alt="Small Image">
    </div>
    <br><br>
    <?php include_once('assets/includes/footer.php'); ?>


    <!-- ----- TYPING JS Link ----- -->
    <script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>

    <!-- ----- MAIN JS ----- -->
    <script src="assets/js/script.js"></script>

    <!-- Include Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    
</body>

</html>

