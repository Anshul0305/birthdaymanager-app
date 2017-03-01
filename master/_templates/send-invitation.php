<?php include_once "./././helper.php"?>
<?php
is_member_logged_in();
if(isset($_GET["team-id"])){
    $team_id = $_GET["team-id"];
}
?>

<?php

if(isset($_POST["message"])){
    $message = $_POST["message"];
    $name = $_POST["bday-of"];
    $location = $_POST["location"];
    $celebration_date = $_POST["celebration-time"];

    ?>
<!--    HTML-->
<div class="content_bottom">
    <div class="col-md-12 span_3">
        <div class="bs-example1" data-example-id="contextual-table">

        <html>
        <head>
            <title>Invitation</title>
            <meta charset="UTF-8">
            <meta name="description" content="" />
            <meta name="keywords" content="" />
            <script src="http://use.edgefonts.net/berkshire-swash:n4:all.js"></script>
            <link rel="stylesheet" href="border.css">
            <style>
                h1,h2,h3,h4{
                    font-family: "berkshire-swash";
                    color: rgb(71, 151, 212);
                }
                .frame{
                    position: relative;
                    padding: 10px;
                    text-align: center;
                    font-family: arial;
                    color: rgba(0, 0, 0, 0.56);
                    text-shadow: 0px 0px 5px rgba(0,0,0,0.2);
                    margin: auto;
                    width: 300px;
                    border-radius: 20px;
                    border: 27px solid;
                    border-image: url("http://jagocoding.com/files/userdata/dandy/f_14052716243793.png") 27 repeat;
                    background-color: rgba(0, 0, 0, 0);
                }

                .foto{
                    position: absolute;
                    width: 120px;
                    top: 20px;
                    right: -120px;
                    -ms-transform: rotate(10deg); /* IE 9 */
                    -webkit-transform: rotate(10deg); /* Chrome, Safari, Opera */
                    transform: rotate(10deg);
                    border: 10px solid rgb(254, 168, 167);
                }
            </style>
        </head>
        <body>
        <div class="frame">
            <img src="http://jagocoding.com/files/userdata/dandy/f_14052716754590.jpg" class="foto">
            <h1>Happy Birthday</h1>
            <h4>Invitation</h4><br>
            Hello Friends!<br>
            <br>Please Join Us<br> At Birthday Celebration of <?php echo $name?><br>
            <br>
            Date :  <?php echo format_date($celebration_date,"day").", ".format_date($celebration_date,"DMY")?> <br>
            Time :  <?php echo format_date($celebration_date,"time")?><br>
            Location: <?php echo $location?> <br>
            <br>
            <?php echo $message?>
        </div>
        </body>
        </html>
            </br></br>
            <div>
                <div class="row">
                    <div class="col-sm-3 col-sm-offset-3">
                        <button onclick="window.history.back();" class="btn-success1 btn">Go Back</button>
                    </div>
                    <div class="col-sm-3 ">
                        <button type="submit" class="btn-success1 btn">Send Invitation</button>
                    </div>
                </div>
            </div>
            </div>
    </div>
    <div class="clearfix"> </div>
</div>
    

    <?php

}else
{
    ?>
        <div class="content_bottom">
            <div class="col-md-12 span_3">
                <div class="bs-example1" data-example-id="contextual-table">
                    <div style="text-align: center; font-weight: 500; font-size: x-large; color: #0b2c89; background: #06D995 ">Send Invitation</div>
                    </br>

                    <?php
                    is_member_logged_in();
                    $ch = curl_init();
                    $api_host = get_api_host();
                    $logged_in_member_id = get_logged_in_member_id();
                    $endpoint = $api_host."/members/".$logged_in_member_id;
                    $json = json_decode(file_get_contents($endpoint));

                    $post_celebration_endpoint = $api_host."/celebrations";

                    $birthday_of_member_id = $_POST['bday-of'];
                    $cake_amount = $_POST['cake-amt'];
                    $other_expense = $_POST['other-exp'];
                    $celebration_date = $_POST['celebration-date'];
                    $team_id = $_POST['select-team'];
                    $attendees_member_id = $_POST['attendee'];


                    if(isset($birthday_of_member_id) && isset($attendees_member_id)){
                        $post_data = "birthday_of_member_id=".$birthday_of_member_id.
                            "&cake_amount=".$cake_amount.
                            "&other_expense=".$other_expense.
                            "&celebration_date=".$celebration_date.
                            "&team_id=".$team_id;

                        foreach ($attendees_member_id as $attendee){
                            $post_data = $post_data. "&attendees_member_id[]=".$attendee;
                        }

                        if($cake_amount!="" && $other_expense !="") {
                            curl_setopt($ch, CURLOPT_URL, $post_celebration_endpoint);
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $server_output = curl_exec($ch);

                            $info = curl_getinfo($ch);
                            $http_code = $info["http_code"];

                            if($http_code = 200) {
                                echo '<div class="alert alert-success">';
                                echo '<strong>Success!</strong> Celebration Added Successfully!</div>';
                            }
                            else{
                                print_r( $server_output);
                                echo '<div class="alert alert-danger">';
                                echo '<strong>Oops!</strong> An Error Occurred! Please Try Again...</div>'.$server_output."ot";
                            }
                            curl_close($ch);
                        }
                        else{
                            echo '<div class="alert alert-danger">';
                            echo '<strong>Oops!</strong> Looks Like You Have Not Entered Some Data!</div>';
                        }
                    }

                    ?>

                    <form class="form-horizontal" method="post" action="">
                        <div class="form-group">
                            <label for="selector1" class="col-sm-3 control-label">Select Team</label>
                            <div class="col-sm-7"><select name="select-team" id="select-team" class="form-control1">
                                    <option>--- Select ---</option>
                                </select></div>
                        </div>
                        <div class="form-group">
                            <label for="selector1" class="col-sm-3 control-label">Celebrating Birthday of</label>
                            <div class="col-sm-7"><select name="bday-of" id="bday-of" class="form-control1">
                                    <option>--- Select ---</option>
                                </select></div>
                        </div>
                        <div class="form-group">
                            <label for="checkbox" class="col-sm-3 control-label">Send Invitation to</label>
                            <div class="col-sm-7" id="attendees">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="checkbox" class="col-sm-3 control-label">Celebration Date & Time</label>
                            <div class="col-sm-7">
                                <label><input type="text" name="celebration-time" id="celebration-time" value="<?php echo date('Y-m-d'); ?>"></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="checkbox" class="col-sm-3 control-label">Location</label>
                            <div class="col-sm-7"><input type="text" class="form-control1" id="location" name="location" placeholder="Enter Location"></div>
                        </div>
                        <div class="form-group">
                            <label for="focusedinput" class="col-sm-3 control-label">Invitation Message</label>
                            <div class="col-sm-7">
                                <textarea style="height: 100px" name="message" id="message" cols="50" rows="10" class="form-control1"></textarea>
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-sm-7 col-sm-offset-3">
                                    <button type="" class="btn-success1 btn">Preview Invitation</button>
                                </div>
                            </div>
                        </div>
                        <div>
                            </br>
                        </div>
                        </br>
                    </form>
                </div>
            </div>
            <div class="clearfix"> </div>
        </div>
        <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <link href="http://code.jquery.com/ui/1.11.4/themes/cupertino/jquery-ui.css" rel="stylesheet">
        <script>
            $(function() {
                $("#celebration-date").datepicker({
                    changeMonth: true,
                    dateFormat: "yy-mm-dd"
                });
            });
            $(function() {
                $("#celebration-time").flatpickr({
                    defaultDate: "<?php echo format_date(date('Y-m-d H:i:s'),"ymd")?>T<?php echo date('H:i:s')?>Z",
                    enableTime: true
                });
            });

        </script>
        <script type = "text/javascript" language = "javascript">
        // Populate Team Dropdown
        $(document).ready( function(){
            $.get("<?php echo $api_host?>/members/<?php echo $logged_in_member_id?>",
                function(data) {
                    var select_team = document.getElementById("select-team");
                    data[0].teams.forEach(function(entry) {
                        if(entry.is_admin == "true"){
                            var option = document.createElement("option");
                            option.text = entry.name;
                            option.value = entry.id;
                            select_team.add(option);
                        }
                    });
                });
        });
        // Populate Team Member Dropdown
        $(document).ready(function() {
            $("#select-team").change(function(){
                var x = document.getElementById("bday-of");
                x.innerHTML="";
                $('#attendees').empty();
                var option = document.createElement("option");
                option.text = "--- Select ---";
                x.add(option);

                var id = $("#select-team").val();
                $.get(
                    "<?php echo $api_host?>/teams/"+id,
                    function(data) {
                        data[0].members.forEach(function(entry) {
                            var option = document.createElement("option");
                            option.text = entry.name;
                            option.value = entry.name;
                            x.add(option);
                        });
                    }
                );
            });
        });
        // Populate attendees
        $(document).ready(function(){
            $("#bday-of").change(function(){
                $('#attendees').empty();
                var id = $("#select-team").val();
                var bday_of = $("#bday-of").val();
                $.get(
                    "<?php echo $api_host?>/teams/"+id,
                    function(data) {
                        data[0].members.forEach(function(entry) {
                            if(entry.id != bday_of){
                                $('#attendees').append('<div class="checkbox-inline1"><label><input type="checkbox" name="attendee[]" value='+ entry.id +' checked=""> '+ entry.name +'</label></div>');
                            }
                        });
                    }
                );
            });
        });
    </script>

    <?php

}

?>

