<?php include_once "./././helper.php"?>
<?php
is_member_logged_in();
$api_host = get_api_host();
$logged_in_member_id = get_logged_in_member_id();
$greeting_card_id = $_GET["greeting-card-id"];

$greeting_endpoint = $api_host."/greeting-card/".$greeting_card_id;
$greeting_json = json_decode(file_get_contents($greeting_endpoint));
$receiver_name = $greeting_json->receiver_name;

// Post params
$greeting_receiver_id = $_POST["bday-of"];
$member_endpoint = $api_host."/members/".$greeting_receiver_id;
$member_json = json_decode(file_get_contents($member_endpoint));
$greeting_receiver_name = $member_json[0]->first_name;
$message = $_POST["message"];
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

ol.pagination_list {
    list-style-type: none;
    position: relative;
    top: 0;
    margin: 25px 0 0 25px;
}

ol.pagination_list li {
    -moz-border-radius:40px 40px 40px 40px;
    -webkit-border-radius: 40px;
    border-radius: 40px 40px 40px 40px;
    -moz-box-shadow:1px 2px 4px grey;
    -webkit-box-shadow:1px 2px 4px grey;
    box-shadow:1px 2px 4px grey; /* Opera 10.5, IE 9 */
    background: #B3C2CC;
    background:-moz-linear-gradient(center bottom , #E9EDF6, #A9BAC5) repeat scroll 0 0 transparent;
    background: -webkit-gradient(linear, left top, left bottom, from(#A9BAC5), to(#E9EDF6));
    filter:  progid:DXImageTransform.Microsoft.gradient(startColorStr='#e9edf6', EndColorStr='#a9bac5'); /* IE6,IE7 */
    -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorStr='#e9edf6', EndColorStr='#a9bac5')"; /* IE8 */
    border-color:#FFFFFF #E7EBEE #E7EBEE #FFFFFF;
    border-style:solid;
    border-width:1px;
    color:grey;
    display:inline-block;
    font-family:verdana;
    font-size:10px;
    font-weight:bold;
    margin:0 0 20px 17px;
    padding:3px 5px;
    text-shadow:1px 1px 2px #FFFFFF;
}

ol.pagination_list li:hover {
    cursor:pointer;
    color:#222;
}

ol.pagination_list li:active {
    color: #708296;
    border-color: lightgrey;
    text-shadow:1px 1px 2px #FFFFFF;
    -moz-box-shadow: none;
    -webkit-box-shadow:none;
    box-shadow: none;
}


</style>

<?php

if (isset($_POST["message"])){ ?>

    <!--// Greeting Card Preview-->
        <div class="content_bottom">
            <div class="col-md-12 span_3">
                <div class="bs-example1" data-example-id="contextual-table">
                    <div id="card">
                        <div id="card-inside">
                            <div class="wrap">
                                <p>Hi <?php echo $greeting_receiver_name ?>,</p>
                                <p><?php echo $string = trim(preg_replace('/\s+/',' ',trim(preg_replace('/\n+/', '<br>', $message)))); ?></p>
                                <p class="signed">  <?php echo "Regards,";?> </br> <?php echo get_logged_in_member_name();?> </p>
                            </div>
                        </div>
                        <div id="card-front">
                            <div class="wrap">
                                <h1 style="font-family: 'Brush Script MT',cursive">Happy Birthday <?php echo $greeting_receiver_name?>!</h1>
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
                                <button type="submit" id="sendButton" onclick="send_greeting()" class="btn-success1 btn">Send Greeting</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"> </div>

        </div>
        <script>
            // Card Opening/Closing Function
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
        <script>
            // Card Sending Function
            function send_greeting(){
                $("#sendButton").text('Sending...');
                var form = new FormData();
                form.append("receiver_id", '<?php echo $greeting_receiver_id?>');
                form.append("sender_id", '<?php echo $logged_in_member_id?>');
                form.append("greeting_card_message", '<?php echo $string = trim(preg_replace('/\s+/',' ',trim(preg_replace('/\n+/', '<br>', $message))));?>');
                form.append("greeting_card_mail_subject", "Subject");
                form.append("send_date", '<?php echo date("Y-m-d");?>');

                var settings = {
                    "async": true,
                    "crossDomain": true,
                    "url": '<?php echo get_api_host(). "/greeting-card" ?>',
                    "method": "POST",
                    "processData": false,
                    "contentType": false,
                    "mimeType": "multipart/form-data",
                    "data": form
                }
                $.ajax(settings).done(function () {
                    $("#sendButton").text('Greeting Sent');
                    alert('Greeting card sent successfully!');
                    $("#sendButton").prop("disabled", true);
                });
            }
        </script>

<?php } else if (isset($_GET["greeting-card-id"])){ ?>

    <!--// View Sent Greeting Card-->
        <div class="content_bottom">
                <div class="col-md-12 span_3">
                    <div class="bs-example1" data-example-id="contextual-table">
                        <div id="card">
                            <div id="card-inside">
                                <div class="wrap">
                                    <?php
                                    // Show multiple messages in one greeting card
                                    if(count($greeting_json->greeting_sender)>1){
                                    ?>
                                    <ol class="pagination_list">
                                    <?php
                                    $j = 0;
                                    foreach ($greeting_json->greeting_sender as $sender){ $j++; ?>
                                    <li><a style="cursor: hand" onclick="show('<?php echo "Page".$j;?>');"><?php echo $j?></a></li>
                                    <?php } ?>
                                    </ol>
                                    <div class="page" style="">Click the numbers above to view the messages!</div>

                                    <?php
                                    $i = 0;
                                    foreach ($greeting_json->greeting_sender as $sender){ $i++;?>
                                        <div id='<?php echo "Page".$i;?>' class="page" style="display:none">
                                            <p>Hi <?php echo $greeting_json->receiver_name ?>,</p>
                                            <p><?php echo $sender->message ?></p>
                                            <p class="signed"> <?php echo "Regards,";?> </br> <?php echo $sender->sender_name;?> </p>
                                            <p></br></p>
                                        </div>
                                    <?php
                                    }}else{
                                    ?>
                                    <p>Hi <?php echo $greeting_json->receiver_name ?>,</p>
                                    <p><?php echo $greeting_json->greeting_sender[0]->message ?></p>
                                    <p class="signed"> <?php echo "Regards,";?> </br> <?php echo $greeting_json->greeting_sender[0]->sender_name;?> </p>
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
                                <div class="col-sm-3 col-sm-offset-3">
                                    <button onclick="location.href='<?php echo "http://". get_website_host()?><?php echo get_website_relative_path(). "/view-greetings"?>'" class="btn-success1 btn">View All Greeting Cards</button>
                                </div>
                                <div class="col-sm-3 ">
                                    <button onclick="location.href='<?php echo "http://". get_website_host()?><?php echo get_website_relative_path(). "/greetings"?>'" class="btn-success1 btn">Send A New Greeting Card</button>
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

        // Card Opening/Closing Function

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

<?php } else { ?>

    <!--// Show Greeting Form-->
        <div class="content_bottom">
            <div class="col-md-12 span_3">
                <div class="bs-example1" data-example-id="contextual-table">
                    <div style="text-align: center; font-weight: 500; font-size: x-large; color: #0b2c89; background: #06D995 ">Send Greeting Card</div>
                    </br>

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
                            var option = document.createElement("option");
                            option.text = entry.name;
                            option.value = entry.id;
                            select_team.add(option);
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
                            option.value = entry.id;
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

<?php } ?>




