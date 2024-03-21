<!DOCTYPE html>
<html>
<head>
    <title>Choose Card Form</title>
    <link rel="icon" type="image/x-icon" href="../images/randomize_ink.ico">
    <link rel="stylesheet" href="style_draft.css">
	<meta http-equiv="X-Content-Type-Options" content="nosniff">
</head>
<body>

<?php

// $passing_player_number gets passed via POST from display_pack.php

// When you draft a card from display_pack.php, it sends you here to process

include '../error_reporting.php';
include '../db_conn.php';
include '../functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $draft_id = $_POST['draft_id'];
    $player_number = $_POST['player_number'];
    $pack_number = $_POST['pack_number'];
    $passing_player_number = $_POST['passing_player_number'];
}

// Rev round_card_count
$newCount = incrementRoundCardCount($conn, $draft_id);

$static_player_number = $player_number;

$current_card_number = getCurrentCardNumber($conn, $draft_id);

$player_count = getPlayerCount($conn, $draft_id);

$player_deck_size = player_deck_size($draft_id, $player_number);

$current_card_slot = sprintf("card_%02d", $current_card_number); // Format to have a leading zero if it is less than 10

$itemCounts = array();

// Get the drafted card id from form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['item']) && is_array($_POST['item'])) {
        // Loop through each checked item and count duplicates
        foreach ($_POST['item'] as $card_id) {
            if (!isset($itemCounts[$card_id])) {
                $itemCounts[$card_id] = 0;
            }
            $itemCounts[$card_id]++;
        }

    } else {
        echo "No items were selected.";
    }
}

// Should have single id in array now
$card_id = key($itemCounts);

//////////////////////////////////////////////////////////////////////////////////////////

// Now remove id from pack

if ($current_card_number == 1 || $current_card_number == 13 || $current_card_number == 25 || $current_card_number == 37) {
    $playerNumberCondition = "player_number = $player_number";
} else {
    $playerNumberCondition = "player_number = $passing_player_number";
}

$query = "SELECT * FROM packs WHERE $playerNumberCondition AND pack_number = ? AND draft_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $pack_number, $draft_id); // Change 'ii' based on the types of your parameters
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$stmt->close();

$fields = ['card_01', 'card_02', 'card_03', 'card_04', 'card_05', 'card_06', 'card_07', 'card_08', 'card_09', 'card_10', 'card_11', 'card_12'];
$first_matching_field = null;

foreach ($fields as $field) {
    if ($row[$field] == $card_id) {
        $first_matching_field = $field;
        break;
    }
}

if ($first_matching_field !== null) {
    $updateQuery = "UPDATE packs SET $first_matching_field = NULL WHERE $playerNumberCondition AND pack_number = ? AND draft_id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ii", $pack_number, $draft_id);
    $updateStmt->execute();

    if ($updateStmt->affected_rows > 0) {
        echo "Field updated successfully.";
    } else {
        echo "Update failed or no row affected.";
    }

    $updateStmt->close();
}

// Now add $card_id to first available card_xx slot of "player_number = $player_number" deck

$sql = "
SELECT
  COALESCE(SUM(
    (CASE WHEN card_01 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_02 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_03 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_04 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_05 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_06 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_07 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_08 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_09 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_10 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_11 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_12 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_13 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_14 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_15 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_16 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_17 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_18 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_19 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_20 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_21 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_22 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_23 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_24 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_25 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_26 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_27 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_28 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_29 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_30 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_31 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_32 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_33 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_34 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_35 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_36 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_37 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_38 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_39 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_40 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_41 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_42 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_43 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_44 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_45 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_46 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_47 IS NOT NULL THEN 1 ELSE 0 END) +
    (CASE WHEN card_48 IS NOT NULL THEN 1 ELSE 0 END)
  ), 0) AS deck_card_total
FROM decks
WHERE player_number = $player_number AND draft_id = $draft_id;
";

$result = $conn->query($sql);

// Number of cards in deck
$deck_card_total = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Debug: Uncomment the line below to see the structure of $deck_card_total
// var_dump($deck_card_total);

// Extract the specific value from the array
$cardCount = isset($deck_card_total[0]['deck_card_total']) ? (int)$deck_card_total[0]['deck_card_total'] : 0;

// Add 1 to total cards in deck
$cardCount++;

// Make it a 2-digit number
$deck_card_total_padded = str_pad((string)$cardCount, 2, "0", STR_PAD_LEFT);

// Assign the correct field name to $slot
$slot = "card_" . $deck_card_total_padded;

// Write $card_id to $slot
// Assuming $card_id, $player_number, and $draft_id are already set and sanitized
// Prepare the SQL statement with placeholders
$sql = "UPDATE decks SET $slot = ? WHERE player_number = ? AND draft_id = ?";

// Bind values to the placeholders
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $card_id, $player_number, $draft_id);

// Execute the prepared statement
if ($stmt->execute()) {
    echo "Deck updated successfully";
} else {
    echo "Error updating deck: " . $stmt->error;
}

// Close the prepared statement
$stmt->close();

//////////////////////////////////////////////////////////////////////////////////////////

/*

// Here we need the logic to rev the card number if you're the last to pick this round
// Say current card is 28
// You just picked and you were the last one to do so
// Your deck now has 28 cards
// Checks to see if there are any card_28 slots left to pick (if there is a NULL)
// If no (if allPicked = true), rev it

// This checks if all cards in card_xx for this draft are NOT NULL (if everyone drafted)
$allPicked = true;

for ($player_number = 1; $player_number <= $player_count; $player_number++) {
    // Log current iteration
    echo "<br><br>Checking player number: $player_number<br><br>";

    $stmt = $conn->prepare("SELECT $current_card_slot FROM decks WHERE draft_id = ? AND player_number = ?");
    $stmt->bind_param("ii", $draft_id, $player_number);
    $stmt->execute();
    $stmt->bind_result($the_card);

    if ($stmt->fetch()) {
        if ($the_card === NULL) {
            $allPicked = false;
            echo "Card for player $player_number is NULL<br>";
        } else {
            echo "Card for player $player_number is $the_card<br>";
        }
    } else {
        echo "<br><br>No data for player $player_number<br><br>";
        $nik = "Awesome";
    }

    $stmt->close();
}

echo $allPicked ? "<br><br>All cards picked<br><br>" : "<br><br>Not all cards picked<br><br>";

// Change current card to whatever current card was sent to earlier +1 
// If there are no NULL card slots in the round, everyone has picked so its now TRUE and rev $current_card_number

if ($allPicked == true) {

    // Prepare the SQL statement to update the current_card_number
    $stmt = $conn->prepare("UPDATE drafts SET current_card_number = current_card_number + 1 WHERE draft_id = ?");
    
    // Bind the draft_id parameter
    $stmt->bind_param("i", $draft_id);

    // Execute the query
    $stmt->execute();

    // Close the statement
    $stmt->close();

}

*/

//////////////////////////////////////////////////////////////////////////////////////////

// Redirect to Owned Cards page
header('Location: owned_cards.php?player_number=' . $static_player_number . '&draft_id=' . $draft_id . '&pack_number=' . $pack_number);
exit;

?>
