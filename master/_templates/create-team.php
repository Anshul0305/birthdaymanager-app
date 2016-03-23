<?php include_once ("./././helper.php")?>
<div class="xs">
    <?php
    is_member_logged_in();
    $ch = curl_init();
    $api_host = get_api_host();
    $endpoint = $api_host."/teams";
    $logged_in_member_id = get_logged_in_member_id();
    $team_name = $_POST["team_name"];
    $post_data = "team_name=".$team_name."&team_admin_id=".$logged_in_member_id;

    if(isset($team_name)){
        curl_setopt($ch, CURLOPT_URL,$endpoint);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        echo '<div class="alert alert-success">';
        echo '<strong>Success!</strong> Team Created Successfully!</div>';
    }

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
                            <button type="submit" class="btn-success1 btn">Create Team</button>
                        </div>
                    </div>
                </div>
                </br>
            </form>
        </div>
    </div>
</div>