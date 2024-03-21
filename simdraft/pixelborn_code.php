<!DOCTYPE html>
<html>
<head>
    <title>Pixelborn Code</title>
    <link rel="icon" type="image/x-icon" href="../images/randomize_ink.ico">
    <link rel="stylesheet" href="style_simdraft.css">
	<meta http-equiv="X-Content-Type-Options" content="nosniff">
</head>
<body>

<center>

<?php

include '../error_reporting.php';
include '../db_conn.php';
include '../functions.php';

//include 'player_navbar.php';

// Initialize $itemCounts as an empty array
$itemCounts = [];

// Process the form submission and create $itemCounts array
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate draft_id and player_number as integers
    $draft_id = isset($_POST['draft_id']) ? intval($_POST['draft_id']) : 0;
    $player_number = isset($_POST['player_number']) ? intval($_POST['player_number']) : 0;

    // Check if any items were checked
    if (isset($_POST['item']) && is_array($_POST['item'])) {
        foreach ($_POST['item'] as $name) {
            // Use htmlspecialchars to prevent XSS
            $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
            
            // Ensure $name is not empty
            if (!empty($name)) {
                // Initialize itemCount for $name
                if (!isset($itemCounts[$name])) {
                    $itemCounts[$name] = 0;
                }
                // Increment itemCount for $name
                $itemCounts[$name]++;
            }
        }
    } else {
        echo "";
    }
}

$current_card_number = getCurrentCardNumber($conn, $draft_id);

$player_deck_size = player_deck_size($draft_id, $player_number);

$cards = getDeckForPixelborn($conn, $player_number, $draft_id);

foreach ($itemCounts as $idToRemove => $timesToRemove) {
    $removedCount = 0;
    foreach ($cards as $key => $value) {
        if ($value['id'] == $idToRemove) {
            unset($cards[$key]);
            $removedCount++;
            if ($removedCount == $timesToRemove) {
                break;
            }
        }
    }
}

// Re-index array if necessary
$cards = array_values($cards);

// Output the modified array
//print_r($cards);

$counts = [];

// Loop through each item in $cards and count duplicates
foreach ($cards as $item) {
    $name = $item['name'];  // Access the 'name' key of each inner array
    if (!isset($counts[$name])) {
        $counts[$name] = 0;
    }
    $counts[$name]++;
}

// Check if any items were selected
if (empty($counts)) {
    echo "No items were selected.";
} else {
    // Print the counts of each item
//    echo "Array\n(\n";
    foreach ($counts as $name => $count) {
//        echo "    [$name] => $count\n";
    }
//    echo ")\n";
}

// Sort the $name_counts array by key (name) in alphabetical order
ksort($cards);

// Process $cards for Pixelborn output
$concatenatedResult = "";

// Assuming $cards has been processed to count duplicates, as per your previous code
foreach ($counts as $name => $count) {
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

// Encoding the concatenated result into Base64
$base64EncodedResult = base64_encode($concatenatedResult);

// Dreamborn code

// Create an array of just the card names from $cards
$cardNames = [];
foreach ($cards as $card) {
    if(isset($card['name'])) { // Ensure there is a 'name' key
        $cardNames[] = $card['name'];
    }
}

// Now count the occurrences of each name
$name_counts = array_count_values($cardNames);

// Continue with your existing code...

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

<h2>Player #<?php echo $player_number; ?> Pixelborn Code</h2>

<!-- Display area -->
<textarea id="codeOutputPixelborn" rows="10" cols="50" readonly>
<?php echo $base64EncodedResult; ?>
</textarea>

<br /><br />

<!-- Copy button -->
<button id="copyButtonPixelborn">Copy Pixelborn Code</button>

<br /><br />

<h2>Player #<?php echo $player_number; ?> Dreamborn Code</h2>

<textarea id="codeOutputDreamborn" rows="10" cols="50" readonly>
<?php echo htmlspecialchars($output); ?>
</textarea>

<br /><br />

<button id="copyButtonDreamborn">Copy Dreamborn Code</button>

<br /><br />

<h2 class="green">Good luck with your deck!</h2>

<br /><br />

<?php
$conn->close();
?>

</div>

<script>
    document.getElementById("copyButtonPixelborn").addEventListener("click", function() {
        // Select the text
        var codeOutputPixelborn = document.getElementById("codeOutputPixelborn");
        codeOutputPixelborn.select();

        // Copy the text
        document.execCommand("copy");

        // Optional: Alert the user that text was copied
        alert("Pixelborn code copied!");
    });

    // Add this block for the Dreamborn Code copy functionality
    document.getElementById("copyButtonDreamborn").addEventListener("click", function() {
        // Select the text
        var codeOutputDreamborn = document.getElementById("codeOutputDreamborn");
        codeOutputDreamborn.select();

        // Copy the text
        document.execCommand("copy");

        // Optional: Alert the user that text was copied
        alert("Dreamborn code copied!");
    });
</script>

</center>

</body>
</html>
