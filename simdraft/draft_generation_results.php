<!DOCTYPE html>
<html>
<head>
    <title>Draft Successfully Generated</title>
    <link rel="icon" type="image/x-icon" href="../images/randomize_ink.ico">
    <link rel="stylesheet" href="style_simdraft.css">
	<meta http-equiv="X-Content-Type-Options" content="nosniff">
</head>
<body>

<center>

<img src="../images/randomize_ink.png" width="100"><br>

<?php

include '../error_reporting.php';
include '../db_conn.php';
include "../functions.php";
include "pack_logic_draft.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $timestamp = $_POST['timestamp'];
    $human_count = $_POST['human_count'];
    $player_count = $_POST['player_count'];
    $series = $_POST['series'];
}

$draft_id = mt_rand(10000000, 99999999);

#sendSimPushoverNotification($draft_id, $series);

insertNewDraft($conn, $timestamp, $human_count, $player_count, $series, $draft_id);

insertPlayerDecks($conn, $draft_id, $player_count);

//////////////////////////////////////////////////////////////////////////////////////////

// Generate packs

$packSet = $_POST['series'];
$numberOfPlayers = $_POST['player_count'];
$numberOfPacksPerPlayer = 4; // 4 packs per player

// Determine the series to be included in the pack
$packSeries = [];

// Determine the series to be included in the pack based on form input
if ($_POST['series'] == "ALL") {
    // If "All Series" is selected, define the pack series order
    $packSeries = ["ITI", "ROTF", "TFC", "ITI"];
} else {
    // For specific series selection, keep the series consistent across all packs
    $packSeries = [$packSet, $packSet]; // Duplicate the series to fit the function structure
}

// Generate packs
$allCardsInPacks = generateMultiplePacks($numberOfPlayers * $numberOfPacksPerPlayer, $cardsBySet, $cardRarity, $packSeries, 1);

$setCardIds = []; // Array to store setCardId values

if (isset($allCardsInPacks) && count($allCardsInPacks) > 0) {
    // Modified foreach loop
    foreach ($allCardsInPacks as $card) {
        if (!is_object($card)) {
            // Handle the non-object case, maybe continue to the next iteration
            continue;
        }
        if (isset($card->setCardId)) {
            $setCardIds[] = $card->setCardId;
        }
    }
} else {
    echo "No cards in the booster pack.";
    exit;
}

//////////////////////////////////////////////////////////////////////////////////////////

$pack_number = 1;
$player_number = 1;

// SQL template
$sql = "INSERT INTO packs (card_01, card_02, card_03, card_04, card_05, card_06, card_07, card_08, card_09, card_10, card_11, card_12, draft_id, player_number, pack_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

// Loop through the card IDs
for ($i = 0; $i < count($setCardIds); $i += 12) {
    // Extract 12 card IDs for the current pack
    $currentPackIds = array_slice($setCardIds, $i, 12);

    // Append additional variables to the currentPackIds array
    array_push($currentPackIds, $draft_id, $player_number, $pack_number);

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Create a string with 12 's' for the card IDs and 'iii' for the integers
    $types = str_repeat("s", 12) . "iii";

    // Bind parameters
    $stmt->bind_param($types, ...$currentPackIds);

    // Execute the statement
    if ($stmt->execute()) {
//        echo "Pack #$pack_number successfully generated for Player #$player_number<br />";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Update pack_number and player_number for next iteration
    if ($pack_number % 4 == 0) {
        $player_number++;
        $pack_number = 1;
    } else {
        $pack_number++;
    }
}

// Close the statement
$stmt->close();

$conn->close();

echo "<br />";

if ($human_count == 1) {
    $redirect_url = "https://www.randomize.ink/simdraft/owned_cards.php?player_number=1&draft_id=$draft_id";
} else {
    $redirect_url = 'instructions.php?draft_id=' . urlencode($draft_id) . '&player_count=' . urlencode($player_count) . '&human_count=' . urlencode($human_count);
}

header("Location: $redirect_url");
exit(); // Always exit after a header redirect to prevent further execution

?>

</center>

</body>
</html>
