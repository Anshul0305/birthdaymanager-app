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
          include("master/widgets.php");
          switch($page){
              case "dashboard":{
                  include("master/_templates/dashboard.php");
              }
              break;
              case "view-teams":{
                  include("master/_templates/view-team.php");
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
