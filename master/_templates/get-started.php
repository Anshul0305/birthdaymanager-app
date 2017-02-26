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
        if($team_name!="") {
            curl_setopt($ch, CURLOPT_URL, $endpoint);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);

            $info = curl_getinfo($ch);
            $http_code = $info["http_code"];
            $team_id = json_decode($server_output)->team_id;
            curl_close($ch);

            if($http_code == 200)
            {
                ?>
                    <div class="alert alert-success"><strong>Good Job!</strong> Your Team is Created Successfully! Now Invite Your Friends to Join this Team...</div>
                    <div class="alert alert-info"> To Invite friends, click on the "Team Invitation Link" button and share this unique link with your friends. Anyone signing up with this unique link will directly become member of your team...</div>
                    <div><button class='btn btn-info' data-toggle="modal" data-target="#linkModal">Team Invitation Link</button></div>

                    <div class="modal fade" id="linkModal" role="dialog">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Copy Team Invitation Link</h4>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal">
                                        <div class="form-group">
                                            <label for="focusedinput" class="col-sm-2 control-label"></label>
                                            <div class="col-sm-12">
                                                <input type="text" onClick="this.select();" class="form-control1" id="team_link" value=" <?php echo get_team_invitation_link($team_id,$team_name);?> "><br>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
            }
            else
            {
                echo '<div class="alert alert-danger">';
                echo '<strong>Oops!</strong> An Error Occurred! Please Try Again...</div>';
            }

        }
        else{
            echo '<div class="alert alert-danger">';
            echo '<strong>Oops!</strong> Looks Like You Have Not Entered Any Team Name!</div>';
        }
    }


    ?>

<!--    <div style="text-align: center; font-weight: 500; font-size: x-large; color: #0b2c89; background: #06D995 ">Create Team</div>-->
    <div class="tab-content">
        <div class="tab-pane active">
            <?php
            if(!isset($team_name)) {
            ?>
            <div class="alert alert-success" role="alert"><b>Well Done!</b> You have Successfully Created Your Account. Now Let's Get Started
             </div> </br>


        <form class="form-horizontal" method="post" action="">
            <div class="form-group">
                <label for="focusedinput" class="col-sm-2 control-label">Create Your First Team</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control1" name="team_name" id="team_name"
                           placeholder="Enter Team Name">
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

        <?php
        }else{
                echo "<table><tr><td> <a class=\"btn-success1 btn\" href='http://"?><?php echo get_website_host()?><?php get_website_relative_path()?><?php echo "/create-team' >Create Another Team </a></td><td>&nbsp;&nbsp;</td><td><a href='http://"?><?php echo get_website_host()?><?php get_website_relative_path()?><?php echo "/dashboard' class=\"btn-success1 btn\"> Go to Dashboard</a></td></tr></table><br>";
        }
        ?>
        </div>


    </div>
</div>