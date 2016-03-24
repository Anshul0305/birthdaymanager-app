<?php
$action = $_GET["action"];

switch($action){
    case "logout":{
        session_destroy();
    }
}

function get_api_host(){
    return json_decode(file_get_contents("env.json"))->api_host;
}

function get_logged_in_member_id(){
    return $_SESSION["member_id"];
}

function is_member_logged_in(){
    if(!isset($_SESSION["member_id"])){
        echo "<script>location.href = 'http://".get_website_host().json_decode(file_get_contents("env.json"))->website_relative_path."'</script>";
    }
}

function get_website_host(){
    return $_SERVER["HTTP_HOST"];
}

function get_website_relative_path(){
    echo json_decode(file_get_contents("env.json"))->website_relative_path;
}
