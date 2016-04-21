<?php include_once "./././helper.php"?>
<?php
is_member_logged_in();
?>
<div class="content_bottom">
     <div class="col-md-12 span_3">
          <div class="bs-example1" data-example-id="contextual-table">
              <div style="text-align: center; font-weight: 500; font-size: x-large; color: #0b2c89; background: #06D995 ">View Celebrations</div>
              </br>

              <?php
              is_member_logged_in();
              $api_host = get_api_host();
              $logged_in_member_id = get_logged_in_member_id();
              $endpoint = $api_host."/members/".$logged_in_member_id."/celebrations";
              $json = json_decode(file_get_contents($endpoint));
              if(count($json)>0){
                  echo "<table class=\"table\">";
                  echo "<thead>";
                  echo "<tr>";
                  echo "<th>Team Name</th>";
                  echo "<th>Birthday Of</th>";
                  echo "<th>My Contribution</th>";
                  echo "<th>Action</th>";
                  echo "</tr>";
                  echo "</thead>";
                  echo "<tbody>";

                  for ($i = 0; $i < count($json); $i++) {
                      echo "<tr class='info'>";
                      echo "<td>" . $json[$i]->team_name . "</td>";
                      echo "<td>" . $json[$i]->birthday_of_member_name . "</td>";
                      echo "<td>" . $json[$i]->perhead_contribution . "</td>";
                      echo "<td> <button onclick='redirect(".$json[$i]->celebration_id.")' class='btn-info'>View Details</button></td></td>";
                      echo "</tr>";
                  }

                  echo "</tbody>";
                  echo "</table>";
              }
              else
              {
                  echo "You have not celebrated any birthday </br></br>";
              }
              ?>

              <script>
                  function redirect(celebration_id){
                      location.href="http://<?php echo get_website_host()?><?php echo get_website_relative_path()?>/view-celebration-details?celebration-id="+celebration_id;
                  }
              </script>

           </div>
       </div>

        <div class="clearfix"> </div>
        </div>