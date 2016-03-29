<?php include_once("./././helper.php") ?>
<div class="content_bottom">
     <div class="col-md-8 span_3">
          <div class="bs-example1" data-example-id="contextual-table">
            <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Team Name</th>
                  <th>Admin Name</th>
                  <th>My Fund Balance</th>
                </tr>
              </thead>
              <tbody>
              <?php
              session_start();
              is_member_logged_in();
              $api_host = get_api_host();
              $logged_in_member_id = get_logged_in_member_id();
              $endpoint = $api_host."/members/".$logged_in_member_id;
              $json = json_decode(file_get_contents($endpoint));

              if(count($json[0]->teams)>0) {
                  for ($i = 0; $i < count($json[0]->teams); $i++) {
                      echo "<tr class='info'>";
                      echo "<th scope='row'>" . ($i + 1) . "</th>";
                      echo "<td>" . $json[0]->teams[$i]->name . "</td>";
                      echo "<td>" . $json[0]->teams[$i]->admin_name . "</td>";
                      echo "<td>£" . $json[0]->teams[$i]->member_fund_balance . "</td>";
                      echo "</tr>";
                  }
              }
              else{
                  echo "<tr class='warning'>";
                  echo "<td colspan='4'>You are not part of any Team. Please <a href='http://"?><?php echo get_website_host()?><?php get_website_relative_path()?><?php echo "/create-team'>Create</a> or <a href='http://"?><?php echo get_website_host()?><?php get_website_relative_path()?><?php echo "/search-teams'> Join</a> a Team!</td>";
                  echo "</tr>";
              }


              $upcoming_birthday_endpoint = $api_host."/members/upcoming-birthdays";
              $json_birthday = json_decode(file_get_contents($upcoming_birthday_endpoint));

              ?>

              </tbody>
            </table>
           </div>
       </div>
       <div class="col-md-4 span_4">
         <div class="col_2">
             <div style="text-align:center;font-weight: 500;margin-bottom: 10px">Upcoming Birthdays</div>
          <div class="box_1">
              <?php
                $head_color = array("red1","tiles_blue1", "fb1", "tw1");
                $body_color = array("red","blue1", "fb2","tw2");

                foreach($json_birthday as $birthday){
                    $index = rand(0,3);
                    echo '<div class="col-md-6 col_1_of_2 span_1_of_2">';
                    echo '<a class="tiles_info">';
                    echo '<div class="tiles-head '.$head_color[$index].'" >';
                    echo '<div class="text-center">'.$birthday->first_name.'</div>';
                    echo '</div>';
                    echo '<div class="tiles-body '.$body_color[$index].'">'.date("M",strtotime($birthday->dob)).' '.date("d",strtotime($birthday->dob)).'</div>';
                    echo '</a>';
                    echo '</div>';
                }
              ?>
           <div class="clearfix"> </div>
           </div>
          </div>
          <div class="cloud">
            <div class="grid-date">
                <div class="date">
                    <p class="date-in">New York</p>
                    <span class="date-on">°F °C </span>
                    <div class="clearfix"> </div>                           
                </div>
                <h4>30°<i class="fa fa-cloud-upload"> </i></h4>
            </div>
            <p class="monday">Monday 10 July</p>
          </div>
        </div>
        <div class="clearfix"> </div>
        </div>