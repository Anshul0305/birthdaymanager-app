<?php include_once ("./././helper.php")?>
<div class="xs">
    <?php
    is_member_logged_in();
    $api_host = get_api_host();
    $logged_in_member_id = get_logged_in_member_id();
    $team_name = $_POST["team_name"];
    $endpoint = $api_host."/teams/search?subquery=".$team_name;
    $json = json_decode(file_get_contents($endpoint));

    ?>

<!--    <div style="text-align: center; font-weight: 500; font-size: x-large; color: #0b2c89; background: #06D995 ">Create Team</div>-->
    <div class="tab-content">
        <div class="tab-pane active">
            <form class="form-horizontal" method="post" action="">
                <div class="form-group">
                    <label for="focusedinput" class="col-sm-2 control-label">Team Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control1" name="team_name" id="team_name" placeholder="Enter Team Name">
                    </div>
                    <div class="col-sm-2">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div>
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <button type="submit" class="btn-success1 btn">Search Team</button>
                        </div>
                    </div>
                </div>
                </br>
            </form>
        </div>
    </div>

    <?php

    if(isset($team_name)){
        if($team_name!="") {
            if(count($json)>0){
                echo "<table class=\"table\">";
                echo "<thead>";
                echo "<tr>";
                echo "<th>Team Name</th>";
                echo "<th>Admin Name</th>";
                echo "<th>Total Members</th>";
                echo "<th>Team Fund Balance</th>";
                echo "<th>Action</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                for ($i = 0; $i < count($json); $i++) {
                    echo "<tr class='info'>";
                    echo "<td>" . $json[$i]->name . "</td>";
                    echo "<td>" . $json[$i]->admin_name . "</td>";
                    echo "<td>" . count($json[$i]->member_id) . "</td>";
                    echo "<td>£" . $json[$i]->fund_balance . "</td>";
                    if(is_member_of_given_team($logged_in_member_id, $json[$i]->id)){
                        echo "<td> Member</td>";
                    }else{
                        echo "<td> <button onclick='join_team(".$json[$i]->id.",".$logged_in_member_id .")' class='btn-info'>Join Team</button></td></td>";
                    }
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            }
            else{
                echo '<div class="alert alert-warning">';
                echo '<strong>Sorry!</strong> No Team Found With That Search Term!</div>';
            }
        }
        else{
            echo '<div class="alert alert-danger">';
            echo '<strong>Oops!</strong> Looks Like You Have Not Entered Any Team Name!</div>';
        }
    }
    ?>
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
    </script>
</div>