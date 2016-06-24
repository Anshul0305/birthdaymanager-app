<?php include_once ("./././helper.php")?>
<div class="xs">
    <?php
    is_member_logged_in();
    $api_host = get_api_host();
    $logged_in_member_id = get_logged_in_member_id();
    $team_id = $_GET["team-id"];
    $member_email = $_POST["member_email"];
    $endpoint = $api_host."/members/search?subquery=".$member_email;
    $json = json_decode(file_get_contents($endpoint));

    $team_endpoint = $api_host."/teams/".$team_id;
    $team_name = json_decode(file_get_contents($team_endpoint))[0]->name;

    ?>

<!--    <div style="text-align: center; font-weight: 500; font-size: x-large; color: #0b2c89; background: #06D995 ">Create Team</div>-->

    <?php
        if($team_id==""){
            echo '<div class="alert alert-warning">';
            echo '<strong>Sorry!</strong> Invalid Request</div>';
            die();
        }
        if(!is_member_admin($logged_in_member_id,$team_id)){
            echo '<div class="alert alert-warning">';
            echo '<strong>Sorry!</strong> You Are Not Allowed to Add Members to This Team!</div>';
            die();
        }
    ?>

    <div class="bs-example1" data-example-id="contextual-table">
    <div><button class="btn-info" onclick="location.href='<?php echo "http://". get_website_host()?><?php echo get_website_relative_path(). "/view-team-details?team-id=".$team_id?>'">Back to Team - <?php echo $team_name?> </button></div></br>
    <div style="text-align: center; font-weight: 500; font-size: x-large; color: floralwhite; background: #06D995 ">Add Member to Team - <?php echo $team_name?></div>
    </br>
    <div class="tab-content">
        <div class="tab-pane active">
            <form class="form-horizontal" method="post" action="">
                <div class="form-group">
                    <label for="focusedinput" class="col-sm-2 control-label">Member Email Id</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control1" name="member_email" id="member_email" placeholder="Enter Member Email">
                    </div>
                    <div class="col-sm-2">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div>
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <button type="submit" class="btn-success1 btn">Search Member</button>
                        </div>
                    </div>
                </div>
                </br>
            </form>
        </div>
    </div>


    <?php

    if(isset($member_email)){
        if($member_email!="") {
            if (!filter_var($member_email, FILTER_VALIDATE_EMAIL) === false) {
                if (count($json) > 0) {
                    echo "<table class=\"table\">";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Member Name</th>";
                    echo "<th>Email</th>";
                    echo "<th>Date of Birth</th>";
                    echo "<th>Action</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    for ($i = 0; $i < count($json); $i++) {
                        echo "<tr class='info'>";
                        echo "<td>" . $json[$i]->first_name . " " . $json[$i]->last_name . "</td>";
                        echo "<td>" . $json[$i]->email . "</td>";
                        echo "<td>" . format_date($json[$i]->dob,"DM") . "</td>";
                        $is_member = false;
                        foreach ($json[$i]->teams as $team) {
                            if ($team->id == $team_id) {
                                $is_member = true;
                            }
                        }
                        if (!$is_member) {
                            echo "<td> <button onclick='join_team(" . $team_id . "," . $json[$i]->id . ")' class='btn-info'>Add Member</button></td></td>";
                        } else {
                            echo "<td> Member</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo '<div class="alert alert-warning">';
                    echo '<strong>Sorry!</strong> No Member Found With That Email Id! <a onclick="invite('.$team_id.",'".$member_email. "'". ')" style="text-decoration: none" href="#"> Send Invitation</a></div>';
                }
            }
            else{
                echo '<div class="alert alert-danger">';
                echo '<strong>Oops!</strong> Looks Like You Have Not Entered a Valid Email Id!</div>';
            }
        }
        else{
            echo '<div class="alert alert-danger">';
            echo '<strong>Sorry!</strong> Please Enter a Valid Email Id!</div>';
        }
    }
    ?>
            </div>
    <script>
        function join_team(team_id,member_id){
            $.post('<?php echo  get_api_host()."/join-team"?>',
                {
                    team_id: team_id,
                    member_id: member_id
                });
            alert("Joined Team Successfully!");
            location.reload();
        }
        function invite(team_id,member_email){
            $.post('<?php echo  get_api_host()."/invite"?>',
                {
                    team_id: team_id,
                    email: member_email
                });
            alert("Invitation Sent Successfully to " + member_email + "!");
        }
    </script>
</div>