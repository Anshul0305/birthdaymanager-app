<?php include_once ($_SERVER["DOCUMENT_ROOT"].json_decode(file_get_contents("env.json"))->website_relative_path. "/helper.php"); ?>
<?php
session_start();
$api_host = get_api_host();
$logged_in_url =

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
	$official_dob = date('Y-m-d', strtotime($_POST["signup-official-dob"]));
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
<script>

	function onSignIn(googleUser) {
		var profile = googleUser.getBasicProfile();
		function postRefreshPage () {
			var theForm, newInput1;
			// Start by creating a <form>
			theForm = document.createElement('form');
			theForm.action = '#';
			theForm.method = 'post';

			newInput1 = document.createElement('input');
			newInput1.type = 'hidden';
			newInput1.name = 'google-signin-email';
			newInput1.value = profile.getEmail();

			// Now put everything together...
			theForm.appendChild(newInput1);

			// ...and it to the DOM...
			document.getElementById('hidden_form_container').appendChild(theForm);
			// ...and submit it
			theForm.submit();
		}
		<?php
		// Get user email ID in php using Self Post

		if($_POST["google-signin-email"]!="")
		{
			// If Google user email id is retrieved, set the session and login the user
			$endpoint = $api_host."/members/search?subquery=".$_POST["google-signin-email"];
			$json = json_decode(file_get_contents($endpoint));
			// If Google user is registered with Birthday manager - Login
			if ($json[0]->id !="" && $json[0]->id != null){
				$_SESSION["member_id"] = $json[0]->id;

				// if session is valid, login user
				if(isset($_SESSION)){
					echo "location.href = 'http://".get_website_host(). json_decode(file_get_contents("env.json"))->website_relative_path."/dashboard'";
				}
			}
			// If Google user is not registered with Birthday manager - Show Register form with field filled up
			else
			{
				$google_new_user = true;
				?>
				var sign_up_form = document.getElementById('sign-up');
				sign_up_form.click();

				// get the fields
				var first_name = document.getElementById('signup-first-name');
				var last_name = document.getElementById('signup-last-name');
				var email = document.getElementById('signup-email');

				// populate the value from google response
				first_name.value=profile.getName().split(' ')[0];
				last_name.value=profile.getName().split(' ')[1];
				email.value=profile.getEmail();

				// hide those fields from form
				first_name.style.display = 'none';
				last_name.style.display = 'none';
				email.style.display = 'none';
			<?php
			}
		}
		else
		{
			echo "postRefreshPage();";
		}
		?>
	}
</script>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Online birthday manager can help you organise the group birthday celebrations. It helps you split the expense during birthday celebrations. You can also send invitations and greeting cards.">
    <meta name="author" content="Axle Web Technology">
	<meta name="keywords" content="birthday, celebration, party, greeting, online, reminder, birthday reminders, reminder service, free birthday reminder, birthday reminder service, email reminders, cell phone reminders,
free email reminders, RSS, birthday cards, gift suggestions, greeting card, paper greeting card, egreetings, ecards, anniversary reminder, calendars, gift suggestions, paper cards">
	<meta name="google-signin-client_id" content="58409882003-e6lo8hvchgbpf0s9iotm826j4ghutplt.apps.googleusercontent.com">

	<link rel="shortcut icon" href="assets/img/favicon.png">

    <title>Online Birthday Manager</title>

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
	  <link href="http://blythedolls.neocities.org/img/favicon.ico" rel="icon" type="image/x-icon" />
  </head>


  <body>
  <script src="assets/js/main.js"></script>
  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script src="https://apis.google.com/js/platform.js" async defer></script>

    <!-- Fixed navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://<?php echo get_website_host()?><?php echo get_website_relative_path()?>">Birthday Manager</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right main-nav">
			 <li><a class="cd-signin" data-toggle="collapse" data-target=".navbar-collapse" href="#" style="width: 80px">Sign in</a></li>
            <li><a id="sign-up" class="cd-signup" data-toggle="collapse" data-target=".navbar-collapse" href="#" style="width: 85px">Sign up</a></li>
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
				<form class="cd-form" method="POST" action="<?php echo json_decode(file_get_contents("env.json"))->website_relative_path.'/index.php'?>">

				<p class="fieldset">
					Sign in with Google:
				<div style="width: 100%" align="middle" class="g-signin2" data-onsuccess="onSignIn"></div>

				</p>
				</br>
				<p>Or Enter Your Username and Password:</p>
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

					<?php if ($google_new_user) echo "<p style='color: red;'>Nearly there! Please provide few more details to complete sign up...</p>";?>

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
						<input class="full-width has-padding has-border" id="signup-official-dob" name="signup-official-dob" type="text" placeholder="Date of Birth" readonly="true">
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
  <div id="hidden_form_container" style="display:none;"></div>


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
							echo "<div class=\"alert alert-success\" role=\"alert\">Registered Successfully! logging in...</div>";
							$_SESSION["member_id"] = json_decode($register_output)->member_id;
							echo "<script>location.href = 'http://".get_website_host(). json_decode(file_get_contents("env.json"))->website_relative_path."/get-started'</script>";
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
					<h2 class="subtitle">Make group birthday celebrations more joyful and convenient...</h2>
					<br>
					<iframe width="100%" height="315" src="https://www.youtube.com/embed/nThCMMtklrY" frameborder="0" allowfullscreen></iframe>
					<div style="margin-top: 20px;">
						<div style="float: left;margin:5px"><a type="submit" href="pages/how-it-works.htm" class="btn btn-theme">How it works</a></div>
						<div style="float: left;margin:5px"><a type="submit" href="pages/faq.htm" class="btn btn-theme">FAQ</a></div>
						<div style="float: left;margin:5px"><a type="submit" href="pages/pricing.htm" class="btn btn-theme">Pricing</a></div>
						<div style="float: left;margin:5px"><a type="submit" href="http://blogs.onlinebirthdaymanager.com" class="btn btn-theme" target="_blank">Blogs</a></div>
						<div style="float: left;margin:5px;margin-bottom: 20px"><a type="submit" href="pages/contact-us.htm" class="btn btn-theme">Contact us</a></div>
					</div>
				</div>
			</div>
		</div>
	</div>

  <style>
	  body { background:#efefef;}
	  .plans {padding: 0 !important;}
	  .plans h5 {background: #C1282D ;padding: 10px 10px;color: #fff;font-size: 16px;text-transform: uppercase;  letter-spacing: 1px;font-weight: bold;}
	  .panel-pricing {-moz-transition: all .3s ease;-o-transition: all .3s ease;-webkit-transition: all .3s ease;}
	  .panel-pricing:hover {box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.2);}
	  .panel-pricing .panel-heading {padding:13px 10px;color:#fdfdfd;background-color:#C1282D;border-color:#ed1c24;}
	  .panel-pricing .panel-heading .fa {margin-top: 10px;font-size: 58px;}
	  .panel-pricing .list-group-item {color: #777777;border-bottom: 1px solid rgba(250, 250, 250, 0.5);}
	  .panel { border:0px solid !important;}
	  .panel-pricing .panel-body {font-size:40px;padding:10px;margin:0px;border-bottom: 1px solid #cfcfcf;}
	  .panel-footer { border:0px solid !important;background-color:#fff !important;}
	  .panel-pricing .panel-heading h3 {margin: 0;padding: 10px; color:white}
	  p.p-title { font-size:18px;text-align: center;text-transform: capitalize;}
	  p.p-time { font-size:18px;text-align: center;text-transform: capitalize;}
	  p.p-price { font-size:18px;text-align: center;text-transform: capitalize;color: #ed1c24;font-weight: bold;}
	  p.p-tax { font-size:18px;text-align: center;text-transform: capitalize;}
	  .sub-btn {background: #ed1c24;color: #fff;border-radius: 0px;padding: 5px 8px;}
	  .sub-btn:hover, .sub-btn:focus { color:#fff; text-decoration:none;}
  </style>

  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"  type="text/css" rel="stylesheet" media="all">

<!--  <div class="container-fluid">-->
<!--	  <div class="plans col-md-12 col-sm-12 col-xs-12 text-center">-->
<!--		  <h5>Features</h5>-->
<!--	  </div>-->
<!--  </div><!--container-fluid close-->
  </br>

  <section>
	  <div class="container">
		  <div class="row">
			  <!-- item -->
			  <div class="col-md-4 col-sm-4 col-xs-12 text-center">
				  <div class="panel panel-pricing">
					  <div class="panel-heading">
						  <i class="fa fa-calendar"></i>
						  <h3>Invitations</h3>
					  </div><!--panel-heading close-->
					  <div class="panel-body text-center">
						  <p class="p-title">Send Invitations for birthday party</p><!--p-title close-->
						  <p class="p-time">Get RSVP from members</p><!--p-time close-->
					  </div><!--panel-body text-center close-->
<!--					  <div class="panel-body text-center">-->
<!--						  <p class="p-price">₦ 50.00 </p><!--p-price close-->
<!--						  <p class="p-tax">All inclusive</p><!--p-tax close-->
<!--					  </div><!--panel-body text-center close-->
					  <div class="panel-footer">
						  <a class="btn sub-btn" href="./pages/how-it-works.htm">Learn More</a>
					  </div>
				  </div><!--panel panel-pricing close-->
			  </div><!--col-md-4 col-sm-4 col-xs-12 text-center close-->


			  <div class="col-md-4 col-sm-4 col-xs-12 text-center">
				  <div class="panel panel-pricing">
					  <div class="panel-heading">
						  <i class="fa fa-envelope"></i>
						  <h3>Greeting Cards</h3>
					  </div><!--panel-heading close-->
					  <div class="panel-body text-center">
						  <p class="p-title">Send beautiful birthday cards</p><!--p-title close-->
						  <p class="p-time">Surprise your teammates</p><!--p-time close-->
					  </div><!--panel-body text-center close-->
<!--					  <div class="panel-body text-center">-->
<!--						  <p class="p-price">₦ 150.00 </p><!--p-price close-->
<!--						  <p class="p-tax">All inclusive</p><!--p-tax close-->
<!--					  </div><!--panel-body text-center close-->
					  <div class="panel-footer">
						  <a class="btn sub-btn" href="./pages/how-it-works.htm">Learn More</a>
					  </div>
				  </div><!--panel panel-pricing close-->
			  </div><!--col-md-4 col-sm-4 col-xs-12 text-center close-->



			  <div class="col-md-4 col-sm-4 col-xs-12 text-center">
				  <div class="panel panel-pricing">
					  <div class="panel-heading">
						  <i class="fa fa-money "></i>
						  <h3>Split Expenses</h3>
					  </div><!--panel-heading close-->
					  <div class="panel-body text-center">
						  <p class="p-title">Split the expense on celebrations</p><!--p-title close-->
						  <p class="p-time">Easily manage the contributions</p><!--p-time close-->
					  </div><!--panel-body text-center close-->
<!--					  <div class="panel-body text-center">-->
<!--						  <p class="p-price">₦ 400.00 </p><!--p-price close-->
<!--						  <p class="p-tax">All inclusive</p><!--p-tax close-->
<!--					  </div><!--panel-body text-center close-->
					  <div class="panel-footer">
						  <a class="btn sub-btn" href="./pages/how-it-works.htm">Learn More</a>
					  </div>
				  </div><!--panel panel-pricing close-->
			  </div><!--col-md-4 col-sm-4 col-xs-12 text-center close-->

		  </div><!--row close-->
	  </div><!--container close-->
  </section><!--section close-->


	<div id="footer">
	<div class="container">
		<div class="row">
			<div class="col-lg-9 col-lg-offset-3">
				<p>Copyright &copy; 2017 All Rights Reserved | Designed and Developed by <a href="#" target="_blank">Axle Web Technologies</a> </p>
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
				changeYear: false,
				dateFormat: "dd MM"
			});
		});
	</script>
    <script src="assets/js/bootstrap.min.js"></script>

  </body>
</html>
