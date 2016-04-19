<?php include_once "./././helper.php"?>
<?php
is_member_logged_in();
?>
<div class="content_bottom">
     <div class="col-md-12 span_3">
          <div class="bs-example1" data-example-id="contextual-table">
              <div style="text-align: center; font-weight: 500; font-size: x-large; color: #0b2c89; background: #06D995 ">My Teams</div>
              </br>
              <a name="admin-section"></a>
              <div style="text-align: left; font-weight: 500">I am Admin</div>
              <hr noshade style="height: 2px">
              <?php
              is_member_logged_in();
              $api_host = get_api_host();
              $logged_in_member_id = get_logged_in_member_id();
              $endpoint = $api_host."/members/".$logged_in_member_id;
              $json = json_decode(file_get_contents($endpoint));

              if(count($json[0]->teams)>0){
                  echo "<table class=\"table\">";
                  echo "<thead>";
                  echo "<tr>";
                  echo "<th>Team Name</th>";
                  echo "<th>Total Members</th>";
                  echo "<th>My Fund Balance</th>";
                  echo "<th>Action</th>";
                  echo "</tr>";
                  echo "</thead>";
                  echo "<tbody>";

                  $admin_count = 0;
                  for ($i = 0; $i < count($json[0]->teams); $i++) {
                      if ($json[0]->teams[$i]->is_admin == "true") {
                          $admin_count++;
                          echo "<tr class='info'>";
                          echo "<td>" . $json[0]->teams[$i]->name . "</td>";
                          echo "<td>" . count($json[0]->teams[$i]->members) . "</td>";
                          echo "<td>£" . $json[0]->teams[$i]->member_fund_balance . "</td>";
                          echo "<td> <button onclick='redirect(".$json[0]->teams[$i]->id .")' class='btn-info'>View Details</button></td></td>";
                          echo "</tr>";
                      }
                  }
                  if($admin_count==0){
                      echo "<td>You are Not Admin of Any Team </td> </br></br>";
                  }

                  echo "</tbody>";
                  echo "</table>";
              }
              else
              {
                  echo "You are Not Admin of Any Team </br></br>";
              }
              ?>

              <script>
                  function redirect(team_id){
                      location.href="http://<?php echo get_website_host()?><?php echo get_website_relative_path()?>/view-team-details?team-id="+team_id;
                  }
              </script>
              <a name="member-section"></a>
              <div style="text-align: left; font-weight: 500">I am a Member</div>
              <hr noshade style="height: 2px">

              <?php

              if(count($json[0]->teams)>0){
                  echo "<table class=\"table\">";
                  echo "<thead>";
                  echo "<tr>";
                  echo "<th>Team Name</th>";
                  echo "<th>Admin Name</th>";
                  echo "<th>Total Members</th>";
                  echo "<th>My Fund Balance</th>";
                  echo "<th>Action</th>";
                  echo "</tr>";
                  echo "</thead>";
                  echo "<tbody>";
                  $member_count = 0;

                  for($i=0;$i<count($json[0]->teams);$i++){
                      if($json[0]->teams[$i]->is_admin == "false")
                      {
                          $member_count++;
                          echo "<tr class='info'>";
                          echo "<td>".$json[0]->teams[$i]->name."</td>";
                          echo "<td>".$json[0]->teams[$i]->admin_name."</td>";
                          echo "<td>".count($json[0]->teams[$i]->members)."</td>";
                          echo "<td>£".$json[0]->teams[$i]->member_fund_balance."</td>";
                          echo "<td> <button onclick='redirect(".$json[0]->teams[$i]->id .")' class='btn-info'>View Details</button></td></td>";
                          echo "</tr>";
                      }
                  }
                  if($member_count==0){
                      echo "You are Not Member of Any Team </br></br>";
                  }
              }
              else{
                  echo "You are Not Member of Any Team </br></br>";
              }

              echo "</tbody>";
              echo "</table>";
              ?>

              <div style="text-align: left; font-weight: 500">Request Pending</div>
              <hr noshade style="height: 2px">
               <p>No Request Pending </br></br></p>

           </div>
       </div>

        <div class="clearfix"> </div>
        </div>