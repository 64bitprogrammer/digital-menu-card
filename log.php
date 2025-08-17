<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
date_default_timezone_set("Asia/Kolkata");

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

    // Decode POST JSON
    $data = json_decode(file_get_contents("php://input"), true);
    $buttonValue = $data['menu'] ?? 'UNKNOWN';

    // Select headers manually
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    $referer = $_SERVER['HTTP_REFERER'] ?? '';
    $language = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';
    $encoding = $_SERVER['HTTP_ACCEPT_ENCODING'] ?? '';
    $host = $_SERVER['HTTP_HOST'] ?? '';

    // Open CSV
    $fp = fopen("menu-stats.csv", "a");

    // If new file, add header row
    if (filesize("menu-stats.csv") === 0) {
        fputcsv($fp, [
            "timestamp",
            "ip",
            "menu",
            "user_agent",
            "referer",
            "language",
            "encoding",
            "host"
        ]);
    }

    // Write log row
    fputcsv($fp, [
        $timestamp,
        $ip,
        $buttonValue,
        $userAgent,
        $referer,
        $language,
        $encoding,
        $host
    ]);

    fclose($fp);

    // echo json_encode(["status" => "ok"]);
}
?>