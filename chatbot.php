<?php
// Set your OpenAI API key here
$apiKey = "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";

// API endpoint URL
$endpoint = "https://api.openai.com/v1/chat/completions";

// Get user input from AJAX request
$userInput = $_POST["user_input"];

// Construct conversation with user input
$messages = [
    ["role" => "system", "content" => "You are a helpful assistant."],
    ["role" => "user", "content" => $userInput],
];

// Prepare data for the API request
$data = [
    "messages" => $messages,
    "model" => "gpt-3.5-turbo", // Add this line
];

// Convert data to JSON
$dataJson = json_encode($data);

// cURL request setup
$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer " . $apiKey, // Fix here
]);

// Execute the cURL request
$response = curl_exec($ch);

// Check for cURL errors
if ($response === false) {
    echo "cURL Error: " . curl_error($ch);
} else {
    // Decode the API response JSON
    $responseData = json_decode($response, true);

    // Check if there is a response and if it has choices
    if (isset($responseData["choices"][0]["message"]["content"])) {
        // Extract assistant's reply from the API response
        $assistantReply = $responseData["choices"][0]["message"]["content"];

        // Output assistant's reply
        echo $assistantReply;
    } else {
        echo "No response from the assistant.";
    }
}

// Close cURL session
curl_close($ch);
?>
