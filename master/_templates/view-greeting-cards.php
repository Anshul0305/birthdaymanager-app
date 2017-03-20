<?php include_once "./././helper.php"?>
<?php
is_member_logged_in();
$api_host = get_api_host();
$logged_in_member_id = get_logged_in_member_id();
$endpoint = $api_host."/members/".$logged_in_member_id."/greetings";
$json = json_decode(file_get_contents($endpoint));
?>

<style>
    /* USER PROFILE PAGE */
    .card {
        margin-top: 20px;
        padding: 30px;
        background-color: rgba(214, 224, 226, 0.2);
        -webkit-border-top-left-radius:5px;
        -moz-border-top-left-radius:5px;
        border-top-left-radius:5px;
        -webkit-border-top-right-radius:5px;
        -moz-border-top-right-radius:5px;
        border-top-right-radius:5px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .card.hovercard {
        position: relative;
        padding-top: 0;
        overflow: hidden;
        text-align: center;
        background-color: #fff;
        background-color: rgba(255, 255, 255, 1);
    }
    .card.hovercard .card-background {
        height: 130px;
    }
    .card-background img {
        -webkit-filter: blur(25px);
        -moz-filter: blur(25px);
        -o-filter: blur(25px);
        -ms-filter: blur(25px);
        filter: blur(25px);
        margin-left: -100px;
        margin-top: -200px;
        min-width: 130%;
    }
    .card.hovercard .useravatar {
        position: absolute;
        top: 15px;
        left: 0;
        right: 0;
    }
    .card.hovercard .useravatar img {
        width: 100px;
        height: 100px;
        max-width: 100px;
        max-height: 100px;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        border-radius: 50%;
        border: 5px solid rgba(255, 255, 255, 0.5);
    }
    .card.hovercard .card-info {
        position: absolute;
        bottom: 14px;
        left: 0;
        right: 0;
    }
    .card.hovercard .card-info .card-title {
        padding:0 5px;
        font-size: 20px;
        line-height: 1;
        color: #262626;
        background-color: rgba(255, 255, 255, 0.1);
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
    }
    .card.hovercard .card-info {
        overflow: hidden;
        font-size: 12px;
        line-height: 20px;
        color: #737373;
        text-overflow: ellipsis;
    }
    .card.hovercard .bottom {
        padding: 0 20px;
        margin-bottom: 17px;
    }
    .btn-pref .btn {
        -webkit-border-radius:0 !important;
    }


</style>

<script>
    $(document).ready(function() {
        $(".btn-pref .btn").click(function () {
            $(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
            // $(".tab").addClass("active"); // instead of this do the below
            $(this).removeClass("btn-default").addClass("btn-primary");
        });
    });
</script>

<div class="content_bottom">
    <div class="col-md-12 span_3">

        <div class="bs-example1" data-example-id="contextual-table">

                <div class="card hovercard">
                    <div class="card-background">
                        <img class="card-bkimg" alt="" src="http://lorempixel.com/100/100/people/9/">
                        <!-- http://lorempixel.com/850/280/people/9/ -->
                    </div>
                    <div class="useravatar">
                        <img alt="" src="https://i.ytimg.com/vi/kXz36tUt7ww/maxresdefault.jpg">
                    </div>
                    <div class="card-info"> <span class="card-title">Greeting Cards</span>

                    </div>
                </div>
                <div class="btn-pref btn-group btn-group-justified btn-group-lg" role="group" aria-label="...">
                    <div class="btn-group" role="group">
                        <button type="button" id="stars" class="btn btn-primary" href="#tab1" data-toggle="tab"><span class="glyphicon glyphicon-import" aria-hidden="true"></span>
                            <div class="hidden-xs">Received Greeting Cards</div>
                        </button>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" id="favorites" class="btn btn-default" href="#tab2" data-toggle="tab"><span class="glyphicon glyphicon-export" aria-hidden="true"></span>
                            <div class="hidden-xs">Sent Greeting Cards</div>
                        </button>
                    </div>
                    <div class="btn-group" role="group">
                        <button type="button" id="following" class="btn btn-default" href="#tab3" data-toggle="tab"><span class="glyphicon glyphicon-hourglass" aria-hidden="true"></span>
                            <div class="hidden-xs">To be signed Greeting Cards</div>
                        </button>
                    </div>
                </div>

                <div class="well">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1">
                            <div class="container">
                                <div class="row col-md-6 col-md-offset-2 custyle">
                                    <table id="receivedTable" class="table table-striped custab">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>From</th>
                                            <th>Date Received</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <?php
                                        $i = 1;
                                        foreach ($json->received_greetings as $greeting_id){
                                            $greeting_endpoint = $api_host."/greeting-card/".$greeting_id;
                                            $greeting_json = json_decode(file_get_contents($greeting_endpoint));
                                            ?>
                                            <tr>
                                                <td><?php echo $i++?></td>
                                                <td><?php
                                                    $text = "";
                                                    foreach ($greeting_json->greeting_sender as $sender){
                                                        $text .= $sender->sender_name.", ";
                                                    }
                                                    echo substr($text, 0, -2);
                                                    ?>
                                                </td>
                                                <td><?php echo $greeting_json->send_date ?></td>
                                                <td class="text-center"><a class="btn btn-info btn-xs" href="http://<?php echo get_website_host()?>/<?php echo get_website_relative_path()?>/greetings?greeting-card-id=<?php echo $greeting_id?>"><span class="glyphicon glyphicon-eye-open"></span> View greeting card</a></td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade in" id="tab2">
                            <div class="container">
                                <div class="row col-md-6 col-md-offset-2 custyle">
                                    <table id="sentTable" class="table table-striped custab">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>To</th>
                                            <th>Date Sent</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                        </thead>
                                        <?php
                                        $i = 1;
                                        foreach ($json->sent_greetings as $greeting_id){
                                            $greeting_endpoint = $api_host."/greeting-card/".$greeting_id;
                                            $greeting_json = json_decode(file_get_contents($greeting_endpoint));
                                            ?>
                                            <tr>
                                                <td><?php echo $i++?></td>
                                                <td><?php echo $greeting_json->receiver_name ?></td>
                                                <td><?php echo $greeting_json->send_date ?></td>
                                                <td class="text-center"><a class="btn btn-info btn-xs" href="http://<?php echo get_website_host()?>/<?php echo get_website_relative_path()?>/greetings?greeting-card-id=<?php echo $greeting_id?>"><span class="glyphicon glyphicon-eye-open"></span> View greeting card</a></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade in" id="tab3">
                            <h3>Sorry! This feature is coming soon... </h3>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <div class="clearfix"> </div>
</div>

<script>
    $(document).ready(function(){
        $('#receivedTable').DataTable({
            "pageLength": 10
        });
    });
    $(document).ready(function(){
        $('#sentTable').DataTable({
            "pageLength": 10
        });
    });
</script>



