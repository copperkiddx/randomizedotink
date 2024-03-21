<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $captcha_response = $_POST['g-recaptcha-response'];

    // Log the CAPTCHA response
    error_log("CAPTCHA response: " . $captcha_response);

    if (!$captcha_response) {
        error_log("CAPTCHA response missing");
        // Handle error: CAPTCHA response missing
    } else {
        $secretKey = "";
        $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$captcha_response}");
        $responseData = json_decode($verifyResponse);

        // Log the verification result
        error_log("CAPTCHA verification result: " . json_encode($responseData));

        if ($responseData->success) {
            // CAPTCHA verified - proceed with form processing
        } else {
            error_log("CAPTCHA verification failed");
            // Handle error: CAPTCHA verification failed
        }
    }
}

?>