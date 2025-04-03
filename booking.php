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

    // Trim and validate inputs
    $adults = trim($_POST["adults"]);
    $date = trim($_POST["departdate"]);
    $returndate = trim($_POST["returndate"]);
    $fullname = trim($_POST["fullname"]);
    $children = trim($_POST["children"]);
    $email = trim($_POST["email"]);
    $contact = trim($_POST["phone"]);
    $services = trim($_POST["service"]);
    $trip = trim($_POST["typeoftrip"]);
    $message = trim($_POST["message"]);
    $country = trim($_POST["country"]);

    if (empty($fullname) || empty($adults) || empty($children) || empty($date) || empty($country) || empty($email) || empty($contact) || empty($services) || empty($trip) || empty($message)) {
        echo '<script>alert("All fields are required."); window.history.back();</script>';
        exit;
    }
include("connection.php");
 // Automatically set return date to '0' for One Way Trip
    if ($tripType == 'One Way Trip') {
        $returnDate = '0';
    }

    // Make sure return date is not compulsory for "Round Trip"
    if ($tripType == 'Round Trip' && empty($returnDate)) {
        die("Return date is required for a round trip.");
    }
   
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO booking (fullname, adults, children, departdate, returndate, email, phone, service, typeoftrip, country, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisssssssss", $fullname, $adults, $children, $date, $returndate, $email, $contact, $services, $trip, $country, $message);

    // Execute the statement
    if ($stmt->execute()) {
        // Close the statement
        $stmt->close();

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
            $mail->Subject = "User contact with you for Booking";
            $mail->Body    = "Sender Full Name: $fullname <br> Adults: $adults <br> Childrens: $children <br> Date of Journey: $date <br> Return Date of Journey: $returndate <br> Sender Contact no: $contact <br> Service: $services <br> Type of trip: $trip <br> Country: $country <br> Sender Email: $email <br> Message: $message";

            $mail->send();
            echo '<script>alert("Thank you! Your message has been successfully sent."); window.location.href="booking.php";</script>';
        } catch (Exception $e) {
            echo '<script>alert("Message could not be sent. Mailer Error: ' . $mail->ErrorInfo . '"); window.history.back();</script>';
        }
    } else {
        echo '<script>alert("Data could not be saved. Error: ' . $stmt->error . '"); window.history.back();</script>';
    }

    // Close the connection
    $conn->close();
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
    <title>Connecteasytravels | Booking </title>
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

.head-heading {
	position: absolute;
	background: rgba(0,30,50,.35);
	display: flex;
	align-items: center;
	justify-content: center;
	margin: auto;
	inset: 0;
	color: #fff;
	font-size: 50px;
	text-align: center;
	line-height: 1em;
	font-weight: 600;
	text-shadow: 3px 3px 8px rgba(0,0,0,.4);
}
.hero {
	position: relative;
}

@media(max-width:767px) {
    .hero .container-fluid {
    	padding: 0;
    }
    .head-heading {
    	font-size: 40px;
    }
}

</style>

<body>
 <!-- Topbar Start -->
<div class="container-fluid px-5 " style="background-color:#1A374D;">
    <div class="row gx-0 align-items-center">
       <!--- <div class="col-lg-2 col-6 text-center text-lg-start mb-lg-0">
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
        </div>---->
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
                <a href="index.php" class="nav-item nav-link active">Home</a>
                <a href="services.php" class="nav-item nav-link">Services</a>
                <!-- <div class="nav-item dropdown">-->
                <!--    <a href="#" class="nav-link" data-bs-toggle="dropdown"><span class="dropdown-toggle">Holidays</span></a>-->
                <!--    <div class="dropdown-menu m-0">-->
                <!--        <a href="canada.php" class="dropdown-item">Canada Holidays Package</a>-->
                <!--        <a href="us.php" class="dropdown-item">USA Holidays Package</a>-->
                <!--        <a href="mexico.php" class="dropdown-item">Mexico Holidays Package</a>-->
                <!--        <a href="dubai.php" class="dropdown-item">Dubai Holidays Package</a>-->
                <!--        <a href="maldives.php" class="dropdown-item">Maldives Holidays Package</a>-->
                <!--        <a href="india.php" class="dropdown-item">India Holidays Package</a>-->
                      
                <!--        <a href="greek.php" class="dropdown-item">Greek Holidays Package</a>-->
                <!--            <a href="australia.php" class="dropdown-item">Australia Holidays Package</a>-->
                <!--    </div>-->
                <!--</div>-->
               <!---  <a href="b2b.php" class="nav-item nav-link">B2B</a>--->
                <a href="about.php" class="nav-item nav-link">About Us </a>
               
                <a href="contact.php" class="nav-item nav-link">Contact</a>
            </div>
        </div>
    </nav>
</div>
<!-- Navbar & Hero End -->



  <div class="hero hero-inner">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mx-auto text-center">
          <div class="intro-wrap">
            <h1 class="mb-5">Booking</h1>
            
          </div>
        </div>
      </div>
    </div>
</div>
  
 <div class="container">
    <div class="row">
        <div class="col-lg-7 col-12">
            <div class="form-container">
                <h2 class="mb-4 text-center">Booking Request</h2>
                <p>Booking is your one-stop destination for the best budget holiday tours in India.</p>

               <form action="" method="POST" onsubmit="return validateForm()">
            <div class="form-section-title">YOUR TRAVEL REQUIREMENT</div>
            <div class="row mb-3">
                <!-- Service Selection -->
                <div class="col-md-6 col-12 mb-3">
                    <div class="form-group">
                        <label for="services" class="form-label">Services *</label>
                        <select name="service" id="services" class="form-control" required>
                            <option selected disabled>Services</option>
                            <option value="Flight Bookings">Flight Bookings</option>
                            <option value="Accommodation Reservations">Accommodation Reservations</option>
                            <option value="Customized Travel Packages">Customized Travel Packages</option>
                            <option value="Car Rentals and Transportation">Car Rentals and Transportation</option>
                            <option value="Cruise Bookings">Cruise Bookings</option>
                            <option value="Destination Wedding Planning">Destination Wedding Planning</option>
                            <option value="Travel Insurance">Travel Insurance</option>
                            <option value="Group Travel Services">Group Travel Services</option>
                        </select>
                    </div>
                </div>
                <!-- Depart Date -->
                <div class="col-md-6 col-12 mb-3"  id="departDateBox">
                    <div class="form-group">
                        <label for="departDate" class="form-label">Date of Journey *</label>
                        <input type="date" id="departDate" name="departdate"  min='2023-01-01' max='3000-01-01' class="form-control" >
                    </div>
                </div>
                <!-- Return Date -->
                <div class="col-md-6 col-12 mb-3" id="returnDateBox">
                    <div class="form-group">
                        <label for="returnDate" class="form-label">Return Date *</label>
                        <input type="date" id="returnDate" name="returndate"  min='2023-01-01' max='3000-01-01' class="form-control"  >
                    </div>
                </div>
                <!-- Trip Type -->
                <div class="col-md-6 col-12 mb-3">
                    <div class="form-group">
                        <label for="trip" class="form-label">Type of Trip *</label>
                        <select name="typeoftrip" id="trip" class="form-control" required>
                            <option selected disabled>Select Trip</option>
                            <option value="Round Trip">Round Trip</option>
                            <option value="One Way Trip">One Way Trip</option>
                        </select>
                    </div>
                    
                </div>
            </div>

            <!-- Adult and Children Count -->
            <div class="row mb-3">
                <div class="col-md-6 col-12 mb-3">
                    <div class="form-group">
                        <label for="adults" class="form-label">Adults (Above 18 years) *</label>
                        <input type="number" class="form-control" id="adults" name="adults" placeholder="Number of Adults" required>
                    </div>
                </div>
                <div class="col-md-6 col-12 mb-3">
                    <div class="form-group">
                        <label for="children" class="form-label">Children (5-12 years)</label>
                        <input type="number" class="form-control" id="children" name="children" placeholder="Number of Children">
                    </div>
                </div>
            </div>

                    <!-- Personal Details Section -->
                    <div class="form-section-title mb-3">YOUR PERSONAL DETAILS</div>
                    <div class="row mb-3">
                        <div class="col-md-6 col-12 mb-3">
                            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Full Name" required>
                        </div>
                 <div class="col-md-6 col-12">
                 
                    <select id="country" name="country" class="form-select" required>
                        <option selected disabled >Select Your Country</option>
                       
    <option value="Afghanistan">Afghanistan</option>
    <option value="Albania">Albania</option>
    <option value="Algeria">Algeria</option>
    <option value="American Samoa">American Samoa</option>
    <option value="Andorra">Andorra</option>
    <option value="Angola">Angola</option>
    <option value="Anguilla">Anguilla</option>
    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
    <option value="Argentina">Argentina</option>
    <option value="Armenia">Armenia</option>
    <option value="Aruba">Aruba</option>
    <option value="Australia">Australia</option>
    <option value="Austria">Austria</option>
    <option value="Azerbaijan">Azerbaijan</option>
    <option value="Bahamas">Bahamas</option>
    <option value="Bahrain">Bahrain</option>
    <option value="Bangladesh">Bangladesh</option>
    <option value="Barbados">Barbados</option>
    <option value="Belarus">Belarus</option>
    <option value="Belgium">Belgium</option>
    <option value="Belize">Belize</option>
    <option value="Benin">Benin</option>
    <option value="Bermuda">Bermuda</option>
    <option value="Bhutan">Bhutan</option>
    <option value="Bolivia">Bolivia</option>
    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
    <option value="Botswana">Botswana</option>
    <option value="Brazil">Brazil</option>
    <option value="Brunei Darussalam">Brunei Darussalam</option>
    <option value="Bulgaria">Bulgaria</option>
    <option value="Burkina Faso">Burkina Faso</option>
    <option value="Burundi">Burundi</option>
    <option value="Cabo Verde">Cabo Verde</option>
    <option value="Cambodia">Cambodia</option>
    <option value="Cameroon">Cameroon</option>
    <option value="Canada">Canada</option>
    <option value="Cayman Islands">Cayman Islands</option>
    <option value="Central African Republic">Central African Republic</option>
    <option value="Chad">Chad</option>
    <option value="Chile">Chile</option>
    <option value="China">China</option>
    <option value="Colombia">Colombia</option>
    <option value="Comoros">Comoros</option>
    <option value="Congo (Congo-Kinshasa)">Congo (Congo-Kinshasa)</option>
    <option value="Congo (Congo-Brazzaville)">Congo (Congo-Brazzaville)</option>
    <option value="Costa Rica">Costa Rica</option>
    <option value="Croatia">Croatia</option>
    <option value="Cuba">Cuba</option>
    <option value="Cyprus">Cyprus</option>
    <option value="Czechia">Czechia</option>
    <option value="Denmark">Denmark</option>
    <option value="Djibouti">Djibouti</option>
    <option value="Dominica">Dominica</option>
    <option value="Dominican Republic">Dominican Republic</option>
    <option value="Ecuador">Ecuador</option>
    <option value="Egypt">Egypt</option>
    <option value="El Salvador">El Salvador</option>
    <option value="Equatorial Guinea">Equatorial Guinea</option>
    <option value="Eritrea">Eritrea</option>
    <option value="Estonia">Estonia</option>
    <option value="Eswatini">Eswatini</option>
    <option value="Ethiopia">Ethiopia</option>
    <option value="Fiji">Fiji</option>
    <option value="Finland">Finland</option>
    <option value="France">France</option>
    <option value="Gabon">Gabon</option>
    <option value="Gambia">Gambia</option>
    <option value="Georgia">Georgia</option>
    <option value="Germany">Germany</option>
    <option value="Ghana">Ghana</option>
    <option value="Greece">Greece</option>
    <option value="Grenada">Grenada</option>
    <option value="Guam">Guam</option>
    <option value="Guatemala">Guatemala</option>
    <option value="Guinea">Guinea</option>
    <option value="Guinea-Bissau">Guinea-Bissau</option>
    <option value="Guyana">Guyana</option>
    <option value="Haiti">Haiti</option>
    <option value="Honduras">Honduras</option>
    <option value="Hungary">Hungary</option>
    <option value="Iceland">Iceland</option>
    <option value="India">India</option>
    <option value="Indonesia">Indonesia</option>
    <option value="Iran">Iran</option>
    <option value="Iraq">Iraq</option>
    <option value="Ireland">Ireland</option>
    <option value="Israel">Israel</option>
    <option value="Italy">Italy</option>
    <option value="Jamaica">Jamaica</option>
    <option value="Japan">Japan</option>
    <option value="Jordan">Jordan</option>
    <option value="Kazakhstan">Kazakhstan</option>
    <option value="Kenya">Kenya</option>
    <option value="Kiribati">Kiribati</option>
    <option value="Korea (North)">Korea (North)</option>
    <option value="Korea (South)">Korea (South)</option>
    <option value="Kuwait">Kuwait</option>
    <option value="Kyrgyzstan">Kyrgyzstan</option>
    <option value="Lao PDR">Lao PDR</option>
    <option value="Latvia">Latvia</option>
    <option value="Lebanon">Lebanon</option>
    <option value="Lesotho">Lesotho</option>
    <option value="Liberia">Liberia</option>
    <option value="Libya">Libya</option>
    <option value="Liechtenstein">Liechtenstein</option>
    <option value="Lithuania">Lithuania</option>
    <option value="Luxembourg">Luxembourg</option>
    <option value="Madagascar">Madagascar</option>
    <option value="Malawi">Malawi</option>
    <option value="Malaysia">Malaysia</option>
    <option value="Maldives">Maldives</option>
    <option value="Mali">Mali</option>
    <option value="Malta">Malta</option>
    <option value="Marshall Islands">Marshall Islands</option>
    <option value="Mauritania">Mauritania</option>
    <option value="Mauritius">Mauritius</option>
    <option value="Mexico">Mexico</option>
    <option value="Micronesia">Micronesia</option>
    <option value="Moldova">Moldova</option>
    <option value="Monaco">Monaco</option>
    <option value="Mongolia">Mongolia</option>
    <option value="Montenegro">Montenegro</option>
    <option value="Morocco">Morocco</option>
    <option value="Mozambique">Mozambique</option>
    <option value="Myanmar">Myanmar</option>
    <option value="Namibia">Namibia</option>
    <option value="Nauru">Nauru</option>
    <option value="Nepal">Nepal</option>
    <option value="Netherlands">Netherlands</option>
    <option value="New Zealand">New Zealand</option>
    <option value="Nicaragua">Nicaragua</option>
    <option value="Niger">Niger</option>
    <option value="Nigeria">Nigeria</option>
    <option value="Norway">Norway</option>
    <option value="Oman">Oman</option>
    <option value="Pakistan">Pakistan</option>
    <option value="Palau">Palau</option>
    <option value="Panama">Panama</option>
    <option value="Papua New Guinea">Papua New Guinea</option>
    <option value="Paraguay">Paraguay</option>
    <option value="Peru">Peru</option>
    <option value="Philippines">Philippines</option>
    <option value="Poland">Poland</option>
    <option value="Portugal">Portugal</option>
    <option value="Qatar">Qatar</option>
    <option value="Romania">Romania</option>
    <option value="Russia">Russia</option>
    <option value="Rwanda">Rwanda</option>
    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
    <option value="Saint Lucia">Saint Lucia</option>
    <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
    <option value="Samoa">Samoa</option>
    <option value="San Marino">San Marino</option>
    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
    <option value="Saudi Arabia">Saudi Arabia</option>
    <option value="Senegal">Senegal</option>
    <option value="Serbia">Serbia</option>
    <option value="Seychelles">Seychelles</option>
    <option value="Sierra Leone">Sierra Leone</option>
    <option value="Singapore">Singapore</option>
    <option value="Slovakia">Slovakia</option>
    <option value="Slovenia">Slovenia</option>
    <option value="Solomon Islands">Solomon Islands</option>
    <option value="Somalia">Somalia</option>
    <option value="South Africa">South Africa</option>
    <option value="South Sudan">South Sudan</option>
    <option value="Spain">Spain</option>
    <option value="Sri Lanka">Sri Lanka</option>
    <option value="Sudan">Sudan</option>
    <option value="Suriname">Suriname</option>
    <option value="Sweden">Sweden</option>
    <option value="Switzerland">Switzerland</option>
    <option value="Syria">Syria</option>
    <option value="Taiwan">Taiwan</option>
    <option value="Tajikistan">Tajikistan</option>
    <option value="Tanzania">Tanzania</option>
    <option value="Thailand">Thailand</option>
    <option value="Timor-Leste">Timor-Leste</option>
    <option value="Togo">Togo</option>
    <option value="Tonga">Tonga</option>
    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
    <option value="Tunisia">Tunisia</option>
    <option value="Turkey">Turkey</option>
    <option value="Turkmenistan">Turkmenistan</option>
    <option value="Tuvalu">Tuvalu</option>
    <option value="Uganda">Uganda</option>
    <option value="Ukraine">Ukraine</option>
    <option value="United Arab Emirates">United Arab Emirates</option>
    <option value="United Kingdom">United Kingdom</option>
    <option value="United States">United States</option>
    <option value="Uruguay">Uruguay</option>
    <option value="Uzbekistan">Uzbekistan</option>
    <option value="Vanuatu">Vanuatu</option>
    <option value="Venezuela">Venezuela</option>
    <option value="Viet Nam">Viet Nam</option>
    <option value="Yemen">Yemen</option>
    <option value="Zambia">Zambia</option>
    <option value="Zimbabwe">Zimbabwe</option>
                    </select>
                </div>
            </div>
           <div class="row mb-3">
                        <div class="col-md-6 col-12 mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" required>
                        </div>
                        <div class="col-md-6 col-12">
                             <input type="tel" class="form-control" id="contact" name="phone" placeholder="Contact No." required maxlength="10">
                        </div>
                    </div>

                    <textarea class="form-control mb-3" id="message" name="message" cols="30" rows="5" placeholder="Message" required></textarea>

                    <div class="g-recaptcha mb-3" data-sitekey="6LdfNTcqAAAAAFzUQuM_Pn4--GwyuraqXsxy1_Gs"></div>

                    <button type="submit" name="submit" class="btn mt-2 mb-3">Submit Query</button>
                </form>
            </div>
        </div>

        <div class="col-lg-4 col-12 mt-3 ms-3">
            <div class="why-book-with-us mb-3">
                <div class="form-section-title">Why book with us?</div>
                <ul>
                    <li>High Operating Standards</li>
                    <li>Friendly and Knowledgeable Staff</li>
                    <li>Personal travel consultants</li>
                    <li>Tailor-made holiday packages</li>
                    <li>Private Tours for individuals and groups.</li>
                    <li>Guarantee Fixed Departures</li>
                    <li>Flexibility in organizing and bookings</li>
                 
                    <li>Save time and effort</li>
                    <li>Licensed and Recognized Tour Operator</li>
                </ul>
            </div>

            <div class="ask-our-experts">
                <h4>ASK OUR EXPERTS</h4>
                <ul>
                    <li><strong>Phone:</strong><a href="tel:+14167712292" style="text-decoration:none; color:black;"> +1 4167712292 </a></li>
                    <li><strong>Email us: </strong><a href="mailto:info@Connecteasytravels.com" style="text-decoration:none; color:black;"> info@Connecteasytravels.com </a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
  

        
     <!--menu bar start -->
    
 <?php include 'element/footer.php';?>
 
   <!--menu bar end -->

            <div id="overlayer"></div>
            <div class="loader">
                <div class="spinner-border" role="status"> <span class="sr-only">Loading...</span> </div>
            </div>
</body> 
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
<script>
     document.getElementById('contact').addEventListener('input', function (e) {
        this.value = this.value.replace(/[^0-9]/g, ''); // Allow only numbers
    });
</script>
<script>
    // Show/Hide Return Date based on Trip Type
    document.getElementById('trip').addEventListener('change', function () {
        var returnDateBox = document.getElementById('returnDateBox');
        if (this.value === 'One Way Trip') {
            returnDateBox.classList.add('d-none');
        } else {
            returnDateBox.classList.remove('d-none');
        }
    });

    // Show Personal Information Section on "Next" Button Click
    document.getElementById('nextButton').addEventListener('click', function () {
        document.getElementById('personalInfoSection').classList.remove('d-none');
        document.getElementById('round-trip-section').classList.add('d-none');
    });
</script>
 
</html>

