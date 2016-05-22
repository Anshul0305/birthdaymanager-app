<?php include_once ($_SERVER["DOCUMENT_ROOT"].json_decode(file_get_contents('./././env.json'))->website_relative_path."/helper.php"); ?>
<nav class="top1 navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="http://<?php echo get_website_host()?><?php echo get_website_relative_path()?>/dashboard">Online Birthday Manager - Beta</a>
    </div>

<!--    <form class="navbar-form navbar-right">-->
<!--        <input type="text" class="form-control" value="Search..." onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search...';}">-->
<!--    </form>-->

