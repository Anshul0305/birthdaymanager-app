<!-- /.navbar-header -->
<?php include_once ($_SERVER["DOCUMENT_ROOT"].json_decode(file_get_contents('./././env.json'))->website_relative_path."/helper.php"); ?>
<ul class="nav navbar-nav navbar-right">
<?php
$api_host = get_api_host();
$logged_in_member_id = get_logged_in_member_id();
$endpoint = $api_host."/members/".$logged_in_member_id;
$json = json_decode(file_get_contents($endpoint));

?>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle avatar" data-toggle="dropdown"><div class="heading-username">Welcome, <?php print_r( $json[0]->first_name) ?></div></a>
        <ul class="dropdown-menu">
            <li class="dropdown-menu-header text-center">
                <strong>Account</strong>
            </li>
            <li class="m_2"><a href="#"><i class="fa fa-bell-o"></i> Updates <span class="label label-info">0</span></a></li>
            <li class="m_2"><a href="#"><i class="fa fa-envelope-o"></i> Messages <span class="label label-success">0</span></a></li>
<!--            <li class="m_2"><a href="#"><i class="fa fa-tasks"></i> Tasks <span class="label label-danger">42</span></a></li>-->
<!--            <li><a href="#"><i class="fa fa-comments"></i> Comments <span class="label label-warning">42</span></a></li>-->
            <li class="dropdown-menu-header text-center">
                <strong>Settings</strong>
            </li>
            <li class="m_2"><a href="profile-settings"><i class="fa fa-user"></i> Profile</a></li>
            <li class="m_2"><a href="#"><i class="fa fa-wrench"></i> Settings</a></li>
<!--            <li class="m_2"><a href="#"><i class="fa fa-usd"></i> Payments <span class="label label-default">42</span></a></li>-->
<!--            <li class="m_2"><a href="#"><i class="fa fa-file"></i> Projects <span class="label label-primary">42</span></a></li>-->
<!--            <li class="divider"></li>-->
<!--            <li class="m_2"><a href="#"><i class="fa fa-shield"></i> Lock Profile</a></li>-->
            <li class="m_2"><a href="#" onclick="logout();"><i class="fa fa-lock"></i> Logout</a></li>

            <script type="text/javascript">
                function logout() {
                    $.get(<?php echo "'http://".get_website_host().json_decode(file_get_contents('./././env.json'))->website_relative_path."/helper.php?action=logout'"?>);
                    location.href = <?php echo "'http://".get_website_host().json_decode(file_get_contents('./././env.json'))->website_relative_path."/'"?>;
                    return false;
                }
            </script>
        </ul>
    </li>
</ul>