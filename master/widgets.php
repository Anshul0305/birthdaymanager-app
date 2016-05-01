<?php include_once ($_SERVER["DOCUMENT_ROOT"].json_decode(file_get_contents('./././env.json'))->website_relative_path."/helper.php"); ?>
<div class="col_3">
    <?php
        $api_host = get_api_host();
        $logged_in_member_id = get_logged_in_member_id();
        $endpoint = $api_host."/members/".$logged_in_member_id;
        $json = json_decode(file_get_contents($endpoint));

        $celebrations_endpoint = $api_host."/members/".$logged_in_member_id."/celebrations";
        $celebrations_json = json_decode(file_get_contents($celebrations_endpoint));
        $celebration_count = count($celebrations_json);

        $admin_count = 0;
        $member_count = 0;
        foreach($json[0]->teams as $team){
            if($team->is_admin == "true"){
                $admin_count++;
            }else{
                $member_count++;
            }

        }
    ?>
        	<div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                    <a href="<?php echo get_website_relative_path()?>/view-teams#admin-section"> <i class="pull-left fa fa-thumbs-up icon-rounded"></i></a>
                    <div class="stats">
                      <h5><strong><?php echo $admin_count?></strong></h5>
                      <span>Team Admin</span>
                    </div>
                </div>
        	</div>
        	<div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                   <a href="<?php echo get_website_relative_path()?>/view-teams#member-section"> <i class="pull-left fa fa-users user1 icon-rounded"></i></a>
                    <div class="stats">
                      <h5><strong><?php echo $member_count?></strong></h5>
                      <span>Team Member</span>
                    </div>
                </div>
        	</div>
        	<div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                    <a href="<?php echo get_website_relative_path()?>/view-celebration"> <i class="pull-left fa fa-gift user3 icon-rounded"></i></a>
                    <div class="stats">
                      <h5><strong><?php echo $celebration_count?></strong></h5>
                      <span>Celebrations</span>
                    </div>
                </div>
        	</div>
        	<div class="col-md-3 widget">
        		<div class="r3_counter_box">
                    <a href="http://<?php echo get_website_host()?>/<?php echo get_website_relative_path()?>/view-teams"><i class="pull-left fa fa-gbp dollar1 icon-rounded"></i></a>
                    <div class="stats">
                        <?php
                        $fund = 0;
                        for($i=0;$i<count($json[0]->teams);$i++){
                          $fund += $json[0]->teams[$i]->member_fund_balance;
                        }
                        echo "<h5><strong>£".$fund."</strong></h5>";
                        ?>
                      <span>Total Fund</span>
                    </div>
                </div>
        	 </div>
        	<div class="clearfix"> </div>
      </div>