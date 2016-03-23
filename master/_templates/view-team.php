<?php include_once "./././helper.php"?>
<div class="content_bottom">
     <div class="col-md-12 span_3">
          <div class="bs-example1" data-example-id="contextual-table">
              <div style="text-align: center; font-weight: 500; font-size: x-large; color: #0b2c89; background: #06D995 ">My Teams</div>
             </br>
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
                  echo "</tr>";
                  echo "</thead>";
                  echo "<tbody>";

                  for ($i = 0; $i < count($json[0]->teams); $i++) {
                      if ($json[0]->teams[$i]->is_admin == "true") {
                          echo "<tr class='info'>";
                          echo "<td>" . $json[0]->teams[$i]->name . "</td>";
                          echo "<td>" . count($json[0]->teams[$i]->members) . "</td>";
                          echo "<td>£" . $json[0]->teams[$i]->fund_balance . "</td>";
                          echo "</tr>";
                      }
                  }

                  echo "</tbody>";
                  echo "</table>";
              }
              else
              {
                  echo "You are Not Admin of Any Team </br></br>";
              }
              ?>

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
                  echo "</tr>";
                  echo "</thead>";
                  echo "<tbody>";

                  for($i=0;$i<count($json[0]->teams);$i++){

                      if($json[0]->teams[$i]->is_admin == "false")
                      {
                          echo "<tr class='info'>";
                          echo "<td>".$json[0]->teams[$i]->name."</td>";
                          echo "<td>".$json[0]->teams[$i]->admin_name."</td>";
                          echo "<td>".count($json[0]->teams[$i]->members)."</td>";
                          echo "<td>£".$json[0]->teams[$i]->fund_balance."</td>";
                          echo "</tr>";
                      }
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

           </div>
       </div>

        <div class="clearfix"> </div>
        </div>