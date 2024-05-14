<?php


$db_host='localhost';
$db_user='the_travel_project';
$db_pass='';
$db_name='the_travel_project';


$dsn="mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";

$pdo_options =[
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

$pdo=new PDO($dsn,$db_user,$db_pass);



// header('Content-Type: application/json');
//告訴瀏覽器回應的是json

// echo json_encode($rows);