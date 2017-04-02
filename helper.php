<?php

$action = isset($_GET['action']) ? $_GET['action'] : '';
$team_id = isset($_GET['team-id']) ? $_GET['team-id'] : '';
$member_id = isset($_GET['member-id']) ? $_GET['member-id'] : '';


switch($action){
    case "logout":{
        session_destroy();
    }
    case "delete-team": {
        $ch = curl_init();
        $api_host = get_api_host();
        $endpoint = $api_host."/teams/".$team_id;
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        $server_output = curl_exec($ch);
        curl_close($ch);
    }
    
}

/**
 * @param $date
 * @param $type
 * @return bool|string
 */
function format_date($date, $type){
    switch($type){
        case "DM":{
            return date("d M", strtotime($date));
        }
        break;
        case "DF":{
            return date("d F", strtotime($date));
        }
        break;
        case "DMY":{
            return date("d M Y", strtotime($date));
        }
        break;
        case "dm":{
            return date("d-m", strtotime($date));
        }
        break;
        case "dmy":{
            return date("d-m-Y", strtotime($date));
        }
        break;
        case "ymd":{
            return date("Y-m-d", strtotime($date));
        }
        break;
        case "time":{
            return date("h:i a", strtotime($date));
        }
        break;
        case "day":{
            return date("l", strtotime($date));
        }
        break;

    }

}

function get_logged_in_member_id(){
    return $_SESSION["member_id"];
}

function get_logged_in_member_name(){
    $member_id = $_SESSION["member_id"];
    $endpoint = get_api_host()."/members/".$member_id;
    $json = json_decode(file_get_contents($endpoint));
    return $json[0]->first_name;
}

function is_member_logged_in(){
    if(!isset($_SESSION["member_id"])){
        echo "<script>location.href = 'http://".get_website_host().json_decode(file_get_contents("env.json"))->website_relative_path."'</script>";
    }
}

function is_member_admin($member_id, $team_id){
    $endpoint = get_api_host()."/teams/".$team_id;
    $json = json_decode(file_get_contents($endpoint));
    foreach ($json[0]->team_admin as $team_admin){
       if ($team_admin->admin_id == $member_id) return true;
    }
    return false;
}

function is_member_of_given_team($member_id, $team_id){
    $endpoint = get_api_host()."/members/".$member_id;
    $json = json_decode(file_get_contents($endpoint));
    foreach($json[0]->teams as $team){
        if($team->id == $team_id) return true;
    }
    return false;
}

function is_member_of_given_celebration($member_id, $celebration_id){
    $endpoint = get_api_host()."/celebrations/".$celebration_id;
    $json = json_decode(file_get_contents($endpoint));
    foreach($json[0]->attendees as $attendee){
        if($attendee->id == $member_id) return true;
    }
    if($json[0]->birthday_of_member_id == $member_id){
        return true;
    }
    return false;
}

function get_api_host(){
    return json_decode(file_get_contents("env.json"))->api_host;
}

function get_website_host(){
    return $_SERVER["HTTP_HOST"];
}

function get_website_relative_path(){
    echo json_decode(file_get_contents("env.json"))->website_relative_path;
}

function get_timezone($country_code){
    $timezone = file_get_contents("http://api.timezonedb.com/v2/list-time-zone?key=SMNEML4RWRJ6&format=json&country=".$country_code);
    return json_decode($timezone)->zones[0]->zoneName;
}

function get_currency_symbol(){
    $country_code  = $_SESSION["country_code"];
    switch ($country_code){
        case "IN":{
            $symbol = "₹";
            break;
        }
        case "GB":{
            $symbol = "£";
            break;
        }
        default:{
            $symbol = "$";
        }
    }
    return $symbol;
}
function get_currency_font(){
    $country_code  = $_SESSION["country_code"];
    switch ($country_code){
        case "IN":{
            $symbol = "fa-inr";
            break;
        }
        case "GB":{
            $symbol = "fa-gbp";
            break;
        }
        default:{
            $symbol = "fa-usd";
        }
    }
    return $symbol;
}

function get_team_invitation_link($team_id,$team_name){
    $link = json_decode(file_get_contents("env.json"))->website_host."/index.php?team-id=".$team_id."&team-name=". urlencode($team_name);
    return $link;
}