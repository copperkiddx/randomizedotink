<!DOCTYPE html>
<html>
<head>
    <title>Dreamborn Code</title>
    <link rel="icon" type="image/x-icon" href="../images/randomize_ink.ico">
    <link rel="stylesheet" href="style_draft.css">
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

// Count occurrences of each name
$name_counts = array_count_values($cards);

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

</center>

</body>
</html>
