<?php
$action = $_GET["action"];

switch($action){
    case "logout":{
        session_destroy();
    }
}

function get_logged_in_member_id(){
    return $_SESSION["member_id"];
}

function is_member_logged_in(){
    if(!isset($_SESSION["member_id"])){
        echo "<script>location.href = 'http://".get_website_host().json_decode(file_get_contents("env.json"))->website_relative_path."'</script>";
    }
}

function is_member_admin($member_id, $team_id){
    $endpoint = get_api_host()."/teams/".$team_id;
    $json = json_decode(file_get_contents($endpoint));
    return $json[0]->admin_id == $member_id?true:false;
}

function is_member_of_given_team($member_id, $team_id){
    $endpoint = get_api_host()."/members/".$member_id;
    $json = json_decode(file_get_contents($endpoint));
    foreach($json[0]->teams as $team){
        if($team->id == $team_id) return true;
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
