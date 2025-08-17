<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Detect IP
    $ip = $_SERVER['REMOTE_ADDR'];
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    }

    // Timestamp
    $timestamp = date("Y-m-d H:i:s");

    // Decode POSTed JSON
    $data = json_decode(file_get_contents("php://input"), true);
    $buttonValue = $data['menu'] ?? 'UNKNOWN';

    // Open CSV file for appending
    $fp = fopen("menu-stats.csv", "a");

    // If file is new/empty, write header
    if (filesize("menu-stats.csv") === 0) {
        fputcsv($fp, ["timestamp", "ip", "menu"]);
    }

    // Write a row
    fputcsv($fp, [$timestamp, $ip, $buttonValue]);

    fclose($fp);

    // Optional response
    // echo json_encode(["status" => "ok"]);
}

?>