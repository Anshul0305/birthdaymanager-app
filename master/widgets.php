<?php include_once ($_SERVER["DOCUMENT_ROOT"]."/birthdaymanager/app/helper.php"); ?>
<div class="col_3">
    <?php
        $api_host = get_api_host();
        $logged_in_member_id = get_logged_in_member_id();
        $endpoint = $api_host."/members/".$logged_in_member_id;
        $json = json_decode(file_get_contents($endpoint));
    ?>
        	<div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                    <i class="pull-left fa fa-thumbs-up icon-rounded"></i>
                    <div class="stats">
                      <h5><strong><?php echo count($json[0]->teams)?></strong></h5>
                      <span>Teams</span>
                    </div>
                </div>
        	</div>
        	<div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                    <i class="pull-left fa fa-users user1 icon-rounded"></i>
                    <div class="stats">
                      <h5><strong>120</strong></h5>
                      <span>Members</span>
                    </div>
                </div>
        	</div>
        	<div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                    <i class="pull-left fa fa-gift user3 icon-rounded"></i>
                    <div class="stats">
                      <h5><strong>8</strong></h5>
                      <span>Celebrations</span>
                    </div>
                </div>
        	</div>
        	<div class="col-md-3 widget">
        		<div class="r3_counter_box">
                    <i class="pull-left fa fa-gbp dollar1 icon-rounded"></i>
                    <div class="stats">
                        <?php
                        $fund = 0;
                        for($i=0;$i<count($json[0]->teams);$i++){
                          $fund += $json[0]->teams[$i]->fund_balance;
                        }
                        echo "<h5><strong>£".$fund."</strong></h5>";
                        ?>
                      <span>Total Fund</span>
                    </div>
                </div>
        	 </div>
        	<div class="clearfix"> </div>
      </div>