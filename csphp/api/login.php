<?php



error_reporting(E_ALL);
ini_set('display_errors', '1');
include 'dbconfig.php';

$response =  ["status" => false, "message" => "", "data" => ""];
if (!isset($_POST['email'])) {

    $response['status'] = false;
    $response['message'] = "Email is not present";
    echo json_encode($response);
    exit;
}
if (!isset($_POST['password'])) {

    $response['status'] = false;
    $response['message'] = "Password is not present";
    echo json_encode($response);
    exit;
}

$email = $_POST['email'];
$password = md5($_POST['password']);
$query = "select user_id from user_details where email = ? and password = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$email, $password]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result && $result['user_id']) {

    $token = generateRandomString(10);


    $query = "Update user_details set token = ? where email =?";
    $stmt = $pdo->prepare($query);
    $result = $stmt->execute([$token, $email]);

    if ($result) {
        $response['status'] = true;
        $response['message'] = "Login successful!";
        $response['data'] = $token;
        echo json_encode($response);
        exit;
    }
    
} else {
    $response['status'] = false;
    $response['message'] = "Username or Password is invalid.";
    echo json_encode($response);
    exit;
}

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}
