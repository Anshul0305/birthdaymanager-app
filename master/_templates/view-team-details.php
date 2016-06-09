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
            if(!is_numeric($_POST["fund_amount"]))
            {
                echo '<div class="alert alert-danger">';
                echo '<strong>Sorry!</strong> That Entry Was Invalid! Please Try Again...</div>';
            }
            else {
                $ch = curl_init();
                $fund_endpoint = $api_host . "/funds";
                $fund_amount = $_POST["fund_amount"];
                $fund_post_data = "team_id=" . $team_id . "&member_id=" . $member_id . "&fund=" . $fund_amount;

                curl_setopt($ch, CURLOPT_URL, $fund_endpoint);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fund_post_data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $server_output = curl_exec($ch);

                $info = curl_getinfo($ch);
                $http_code = $info["http_code"];

                if ($http_code = 200) {
                    echo '<div class="alert alert-success">';
                    echo '<strong>Success!</strong> Fund Added Successfully!</div>';
                } else {
                    echo '<div class="alert alert-danger">';
                    echo '<strong>Sorry!</strong> That Entry Was Invalid! Please Try Again...</div>';
                }
                curl_close($ch);
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

              if (count($json_team[0]->members) > 0) {
                  echo "<table id='myTable' class=\"table\">";
                  echo "<thead>";
                  echo "<tr>";
                  echo "<th>Member Name</th>";
                  echo "<th>Date of Birth</th>";
                  echo "<th style='text-align: center'>Member Fund Balance</th>";
                  if ($is_admin) echo "<th style='text-align: center'>Action</th>";
                  echo "</tr>";
                  echo "</thead>";
                  echo "<tbody>";

                  for ($i = 0; $i < count($json_team[0]->members); $i++) {
                      $member_endpoint = $api_host . "/members/" . $json_team[0]->members[$i]->id;
                      $member_json = json_decode(file_get_contents($member_endpoint));
                      $teams_list = $member_json[0]->teams;
                      foreach ($teams_list as $team) {
                          if ($team->id == $team_id) {
                              $member_fund_balance = $team->member_fund_balance;
                          }
                      }
                      echo "<tr class='info'>";
                      echo "<td>" . $member_json[0]->first_name . " " . $member_json[0]->last_name . "</td>";
                      echo "<td>" . format_date($member_json[0]->dob,"DM") . "</td>";
                      echo "<td style='text-align: center'>£ " . $member_fund_balance . "</td>";
                      if ($is_admin)
                          if($member_json[0]->id == $logged_in_member_id){
                              echo "<td style='text-align: center'> 
                                    <button style='width: 65%;' class='btn-primary' data-toggle=\"modal\" data-target=\"#myModal\" data-id='" . $member_json[0]->id . "' >Add Fund</button>
                                    &nbsp;";
                          }else {
                              echo "<td style='text-align: center'> 
                                    <button class='btn-primary' data-toggle=\"modal\" data-target=\"#myModal\" data-id='" . $member_json[0]->id . "' >Add Fund</button>
                                    &nbsp;
                                    <button class='btn-danger' onclick='leave_team(" . $json_team[0]->id . "," . $member_json[0]->id . ")'>Remove Member</button>
                                </td>";
                          }
                      echo "</tr>";
                  }
                  echo "</tbody>";
                  echo "</table>";

              } else {
                  echo "You are Not Admin of Any Team </br></br>";
              }
              ?>

              <?php
              if($is_admin){ ?>
                  <div align="middle"><button class='btn-info' onclick="location.href='<?php echo "http://". get_website_host()?><?php echo get_website_relative_path(). "/search-member?team-id=".$team_id?>'" >Add Member</button>
                  <button class='btn-info' onclick="location.href='<?php echo "http://". get_website_host()?><?php echo get_website_relative_path(). "/celebrate?team-id=".$team_id?>'" >Celebrate Birthday</button></div>
              <?php
              }
              ?>


           </div>
       </div>

        <div class="clearfix"> </div>
        </div>

<script>
    $(document).ready(function(){
        $('#myTable').DataTable({

        });
    });

$(document).ready(function(){
    $('button[data-toggle=modal]').click(function(){
        var member_id = $(this).data('id');
        $(".modal-body #member_id").val( member_id );
    });
});

function leave_team(team_id,member_id){
    if(confirm("Are You Sure You Want To Remove This Member From The Team! \n\nIf This Member has any Remaining Fund, Please Make Sure to Return it to The Team Member!")){
        $.post('<?php echo  get_api_host()."/leave-team"?>',
            {
                team_id: team_id,
                member_id: member_id
            });
        alert("Member Removed From Team Successfully!");
        location.href="http://<?php echo get_website_host()?><?php echo get_website_relative_path()?>/view-team-details?team-id="+team_id;
    }else{

    }
}
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