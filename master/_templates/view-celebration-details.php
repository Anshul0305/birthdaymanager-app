<?php include_once "./././helper.php"?>
<?php
    is_member_logged_in();

    $api_host = get_api_host();
    $logged_in_member_id = get_logged_in_member_id();
    $celebration_id = $_GET["celebration-id"];

    $is_admin = is_member_admin($logged_in_member_id, $team_id);
    $is_valid_celebration_id = is_member_of_given_celebration($logged_in_member_id, $celebration_id);

//    $endpoint = $api_host."/members/".$logged_in_member_id;
//    $json = json_decode(file_get_contents($endpoint));
      $celebrations_endpoint = $api_host."/celebrations/".$celebration_id;
      $json_celebrations = json_decode(file_get_contents($celebrations_endpoint));

//    $fund_amount = $_POST["fund_amount"];
//    $member_id = $_POST["member_id"];

    if(!$is_valid_celebration_id){
        echo "<div class=\"alert alert-danger\">
                         <strong>Sorry!</strong> You Are Not Allowed To View This Celebration.
                        </div>";
        die();
    }
//
//    if(isset($_POST["fund_amount"])){
//        if($_POST["fund_amount"]!="") {
//            if(!is_numeric($_POST["fund_amount"]))
//            {
//                echo '<div class="alert alert-danger">';
//                echo '<strong>Sorry!</strong> That Entry Was Invalid! Please Try Again...</div>';
//            }
//            else {
//                $ch = curl_init();
//                $fund_endpoint = $api_host . "/funds";
//                $fund_amount = $_POST["fund_amount"];
//                $fund_post_data = "team_id=" . $team_id . "&member_id=" . $member_id . "&fund=" . $fund_amount;
//
//                curl_setopt($ch, CURLOPT_URL, $fund_endpoint);
//                curl_setopt($ch, CURLOPT_POST, 1);
//                curl_setopt($ch, CURLOPT_POSTFIELDS, $fund_post_data);
//                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//                $server_output = curl_exec($ch);
//
//                $info = curl_getinfo($ch);
//                $http_code = $info["http_code"];
//
//                if ($http_code = 200) {
//                    echo '<div class="alert alert-success">';
//                    echo '<strong>Success!</strong> Fund Added Successfully!</div>';
//                } else {
//                    echo '<div class="alert alert-danger">';
//                    echo '<strong>Sorry!</strong> That Entry Was Invalid! Please Try Again...</div>';
//                }
//                curl_close($ch);
//            }
//
//        }else{
//            echo '<div class="alert alert-danger">';
//            echo '<strong>Oops!</strong> Looks Like You Have Not Entered Any Fund...</div>';
//        }
//
//
//    }else{
//
//    }
?>

<div class="content_bottom">
     <div class="col-md-12 span_3">
          <div class="bs-example1" data-example-id="contextual-table">
              <div><button class="btn-info" onclick="location.href='<?php echo "http://". get_website_host()?><?php echo get_website_relative_path(). "/view-celebration"?>'">Back to All Celebrations</button></div></br>
              <div style="text-align: center; font-weight: 500; font-size: x-large; color: #0b2c89; background: #06D995 "><?php echo "Birthday Celebration of ". $json_celebrations[0]->birthday_of_member_name?></div>
             </br>


              <table class="table" style="border: 1.5px solid black">
              <tbody>
              <tr class="active">
                  <td width="20%"><strong>Birthday Celebration Of:</strong></td>
                  <td><?php echo $json_celebrations[0]->birthday_of_member_name?></td>
              </tr>
              <tr class="active">
                  <td width="20%"><strong>Team Name:</strong></td>
                  <td><?php echo $json_celebrations[0]->team_name?></td>
              </tr>
              <tr class="active">
                  <td><strong>Celebration Date:</strong></td>
                  <td><?php echo format_date($json_celebrations[0]->celebration_date)?></td>
              </tr>
              <tr class="active">
                  <td width="20%"><strong>Cake Amount:</strong></td>
                  <td><?php echo $json_celebrations[0]->cake_amount?></td>
              </tr>
              <tr class="active">
                  <td><strong>Other Expense:</strong></td>
                  <td><?php echo $json_celebrations[0]->other_expense?></td>
              </tr>
              <tr class="active">
                  <td><strong>Total Attendees:</strong></td>
                  <td><?php echo count($json_celebrations[0]->attendees)?></td>
              </tr>
              <tr class="active">
                  <td><strong>Perhead Contribution:</strong></td>
                  <td><?php echo $json_celebrations[0]->perhead_contribution?></td>
              </tr>
              </tbody>
              </table>

              <?php

              if (count($json_celebrations[0]->attendees) > 0) {
                  echo "<table class=\"table\">";
                  echo "<thead>";
                  echo "<tr>";
                  echo "<th>Attendee's Name</th>";
                  echo "<th>Date of Birth</th>";
                  echo "<th style='text-align: center'>Current Fund Balance in ".$json_celebrations[0]->team_name." </th>";
                  echo "</tr>";
                  echo "</thead>";
                  echo "<tbody>";

                  for ($i = 0; $i < count($json_celebrations[0]->attendees); $i++) {
                      $member_endpoint = $api_host . "/members/" . $json_celebrations[0]->attendees[$i]->id;
                      $member_json = json_decode(file_get_contents($member_endpoint));
                      $teams_list = $member_json[0]->teams;

                      $member_fund_balance = "Team Deleted!";
                      foreach ($teams_list as $team) {
                          if ($team->id == $json_celebrations[0]->team_id) {
                              $member_fund_balance = "£ ". $team->member_fund_balance;
                          }
                      }
                      echo "<tr class='info'>";
                      echo "<td>" . $member_json[0]->first_name . " " . $member_json[0]->last_name . "</td>";
                      echo "<td>" . date("d-m-Y", strtotime($member_json[0]->dob)) . "</td>";
                      echo "<td style='text-align: center'>" . $member_fund_balance . "</td>";
                      echo "</tr>";
                  }
                  echo "</tbody>";
                  echo "</table>";

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
                                <input type="number" step="0.01" min="-10000" max="10000" class="form-control1" name="fund_amount" id="fund_amount" placeholder="Enter Fund Amount">
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