<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $captcha_response = $_POST['g-recaptcha-response'];

    // Log the CAPTCHA response
    error_log("CAPTCHA response: " . $captcha_response);

    if (!$captcha_response) {
        error_log("CAPTCHA response missing");
        // Handle error: CAPTCHA response missing
    } else {
        $secretKey = "6Lf1LzkpAAAAADQFyY8ldK1YnWHG-hDGhvrAGAJ1";
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

<?php
function sendPushoverNotification3() {
    $ch = curl_init("https://api.pushover.net/1/messages.json");

    $token = "axk4dusxojc9escfxyo222bz5i2st3"; // Replace with your actual token
    $user = "QTDqhKMOj28GaY1x3mCwlXFMxTaBFb"; // Replace with your actual user key

    curl_setopt_array($ch, array(
        CURLOPT_POSTFIELDS => array(
            "token" => $token,
            "user" => $user,
            "message" => "Custom Deck",
        ),
        CURLOPT_SAFE_UPLOAD => true,
        CURLOPT_RETURNTRANSFER => true,
    ));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        //echo 'Error:' . curl_error($ch);
    } else {
        //echo 'Response:' . $response;
    }

    curl_close($ch);
}

#sendPushoverNotification3();
?>

<!DOCTYPE html>
<html>
<head>
    <title>randomize.ink</title>
    <link rel="icon" type="image/x-icon" href="../images/randomize_ink.ico">
    <link rel="stylesheet" href="../style_main.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>

<center>

<div class="results">
<?php
$servername = "localhost";
$username = "root"; // Replace with your username
$password = "shanikylEli101010!"; // Replace with your password
$dbname = "lorcana"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

////////////////////////////////////////////////////////////////////////////////

// Get the deck size from user input
$deckSize = isset($_POST['deck_size']) ? intval($_POST['deck_size']) : 60; // Default to 60 if not set

// Set the inkable0Count based on deck size
if ($deckSize == 40) {
    $inkable0Count = rand(6, 10);
} elseif ($deckSize == 50) {
    $inkable0Count = rand(8, 12);
} else {
    $inkable0Count = rand(10, 15);
}

include 'deck_logic.php';

// Shuffle the deck array
shuffle($deck);

// Count occurrences of each name
$name_counts = array_count_values($deck);

$output = "";

// Sort the $name_counts array by key (name) in alphabetical order
ksort($name_counts);

$output = "";
$firstLine = true;

foreach ($name_counts as $name => $count) {
    // Add the newline character before each line except the first
    if (!$firstLine) {
        $output .= "\n";
    } else {
        $firstLine = false;
    }

    $output .= $count . "x " . $name;
}

?>

<center><h2>Code for Dreamborn</h2>

<textarea id="codeOutputDreamborn" rows="10" cols="50" readonly>
<?php echo htmlspecialchars($output); ?>
</textarea>

<br /><br />

<button id="copyButtonDreamborn">Copy Dreamborn Code</button>

<br />

<?php

// Initialize an empty string to hold the concatenated result
$concatenatedResult = "";

foreach ($name_counts as $name => $count) {
    // Split the name into card name and subname, if available
    $parts = explode(" - ", $name);
    if (count($parts) == 2) {
        // If there is a subname
        $concatenatedResult .= $parts[0] . "_" . $parts[1] . "$" . $count . "|";
    } else {
        // If there is no subname
        $concatenatedResult .= $parts[0] . "$" . $count . "|";
    }
}

//echo $concatenatedResult;

// Encoding the concatenated result into Base64
$base64EncodedResult = base64_encode($concatenatedResult);

// Echo the Base64 encoded string

?>

<h2>Code for Pixelborn</h2>

<!-- Display area -->
<textarea id="codeOutputPixelborn" rows="10" cols="50" readonly>
<?php echo $base64EncodedResult; ?>
</textarea>

<br /><br />

<!-- Copy button -->
<button id="copyButtonPixelborn">Copy Pixelborn Code</button>

<?php
$conn->close();
?>

</div>

<script>
    document.getElementById("copyButtonDreamborn").addEventListener("click", function() {
        // Select the text
        var codeOutput = document.getElementById("codeOutputDreamborn");
        codeOutput.select();

        // Copy the text
        document.execCommand("copy");

        // Optional: Alert the user that text was copied
        alert("Dreamborn code copied!");
    });
</script>

<script>
    document.getElementById("copyButtonPixelborn").addEventListener("click", function() {
        // Select the text
        var codeOutput = document.getElementById("codeOutputPixelborn");
        codeOutput.select();

        // Copy the text
        document.execCommand("copy");

        // Optional: Alert the user that text was copied
        alert("Pixelborn code copied!");
    });
</script>

</center>

<br /><br />

<?php include '../linkbar.php';?>

</center>

</body>
</html>
