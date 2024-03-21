<?php
session_start(); // Start a session if needed

error_reporting(E_ALL);
ini_set("display_errors", 1);

include "../captcha_header.php";
include "../db_conn.php";
include '../enchanted_cards.php';
include "pack_logic.php";

// Check if the form has been submitted and the 'option' value is valid
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["option"])) {
    $option = $_POST["option"];

    // Set $option in the session
    $_SESSION['option'] = $option;

    // Determine the pack configuration based on the user's selection
    switch ($option) {
        case "option1":
            $setPacks = ["TFC" => 6];
            $setname = "TFC";
            break;
        case "option2":
            $setPacks = ["ROTF" => 6];
            $setname = "ROTF";
            break;
        case "option3":
            $setPacks = ["ITI" => 6];
            $setname = "ITI";
            break;
        case "option4":
            $setPacks = ["TFC" => 2, "ROTF" => 2, "ITI" => 2];
            $setname = "ALL";
            break;
        default:
            $setPacks = []; // Default behavior for unknown option
            break;
    }

	function sendPushoverNotification4($setname) {
		$ch = curl_init("https://api.pushover.net/1/messages.json");
	
		$token = "axk4dusxojc9escfxyo222bz5i2st3"; // Replace with your actual token
		$user = "QTDqhKMOj28GaY1x3mCwlXFMxTaBFb"; // Replace with your actual user key
	
		curl_setopt_array($ch, array(
			CURLOPT_POSTFIELDS => array(
				"token" => $token,
				"user" => $user,
				"message" => "Sealed ($setname)",
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
	
	#sendPushoverNotification4($setname);

    // Generate pack data based on user selection and store in the session
    $_SESSION['generatedPacksData'] = generatePacksData($setPacks, $enchanted_cards);

    // Redirect to the results page
    header('Location: results.php');
    exit;
} else {
    // Handle cases where the form was not submitted or 'option' is missing
    // Example: display an error message or redirect to an error page
}

// Function to generate pack data based on the setPacks array
function generatePacksData($setPacks, $enchanted_cards) {
    global $cardsBySet, $cardRarity; // Ensure these variables are accessible
    $generatedData = [];

    foreach ($setPacks as $packSet => $numPacks) {
        for ($packIndex = 0; $packIndex < $numPacks; $packIndex++) {
            $boosterPack = buildPackFromSet($cardsBySet, $cardRarity, $packSet, 1);
            if (isset($boosterPack) && count($boosterPack->cardsInBooster) > 0) {
                $generatedData[] = preparePackData($boosterPack, $enchanted_cards);
            } else {
                $generatedData[] = "0 results";
            }
        }
    }
    return $generatedData;
}

// Function to prepare pack data for a single pack
function preparePackData($boosterPack, $enchanted_cards) {
    $packData = [];
    $foil_counter = 0;

    foreach ($boosterPack->cardsInBooster as $card) {
        $foil_counter++;
        $image_name_raw = trim($card->image);
        $image_extension = ".webp";

        if ($foil_counter % 12 == 0) {
            $random_chance = rand(0, 4);
            if (in_array($image_name_raw, $enchanted_cards) && $random_chance === 0) {
                $image_extension = "_enchanted.webp";
            } else {
//              $image_extension = "_foil.webp";
                $image_extension = ".webp";
            }
        }

        $packData[] = [
            'name' => $card->name,
            'image' => $image_name_raw . $image_extension
        ];
    }

    return $packData;
}
?>
