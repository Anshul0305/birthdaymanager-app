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
$login_endpoint = $api_host."/autologin";
$signin_email = $_GET["signin-email"];
$signin_code = $_GET["signin-code"];
$signin_post_data = "email=".$signin_email."&reset_code=".$signin_code;

if(isset($signin_email)&&isset($signin_code)){
	curl_setopt($ch, CURLOPT_URL,$login_endpoint);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $signin_post_data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$login_output = curl_exec ($ch);
	$login_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close ($ch);
}

// Handle Login
if(isset($signin_email)&&isset($signin_code)) {
	if ($login_http_code == 200 && $signin_email != "" && $signin_code != "") {
		$_SESSION["member_id"] = json_decode($login_output)->member_id;
		echo "<script>location.href = 'http://".get_website_host(). json_decode(file_get_contents("env.json"))->website_relative_path."/dashboard'</script>";
	} else {
		echo "<div class=\"alert alert-danger\" role=\"alert\">Sorry! This link is expired or invalid.</div>";
	}
}

?>