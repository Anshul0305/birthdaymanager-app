<?php
include_once ("helper.php");
$ch = curl_init();
$api_host = get_api_host();
$endpoint = $api_host."/reset-password";
$email = $_GET["email"];
$reset_code = $_GET["code"];
$password1 = $_POST["password1"];
$password2 = $_POST["password2"];
$post_data = "email=".$email."&reset_code=".$reset_code."&password1=".$password1."&password2=".$password2;

if(isset($password1)&&isset($password2)){
    if($password1!=""&&$password2!="") {
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);

        $info = curl_getinfo($ch);
        $http_code = $info["http_code"];

        if($http_code == 200) {
            echo '<div class="alert alert-success">';
            echo '<strong>Success!</strong> Password Changed Successfully!</div>';
        }
        elseif($http_code == 409){
            echo '<div class="alert alert-danger">';
            echo '<strong>Sorry!</strong> Password Do Not Match! Please Try Again...</div>';
        }
        else{
            echo '<div class="alert alert-danger">';
            echo '<strong>Oops!</strong> An Error Occurred! Please Try Again...</div>'.$http_code;
        }
        curl_close($ch);
    }
    else{
        echo '<div class="alert alert-danger">';
        echo '<strong>Oops!</strong> Looks Like You Have Not Entered Any Team Name!</div>';
    }
}


?>
<!DOCTYPE HTML>
<html>
<head>
<title>Online Birthday Manager</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
 <!-- Bootstrap Core CSS -->
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- jQuery -->
<script src="js/jquery.min.js"></script>
<!----webfonts--->
<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
<!---//webfonts--->  
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
</head>
<body>
<div id="wrapper">
     <!-- Navigation -->
        <nav class="top1 navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Online Birthday Manager</a>
            </div>

        </nav>
        <div id="page-wrapper">
        <div class="col-md-12 graphs">
	   <div class="xs">
  	    <h3>Reset Password</h3>
  	    <div class="well1 white">
        <form class="form-floating ng-pristine ng-invalid ng-invalid-required ng-valid-email ng-valid-url ng-valid-pattern" novalidate="novalidate" method="post" action="">
          <fieldset>
            <div class="form-group">
              <label class="control-label">Enter Password</label>
              <input type="password" class="form-control1 ng-invalid ng-invalid-required ng-touched" id="password1" name="password1" required="">
            </div>
              <div class="form-group">
                  <label class="control-label">Confirm Password</label>
                  <input type="password" class="form-control1 ng-invalid ng-invalid-required ng-touched" id="password2" name="password2" required="">
              </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary">Submit</button>
              <button type="reset" class="btn btn-default">Reset</button>
            </div>
          </fieldset>
        </form>
      </div>
    </div>

   </div>
      </div>
      <!-- /#page-wrapper -->
   </div>
    <!-- /#wrapper -->
<!-- Nav CSS -->
<link href="css/custom.css" rel="stylesheet">
<!-- Metis Menu Plugin JavaScript -->
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
</body>
</html>
