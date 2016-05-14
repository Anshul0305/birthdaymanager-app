<?php include_once "./././helper.php"?>
<?php
is_member_logged_in();
?>
<div class="content_bottom">
     <div class="col-md-12 span_3">
          <div class="bs-example1" data-example-id="contextual-table">
              <div style="text-align: center; font-weight: 500; font-size: x-large; color: #0b2c89; background: #06D995 ">My Transactions</div>
              </br>

<!--              <form class="form-horizontal" method="post" action="">-->
<!--                  <div class="form-group">-->
<!--                      <label for="selector1" class="col-sm-2 control-label">Select Team</label>-->
<!--                      <div class="col-sm-8"><select name="select-team" id="select-team" class="form-control1">-->
<!--                              <option>--- Select ---</option>-->
<!--                                          <option value="1">Mindtree Team</option>-->
<!--                                          <option value="2">BBC Team</option>-->
<!--                                          <option value="3">40 Lime Court Team</option>-->
<!--                                          <option value="4">London Team</option>-->
<!--                          </select></div>-->
<!--                  </div>-->
<!--                  </form>-->

              <?php
              is_member_logged_in();
              $api_host = get_api_host();
              $logged_in_member_id = get_logged_in_member_id();
              $endpoint = $api_host."/members/".$logged_in_member_id."/transactions";
              $json = json_decode(file_get_contents($endpoint));

              if(count($json)>0){
                  echo "<table class=\"table\">";
                  echo "<thead>";
                  echo "<tr>";
                  echo "<th>Transaction Date</th>";
                  echo "<th>Transaction Type</th>";
                  echo "<th>Amount</th>";
                  echo "<th>Team Name</th>";
                  echo "<th>Comments</th>";
                  echo "</tr>";
                  echo "</thead>";
                  echo "<tbody>";

                  for ($i = 0; $i < count($json); $i++) {
                      echo "<tr class='info'>";
                      echo "<td>" . format_date( $json[$i]->transaction_date,"DMY" ) . "</td>";
                      echo "<td>" . ucfirst($json[$i]->transaction_type)  . "</td>";
                      if ($json[$i]->transaction_type == "debit")
                      echo "<td>£ -" . $json[$i]->transaction_amount . "</td>";
                      else
                      echo "<td>£ " . $json[$i]->transaction_amount . "</td>";
                      echo "<td>" . $json[$i]->team_name  . "</td>";
                      if ($json[$i]->birthday_celebration_of != null )
                      echo "<td> Birthday Of " . $json[$i]->birthday_celebration_of  . "</td>";
                      else
                      echo "<td>New Topup</td>";
                      //  echo "<td> <button onclick='redirect(".$json[0]->teams[$i]->id .")' class='btn-info'>View Details</button></td></td>";
                      echo "</tr>";
                  }

                  echo "</tbody>";
                  echo "</table><br>";
                  echo "<input type=button name=print value=\"Print Page\"onClick=\"window.print()\">";
              }
              else
              {
                  echo "You dont have any Transaction yet </br></br>";
              }
              ?>

              <script>
                  function redirect(team_id){
                      location.href="http://<?php echo get_website_host()?><?php echo get_website_relative_path()?>/view-team-details?team-id="+team_id;
                  }
              </script>

           </div>
       </div>

        <div class="clearfix"> </div>
        </div>