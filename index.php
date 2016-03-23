<?php include_once ($_SERVER["DOCUMENT_ROOT"]."/birthdaymanager/app/helper.php"); ?>
<?php
session_start();
$ch = curl_init();
$api_host = get_api_host();
$endpoint = $api_host."/login";
$email = $_POST["signin-email"];
$password = $_POST["signin-password"];
$post_data = "email=".$email."&password=".$password;

if(isset($email)&&isset($password)){
	curl_setopt($ch, CURLOPT_URL,$endpoint);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec ($ch);
	$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
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


    <!-- Fixed navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.html">Birthday Manager</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right main-nav">
			 <li><a class="cd-signin" href="#">Sign in</a></li>
            <li><a class="cd-signup" href="#">Sign up</a></li>
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
				<form class="cd-form" method="POST" action="/birthdaymanager/app/index.php"?>
					<p class="fieldset">
						<label class="image-replace cd-email" for="signin-email">E-mail</label>
						<input class="full-width has-padding has-border" name="signin-email" id="signin-email" type="email" placeholder="E-mail">
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset">
						<label class="image-replace cd-password" for="signin-password">Password</label>
						<input class="full-width has-padding has-border" name="signin-password" id="signin-password" type="text"  placeholder="Password">
						<a href="#0" class="hide-password">Hide</a>
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
				<form class="cd-form" id="register">
					<p class="fieldset">
						<label class="image-replace cd-username" for="signup-first-name">First Name</label>
						<input class="full-width has-padding has-border" id="signup-first-name" type="text" placeholder="First Name">
						<span class="cd-error-message">Error message here!</span>
					</p>
					
					<p class="fieldset">
						<label class="image-replace cd-username" for="signup-last-name">Last Name</label>
						<input class="full-width has-padding has-border" id="signup-last-name" type="text" placeholder="Last Name">
						<span class="cd-error-message">Error message here!</span>
					</p>
					
					<p class="fieldset">
						<label class="image-replace cd-username" for="signup-team-name">Team Name</label>
						<input class="full-width has-padding has-border" id="signup-team-name" type="text" placeholder="Team Name">
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset">
						<label class="image-replace cd-email" for="signup-email">E-mail</label>
						<input class="full-width has-padding has-border" id="signup-email" type="email" placeholder="E-mail">
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset">
						<label class="image-replace cd-password" for="signup-password">Password</label>
						<input class="full-width has-padding has-border" id="signup-password" type="text"  placeholder="Password">
						<a href="#0" class="hide-password">Hide</a>
						<span class="cd-error-message">Error message here!</span>
					</p>

					<p class="fieldset">
						<input type="checkbox" id="accept-terms">
						<label for="accept-terms">I agree to the <a href="#0">Terms</a></label>
					</p>

					<p class="fieldset">
						<input class="full-width has-padding" type="submit" value="Create account">
					</p>
				</form>

				<!-- <a href="#0" class="cd-close-form">Close</a> -->
			</div> <!-- cd-signup -->

			<div id="cd-reset-password"> <!-- reset password form -->
				<p class="cd-form-message">Lost your password? Please enter your email address. You will receive a link to create a new password.</p>

				<form class="cd-form">
					<p class="fieldset">
						<label class="image-replace cd-email" for="reset-email">E-mail</label>
						<input class="full-width has-padding has-border" id="reset-email" type="email" placeholder="E-mail">
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
					if(isset($email)&&isset($password)) {
						if ($http_code == 200 && $email != "" && $password != "") {
							$_SESSION["member_id"] = json_decode($server_output)->member_id;
							echo("<script>location.href = 'http://localhost:8888/birthdaymanager/app/dashboard'</script>");
						} else {
							echo "<div class=\"alert alert-danger\" role=\"alert\">Login Failed! Please Try Again...</div>";
						}
					}
					?>
					<h1>Birthday Manager</h1>
					<h2 class="subtitle">Always believe something wonderful is about to happen...</h2>
					<form class="form-inline signup" role="form">
					  <div class="form-group">
					    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter your email address">
					  </div>
					  <button type="submit" class="btn btn-theme">Get it now</button>
					</form>					
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
			<div class="col-lg-6 col-lg-offset-3">
					<p class="copyright">Copyright &copy; 2016 - Designed by <a href="http://axlewebtech.com">Axle Web Technologies</a></p>
			</div>
		</div>		
	</div>	
	</div>

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/main.js"></script>
  </body>
</html>
