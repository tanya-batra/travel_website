<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    // Your reCAPTCHA secret key
    $recaptchaSecret = '6LdfNTcqAAAAAGOnpULHozpQj1EXGC20bowH1zEG';
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    // Verify reCAPTCHA
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaResponse");
    $responseKeys = json_decode($response, true);

    if (intval($responseKeys["success"]) !== 1) {
        echo '<script>alert("Please complete the CAPTCHA."); window.history.back();</script>';
        exit;
    }
$companyname = htmlspecialchars(trim($_POST["companyname"]));
    $fname = htmlspecialchars(trim($_POST["fname"]));
    $lname = htmlspecialchars(trim($_POST["lname"]));
    $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
    $phone = htmlspecialchars(trim($_POST["phone"]));
    $services = htmlspecialchars(trim($_POST["services"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    if (empty($companyname) || empty($fname) || empty($lname) || empty($email)  || empty($phone)  || empty($services) || empty($message)) {
        echo '<script>alert("All fields are required."); window.history.back();</script>';
        exit;
    }

    require 'PHPMailer/PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer/PHPMailer.php';
    require 'PHPMailer/PHPMailer/SMTP.php';

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'Connecteasytravels@gmail.com';
        $mail->Password   = 'jeolacyulgnzkkwn';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('Connecteasytravels@gmail.com', 'Connect Easy Travels');
        $mail->addAddress('Connecteasytravels@gmail.com', 'Connect Easy');

        $mail->isHTML(true);
        $mail->Subject = "Business user  contact with u  ";
        $mail->Body    = "Sender Company Name: $companyname <br> Sender First Name: $fname <br>Sender Last Name: $lname <br>Sender mobile no : $phone <br>Service: $services   <br>Sender Email: $email <br>Message: $message";

        $mail->send();
        echo '<script>alert("Thank you! Your message has been successfully sent."); window.location.href="b2b.php";</script>';
    } catch (Exception $e) {
        echo '<script>alert("Message could not be sent. Mailer Error: ' . $mail->ErrorInfo . '"); window.history.back();</script>';
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="favicon.png">
    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Source+Serif+Pro:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" href="css/daterangepicker.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Connecteasytravels | B2B </title>
     <script src="https://www.google.com/recaptcha/api.js" async defer></script>   
</head>
<style>
    .site-navigation {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .site-navigation img {
        max-width: 150px;
    }
    .nav-tabs .nav-link {
                font-weight: bold;
                color: #000;
            }
            .nav-tabs .nav-link.active {
                background-color: #1A374D;
                color: #fff;
            }
            .form-control {
                border-radius: 0;
                box-shadow: none;
            }
            .btn-primary {
                background-color: #1A374D;
                border-color: #fff;
              
                font-weight: bold;
            }
           
    		.btn{
    			background-color: #1A374D;
                border-color: #fff;
    			color:white;
                font-weight: bold;
    		}
    		.btn:hover{
    			background-color:#6998AB;
    			color:black;
    		}
           
            .custom-checkbox-label {
                margin-top: 10px;
                margin-left: 15px;
                font-size: 14px;
            }
            .toggle-button {
                background-color:#1A374D;
                color: #fff;
                padding: 5px 10px;
                border-radius: 5px;
            }
          
    		.dropdown-menu {
                padding: 20px;
                width: 300px;
               
            }
            .dropdown-menu .btn {
                width: 30px;
                height: 30px;
                line-height: 20px;
                padding: 0;
            }
            .dropdown-menu .count {
                width: 40px;
                text-align: center;
                font-size: 16px;
                line-height: 30px;
            }
            .dropdown-menu .done-btn {
                width: 100%;
                margin-top: 10px;
                background-color: #1A374D;
                color: white;
            }
            .swap-button {
                background-color:#1A374D;
                color: #fff;
                border-radius: 50%;
                border: 1px solid #ddd;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                width: 30px;
                height: 30px;
                margin: 0 ;
            }
    
            .swap-button:hover {
                background-color: #6998AB;
            }
            .date-box {
                border: 1px solid #ccc;
                border-radius: 5px;
                padding: 0 6px;
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                min-height: 37px;
                text-align: center;
                cursor: pointer;
                margin-bottom: 20px;
            }
    
            .date-box i {
                font-size: 20px;
                margin-right: 8px;
                color: #5a5a5a;
            }
    
            .date-box .date-display {
                font-size: 16px;
                color: #5a5a5a;
            }
    
            .date-box .date-display span {
                display: block;
                font-size: 13px;
                color: #999;
            }
    
            .date-box input[type="date"] {
                display: none;
            }
            .call-button {
                display: flex;
                align-items: center;
                background-color: #1A374D;
                border-radius: 50px;
                padding: 4px 12px;
                color: white;
                font-weight:500;
                box-shadow: 0px 0px 5px #6998AB;
                margin-left: 10px;
            }
    
           
    
            .call-button a {
                color: #6998AB;
                text-decoration: none;
            }
    
            .call-button a:hover {
                text-decoration: underline;
            }
    
            .call-button i {
                color: #6998AB;
                margin-right: 8px;
            }
            .tour { margin: -6em 0 0;}
             .whatsapp-icon {
    position: fixed;
    bottom: 20px;
    right: 20px; /* Changed from 'left' to 'right' */
    background-color: #25D366;
    color: white;
    border-radius: 50%;
    padding: 15px;
    font-size: 24px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}



</style>

<body>
   
    
    
   <!-- Topbar Start -->
<div class="container-fluid px-5 " style="background-color:#1A374D;">
    <div class="row gx-0 align-items-center">
         <!--  <div class="col-lg-2 col-6 text-center text-lg-start mb-lg-0">
             <div class="d-flex">
                 <a href="#" class="text-light py-1 " style="text-decoration:none;">
                    <i class="fa-solid fa-user"></i> Agent Login
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-6 text-center text-lg-start mb-lg-0">
            <div class="d-flex">
                <a href="#" class="text-light py-1 " style="text-decoration:none;">
                    <i class="fa-solid fa-user"></i> Customer Login
                </a>
            </div>
        </div>-->
        <div class="col-lg-8 col-12 text-center text-lg-start mb-lg-0">
            <div class="d-flex justify-content-center justify-content-lg-start">
                <a href="tel:+14167712292" class="me-4 text-light py-1" style="text-decoration:none;">
                    <i class="fa-solid fa-phone"></i> Call us Now +14167712292
                </a>
            </div>
        </div>
        <div class="col-lg-4 col-12 row-cols-1 mb-2 mb-lg-0">
            <div class="d-inline-flex align-items-center justify-content-center justify-content-lg-end py-1" style="height: 45px;">
                <a href="https://www.facebook.com/profile.php?id=61565488796900" class="btn me-4" href=""><i class="fab fa-facebook-f fw-normal"></i></a>
                <a class="btn me-4" href=""><i class="fab fa-linkedin-in fw-normal"></i></a>
                <a href="https://www.instagram.com/connecteasytravels24/" class="btn me-4" href=""><i class="fab fa-instagram fw-normal"></i></a>
                 <a href="https://www.instagram.com/connecteasytravels24/" class="btn me-4" href=""><i class="fab fa-youtube fw-normal"></i></a>
                <a href="https://www.instagram.com/connecteasytravels24/" class="btn me-4" href=""><i class="fab fa-tiktok fw-normal"></i></a>
            </div>
        </div>
    </div>
</div>
<!-- Topbar End -->


<!-- Navbar & Hero Start -->
<div class="container-fluid nav-bar p-0">
    <nav class="navbar navbar-expand-lg navbar-light bg-white px-4 px-lg-5 py-3 py-lg-0">
        <a href="index.php" class="navbar-brand p-0">
            <h1 class="display-5 text-secondary m-0"><img src="images/logo.png" class="img-fluid" alt=""></h1>
        </a>
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarCollapse">
            <div class="navbar-nav py-0">
                <a href="index.php" class="nav-item nav-link ">Home</a>
                <a href="services.php" class="nav-item nav-link">Services</a>
              <!--<div class="nav-item dropdown">-->
              <!--      <a href="#" class="nav-link" data-bs-toggle="dropdown"><span class="dropdown-toggle">Holidays</span></a>-->
              <!--      <div class="dropdown-menu m-0">-->
              <!--          <a href="canada.php" class="dropdown-item">Canada Holidays Package</a>-->
              <!--          <a href="us.php" class="dropdown-item">USA Holidays Package</a>-->
              <!--          <a href="mexico.php" class="dropdown-item">Mexico Holidays Package</a>-->
              <!--          <a href="dubai.php" class="dropdown-item">Dubai Holidays Package</a>-->
              <!--          <a href="maldives.php" class="dropdown-item">Maldives Holidays Package</a>-->
              <!--          <a href="india.php" class="dropdown-item">India Holidays Package</a>-->
                      
              <!--          <a href="greek.php" class="dropdown-item">Greek Holidays Package</a>-->
              <!--              <a href="australia.php" class="dropdown-item">Australia Holidays Package</a>-->
              <!--      </div>-->
              <!--  </div>-->
                <a href="b2b.php" class="nav-item nav-link active">B2B</a>
                <a href="about.php" class="nav-item nav-link">About Us</a>
                
                <a href="contact.php" class="nav-item nav-link">Contact</a>
            </div>
        </div>
    </nav>
</div>
<!-- Navbar & Hero End -->


  <div class="hero hero-inner">
    <div class="container">
      <div class="row ">
        <div class="col-lg-8 ">
          <div class="intro-wrap">
            <h1 class="mb-0 display-2 fw-bold">A Dynamic Ally For Your Business</h1>
            <h2 class="display-6" style="color: #6998AB">Over <span style="color: #1A374D;">24</span> Satisfied Businesses

            </h2>
            <p><a href="contact.php" class="btn">Know More</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
 
 <!--<div class="scrolling-text">
   <!-- <span>
        Best Travel Agent In Dubai <img src="https://cdn-icons-png.flaticon.com/512/541/541415.png" alt="Check Icon">
        Best Travel Agent In Dubai <img src="https://cdn-icons-png.flaticon.com/512/541/541415.png" alt="Check Icon">
        Best Travel Agent In Dubai <img src="https://cdn-icons-png.flaticon.com/512/541/541415.png" alt="Check Icon">
        Best Travel Agent In Dubai <img src="https://cdn-icons-png.flaticon.com/512/541/541415.png" alt="Check Icon">
        Best Travel Agent In Dubai <img src="https://cdn-icons-png.flaticon.com/512/541/541415.png" alt="Check Icon">
        Best Travel Agent In Dubai <img src="https://cdn-icons-png.flaticon.com/512/541/541415.png" alt="Check Icon">
    </span>
</div>-->
<div class="container mt-5 mb-4">
  <div class="row ">
      <!-- Left Content Section -->
      <div class="col-md-7 content ">
          <h2 class="text-center"><span style="color: #1A374D;">Partner with Connect Easy Travels</span> </h2>
          <p>At <b>Connect Easy Travels</b>, we specialize in offering customized travel solutions for businesses, providing seamless and efficient travel planning services. Whether you need corporate travel management, group travel solutions, or destination event planning, we ensure that your business trips are hassle-free and cost-effective.
</p>
          <p>If your business is looking for a reliable travel partner, please fill out the form below, and one of our specialists will get back to you promptly.

</p>
                    <h2 class="text-center"><span style="color: #1A374D;">Why Work with Us?</span> </h2>
          <p> <b>Tailored Corporate Solutions</b> -  We create travel plans that align with your business objectives and budget.

</p>
          <p> <b>Expert Support</b>- Our team is available 24/7, providing ongoing assistance for all your travel needs.

</p>
          <p> <b>Cost-Effective Packages</b> - We offer competitive pricing and exclusive deals through our global partnerships

</p>

      </div>

      <!-- Right Form Section -->
      <div class="col-md-5 form-section">
          <h3 class="text-center">Register your business</h3>
          <form class="contact-form" action="" method="POST" data-aos="fade-up" data-aos-delay="200" onsubmit="return validateForm()">
    <div class="row">
                <div class="col-12">
            <div class="form-group">
                <label class="text-black" for="companyname">Company name</label>
                <input type="text" class="form-control" id="companyname" name="companyname" required style="border:1px solid black;">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="text-black" for="fname">First name</label>
                <input type="text" class="form-control" id="fname" name="fname" required style="border:1px solid black;">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="text-black" for="lname">Last name</label>
                <input type="text" class="form-control" id="lname" name="lname" required style="border:1px solid black;">
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="text-black" for="email">Email address</label>
        <input type="email" class="form-control" id="email" name="email" required style="border:1px solid black;">
    </div>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label class="text-black" for="fname">Mobile No </label>
                <input type="tel" id="phone" class="form-control" name="phone" required style="border:1px solid black;" />
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="text-black" for="lname">Services</label>
                <select name="services" id="services"  class="form-control" style="border:1px solid black;">
  <option value="Flight Bookings">Flight Bookings</option>
  <option value="Accommodation Reservations"> Accommodation Reservations</option>
  <option value="Customized Travel Packages">Customized Travel Packages</option>
  <option value="Car Rentals and Transportation">Car Rentals and Transportation</option>
  <option value="Cruise Bookings">Cruise Bookings</option>
  <option value="Destination Wedding Planning">Destination Wedding Plannings</option>
  <option value="Travel Insurance">Travel Insurance</option>
  <option value="Group Travel Services">Group Travel Services</option>
</select>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="text-black" for="message">Message</label>
        <textarea class="form-control" id="message" name="message" cols="30" rows="5" required style="border:1px solid black;"></textarea>
    </div>
    <div class="form-group">
        <div class="g-recaptcha" data-sitekey="6LdfNTcqAAAAAFzUQuM_Pn4--GwyuraqXsxy1_Gs"></div>
    </div>
    <button type="submit" name="submit" class="btn ">Send Message</button>
</form>
      </div>
  </div>
</div>

<div class="container text-center mt-4 ">
  <div class="row">
      <!-- Clients Section -->
      <div class="col-md-4">
          <div class="section-title">Clients</div>
         
          <div class="section-number">1200+</div>
          <div class="section-description">Our track record speaks for itself - a vast clientele places their trust in us for their application processing needs.</div>
      </div>

      <!-- Destinations Section -->
      <div class="col-md-4">
          <div class="section-title">Destinations</div>
          
          <div class="section-number">24+</div>
          <div class="section-description">Our comprehensive visa consultancy services extend to over 40 countries worldwide.</div>
      </div>

      <!-- Happiness Section -->
      <div class="col-md-4">
          <div class="section-title">Happiness</div>
          
          <div class="icon"><i class="fas fa-infinity"></i></div>
          <div class="section-description">From exhilarating desert safaris to mesmerizing dhow cruises along the Dubai Creek, every moment is crafted to bring smiles and unforgettable memories.</div>
      </div>
  </div>
</div>
<div class="hero hero-inner">
  <div class="container">
    <div class="row ">
      <div class="col-lg-12 ">
        <div class="intro-wrap">
          <h1 class="mb-0 display-2 fw-bold">Home Based Agency, located in the heart of Brampton
</h1>
          <h2 class="display-6" style="color: #6998AB">HEAD OFFICE: 221-2155 Leanne Blvd. Mississauga, ON L5K 2K8
          </h2>
          <section class="map-section map-style-9">
            <div class="map-container">
             <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d2892.867909453061!2d-79.65462752500108!3d43.52594716065363!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sHEAD%20OFFICE%3A%20221-2155%20Leanne%20Blvd.%20Mississauga%2C%20ON%20L5K%202K8!5e0!3m2!1sen!2sin!4v1727240628475!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
</div>


     <!--menu bar start -->
    
 <?php include 'element/footer.php';?>
 
   <!--menu bar end -->



   

  <div id="overlayer"></div>
  <div class="loader">
    <div class="spinner-border" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.animateNumber.min.js"></script>
  <script src="js/jquery.waypoints.min.js"></script>
  <script src="js/jquery.fancybox.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/moment.min.js"></script>
  <script src="js/daterangepicker.js"></script>

  <script src="js/typed.js"></script>
  
  <script src="js/custom.js"></script>
   <script>
    function validateForm() {
        var response = grecaptcha.getResponse();
        if(response.length == 0) { 
            alert("Please complete the CAPTCHA.");
            return false;
        }
        return true;
    }

    <?php if (!empty($successMessage)) : ?>
        alert("<?php echo $successMessage; ?>");
    <?php endif; ?>

    <?php if (!empty($errorMessage)) : ?>
        alert("<?php echo $errorMessage; ?>");
    <?php endif; ?>
    </script>

</body>

</html>
