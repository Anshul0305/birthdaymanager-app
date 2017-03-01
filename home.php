<?php session_start(); ?>
<?php include("master/header.php"); ?>
<!DOCTYPE HTML>
<html>
<?php $page = $_GET["page"];?>
<body>
<div id="wrapper">

        <?php
        include("master/top_row.php");
        include("master/notifications.php");
        include("master/navbar.php");?>

        <div id="page-wrapper">
        <div class="graphs">

          <?php

          switch($page){
              case "dashboard":{
                  include("master/widgets.php");
                  include("master/_templates/dashboard.php");
              }
              break;
              case "view-teams":{
                  include("master/_templates/view-team.php");
              }
              break;
              case "search-teams":{
                  include("master/_templates/search-team.php");
              }
              break;
              case "search-member":{
                  include("master/_templates/search-member.php");
              }
              break;
              case "view-team-details":{
                  include("master/_templates/view-team-details.php");
              }
              break;
              case "create-team":{
                  include("master/_templates/create-team.php");
              }
              break;
              case "celebrate":{
                  include("master/_templates/celebrate-birthday.php");
              }
              break;
              case "view-celebration":{
                  include("master/_templates/view-celebration.php");
              }
              break;
              case "view-celebration-details":{
                  include("master/_templates/view-celebration-details.php");
              }
              break;
              case "transactions":{
                  include("master/_templates/transactions.php");
              }
              break;
              case "profile-settings":{
                  include("master/_templates/profile.php");
              }
              break;
              case "get-started":{
                  include("master/_templates/get-started.php");
              }
              break;
              case "invite":{
                  include("master/_templates/send-invitation.php");
              }
              break;
              case "greeting":{
                  include("master/_templates/send-greeting.php");
              }
              break;

              default:{
                  include("master/_templates/blank.php");
              }
              break;
          }

          include("master/footer.php");
          ?>
		</div>
       </div>
   </div>
   
</body>
</html>
