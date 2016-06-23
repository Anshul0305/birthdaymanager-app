<?php include_once ($_SERVER["DOCUMENT_ROOT"].json_decode(file_get_contents("env.json"))->website_relative_path. "/helper.php"); ?>
<?php
session_start();
$api_host = get_api_host();

// Localisation Handler
$ip_address= $_SERVER['REMOTE_ADDR'];
$ip_endpoint = "http://ip-api.com/json/".$ip_address;
$json_ip = file_get_contents($ip_endpoint);

$_SESSION["country"] = json_decode($json_ip)->country;
$_SESSION["region"] = json_decode($json_ip)->region;
$_SESSION["country_code"] = json_decode($json_ip)->countryCode;

// Login Handler
$ch = curl_init();
$login_endpoint = $api_host."/login";
$signin_email = $_POST["signin-email"];
$signin_password = $_POST["signin-password"];
$signin_post_data = "email=".$signin_email."&password=".$signin_password;

if(isset($signin_email)&&isset($signin_password)){
	curl_setopt($ch, CURLOPT_URL,$login_endpoint);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $signin_post_data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$login_output = curl_exec ($ch);
	$login_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close ($ch);
}

// Registration Handler
if(isset($_POST["signup-email"])) {
	$ch = curl_init();
	$register_endpoint = $api_host . "/register";
	$first_name = $_POST["signup-first-name"];
	$last_name = $_POST["signup-last-name"];
	$signup_email = $_POST["signup-email"];
	$signup_password = $_POST["signup-password"];
	$official_dob = $_POST["signup-official-dob"];
	$team_id = $_GET["team-id"];
	$team_name = $_GET["team-name"];
	if (isset($team_id)) {
		$signup_post_data = "first_name=" . $first_name . "&last_name=" . $last_name . "&official_dob=" . $official_dob . "&email=" . $signup_email . "&password=" . $signup_password . "&team_id=" . $team_id."&team_name=".$team_name;
	} else {
		$signup_post_data = "first_name=" . $first_name . "&last_name=" . $last_name . "&official_dob=" . $official_dob . "&email=" . $signup_email . "&password=" . $signup_password;
	}
}

if(isset($signup_email)&&isset($signup_password)){
	curl_setopt($ch, CURLOPT_URL,$register_endpoint);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $signup_post_data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$register_output = curl_exec ($ch);
	$register_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close ($ch);
}


// Forgot Password Handler

if(isset($_POST["reset-email"])){
	$ch = curl_init();
	$reset_endpoint = $api_host."/reset-password-link";
	$reset_email = $_POST["reset-email"];
	$reset_post_data = "email=".$reset_email;

	curl_setopt($ch, CURLOPT_URL,$reset_endpoint);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $reset_post_data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$reset_output = curl_exec ($ch);
	$reset_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close ($ch);
}


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/img/favicon.png">

    <title>Birthday Manager</title>

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
	<link href="assets/css/bootstrap-theme.css" rel="stylesheet">

    <!-- siimple style -->
    <link href="assets/css/style.css" rel="stylesheet">
	<link href="assets/css/reset.css" rel="stylesheet">
	 <script src="assets/js/modernizr.js"></script> 
    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>


    <![endif]-->
  </head>


  <body>
  <script src="assets/js/main.js"></script>
  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <!-- Fixed navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://<?php echo get_website_host()?><?php echo get_website_relative_path()?>">Birthday Manager - Beta</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right main-nav">
			 <li><a class="cd-signin" data-toggle="collapse" data-target=".navbar-collapse" href="#" style="width: 80px">Sign in</a></li>
            <li><a class="cd-signup" data-toggle="collapse" data-target=".navbar-collapse" href="#" style="width: 85px">Sign up</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
	  
<!-- Modal Signin/Signup Window	   -->
	  
	  <div class="cd-user-modal"> <!-- this is the entire modal form, including the background -->
		<div class="cd-user-modal-container"> <!-- this is the container wrapper -->
			<ul class="cd-switcher">
				<li><a href="#0">Sign in</a></li>
				<li><a href="#0">Sign up</a></li>
			</ul>

			<div id="cd-login"> <!-- log in form -->
				<form class="cd-form" method="POST" action="<?php echo json_decode(file_get_contents("env.json"))->website_relative_path.'/index.php'?>"/>
					<p class="fieldset">
						<label class="image-replace cd-email" for="signin-email">E-mail</label>
						<input class="full-width has-padding has-border" name="signin-email" id="signin-email" type="email" placeholder="E-mail">
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset">
						<label class="image-replace cd-password" for="signin-password">Password</label>
						<input class="full-width has-padding has-border" name="signin-password" id="signin-password" type="password"  placeholder="Password">
						<a href="#0" class="hide-password">Show</a>
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset">
						<input type="checkbox" id="remember-me" checked>
						<label for="remember-me">Remember me</label>
					</p>

					<p class="fieldset">
						<input class="full-width" type="submit" value="Login">
					</p>
				</form>
				
				<p class="cd-form-bottom-message"><a href="#0">Forgot your password?</a></p>
				<!-- <a href="#0" class="cd-close-form">Close</a> -->
			</div> <!-- cd-login -->

			<div id="cd-signup"> <!-- sign up form -->
				<form class="cd-form" id="register" method="POST" action="">
					<p class="fieldset">
						<label class="image-replace cd-username" for="signup-first-name">First Name</label>
						<input class="full-width has-padding has-border" name="signup-first-name" id="signup-first-name" type="text" placeholder="First Name">
						<span class="cd-error-message">Error message here!</span>
					</p>
					
					<p class="fieldset">
						<label class="image-replace cd-username" for="signup-last-name">Last Name</label>
						<input class="full-width has-padding has-border" name="signup-last-name" id="signup-last-name" type="text" placeholder="Last Name">
						<span class="cd-error-message">Error message here!</span>
					</p>
					
					<p class="fieldset">
						<label class="image-replace cd-username" >Date of Birth</label>
						<input class="full-width has-padding has-border" id="signup-official-dob" name="signup-official-dob" type="text" placeholder="Date of Birth">
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset">
						<label class="image-replace cd-email" for="signup-email">E-mail</label>
						<input class="full-width has-padding has-border" name="signup-email" id="signup-email" type="email" placeholder="E-mail">
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset">
						<label class="image-replace cd-password" for="signup-password">Password</label>
						<input class="full-width has-padding has-border" name="signup-password" id="signup-password" type="password"  placeholder="Password">
						<a href="#0" class="hide-password">Show</a>
						<span class="cd-error-message">Error message here!</span>
					</p>

<!--					<p class="fieldset">-->
<!--						<input type="checkbox" id="accept-terms">-->
<!--						<label for="accept-terms">I agree to the <a href="#">Terms</a></label>-->
<!--					</p>-->

					<p class="fieldset">
						<input class="full-width has-padding" type="submit" value="Create account">
					</p>
				</form>

			</div> <!-- cd-signup -->

			<div id="cd-reset-password"> <!-- reset password form -->
				<p class="cd-form-message">Lost your password? Please enter your email address. You will receive a link to create a new password.</p>

				<form class="cd-form" id="forgot-password" method="POST" action="<?php echo json_decode(file_get_contents("env.json"))->website_relative_path.'/index.php'?>">
					<p class="fieldset">
						<label class="image-replace cd-email" for="reset-email">E-mail</label>
						<input class="full-width has-padding has-border" name="reset-email" id="reset-email" type="email" placeholder="E-mail">
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset">
						<input class="full-width has-padding" type="submit" value="Reset password">
					</p>
				</form>

				<p class="cd-form-bottom-message"><a href="#0">Back to log-in</a></p>
			</div> <!-- cd-reset-password -->
			<a href="#0" class="cd-close-form">Close</a>
		</div> <!-- cd-user-modal-container -->
	</div> 

	<div id="header">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<?php

					// Handle Login
					if(isset($signin_email)&&isset($signin_password)) {
						if ($login_http_code == 200 && $signin_email != "" && $signin_password != "") {
							$_SESSION["member_id"] = json_decode($login_output)->member_id;
							echo "<script>location.href = 'http://".get_website_host(). json_decode(file_get_contents("env.json"))->website_relative_path."/dashboard'</script>";
						} else {
							echo "<div class=\"alert alert-danger\" role=\"alert\">Login Failed! Please Try Again...</div>";
						}
					}
					// Handle Register
					if(isset($signup_email)&&isset($signup_password)){
						if($register_http_code == 200 && $signup_email!= "" && $signup_password!= ""){
							echo "<div class=\"alert alert-success\" role=\"alert\">Registered Successfully! Please login...</div>";
						}
						elseif($register_http_code == 409 && $signup_email!= "" && $signup_password!= "") {
							echo "<div class=\"alert alert-warning\" role=\"alert\">This user is already registered! Please Try with different email id...</div>";
						}
						else{
							echo "<div class=\"alert alert-danger\" role=\"alert\">Registration Failed! Please Try Again...</div>";
						}
					}
					// Handle Reset Password
					if(isset($reset_email)){
						if($reset_http_code == 200 && $reset_email!= ""){
							echo "<div class=\"alert alert-success\" role=\"alert\">Email Sent Successfully! Please Change Your Password and Login...</div>";
						}
						else{
							echo "<div class=\"alert alert-danger\" role=\"alert\">Reset Password Failed! Please Try Again...</div>";
						}
					}
					?>
					<h3><?php echo $_SESSION["country"];?></h3>
					<h1>Birthday Manager</h1>
					<h2 class="subtitle">Always believe something wonderful is about to happen...</h2>
<!--					<form class="form-inline signup" role="form">-->
<!--					  <div class="form-group">-->
<!--					    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter your email address">-->
<!--					  </div>-->
<!--					  <button type="submit" class="btn btn-theme">Subscribe Us</button>-->
<!--					</form>					-->
				</div>
				<div class="col-lg-4 col-lg-offset-2">
					<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
					  <ol class="carousel-indicators">
						<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
						<li data-target="#carousel-example-generic" data-slide-to="1"></li>
						<li data-target="#carousel-example-generic" data-slide-to="2"></li>
					  </ol>					
					  <!-- slides -->
					  <div class="carousel-inner">
						<div class="item active">
						  <img src="assets/img/slide-4.png" alt="">
						</div>
						<div class="item">
						  <img src="assets/img/slide-5.png" alt="">
						</div>
						<div class="item">
						  <img src="assets/img/slide-6.png" alt="">
						</div>
					  </div>
					</div>		
				</div>
				
			</div>
		</div>
	</div>
	<div id="footer">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-lg-offset-3">
<!--					<p class="copyright">Copyright &copy; 2016 - Designed by <a href="http://axlewebtech.com" target="_blank">Axle Web Technologies | </a>-->
				<p>Copyright &copy; 2016 All Rights Reserved | Designed and Developed by <a href="https://www.facebook.com/anshulshr" target="_blank">Anshul Shrivastava</a> &amp; <a href="https://www.facebook.com/AnkitSkJain" target="_blank">Ankit Jain</a> </p>
				<a href="whatsapp://send?text=Try%20Birthday%20Manager%20Now!+http%3a%2f%2fonlinebirthdaymanager.com%2f">Share on Whatsapp</a></p>
			</div>
		</div>		
	</div>	
	</div>
	<link href="http://code.jquery.com/ui/1.11.4/themes/cupertino/jquery-ui.css" rel="stylesheet">



	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/main.js"></script>
	<script>
		$(function() {
			$("#signup-official-dob").datepicker({
				changeMonth: true,
				changeYear: true,
				yearRange: "1950:+nn",
				dateFormat: "yy-mm-dd"
			});
		});
	</script>



    <script src="assets/js/bootstrap.min.js"></script>

  </body>
</html>
