<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include 'dbconfig.php';

$response=  ["status"=>false,"message"=>""];
if (!isset($_POST['email'])) {
    
    $response['status'] = false;
    $response['message'] ="Email is not present";
    echo json_encode($response);
    exit;
}
if (!isset($_POST['password'])) {

    $response['status'] = false;
    $response['message'] = "Password is not present";
    echo json_encode($response);
    exit;
}

if (!isset($_POST['confirmPassword'])) {
    
    $response['status'] = false;
    $response['message'] = "Confirm Password is not present";
    echo json_encode($response);
    exit;
}

$email = $_POST['email'];
$password = $_POST['password'];
$password = md5($password);

$query = "select user_id from user_details where email = '$email'";
$stmt = $pdo->query($query);
$result = $stmt->fetch();
if($result && $result['user_id']){
    $response['status'] = false;
    $response['message'] =$email." already exits";
    echo json_encode($response);
    exit;
}

$query = "Insert into user_details (email,password) values(?,?)";
$stmt = $pdo->prepare($query);
$result = $stmt->execute([$email,$password]);

if($result){

    $response['status'] = true;
    $response['message'] = "User Successfully Registered";
    echo json_encode($response);
    
}





