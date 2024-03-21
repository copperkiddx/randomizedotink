<!DOCTYPE html>
<html>
<head>
    <title>Deck Output</title>
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

if (isset($_GET['draft_id']) && isset($_GET['player_number'])) {
    // Extract the variables
    $draft_id = $_GET['draft_id'];
    $player_number = $_GET['player_number'];
}

////////////////////////////////////////////////////////////////////////////////

$deckCards = array();

include 'final_deck_query.php';

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$deckCards = mysqli_fetch_all($result, MYSQLI_ASSOC);

$counts = [];

// Loop through each item in $deckCards and count duplicates
foreach ($deckCards as $item) {
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

//print_r($deckCards);

// Sort the $name_counts array by key (name) in alphabetical order
ksort($deckCards);

// Process $deckCards for Pixelborn output
$concatenatedResult = "";

// Assuming $deckCards has been processed to count duplicates, as per your previous code
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

?>

<h2>Code for Pixelborn</h2>

<!-- Display area -->
<textarea id="codeOutputPixelborn" rows="10" cols="50" readonly>
<?php echo $base64EncodedResult; ?>
</textarea>

<br /><br />

<!-- Copy button -->
<button id="copyButtonPixelborn">Copy Pixelborn Code</button>

<br /><br /><br />

<span class="highlight">BOOKMARK THIS PAGE JUST IN CASE!</span>

<br /><br />

<?php
$conn->close();
?>

</div>

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

</body>
</html>
