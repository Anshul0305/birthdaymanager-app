<?php include_once "./././helper.php"?>
<?php
is_member_logged_in();
$member_id = get_logged_in_member_id();
$member_endpoint = get_api_host()."/members/".$member_id;
$member_json = json_decode(file_get_contents($member_endpoint));

$first_name = $member_json[0]->first_name;
$last_name = $member_json[0]->last_name;
$dob = $member_json[0]->dob;
$email = $member_json[0]->email;

$post_first_name = $_POST["first-name"];
$post_last_name = $_POST["last-name"];
$post_dob = $_POST["dob"];
$post_email = $_POST["email"];

$ch = curl_init();
$api_host = get_api_host();
$post_members_endpoint = $api_host."/members";

if(isset($post_first_name) && isset($post_last_name) && isset($post_dob) && isset($post_email)) {
    $post_data = "first_name=" . $post_first_name .
        "&last_name=" . $post_last_name .
        "&official_dob=" .format_date($post_dob,"ymd") .
        "&email=" . $post_email .
        "&member_id=" . $member_id;

    if($post_first_name !="" && $post_last_name !="" && $post_dob !="" && $post_email != ""){
        curl_setopt($ch, CURLOPT_URL, $post_members_endpoint);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $info = curl_getinfo($ch);
        $http_code = $info["http_code"];
        curl_close($ch);

        if ($http_code = 200) {
            echo '<div class="alert alert-success">';
            echo '<strong>Success!</strong> Profile Updated Successfully!</div>';
            $member_endpoint = get_api_host()."/members/".$member_id;
            $member_json = json_decode(file_get_contents($member_endpoint));
            $first_name = $member_json[0]->first_name;
            $last_name = $member_json[0]->last_name;
            $dob = $member_json[0]->dob;
            $email = $member_json[0]->email;
        }
        else{
            echo '<div class="alert alert-danger">';
            echo '<strong>Oops!</strong> Some Error Occurred!</div>';
        }
    }
    else{
        echo '<div class="alert alert-danger">';
        echo '<strong>Oops!</strong> Looks Like You Have Not Entered Some Data!</div>';
    }
}
?>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link href="http://code.jquery.com/ui/1.11.4/themes/cupertino/jquery-ui.css" rel="stylesheet">
<script>
    $(function() {
        $("#dob").datepicker({
            yearRange: "1950:+nn",
            changeMonth: true,
            changeYear: true,
            dateFormat: "dd-mm-yy"
        });
    });
</script>
<div class="content_bottom">
    <div class="col-md-12 span_3">
        <div class="bs-example1" data-example-id="contextual-table">
            <div style="text-align: center; font-weight: 500; font-size: x-large; color: #0b2c89; background: #06D995 ">Profile Settings</div>
            </br>

            <form class="form-horizontal" method="post" action="">
                <div class="form-group">
                    <label for="focusedinput" class="col-sm-2 control-label">First Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control1" name="first-name" id="first-name" placeholder="Enter Your First Name" value="<?php echo $first_name ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="focusedinput" class="col-sm-2 control-label">Last Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control1" name="last-name" id="last-name" placeholder="Enter Your Last Name" value="<?php echo $last_name ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="focusedinput" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-8">
                        <input type="email" class="form-control1" name="email" id="email" placeholder="Enter Your Email Address" value="<?php echo $email ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="focusedinput" class="col-sm-2 control-label">Date of Birth</label>
                    <div class="col-sm-8">
                        <label><input type="text" name="dob" id="dob" value="<?php echo format_date($dob, "dmy") ?>"></label>
                    </div>
                </div>
                <div>
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <button type="submit" class="btn-success1 btn">Update Profile</button>
                        </div>
                    </div>
                </div>
                </br>
            </form>

        </div>
    </div>
    <div class="clearfix"> </div>
</div>