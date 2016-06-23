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
                    <a href="http://<?php echo get_website_host()?>/<?php echo get_website_relative_path()?>/view-teams"><i class="pull-left fa <?php echo get_currency_font(); ?> dollar1 icon-rounded"></i></a>
                    <div class="stats">
                        <?php
                        $fund = 0;
                        for($i=0;$i<count($json[0]->teams);$i++){
                          $fund += $json[0]->teams[$i]->member_fund_balance;
                        }
                        echo "<h5><strong>".get_currency_symbol().$fund."</strong></h5>";
                        ?>
                      <span>Total Fund</span>
                    </div>
                </div>
        	 </div>
        	<div class="clearfix"> </div>
      </div>
<script type='text/javascript'>

    var _ues = {
        host:'onlinebirthdaymanager.userecho.com',
        forum:'1',
        lang:'en',
        tab_corner_radius:5,
        tab_font_size:20,
        tab_image_hash:'RmVlZGJhY2s%3D',
        tab_chat_hash:'Y2hhdA%3D%3D',
        tab_alignment:'bottom',
        tab_text_color:'#ffffff',
        tab_text_shadow_color:'#00000055',
        tab_bg_color:'#57a957',
        tab_hover_color:'#f45c5c'
    };

    (function() {
        var _ue = document.createElement('script'); _ue.type = 'text/javascript'; _ue.async = true;
        _ue.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.userecho.com/js/widget-1.4.gz.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(_ue, s);
    })();

</script>   