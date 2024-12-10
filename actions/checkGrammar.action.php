<?php

// Ensuring script is only accessed via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Invalid request method.']);
    exit;
}

// Capturing the text input from the user
$text = $_POST['text'] ?? '';

if (empty($text)) {
    echo json_encode(['error' => 'No text provided for grammar checking.']);
    exit;
}

// Using LanguageTool API
$apiUrl = 'https://api.languagetool.org/v2/check';
$data = [
    'text' => $text,
    'language' => 'en-US'
];

// Initializing cURL session
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Executing and capturing the response
$response = curl_exec($ch);
curl_close($ch);

// Output the response
header('Content-Type: application/json');
echo $response;
