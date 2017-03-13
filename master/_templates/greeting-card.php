<?php include_once "./././helper.php"?>
<?php
is_member_logged_in();
$api_host = get_api_host();
$logged_in_member_id = get_logged_in_member_id();
$greeting_card_id = $_GET["greeting-card-id"];

$endpoint = $api_host."/greeting-card/".$greeting_card_id;
$json = json_decode(file_get_contents($endpoint));

$receiver_name = $json->receiver_name;
?>
<style>
    @import url(http://fonts.googleapis.com/css?family=Nobile:400italic,700italic);
    @import url(http://fonts.googleapis.com/css?family=Dancing+Script);
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
    }
    body {
        background: #E5E5E5;
    }

    #card-front {
        color: #FFDFDF;
    }

    #card, #card-front, #card-inside {
        height: 480px;
    }

    .wrap {
        padding: 1.5em 2.5em;
        height: 100%;
    }
    #card-front, #card-inside {
        width: 50%;
        -webkit-box-shadow: 2px 2px 30px rgba(0, 0, 0, .25), 0 0 1px rgba(0, 0, 0, .5);
        -moz-box-shadow: 2px 2px 30px rgba(0, 0, 0, .25), 0 0 1px rgba(0, 0, 0, .5);
        box-shadow: 2px 2px 30px rgba(0, 0, 0, .25), 0 0 1px rgba(0, 0, 0, .5);
        position: absolute;
        left: 50%;
    }


    #card-inside .wrap {
        background: #FFEFEF;
        -webkit-box-shadow: inset 2px 0 1px rgba(0, 0, 0, .05);
        -moz-box-shadow: inset 2px 0 1px rgba(0, 0, 0, .05);
        box-shadow: inset 2px 0 1px rgba(0, 0, 0, .05);
    }
    #card {
        max-width: 960px;
        margin: 0 auto;
        transform-style: preserve-3d;
        -moz-transform-style: preserve-3d;
        -webkit-transform-style: preserve-3d;
        perspective: 5000px;
        -moz-perspective: 5000px;
        -webkit-perspective: 5000px;
        position: relative;
    }

    #card h1 {
        text-align: center;
        font-family: 'Nobile', sans-serif;
        font-style: italic;
        font-size: 70px;
        text-shadow:
            4px 4px 0px rgba(0, 0, 0, .15),
            1px 1px 0 rgba(255, 200, 200, 255),
            2px 2px 0 rgba(255, 150, 150, 255),
            3px 3px 0 rgba(255, 125, 125, 255);
        color: #FFF;
    }
    #card-inside {
        font-size: 1.1em;
        line-height: 1.4;
        font-family: 'Nobile';
        color: #331717;
        font-style: italic;
    }

    p {
        margin-top: 1em;
    }

    p:first-child {
        margin-top: 0;
    }

    p.signed {
        margin-top: 1.5em;
        text-align: center;
        font-family: 'Dancing Script', sans-serif;
        font-size: 1.5em;
    }

    #card-front {
        background-color: #FF5555;
        background-image: linear-gradient(top, #FF5555 0%, #FF7777 100%);
        background-image: -moz-linear-gradient(top, #FF5555 0%, #FF7777 100%);
        background-image: -webkit-linear-gradient(top, #FF5555 0%, #FF7777 100%);
        transform-origin: left;
        -moz-transform-origin: left;
        -webkit-transform-origin: left;
        transition:         transform 1s linear;
        -moz-transition:    -moz-transform 1s linear;
        -webkit-transition: -webkit-transform 1s linear;
        position: relative;
    }

    #card-front .wrap {
        transition: background 1s linear;
        -moz-transition: background 1s linear;
        -webkit-transition: background 1s linear;
    }

    #card-front button {
        position: absolute;
        bottom: 1em;
        right: -12px;
        background: #F44;
        color: #FFF;
        font-family: 'Nobile', sans-serif;
        font-style: italic;
        font-weight: bold;
        font-size: 1.5em;
        padding: .5em;
        border: none;
        cursor: pointer;
        box-shadow: 2px 2px 3px rgba(0, 0, 0, .25), 0 0 1px rgba(0, 0, 0, .4);
        -moz-box-shadow: 2px 2px 3px rgba(0, 0, 0, .25), 0 0 1px rgba(0, 0, 0, .4);
        -webkit-box-shadow: 2px 2px 3px rgba(0, 0, 0, .25), 0 0 1px rgba(0, 0, 0, .4);
    }

    #card-front button:hover,
    #card-front button:focus {
        background: #F22;
    }

    #close {
        display: none;
    }

    #card.open-fully #close,
    #card-open-half #close {
        display: inline;
    }

    #card.open-fully #open {
        display: none;
    }


    #card.open-half #card-front,
    #card.close-half #card-front {
        transform: rotateY(-90deg);
        -moz-transform: rotateY(-90deg);
        -webkit-transform: rotateY(-90deg);
    }
    #card.open-half #card-front .wrap {
        background-color: rgba(0, 0, 0, .5);
    }

    #card.open-fully #card-front,
    #card.close-half #card-front {
        background: #FFEFEF;
    }

    #card.open-fully #card-front {
        transform: rotateY(-180deg);
        -moz-transform: rotateY(-180deg);
        -webkit-transform: rotateY(-180deg);
    }

    #card.open-fully #card-front .wrap {
        background-color: rgba(0, 0, 0, 0);
    }

    #card.open-fully #card-front .wrap *,
    #card.close-half #card-front .wrap * {
        display: none;
    }

    footer {
        max-width: 500px;
        margin: 40px auto;
        font-family: 'Nobile', sans-serif;
        font-size: 14px;
        line-height: 1.6;
        color: #888;
        text-align: center;
    }
</style>



<?php
$name = $_POST["bday-of"];
$message = $_POST["message"];

if (isset($_POST["message"])){

    ?>
<!--        //html js-->
    <!--// Greeting Card-->
        <div class="content_bottom">
            <div class="col-md-12 span_3">
                <div class="bs-example1" data-example-id="contextual-table">
                    <div id="card">
                        <div id="card-inside">
                            <div class="wrap">
                                <p>Hi <?php echo $name ?>,</p>
                                <p><?php echo $message ?></p>
                                <p class="signed"> <?php echo get_logged_in_member_name();?> </p>

                            </div>
                        </div>

                        <div id="card-front">
                            <div class="wrap">
                                <h1 style="font-family: 'Brush Script MT',cursive">Happy Birthday <?php echo $name?>!</h1>
                            </div>
                            <button id="open">&gt;</button>
                            <button id="close">&lt;</button>
                        </div>
                    </div>
                    </br>
                    <div>
                        <div class="row">
                            <div class="col-sm-3 col-sm-offset-3">
                                <button onclick="window.history.back();" class="btn-success1 btn">Go Back</button>
                            </div>
                            <div class="col-sm-3 ">
                                <button type="submit" onclick="alert('This feature is coming soon..!');" class="btn-success1 btn">Send Greeting</button>
                            </div>
                        </div>
                    </div>


                </div>

            </div>

            <div class="clearfix"> </div>

        </div>
        <script>
            (function() {
                function $(id) {
                    return document.getElementById(id);
                }

                var card = $('card'),
                    openB = $('open'),
                    closeB = $('close'),
                    timer = null;
                console.log('wat', card);
                openB.addEventListener('click', function () {
                    card.setAttribute('class', 'open-half');
                    if (timer) clearTimeout(timer);
                    timer = setTimeout(function () {
                        card.setAttribute('class', 'open-fully');
                        timer = null;
                    }, 1000);
                });

                closeB.addEventListener('click', function () {
                    card.setAttribute('class', 'close-half');
                    if (timer) clearTimerout(timer);
                    timer = setTimeout(function () {
                        card.setAttribute('class', '');
                        timer = null;
                    }, 1000);
                });

            }());
        </script>
    <?php

}else if (isset($_GET["greeting-card-id"])){

    ?>

    <!--// View Greeting Card-->



    <div class="content_bottom">
        <div class="col-md-12 span_3">
            <div class="bs-example1" data-example-id="contextual-table">
                <div id="card">
                    <div id="card-inside">
                        <div class="wrap">
                            <?php
                            if(count($json->greeting_sender)>1){
                            ?>
                            <ul class="pagination">
                                <?php
                                $j = 0;
                                foreach ($json->greeting_sender as $sender){ $j++;?>
                                <li><a style="cursor: hand" onclick="show('<?php echo "Page".$j;?>');"><?php echo $j;?></a></li>
                                <?php } ?>
                            </ul>
                            <div class="page" style="">There are multiple messages in this card, please click the numbers above to view the messages from individual team members!</div>

                            <?php
                            $i = 0;
                            foreach ($json->greeting_sender as $sender){ $i++;?>
                                <div id='<?php echo "Page".$i;?>' class="page" style="display:none">
                                    <p><?php echo $sender->message ?></p>
                                    <p class="signed"> <?php echo "Regards,";?> </br> <?php echo $sender->sender_name;?> </p>
                                    <p></br></p>
                                </div>
                            <?php
                            }}else{
                            ?>
                            <p><?php echo $json->greeting_sender[0]->message ?></p>
                            <p class="signed"> <?php echo "Regards,";?> </br> <?php echo $json->greeting_sender[0]->sender_name;?> </p>
                            <p></br></p>
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                    <div id="card-front">
                        <div class="wrap">
                            <h1 style="font-family: 'Brush Script MT',cursive">Happy Birthday <?php echo $receiver_name?>!</h1>
                        </div>
                        <button id="open">&gt;</button>
                        <button id="close">&lt;</button>
                    </div>
                </div>
                </br>
                <div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                            <button onclick="location.href='<?php echo "http://". get_website_host()?><?php echo get_website_relative_path(). "/greetings"?>'" class="btn-success1 btn">Send a Greeting Card</button>
                        </div>
                    </div>
                </div>


            </div>

        </div>

        <div class="clearfix"> </div>

    </div>
    <script>
        function show(elementID) {
            var ele = document.getElementById(elementID);
            if (!ele) {
                alert("no such element");
                return;
            }
            var pages = document.getElementsByClassName('page');
            for(var i = 0; i < pages.length; i++) {
                pages[i].style.display = 'none';
            }
            ele.style.display = 'block';
        }

        (function() {
            function $(id) {
                return document.getElementById(id);
            }

            var card = $('card'),
                openB = $('open'),
                closeB = $('close'),
                timer = null;
            console.log('wat', card);
            openB.addEventListener('click', function () {
                card.setAttribute('class', 'open-half');
                if (timer) clearTimeout(timer);
                timer = setTimeout(function () {
                    card.setAttribute('class', 'open-fully');
                    timer = null;
                }, 1000);
            });

            closeB.addEventListener('click', function () {
                card.setAttribute('class', 'close-half');
                if (timer) clearTimerout(timer);
                timer = setTimeout(function () {
                    card.setAttribute('class', '');
                    timer = null;
                }, 1000);
            });

        }());
    </script>

    <?php
}

else
{

    ?>
<!--        //html js-->
        <!--// Form-->
        <div class="content_bottom">
            <div class="col-md-12 span_3">
                <div class="bs-example1" data-example-id="contextual-table">
                    <div style="text-align: center; font-weight: 500; font-size: x-large; color: #0b2c89; background: #06D995 ">Send Greeting Card</div>
                    </br>

                    <?php
                    is_member_logged_in();
                    $ch = curl_init();
                    $api_host = get_api_host();
                    $logged_in_member_id = get_logged_in_member_id();
                    $endpoint = $api_host."/members/".$logged_in_member_id;
                    $json = json_decode(file_get_contents($endpoint));

                    $post_celebration_endpoint = $api_host."/celebrations";

                    $birthday_of_member_id = $_POST['bday-of'];
                    $cake_amount = $_POST['cake-amt'];
                    $other_expense = $_POST['other-exp'];
                    $celebration_date = $_POST['celebration-date'];
                    $team_id = $_POST['select-team'];
                    $attendees_member_id = $_POST['attendee'];


                    if(isset($birthday_of_member_id) && isset($attendees_member_id)){
                        $post_data = "birthday_of_member_id=".$birthday_of_member_id.
                            "&cake_amount=".$cake_amount.
                            "&other_expense=".$other_expense.
                            "&celebration_date=".$celebration_date.
                            "&team_id=".$team_id;

                        foreach ($attendees_member_id as $attendee){
                            $post_data = $post_data. "&attendees_member_id[]=".$attendee;
                        }

                        if($cake_amount!="" && $other_expense !="") {
                            curl_setopt($ch, CURLOPT_URL, $post_celebration_endpoint);
                            curl_setopt($ch, CURLOPT_POST, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $server_output = curl_exec($ch);

                            $info = curl_getinfo($ch);
                            $http_code = $info["http_code"];

                            if($http_code = 200) {
                                echo '<div class="alert alert-success">';
                                echo '<strong>Success!</strong> Celebration Added Successfully!</div>';
                            }
                            else{
                                print_r( $server_output);
                                echo '<div class="alert alert-danger">';
                                echo '<strong>Oops!</strong> An Error Occurred! Please Try Again...</div>'.$server_output."ot";
                            }
                            curl_close($ch);
                        }
                        else{
                            echo '<div class="alert alert-danger">';
                            echo '<strong>Oops!</strong> Looks Like You Have Not Entered Some Data!</div>';
                        }
                    }

                    ?>

                    <form class="form-horizontal" method="post" action="">
                        <div class="form-group">
                            <label for="selector1" class="col-sm-3 control-label">Select Team</label>
                            <div class="col-sm-7"><select name="select-team" id="select-team" class="form-control1">
                                    <option>--- Select ---</option>
                                </select></div>
                        </div>
                        <div class="form-group">
                            <label for="selector1" class="col-sm-3 control-label">Send Greeting to</label>
                            <div class="col-sm-7"><select name="bday-of" id="bday-of" class="form-control1">
                                    <option>--- Select ---</option>
                                </select></div>
                        </div>
                        <div class="form-group">
                            <label for="focusedinput" class="col-sm-3 control-label">Greeting Message</label>
                            <div class="col-sm-7">
                                <textarea maxlength="200" style="height: 100px" name="message" id="message" cols="50" rows="10" class="form-control1"></textarea>
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-sm-7 col-sm-offset-3">
                                    <button type="submit" class="btn-success1 btn">Preview Card</button>
                                </div>
                            </div>
                        </div>
                        <div>
                            </br>
                        </div>

                        </br>
                    </form>
                </div>
            </div>
            <div class="clearfix"> </div>
        </div>
        <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <link href="http://code.jquery.com/ui/1.11.4/themes/cupertino/jquery-ui.css" rel="stylesheet">
        <script>
            $(function() {
                $("#celebration-date").datepicker({
                    changeMonth: true,
                    dateFormat: "yy-mm-dd"
                });
            });
            $(function() {
                $("#celebration-time").flatpickr({
                    enableTime: true
                });
            });

        </script>

        <script type = "text/javascript" language = "javascript">
        // Populate Team Dropdown
        $(document).ready( function(){
            $.get("<?php echo $api_host?>/members/<?php echo $logged_in_member_id?>",
                function(data) {
                    var select_team = document.getElementById("select-team");
                    data[0].teams.forEach(function(entry) {
                        if(entry.is_admin == "true"){
                            var option = document.createElement("option");
                            option.text = entry.name;
                            option.value = entry.id;
                            select_team.add(option);
                        }
                    });
                });
        });
        // Populate Team Member Dropdown
        $(document).ready(function() {
            $("#select-team").change(function(){
                var x = document.getElementById("bday-of");
                x.innerHTML="";
                $('#attendees').empty();
                var option = document.createElement("option");
                option.text = "--- Select ---";
                x.add(option);

                var id = $("#select-team").val();
                $.get(
                    "<?php echo $api_host?>/teams/"+id,
                    function(data) {
                        data[0].members.forEach(function(entry) {
                            var option = document.createElement("option");
                            option.text = entry.name;
                            option.value = entry.name;
                            x.add(option);
                        });
                    }
                );
            });
        });
        // Populate attendees
        $(document).ready(function(){
            $("#bday-of").change(function(){
                $('#attendees').empty();
                var id = $("#select-team").val();
                var bday_of = $("#bday-of").val();
                $.get(
                    "<?php echo $api_host?>/teams/"+id,
                    function(data) {
                        data[0].members.forEach(function(entry) {
                            if(entry.id != bday_of){
                                $('#attendees').append('<div class="checkbox-inline1"><label><input type="checkbox" name="attendee[]" value='+ entry.id +' checked=""> '+ entry.name +'</label></div>');
                            }
                        });
                    }
                );
            });
        });
    </script>
    <?php

}
?>




