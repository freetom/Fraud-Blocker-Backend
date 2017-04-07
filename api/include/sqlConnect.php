<?php

$conn = new mysqli('127.0.0.1', 'root', '','fraud_blocker');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$reportTable='reported_sites';
$blackListTable='black_list_table';
$whiteListTable='white_list_table';
$evaluationTable='evaluation';
$subleasesTable='subleases';
$userTable='users';
$activationTable='activation';

?>
