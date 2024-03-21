<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include "../db_conn.php";

function sendPushoverNotification2() {
    $ch = curl_init("https://api.pushover.net/1/messages.json");

    $token = "axk4dusxojc9escfxyo222bz5i2st3"; // Replace with your actual token
    $user = "QTDqhKMOj28GaY1x3mCwlXFMxTaBFb"; // Replace with your actual user key

    curl_setopt_array($ch, array(
        CURLOPT_POSTFIELDS => array(
            "token" => $token,
            "user" => $user,
            "message" => "Balanced Deck",
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

#sendPushoverNotification2();

// Initialize $ink1 and $ink2 with default values (or values you want to use if checkboxes are not selected)
$ink1 = "DefaultInk1";
$ink2 = "DefaultInk2";

// Check if the ink_choice array is set in the POST data
if(isset($_POST['ink_choice']) && is_array($_POST['ink_choice'])){
    // Get the values of the checkboxes and assign them to $ink1 and $ink2
    $ink_choice = $_POST['ink_choice'];
    if(count($ink_choice) >= 2){
        $ink1 = $ink_choice[0];
        $ink2 = $ink_choice[1];
    }
}

$ink1 = htmlspecialchars($ink1); // Sanitize the input if necessary
$ink2 = htmlspecialchars($ink2); // Sanitize the input if necessary

if(isset($_POST['set_choice']) && is_array($_POST['set_choice'])){
    // Get the values of the checkboxes and assign them to an array $selectedSets
    $selectedSets = $_POST['set_choice'];
    // You may want to sanitize the input or validate it here.
} else {
    // Handle the case where no set is selected
    $selectedSets = array(); // Set it as an empty array or handle the default value
}

$selectedSetClause = "";

if (in_array("ALL", $selectedSets)) {
    // If "ALL" is selected, allow any series
    $selectedSetClause = " (series = 'TFC' OR series = 'ROTF' OR series = 'ITI') ";
} else {
    // Use the selected set(s) from the checkboxes
    $selectedSetClause = " series IN ('" . implode("', '", $selectedSets) . "') ";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Balanced Deck</title>
    <link rel="icon" type="image/x-icon" href="../images/randomize_ink.ico">
    <link rel="stylesheet" href="../style_main.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>

<center>

<div class="results">

<?php

// Initialize the global uninkable card count
$uninkableCardCount = 0;

// Get all cards from the database and put them into $cardPool array
$sql = "SELECT name, cost, inkable, type FROM lorcana_cards WHERE ($selectedSetClause) AND (color = '$ink1' OR color = '$ink2') ORDER BY name ASC";
$result = $conn->query($sql);

$cardPool = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $cardPool[] = $row;
    }
} else {
    echo "0 results";
}

$conn->close();

//////////////////////////////////////////////////////////////////////////////////////////

function addCards(&$cardPool, &$cards, $typesAllowed, $costMin, $costMax, $inkable = null, $requestedCopies) {
    global $uninkableCardCount; // Access the global uninkable card count

    while ($requestedCopies > 0) {
        // Adjust inkable selection if the uninkable card count is 15 or more
        $effectiveInkable = ($uninkableCardCount >= 15) ? 1 : $inkable;

        $filteredPool = array_filter($cardPool, function ($card) use ($typesAllowed, $costMin, $costMax, $effectiveInkable) {
            return in_array($card['type'], $typesAllowed) &&
                   ($effectiveInkable === null || $card['inkable'] == $effectiveInkable) &&
                   $card['cost'] >= $costMin && $card['cost'] <= $costMax;
        });

        if (!empty($filteredPool)) {
            $randomKey = array_rand($filteredPool);
            $selectedCard = $filteredPool[$randomKey];

            // Determine if we can add the requested number of copies
            $canAddAllCopies = ($selectedCard['inkable'] == 0 && $uninkableCardCount + $requestedCopies > 15) ? false : true;

            // If we can't add all copies, skip to the next card
            if (!$canAddAllCopies) {
                unset($cardPool[array_search($selectedCard, $cardPool)]);
                continue;
            }

            for ($i = 0; $i < $requestedCopies; $i++) {
                $cards[] = $selectedCard['name'];
                if ($selectedCard['inkable'] == 0) {
                    $uninkableCardCount++;
                }
            }

            // Remove the selected card from the card pool
            unset($cardPool[array_search($selectedCard, $cardPool)]);

            // Reset the requested copies count
            $requestedCopies = 0;
        } else {
            // If no suitable cards are found, break the loop
            break;
        }
    }
}

//////////////////////////////////////////////////////////////////////////////////////////

// Initialize $cards array
$cards = [];

// Add 1-drop Characters (3-3-2)
// ($typesAllowed, $costMin, $costMax, $inkable, $copies)
addCards($cardPool, $cards, ['Character'], 1, 1, null, 3);
addCards($cardPool, $cards, ['Character'], 1, 1, null, 3);
addCards($cardPool, $cards, ['Character'], 1, 1, null, 2);

// Add 2-drop Characters (3-3-2)
// ($typesAllowed, $costMin, $costMax, $inkable, $copies)
addCards($cardPool, $cards, ['Character'], 2, 2, null, 3);
addCards($cardPool, $cards, ['Character'], 2, 2, null, 3);
addCards($cardPool, $cards, ['Character'], 2, 2, null, 2);

// Add 3-drop Characters (3-3-3-2)
// ($typesAllowed, $costMin, $costMax, $inkable, $copies)
addCards($cardPool, $cards, ['Character'], 3, 3, null, 3);
addCards($cardPool, $cards, ['Character'], 3, 3, null, 3);
addCards($cardPool, $cards, ['Character'], 3, 3, null, 2);
addCards($cardPool, $cards, ['Character'], 3, 3, null, 2);

// Add Non-characters (2-2-2)
// ($typesAllowed, $costMin, $costMax, $inkable, $copies)
$typesAllowed = ['Action', 'Action - Song', 'Item'];
addCards($cardPool, $cards, $typesAllowed, 2, 2, null, 2);
addCards($cardPool, $cards, $typesAllowed, 2, 2, null, 2);
addCards($cardPool, $cards, $typesAllowed, 2, 2, null, 2);

// Add 6-10 drop Characters (2-2-2-2)
// ($typesAllowed, $costMin, $costMax, $inkable, $copies)
addCards($cardPool, $cards, ['Character'], 6, 10, null, 2);
addCards($cardPool, $cards, ['Character'], 6, 10, null, 2);
addCards($cardPool, $cards, ['Character'], 6, 10, null, 2);
addCards($cardPool, $cards, ['Character'], 6, 10, null, 2);

// Add 4-drop Characters (3-3-2)
// ($typesAllowed, $costMin, $costMax, $inkable, $copies)
addCards($cardPool, $cards, ['Character'], 4, 4, null, 3);
addCards($cardPool, $cards, ['Character'], 4, 4, null, 3);
addCards($cardPool, $cards, ['Character'], 4, 4, null, 2);

// Add 5-drop Characters (4-3-3-2)
// ($typesAllowed, $costMin, $costMax, $inkable, $copies)
addCards($cardPool, $cards, ['Character'], 5, 5, null, 4);
addCards($cardPool, $cards, ['Character'], 5, 5, null, 3);
addCards($cardPool, $cards, ['Character'], 5, 5, null, 3);
addCards($cardPool, $cards, ['Character'], 5, 5, null, 2);

// Count occurrences of each name
$name_counts = [];
foreach ($cards as $card) {
    if (!isset($name_counts[$card])) {
        $name_counts[$card] = 0;
    }
    $name_counts[$card]++;
}

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
