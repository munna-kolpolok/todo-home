<?php
/**
 * Created by PhpStorm.
 * User: mamun0024
 * Date: 15/02/2017
 * Time: 10:43 AM
 */

date_default_timezone_set('Asia/Dhaka');

$host   = "127.0.0.1";
$dbname = "kishorda_bidyanondo_2";
$user   = "kishorda_v2bidya";
$pass   = "aS1$jK!Hn8L3M";
try {
    $DBH = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $DBH->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
}catch(PDOException $exception) {
    echo $exception->getMessage();
}

function clean($input = "") {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}


$bdn_sslCommerz_tran_id = clean($_REQUEST["tran_id"]);



$query = $DBH->prepare("INSERT INTO bdn_sslcommerz_ipn(tranID)
                        VALUES( :tranID)");

$query->bindParam(':tranID', $bdn_sslCommerz_tran_id, PDO::PARAM_STR);

$query->execute();