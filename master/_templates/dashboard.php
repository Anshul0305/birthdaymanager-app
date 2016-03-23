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
                  <th>Fund Balance</th>
                </tr>
              </thead>
              <tbody>
              <?php
              //session_start();
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
                      echo "<td>£" . $json[0]->teams[$i]->fund_balance . "</td>";
                      echo "</tr>";
                  }
              }
              else{
                  echo "<tr class='warning'>";
                  echo "<td colspan='4'>You are not part of any Team. Please <a href='create-team'>Create</a> or <a href='#'>Join</a> a Team!</td>";
                  echo "</tr>";
              }
              ?>

              </tbody>
            </table>
           </div>
       </div>
       <div class="col-md-4 span_4">
         <div class="col_2">
             <div style="text-align:center;font-weight: 500;margin-bottom: 10px">Upcoming Birthdays</div>
          <div class="box_1">

           <div class="col-md-6 col_1_of_2 span_1_of_2">

             <a class="tiles_info">
                <div class="tiles-head red1">
                    <div class="text-center">Ankit</div>
                </div>
                <div class="tiles-body red">May 01</div>
             </a>
           </div>
           <div class="col-md-6 col_1_of_2 span_1_of_2">
              <a class="tiles_info tiles_blue">
                <div class="tiles-head tiles_blue1">
                    <div class="text-center">Anshul</div>
                </div>
                <div class="tiles-body blue1">May 03</div>
              </a>
           </div>
           <div class="clearfix"> </div>
         </div>
         <div class="box_1">
           <div class="col-md-6 col_1_of_2 span_1_of_2">
             <a class="tiles_info">
                <div class="tiles-head fb1">
                    <div class="text-center">Rahul</div>
                </div>
                <div class="tiles-body fb2">June 31</div>
             </a>
           </div>
           <div class="col-md-6 col_1_of_2 span_1_of_2">
              <a class="tiles_info tiles_blue">
                <div class="tiles-head tw1">
                    <div class="text-center">Amitabh</div>
                </div>
                <div class="tiles-body tw2">Oct 13</div>
              </a>
           </div>
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