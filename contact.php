<?php
// PHP Mailer Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Sanitize and capture inputs
  $name = htmlspecialchars(strip_tags(trim($_POST['name'])));
  $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
  $country_code = htmlspecialchars(strip_tags(trim($_POST['country_code'])));
  $phone = htmlspecialchars(strip_tags(trim($_POST['phone'])));
  $country = htmlspecialchars(strip_tags(trim($_POST['country'])));
  $department = htmlspecialchars(strip_tags(trim($_POST['department'])));
  $message = htmlspecialchars(strip_tags(trim($_POST['message'])));

  // Set up the email
  $to = "info@hostmeerkat.co.uk";
  $subject = "New Enquiry: " . $department . " - HostMeerkat";

  $email_body = "You have received a new message from your website contact form.\n\n";
  $email_body .= "Name: {$name}\n";
  $email_body .= "Email: {$email}\n";
  $email_body .= "Phone: {$country_code} {$phone}\n";
  $email_body .= "Country: {$country}\n";
  $email_body .= "Department: {$department}\n\n";
  $email_body .= "Message:\n{$message}\n";

  // Headers
  $headers = "From: noreply@hostmeerkat.cloud\r\n";
  $headers .= "Reply-To: {$email}\r\n";
  $headers .= "X-Mailer: PHP/" . phpversion();

  // Send email and redirect
  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    if (mail($to, $subject, $email_body, $headers)) {
      header("Location: message.php");
      exit;
    } else {
      header("Location: contact.php?error=1");
      exit;
    }
  } else {
    header("Location: contact.php?error=1");
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us - HostMeerkat</title>

  <meta name="author" content="HostMeerkat.co.uk">
  <meta name="description" content="Get in touch with HostMeerkat - sales, billing, and technical support. We're here 24/7.">
  <link rel="canonical" href="https://hostmeerkat.co.uk/contact.php" />

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  
  <meta property="og:type" content="website">
  <meta property="og:locale" content="en_GB">
  <meta property="og:description" content="Get in touch with HostMeerkat - sales, billing, and technical support. We're here 24/7.">
  <meta name="theme-color" content="#2b2f32">
  <meta property="og:site_name" content="HostMeerkat">
  <meta property="og:url" content="https://hostmeerkat.co.uk/contact.php">
  <meta property="og:title" content="Contact Us - HostMeerkat">
  <meta property="og:image" content="https://hostmeerkat.co.uk/assets/images/og_image.png">
  
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:url" content="https://hostmeerkat.co.uk/contact.php">
  <meta name="twitter:title" content="Contact Us - HostMeerkat">
  <meta name="twitter:description" content="Get in touch with HostMeerkat - sales, billing, and technical support. We're here 24/7.">
  <meta name="twitter:image" content="https://hostmeerkat.co.uk/assets/images/og_image.png">

  <link rel="shortcut icon" href="assets/images/favicon.png">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <link rel="stylesheet" type="text/css" href="assets/css/main.css">
  <link rel="stylesheet" type="text/css" href="assets/css/customize.css">
  <link rel="stylesheet" type="text/css" href="assets/css/light-dark.css">
  <link rel="stylesheet" type="text/css" href="assets/css/contact.css">

  <style>
    /* Flag emoji styling for dropdowns */
    .flag-option {
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 6px 0;
    }
    
    .flag-emoji {
      font-size: 1.2rem;
      min-width: 28px;
      display: inline-block;
    }
    
    .country-name {
      flex: 1;
    }
    
    /* Style for select dropdowns to better show flag emojis */
    .form-select-custom {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: right 0.75rem center;
      background-size: 16px 12px;
      font-size: 0.95rem;
    }
    
    option {
      padding: 8px 12px;
    }
    
    /* Phone row styling */
    .phone-row {
      display: flex;
      gap: 12px;
      align-items: center;
    }
    
    .phone-row .form-select-custom {
      width: 120px;
      flex-shrink: 0;
    }
    
    .phone-row .form-control-custom {
      flex: 1;
    }
    
    @media (max-width: 576px) {
      .phone-row {
        flex-direction: column;
        gap: 10px;
      }
      .phone-row .form-select-custom {
        width: 100%;
      }
    }
  </style>

  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "ContactPage",
    "name": "Contact HostMeerkat",
    "url": "https://hostmeerkat.co.uk/contact.php",
    "description": "Get in touch with HostMeerkat - sales, billing, and technical support. We're here 24/7.",
    "mainEntity": {
      "@type": "Organization",
      "name": "HostMeerkat",
      "logo": "https://hostmeerkat.co.uk/assets/images/logo.png",
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+447761958885",
        "contactType": "customer service",
        "areaServed": "GB"
      }
    }
  }
  </script>
</head>

<body>

  <div class="object_1 text-center">
    <img src="assets/images/vector_object_1.png" class="img-fluid" alt="HostMeerkat UK Cloud Infrastructure">
  </div>

  <nav id="fixedR" class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid container-custom">
      <a class="navbar-brand text-white" href="index.html">
        <div class="d-flex align-items-center">
          <img class="mr-2" src="assets/images/logo.png" alt="HostMeerkat UK Web Hosting Logo">
          <h2 class="mb-0 d-flex align-items-center">Host<span>Meerkat</span></h2>
        </div>
      </a>

      <div class="d-flex align-items-center d-lg-none gap-3 hmk-nav-actions">
        <button class="navbar-toggler ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarType" aria-controls="navbarType">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>

      <div class="offcanvas offcanvas-start" tabindex="-1" id="navbarType" aria-labelledby="navbarTypeLabel">
        <div class="offcanvas-header border-0">
          <a class="navbar-brand d-flex align-items-center" href="index.html" style="text-decoration: none;">
            <img src="assets/images/logo.png" alt="HostMeerkat UK Web Hosting Logo" style="height: 32px; margin-right: 8px;">
            <h3 class="mb-0 hmk-drawer-brand" style="font-weight: 800; font-size: 1.2rem;">
              <span style="color: #ffffff !important; -webkit-text-fill-color: #ffffff !important;">Host</span><span style="color: #3b82f6 !important; -webkit-text-fill-color: #3b82f6 !important;">MEERKAT</span>
            </h3>
          </a>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body p-lg-0">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
            <li class="nav-item">
              <a class="nav-link" href="index.html">Home</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Hosting</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="web-hosting.html">Web Hosting</a></li>
                <li><a class="dropdown-item" href="wordpress-hosting.html">WordPress Hosting</a></li>
                <li><a class="dropdown-item" href="reseller-hosting.html">Reseller Hosting</a></li>
                <li><a class="dropdown-item" href="vps-hosting.html">VPS Hosting</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="design-development.html">Design & Development</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="about.html">About us</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="contact.php">Contact</a>
            </li>

            <li class="nav-item ms-lg-3 mt-3 mt-lg-0">
              <div class="button">
                <div class="dropdown w-100">
                  <a href="#" class="btn dropdown-toggle w-100" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-user me-2 d-lg-none"></i> <img src="assets/images/user.svg" alt="HostMeerkat Client Portal Login" class="d-none d-lg-inline"> LOGIN
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="https://clients.hostmeerkat.co.uk/login">Client Area</a></li>
                    <li><a class="dropdown-item" href="#">Web Panel</a></li>
                  </ul>
                </div>
              </div>
            </li>

            <li class="nav-item ms-lg-4 mt-4 mt-lg-0 d-none d-lg-block">
              <button class="theme-toggle-btn" aria-label="Toggle theme">
                <i class="fa-solid fa-moon icon-dark"></i>
                <i class="fa-solid fa-sun icon-light"></i>
              </button>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <section class="contact-hero">
    <div class="container text-center fade-up">
      <div class="badge-custom">
        <span class="badge-dot"></span> Get in Touch
      </div>
      <h1 class="hero-heading">Contact <span class="heading-gradient">Us</span></h1>
      <p class="hero-intro">
        Have a question about <strong>HostMeerkat</strong> hosting, billing, or migration?
        Our team is ready to help - reach out by form, email, or client area support.
      </p>
      <a href="https://clients.hostmeerkat.co.uk/login" class="btn-touch">
        <i class="fa-solid fa-headset"></i> Client Support Portal
      </a>
    </div>
  </section>

  <section class="contact-main">
    <div class="container">
      <div class="contact-layout fade-up">

        <div class="info-cards">
          <div class="info-card">
            <div class="info-card-icon"><i class="fa-solid fa-location-dot"></i></div>
            <h3>Our Location</h3>
            <p>United Kingdom<br>London-based UK servers</p>
          </div>
          <div class="info-card">
            <div class="info-card-icon"><i class="fa-solid fa-envelope"></i></div>
            <h3>Email Us</h3>
            <p><a href="mailto:support@hostmeerkat.co.uk">support@hostmeerkat.co.uk</a></p>
          </div>
          <div class="info-card">
            <div class="info-card-icon"><i class="fa-solid fa-clock"></i></div>
            <h3>Support Hours</h3>
            <p>24/7 expert support<br>Fast response via ticket & email</p>
          </div>
        </div>

        <div class="form-card">
          <h2>Send us a message</h2>
          <p class="form-sub">Fill in the form below and we'll get back to you as soon as possible.</p>

          <div id="formAlert" class="form-alert" role="alert"></div>

          <form id="contactForm" action="contact.php" method="POST" novalidate="">
            <div class="form-group">
              <label for="name">Full Name <span class="req">*</span></label>
              <input type="text" class="form-control-custom" id="name" name="name" placeholder="Your name" required="">
            </div>

            <div class="form-group">
              <label for="email">Email Address <span class="req">*</span></label>
              <input type="email" class="form-control-custom" id="email" name="email" placeholder="Your email" required="">
            </div>

            <div class="form-group">
              <label for="phone">WhatsApp / Phone</label>
              <div class="phone-row">
                <select class="form-select-custom" id="countryCode" name="country_code" aria-label="Country code">
                  <!-- Country codes with flags will be populated by JavaScript -->
                </select>
                <input type="tel" class="form-control-custom" id="phone" name="phone" placeholder="Your number">
              </div>
            </div>

            <div class="form-group">
              <label for="country">Country <span class="req">*</span></label>
              <div class="country-select-wrapper">
                <select class="form-select-custom" id="country" name="country" required>
                  <option value="" selected disabled>🌍 Select your country</option>
                  <!-- Country options will be populated by JavaScript with flag emojis -->
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="department">Department</label>
              <select class="form-select-custom" id="department" name="department">
                <option value="Sales">Sales</option>
                <option value="Billing">Billing</option>
                <option value="Technical Support">Technical Support</option>
                <option value="General Inquiry">General Inquiry</option>
              </select>
            </div>

            <div class="form-group">
              <label for="message">Message <span class="req">*</span></label>
              <textarea class="form-control-custom" id="message" name="message" placeholder="How can we help you?" required=""></textarea>
            </div>

            <div class="terms-row">
              <input type="checkbox" id="terms" name="terms" value="accepted" required="">
              <label for="terms">
                I agree to the <a href="terms-of-service.html" rel="noopener" target="_blank">Terms of Service</a>
                and understand my details will be used to respond to this enquiry.
              </label>
            </div>

            <button type="submit" class="btn-submit" id="submitBtn">
              <i class="fa-solid fa-paper-plane"></i> Send Message
            </button>
          </form>
        </div>

      </div>
    </div>
  </section>

  <div class="footer-wrap">
    <div class="footer-horizon"></div>
    <div class="container container-custom">
      <div class="row footer_links">
        <div class="col-lg-8 col-md-12">
          <div class="row">
            <div class="col-md-4 col-sm-6">
              <h4>Solutions</h4>
              <ul>
                <li><a href="web-hosting.html">Web Hosting</a></li>
                <li><a href="wordpress-hosting.html">WordPress Hosting</a></li>
                <li><a href="reseller-hosting.html">Reseller Hosting</a></li>
                <li><a href="vps-hosting.html">VPS Hosting</a></li>
              </ul>
            </div>
            <div class="col-md-4 col-sm-6">
              <h4>Resources</h4>
              <ul>
                <li><a href="https://clients.hostmeerkat.co.uk/login">Client Portal</a></li>
                <li><a href="#">Knowledge Base</a></li>
                <li><a href="https://hostmeerkat.co.uk/#payment-methods">Payment Methods</a></li>
              </ul>
            </div>
            <div class="col-md-4 col-sm-6">
              <h4>Company</h4>
              <ul>
                <li><a href="about.html">About HostMeerkat</a></li>
                <li><a href="why-chose.html">Why Choose Us</a></li>
                <li><a href="contact.php">Contact Sales</a></li>
                <li><a href="privacy-policy.html">Privacy Policy</a></li>
                <li><a href="terms-and-conditions.html">Terms &amp; Conditions</a></li>
                <li><a href="anti-spam-policy.html">Anti-Spam Policy</a></li>
                <li><a href="report-abuse.html">Report Abuse</a></li>
                <li><a href="reseller-agreement.html">Reseller Agreement</a></li>
                <li><a href="cancellation-and-refund.html">Cancellation &amp; Refund</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-12 footer_about">
          <div class="d-flex align-items-center mb-3">
            <img class="mr-2" src="assets/images/logo.png" alt="HostMeerkat Secure UK Hosting" height="38">
            <h2 class="mb-0 d-flex align-items-center text-white" style="font-weight:800;font-size:1.8rem;">Host<span style="color:#3b82f6;">Meerkat</span></h2>
          </div>
          <p>Deploy your digital future on our blazing-fast, secure, and infinitely scalable UK cloud infrastructure.</p>
          <div class="footer-status">
            <div class="pulse"></div>
            All Systems Operational
          </div>
        </div>
      </div>
    </div>
    <div class="footer_bottom">
      <div class="container container-custom">
        <div class="row d-flex justify-content-between align-items-center">
          <div class="col-md-6 d-flex align-items-center justify-content-center justify-content-md-start mb-3 mb-md-0">
            <img src="assets/images/paymethod.png" height="28" alt="Pay for hosting securely with Visa, Mastercard, or PayPal" style="opacity:0.9;transition:0.3s;">
          </div>
          <div class="col-md-6 d-flex align-items-center justify-content-center justify-content-md-end">
            <p class="mb-0">&copy; 2026 HostMeerkat.co.uk. Designed for performance.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.1.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="assets/js/custom.js"></script>

  <script>
  // Theme Toggle
    document.addEventListener("DOMContentLoaded", function () {
      var toggleBtns = document.querySelectorAll('.theme-toggle-btn');
      if (localStorage.getItem('hmk-theme') === 'light') { document.body.classList.add('light-mode'); }
      toggleBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
          document.body.classList.toggle('light-mode');
          localStorage.setItem('hmk-theme', document.body.classList.contains('light-mode') ? 'light' : 'dark');
        });
      });
    });
    // Country list with flag emojis - Complete list from original HTML
    const countriesWithFlags = [
      { name: "Afghanistan", flag: "🇦🇫" },
      { name: "Albania", flag: "🇦🇱" },
      { name: "Algeria", flag: "🇩🇿" },
      { name: "Andorra", flag: "🇦🇩" },
      { name: "Angola", flag: "🇦🇴" },
      { name: "Antigua and Barbuda", flag: "🇦🇬" },
      { name: "Argentina", flag: "🇦🇷" },
      { name: "Armenia", flag: "🇦🇲" },
      { name: "Australia", flag: "🇦🇺" },
      { name: "Austria", flag: "🇦🇹" },
      { name: "Azerbaijan", flag: "🇦🇿" },
      { name: "Bahamas", flag: "🇧🇸" },
      { name: "Bahrain", flag: "🇧🇭" },
      { name: "Bangladesh", flag: "🇧🇩" },
      { name: "Barbados", flag: "🇧🇧" },
      { name: "Belarus", flag: "🇧🇾" },
      { name: "Belgium", flag: "🇧🇪" },
      { name: "Belize", flag: "🇧🇿" },
      { name: "Benin", flag: "🇧🇯" },
      { name: "Bhutan", flag: "🇧🇹" },
      { name: "Bolivia", flag: "🇧🇴" },
      { name: "Bosnia and Herzegovina", flag: "🇧🇦" },
      { name: "Botswana", flag: "🇧🇼" },
      { name: "Brazil", flag: "🇧🇷" },
      { name: "Brunei", flag: "🇧🇳" },
      { name: "Bulgaria", flag: "🇧🇬" },
      { name: "Burkina Faso", flag: "🇧🇫" },
      { name: "Burundi", flag: "🇧🇮" },
      { name: "Cambodia", flag: "🇰🇭" },
      { name: "Cameroon", flag: "🇨🇲" },
      { name: "Canada", flag: "🇨🇦" },
      { name: "Cape Verde", flag: "🇨🇻" },
      { name: "Central African Republic", flag: "🇨🇫" },
      { name: "Chad", flag: "🇹🇩" },
      { name: "Chile", flag: "🇨🇱" },
      { name: "China", flag: "🇨🇳" },
      { name: "Colombia", flag: "🇨🇴" },
      { name: "Comoros", flag: "🇰🇲" },
      { name: "Congo", flag: "🇨🇬" },
      { name: "Costa Rica", flag: "🇨🇷" },
      { name: "Croatia", flag: "🇭🇷" },
      { name: "Cuba", flag: "🇨🇺" },
      { name: "Cyprus", flag: "🇨🇾" },
      { name: "Czech Republic", flag: "🇨🇿" },
      { name: "Denmark", flag: "🇩🇰" },
      { name: "Djibouti", flag: "🇩🇯" },
      { name: "Dominica", flag: "🇩🇲" },
      { name: "Dominican Republic", flag: "🇩🇴" },
      { name: "Ecuador", flag: "🇪🇨" },
      { name: "Egypt", flag: "🇪🇬" },
      { name: "El Salvador", flag: "🇸🇻" },
      { name: "Equatorial Guinea", flag: "🇬🇶" },
      { name: "Eritrea", flag: "🇪🇷" },
      { name: "Estonia", flag: "🇪🇪" },
      { name: "Eswatini", flag: "🇸🇿" },
      { name: "Ethiopia", flag: "🇪🇹" },
      { name: "Fiji", flag: "🇫🇯" },
      { name: "Finland", flag: "🇫🇮" },
      { name: "France", flag: "🇫🇷" },
      { name: "Gabon", flag: "🇬🇦" },
      { name: "Gambia", flag: "🇬🇲" },
      { name: "Georgia", flag: "🇬🇪" },
      { name: "Germany", flag: "🇩🇪" },
      { name: "Ghana", flag: "🇬🇭" },
      { name: "Greece", flag: "🇬🇷" },
      { name: "Grenada", flag: "🇬🇩" },
      { name: "Guatemala", flag: "🇬🇹" },
      { name: "Guinea", flag: "🇬🇳" },
      { name: "Guinea-Bissau", flag: "🇬🇼" },
      { name: "Guyana", flag: "🇬🇾" },
      { name: "Haiti", flag: "🇭🇹" },
      { name: "Honduras", flag: "🇭🇳" },
      { name: "Hungary", flag: "🇭🇺" },
      { name: "Iceland", flag: "🇮🇸" },
      { name: "India", flag: "🇮🇳" },
      { name: "Indonesia", flag: "🇮🇩" },
      { name: "Iran", flag: "🇮🇷" },
      { name: "Iraq", flag: "🇮🇶" },
      { name: "Ireland", flag: "🇮🇪" },
      { name: "Israel", flag: "🇮🇱" },
      { name: "Italy", flag: "🇮🇹" },
      { name: "Jamaica", flag: "🇯🇲" },
      { name: "Japan", flag: "🇯🇵" },
      { name: "Jordan", flag: "🇯🇴" },
      { name: "Kazakhstan", flag: "🇰🇿" },
      { name: "Kenya", flag: "🇰🇪" },
      { name: "Kiribati", flag: "🇰🇮" },
      { name: "Kuwait", flag: "🇰🇼" },
      { name: "Kyrgyzstan", flag: "🇰🇬" },
      { name: "Laos", flag: "🇱🇦" },
      { name: "Latvia", flag: "🇱🇻" },
      { name: "Lebanon", flag: "🇱🇧" },
      { name: "Lesotho", flag: "🇱🇸" },
      { name: "Liberia", flag: "🇱🇷" },
      { name: "Libya", flag: "🇱🇾" },
      { name: "Liechtenstein", flag: "🇱🇮" },
      { name: "Lithuania", flag: "🇱🇹" },
      { name: "Luxembourg", flag: "🇱🇺" },
      { name: "Madagascar", flag: "🇲🇬" },
      { name: "Malawi", flag: "🇲🇼" },
      { name: "Malaysia", flag: "🇲🇾" },
      { name: "Maldives", flag: "🇲🇻" },
      { name: "Mali", flag: "🇲🇱" },
      { name: "Malta", flag: "🇲🇹" },
      { name: "Marshall Islands", flag: "🇲🇭" },
      { name: "Mauritania", flag: "🇲🇷" },
      { name: "Mauritius", flag: "🇲🇺" },
      { name: "Mexico", flag: "🇲🇽" },
      { name: "Micronesia", flag: "🇫🇲" },
      { name: "Moldova", flag: "🇲🇩" },
      { name: "Monaco", flag: "🇲🇨" },
      { name: "Mongolia", flag: "🇲🇳" },
      { name: "Montenegro", flag: "🇲🇪" },
      { name: "Morocco", flag: "🇲🇦" },
      { name: "Mozambique", flag: "🇲🇿" },
      { name: "Myanmar", flag: "🇲🇲" },
      { name: "Namibia", flag: "🇳🇦" },
      { name: "Nauru", flag: "🇳🇷" },
      { name: "Nepal", flag: "🇳🇵" },
      { name: "Netherlands", flag: "🇳🇱" },
      { name: "New Zealand", flag: "🇳🇿" },
      { name: "Nicaragua", flag: "🇳🇮" },
      { name: "Niger", flag: "🇳🇪" },
      { name: "Nigeria", flag: "🇳🇬" },
      { name: "North Korea", flag: "🇰🇵" },
      { name: "North Macedonia", flag: "🇲🇰" },
      { name: "Norway", flag: "🇳🇴" },
      { name: "Oman", flag: "🇴🇲" },
      { name: "Pakistan", flag: "🇵🇰" },
      { name: "Palau", flag: "🇵🇼" },
      { name: "Panama", flag: "🇵🇦" },
      { name: "Papua New Guinea", flag: "🇵🇬" },
      { name: "Paraguay", flag: "🇵🇾" },
      { name: "Peru", flag: "🇵🇪" },
      { name: "Philippines", flag: "🇵🇭" },
      { name: "Poland", flag: "🇵🇱" },
      { name: "Portugal", flag: "🇵🇹" },
      { name: "Qatar", flag: "🇶🇦" },
      { name: "Romania", flag: "🇷🇴" },
      { name: "Russia", flag: "🇷🇺" },
      { name: "Rwanda", flag: "🇷🇼" },
      { name: "Saint Kitts and Nevis", flag: "🇰🇳" },
      { name: "Saint Lucia", flag: "🇱🇨" },
      { name: "Saint Vincent and the Grenadines", flag: "🇻🇨" },
      { name: "Samoa", flag: "🇼🇸" },
      { name: "San Marino", flag: "🇸🇲" },
      { name: "Sao Tome and Principe", flag: "🇸🇹" },
      { name: "Saudi Arabia", flag: "🇸🇦" },
      { name: "Senegal", flag: "🇸🇳" },
      { name: "Serbia", flag: "🇷🇸" },
      { name: "Seychelles", flag: "🇸🇨" },
      { name: "Sierra Leone", flag: "🇸🇱" },
      { name: "Singapore", flag: "🇸🇬" },
      { name: "Slovakia", flag: "🇸🇰" },
      { name: "Slovenia", flag: "🇸🇮" },
      { name: "Solomon Islands", flag: "🇸🇧" },
      { name: "Somalia", flag: "🇸🇴" },
      { name: "South Africa", flag: "🇿🇦" },
      { name: "South Korea", flag: "🇰🇷" },
      { name: "South Sudan", flag: "🇸🇸" },
      { name: "Spain", flag: "🇪🇸" },
      { name: "Sri Lanka", flag: "🇱🇰" },
      { name: "Sudan", flag: "🇸🇩" },
      { name: "Suriname", flag: "🇸🇷" },
      { name: "Sweden", flag: "🇸🇪" },
      { name: "Switzerland", flag: "🇨🇭" },
      { name: "Syria", flag: "🇸🇾" },
      { name: "Taiwan", flag: "🇹🇼" },
      { name: "Tajikistan", flag: "🇹🇯" },
      { name: "Tanzania", flag: "🇹🇿" },
      { name: "Thailand", flag: "🇹🇭" },
      { name: "Timor-Leste", flag: "🇹🇱" },
      { name: "Togo", flag: "🇹🇬" },
      { name: "Tonga", flag: "🇹🇴" },
      { name: "Trinidad and Tobago", flag: "🇹🇹" },
      { name: "Tunisia", flag: "🇹🇳" },
      { name: "Turkey", flag: "🇹🇷" },
      { name: "Turkmenistan", flag: "🇹🇲" },
      { name: "Tuvalu", flag: "🇹🇻" },
      { name: "Uganda", flag: "🇺🇬" },
      { name: "Ukraine", flag: "🇺🇦" },
      { name: "United Arab Emirates", flag: "🇦🇪" },
      { name: "United Kingdom", flag: "🇬🇧" },
      { name: "United States", flag: "🇺🇸" },
      { name: "Uruguay", flag: "🇺🇾" },
      { name: "Uzbekistan", flag: "🇺🇿" },
      { name: "Vanuatu", flag: "🇻🇺" },
      { name: "Vatican City", flag: "🇻🇦" },
      { name: "Venezuela", flag: "🇻🇪" },
      { name: "Vietnam", flag: "🇻🇳" },
      { name: "Yemen", flag: "🇾🇪" },
      { name: "Zambia", flag: "🇿🇲" },
      { name: "Zimbabwe", flag: "🇿🇼" },
      { name: "Other", flag: "🌐" }
    ];

    // Country codes with flags (phone codes)
    const countryCodesWithFlags = [
      { code: "+44", country: "United Kingdom", flag: "🇬🇧", selected: true },
      { code: "+1", country: "United States", flag: "🇺🇸", selected: false },
      { code: "+1", country: "Canada", flag: "🇨🇦", selected: false },
      { code: "+91", country: "India", flag: "🇮🇳", selected: false },
      { code: "+61", country: "Australia", flag: "🇦🇺", selected: false },
      { code: "+49", country: "Germany", flag: "🇩🇪", selected: false },
      { code: "+92", country: "Pakistan", flag: "🇵🇰", selected: false },
      { code: "+971", country: "United Arab Emirates", flag: "🇦🇪", selected: false },
      { code: "+966", country: "Saudi Arabia", flag: "🇸🇦", selected: false },
      { code: "+974", country: "Qatar", flag: "🇶🇦", selected: false },
      { code: "+968", country: "Oman", flag: "🇴🇲", selected: false },
      { code: "+973", country: "Bahrain", flag: "🇧🇭", selected: false },
      { code: "+965", country: "Kuwait", flag: "🇰🇼", selected: false },
      { code: "+20", country: "Egypt", flag: "🇪🇬", selected: false },
      { code: "+90", country: "Turkey", flag: "🇹🇷", selected: false },
      { code: "+33", country: "France", flag: "🇫🇷", selected: false },
      { code: "+39", country: "Italy", flag: "🇮🇹", selected: false },
      { code: "+34", country: "Spain", flag: "🇪🇸", selected: false },
      { code: "+31", country: "Netherlands", flag: "🇳🇱", selected: false },
      { code: "+32", country: "Belgium", flag: "🇧🇪", selected: false },
      { code: "+41", country: "Switzerland", flag: "🇨🇭", selected: false },
      { code: "+43", country: "Austria", flag: "🇦🇹", selected: false },
      { code: "+46", country: "Sweden", flag: "🇸🇪", selected: false },
      { code: "+47", country: "Norway", flag: "🇳🇴", selected: false },
      { code: "+45", country: "Denmark", flag: "🇩🇰", selected: false },
      { code: "+358", country: "Finland", flag: "🇫🇮", selected: false },
      { code: "+48", country: "Poland", flag: "🇵🇱", selected: false },
      { code: "+420", country: "Czech Republic", flag: "🇨🇿", selected: false },
      { code: "+421", country: "Slovakia", flag: "🇸🇰", selected: false },
      { code: "+36", country: "Hungary", flag: "🇭🇺", selected: false },
      { code: "+40", country: "Romania", flag: "🇷🇴", selected: false },
      { code: "+359", country: "Bulgaria", flag: "🇧🇬", selected: false },
      { code: "+30", country: "Greece", flag: "🇬🇷", selected: false },
      { code: "+380", country: "Ukraine", flag: "🇺🇦", selected: false },
      { code: "+7", country: "Russia", flag: "🇷🇺", selected: false },
      { code: "+86", country: "China", flag: "🇨🇳", selected: false },
      { code: "+81", country: "Japan", flag: "🇯🇵", selected: false },
      { code: "+82", country: "South Korea", flag: "🇰🇷", selected: false },
      { code: "+852", country: "Hong Kong", flag: "🇭🇰", selected: false },
      { code: "+886", country: "Taiwan", flag: "🇹🇼", selected: false },
      { code: "+65", country: "Singapore", flag: "🇸🇬", selected: false },
      { code: "+60", country: "Malaysia", flag: "🇲🇾", selected: false },
      { code: "+66", country: "Thailand", flag: "🇹🇭", selected: false },
      { code: "+84", country: "Vietnam", flag: "🇻🇳", selected: false },
      { code: "+62", country: "Indonesia", flag: "🇮🇩", selected: false },
      { code: "+63", country: "Philippines", flag: "🇵🇭", selected: false },
      { code: "+880", country: "Bangladesh", flag: "🇧🇩", selected: false },
      { code: "+94", country: "Sri Lanka", flag: "🇱🇰", selected: false },
      { code: "+977", country: "Nepal", flag: "🇳🇵", selected: false },
      { code: "+975", country: "Bhutan", flag: "🇧🇹", selected: false },
      { code: "+93", country: "Afghanistan", flag: "🇦🇫", selected: false },
      { code: "+98", country: "Iran", flag: "🇮🇷", selected: false },
      { code: "+964", country: "Iraq", flag: "🇮🇶", selected: false },
      { code: "+962", country: "Jordan", flag: "🇯🇴", selected: false },
      { code: "+961", country: "Lebanon", flag: "🇱🇧", selected: false },
      { code: "+972", country: "Israel", flag: "🇮🇱", selected: false },
      { code: "+52", country: "Mexico", flag: "🇲🇽", selected: false },
      { code: "+55", country: "Brazil", flag: "🇧🇷", selected: false },
      { code: "+54", country: "Argentina", flag: "🇦🇷", selected: false },
      { code: "+56", country: "Chile", flag: "🇨🇱", selected: false },
      { code: "+57", country: "Colombia", flag: "🇨🇴", selected: false },
      { code: "+51", country: "Peru", flag: "🇵🇪", selected: false },
      { code: "+58", country: "Venezuela", flag: "🇻🇪", selected: false },
      { code: "+598", country: "Uruguay", flag: "🇺🇾", selected: false },
      { code: "+595", country: "Paraguay", flag: "🇵🇾", selected: false },
      { code: "+27", country: "South Africa", flag: "🇿🇦", selected: false },
      { code: "+234", country: "Nigeria", flag: "🇳🇬", selected: false },
      { code: "+254", country: "Kenya", flag: "🇰🇪", selected: false },
      { code: "+251", country: "Ethiopia", flag: "🇪🇹", selected: false },
      { code: "+212", country: "Morocco", flag: "🇲🇦", selected: false },
      { code: "+213", country: "Algeria", flag: "🇩🇿", selected: false },
      { code: "+216", country: "Tunisia", flag: "🇹🇳", selected: false },
      { code: "+64", country: "New Zealand", flag: "🇳🇿", selected: false }
    ];

    // Populate country dropdown with flag emojis
    function populateCountryDropdown() {
      const countrySelect = document.getElementById('country');
      if (countrySelect) {
        countrySelect.innerHTML = '';
        
        const placeholderOption = document.createElement('option');
        placeholderOption.value = '';
        placeholderOption.selected = true;
        placeholderOption.disabled = true;
        placeholderOption.textContent = '🌍 Select your country';
        countrySelect.appendChild(placeholderOption);
        
        countriesWithFlags.forEach(country => {
          const option = document.createElement('option');
          option.value = country.name;
          option.textContent = `${country.flag} ${country.name}`;
          countrySelect.appendChild(option);
        });
      }
    }

    // Populate country code dropdown with flags
    function populateCountryCodeDropdown() {
      const codeSelect = document.getElementById('countryCode');
      if (codeSelect) {
        codeSelect.innerHTML = '';
        
        countryCodesWithFlags.forEach(item => {
          const option = document.createElement('option');
          option.value = item.code;
          option.textContent = `${item.flag} ${item.code} (${item.country})`;
          if (item.selected) {
            option.selected = true;
          }
          codeSelect.appendChild(option);
        });
      }
    }

    // Initialize both dropdowns when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
      populateCountryDropdown();
      populateCountryCodeDropdown();
    });

    (function() {
      var params = new URLSearchParams(window.location.search);
      var alertEl = document.getElementById('formAlert');

      // Only show error alert on this page (success now goes to message.php)
      if (params.get('error') === '1') {
        alertEl.textContent = 'Sorry, there was an error sending your message. Please try again.';
        alertEl.className = 'form-alert form-alert-error is-visible';
        if (window.history.replaceState) {
          window.history.replaceState({}, document.title, window.location.pathname);
        }
      }

      var form = document.getElementById('contactForm');
      var submitBtn = document.getElementById('submitBtn');

      if (form) {
        form.addEventListener('submit', function(e) {
          if (!form.checkValidity()) {
            e.preventDefault();
            alertEl.textContent = 'Please fill in all required fields and accept the terms.';
            alertEl.className = 'form-alert form-alert-error is-visible';
            return;
          }
          submitBtn.disabled = true;
          submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Sending...';
        });
      }
    })();
  </script>

</body>
</html>