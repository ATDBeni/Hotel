<?php

session_start();

header('Content-Type: application/json');

$_SESSION = array();

session_destroy();

echo json_encode(["status" => "success", "message" => "Deconectare reușită!"]);
