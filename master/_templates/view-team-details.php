<?php include_once "./././helper.php"?>
<?php
    is_member_logged_in();

    $api_host = get_api_host();
    $logged_in_member_id = get_logged_in_member_id();
    $team_id = $_GET["team-id"];

    $is_admin = is_member_admin($logged_in_member_id, $team_id);
    $is_valid_team_id = is_member_of_given_team($logged_in_member_id, $team_id);

    $endpoint = $api_host."/members/".$logged_in_member_id;
    $json = json_decode(file_get_contents($endpoint));
    $team_endpoint = $api_host."/teams/".$team_id;
    $json_team = json_decode(file_get_contents($team_endpoint));

    $fund_amount = $_POST["fund_amount"];
    $member_id = $_POST["member_id"];

    if(!$is_valid_team_id){
        echo "<div class=\"alert alert-danger\">
                         <strong>Sorry!</strong> You Are Not Allowed To View This Team.
                        </div>";
        die();
    }

    if(isset($_POST["fund_amount"])){
        if($_POST["fund_amount"]!="") {
            $ch = curl_init();
            $fund_endpoint = $api_host . "/funds";
            $fund_amount = $_POST["fund_amount"];
            $fund_post_data = "team_id=" . $team_id . "&member_id=" . $member_id . "&fund=" . $fund_amount;

            curl_setopt($ch, CURLOPT_URL, $fund_endpoint);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fund_post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            curl_close($ch);
            if ($server_output == true) {
                echo '<div class="alert alert-success">';
                echo '<strong>Success!</strong> Fund Added Successfully!</div>';
            } else {
                echo '<div class="alert alert-danger">';
                echo '<strong>Sorry!</strong> That Entry Was Invalid! Please Try Again...</div>';
            }
        }else{
            echo '<div class="alert alert-danger">';
            echo '<strong>Oops!</strong> Looks Like You Have Not Entered Any Fund...</div>';
        }

    }else{

    }
?>

<div class="content_bottom">
     <div class="col-md-12 span_3">
          <div class="bs-example1" data-example-id="contextual-table">
              <div><button class="btn-info" onclick="location.href='<?php echo "http://". get_website_host()?><?php echo get_website_relative_path(). "/view-teams"?>'">Back to All Teams</button></div></br>
              <div style="text-align: center; font-weight: 500; font-size: x-large; color: #0b2c89; background: #06D995 "><?php echo $json_team[0]->name?></div>
             </br>


              <table class="table" style="border: 1.5px solid black">
              <tbody>
              <tr class="active">
                  <td width="20%"><strong>Team Fund:</strong></td>
                  <td>£<?php echo $json_team[0]->fund_balance?></td>
              </tr>
              <tr class="active">
                  <td><strong>Admin Name:</strong></td>
                  <td><?php echo $json_team[0]->admin_name?></td>
              </tr>
              </tbody>
              </table>

              <?php

              if (count($json_team[0]->member_id) > 0) {
                  echo "<table class=\"table\">";
                  echo "<thead>";
                  echo "<tr>";
                  echo "<th>Member Name</th>";
                  echo "<th>Date of Birth</th>";
                  echo "<th>Member Fund Balance</th>";
                  if ($is_admin) echo "<th>Action</th>";
                  echo "</tr>";
                  echo "</thead>";
                  echo "<tbody>";

                  for ($i = 0; $i < count($json_team[0]->member_id); $i++) {
                      $member_endpoint = $api_host . "/members/" . $json_team[0]->member_id[$i];
                      $member_json = json_decode(file_get_contents($member_endpoint));
                      $teams_list = $member_json[0]->teams;

                      foreach ($teams_list as $team) {
                          if ($team->id == $team_id) {
                              $member_fund_balance = $team->member_fund_balance;
                          }
                      }

                      echo "<tr class='info'>";
                      echo "<td>" . $member_json[0]->first_name . " " . $member_json[0]->last_name . "</td>";
                      echo "<td>" . date("d-m-Y", strtotime($member_json[0]->dob)) . "</td>";
                      echo "<td>£" . $member_fund_balance . "</td>";
                      if ($is_admin)
                          echo "<td> <button class='btn-info'>Edit</button>&nbsp;<button class='btn-danger'>Delete</button>&nbsp;&nbsp;
                                <button class='btn-group' data-toggle=\"modal\" data-target=\"#myModal\" data-id='".$member_json[0]->id."' >Add Fund</button></td>";
                      echo "</tr>";
                  }

                  echo "</tbody>";
                  echo "</table>";

                  if ($is_admin) echo "<div align=\"middle\"><button class='btn-group'>Add Member</button></div>";
              } else {
                  echo "You are Not Admin of Any Team </br></br>";
              }


              ?>


           </div>
       </div>

        <div class="clearfix"> </div>
        </div>

<script>
$(document).ready(function(){
    $('button[data-toggle=modal]').click(function(){
        var member_id = $(this).data('id');
        $(".modal-body #member_id").val( member_id );
    });
});
</script>

<div class="container">
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Fund</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" action="">
                        <div class="form-group">
                            <label for="focusedinput" class="col-sm-2 control-label"></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control1" name="fund_amount" id="fund_amount" placeholder="Enter Fund Amount">
                                <input type="hidden" name="member_id" id="member_id" value="">
                            </div>
                            <div class="col-sm-2">
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <button type="submit" class="btn-success1 btn">Add Fund</button>
                                </div>
                            </div>
                        </div>
                        </br>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>