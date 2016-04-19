<?php include_once "./././helper.php"?>
<?php
is_member_logged_in();
?>
<div class="content_bottom">
    <div class="col-md-12 span_3">
        <div class="bs-example1" data-example-id="contextual-table">
            <div style="text-align: center; font-weight: 500; font-size: x-large; color: #0b2c89; background: #06D995 ">Celebrate Birthday</div>
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

            $post_data = "birthday_of_member_id=".$birthday_of_member_id.
                    "&cake_amount=".$cake_amount.
                    "&other_expense=".$other_expense.
                    "&celebration_date=".$celebration_date.
                    "&team_id=".$team_id;

            foreach ($attendees_member_id as $attendee){
                $post_data = $post_data. "&attendees_member_id[]=".$attendee;
            }

            if(isset($birthday_of_member_id)){
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
//                        echo $post_celebration_endpoint."</br>";
//                        echo $post_data."</br>";
//                        echo '</br>bday-of '.$birthday_of_member_id;
//                        echo '</br>cake-amt '.$cake_amount ;
//                        echo '</br>other-exp '.$other_expense ;
//                        echo '</br>celebration-date '.$celebration_date;
//                        echo '</br>team-id '.$team_id;
//                        foreach ($attendees_member_id as $id){
//                            echo '</br>attendee '.$id;
//                        }
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
                    <label for="selector1" class="col-sm-2 control-label">Select Team</label>
                    <div class="col-sm-8"><select name="select-team" id="select-team" class="form-control1">
                            <option>--- Select ---</option>
<!--                            <option value="1">Mindtree Team</option>-->
<!--                            <option value="2">BBC Team</option>-->
<!--                            <option value="3">40 Lime Court Team</option>-->
<!--                            <option value="4">London Team</option>-->
                        </select></div>
                </div>
                <div class="form-group">
                    <label for="selector1" class="col-sm-2 control-label">Celebrate Birthday Of</label>
                    <div class="col-sm-8"><select name="bday-of" id="bday-of" class="form-control1">
                            <option>--- Select ---</option>
<!--                            <option>Ankit Jain</option>-->
<!--                            <option>Anshul Shrivastava</option>-->
<!--                            <option>Sonal Manoria</option>-->
<!--                            <option>Mummy</option>-->
                        </select></div>
                </div>
                <div class="form-group">
                    <label for="checkbox" class="col-sm-2 control-label">Attendees</label>
                    <div class="col-sm-8" id="attendees">
<!--                        <div class="checkbox-inline1"><label><input type="checkbox"> Ankit Jain</label></div>-->
<!--                        <div class="checkbox-inline1"><label><input type="checkbox"> Anshul Shrivastava</label></div>-->
<!--                        <div class="checkbox-inline1"><label><input type="checkbox"> Sonal Manoria</label></div>-->
<!--                        <div class="checkbox-inline1"><label><input type="checkbox"> Mummy</label></div>-->
                    </div>
                </div>
                <div class="form-group">
                    <label for="checkbox" class="col-sm-2 control-label">Celebration Date</label>
                    <div class="col-sm-8">
                        <label><input type="date" name="celebration-date" id="celebration-date" value="<?php echo date('Y-m-d'); ?>"></label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="focusedinput" class="col-sm-2 control-label">Cake Amount</label>
                    <div class="col-sm-8">
                        <input type="number" min="0" step="0.01" class="form-control1" name="cake-amt" id="cake-amt" placeholder="Total Expense on Cake">
                    </div>
                    <div class="col-sm-2">
                        <p class="help-block">How Much You Paid For Cake!</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="focusedinput" class="col-sm-2 control-label">Other Expense</label>
                    <div class="col-sm-8">
                        <input type="number" min="0" step="0.01" class="form-control1" name="other-exp" id="other-exp" placeholder="Total Other Expense">
                    </div>
                    <div class="col-sm-2">
                        <p class="help-block">Anything Else You Spend Money On!</p>
                    </div>
                </div>
                <div>
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <button type="submit" class="btn-success1 btn">Send Update</button>
                        </div>
                    </div>
                </div>
                </br>
            </form>
        </div>
    </div>
    <div class="clearfix"> </div>
</div>

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
                        option.value = entry.id;
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