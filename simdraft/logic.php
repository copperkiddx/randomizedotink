<!DOCTYPE html>
<html>
<head>
    <title>Choose Card Form</title>
    <link rel="icon" type="image/x-icon" href="../images/randomize_ink.ico">
    <link rel="stylesheet" href="style_simdraft.css">
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

if ($player_number == 1) {
    $sim = "1";
}

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

// Add $card_id to first available card_xx slot of "player_number = $player_number" deck

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
	echo "<br>player_number $player_number deck updated successfully with card_id $card_id<br>";
} else {
	echo "Error updating deck for player_number $player_number: " . $stmt->error;
}

// Close the prepared statement
$stmt->close();

//////////////////////////////////////////////////////////////////////////////////////////

// Now remove card_id from pack

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
        echo "<br>Card $card_id removed from player_number $player_number - pack_number $pack_number<br>";
    } else {
		echo "$card_id not removed, error";
    }

    $updateStmt->close();
}

echo '<br><hr>';
	
// Rev round_card_count
$newCount = incrementRoundCardCount($conn, $draft_id);

//////////////////////////////////////////////////////////////////////////////////////////
// BEGIN LOOP
//////////////////////////////////////////////////////////////////////////////////////////

if ($sim == 1) {

	// Get human_count from database
	$human_count = getHumanCount($conn, $draft_id);
	
	$player_number = $human_count + 1; // Start with $human_count + 1 as first simulated player
	
	while ($player_number <= $player_count) {
	
		echo '<br>';
		echo 'player_number: '. $player_number;
		echo '<br>';

	// - what pack am i seeing right now?
	// - pack 1 but from what player? and is $pack_number accessible from within this loop? check by echoing
		echo '<br>';
		echo 'pack_number: '. $pack_number;
		echo '<br>';
	
	// - need to determine $passing_player_number - use function
	
	$passing_player_number = calculatePassingPlayerNumber($current_card_number, $player_number, $player_count);
	
		echo '<br>';
		echo 'passing_player_number: '. $passing_player_number;
		echo '<br>';
		
	// - is player_count accessible from within this loop? check by echoing

		echo '<br>';
		echo 'player_count: '. $player_count;
		echo '<br>';
	
	// Set card_id from random card from pack
	
	if ($current_card_number == 1 || $current_card_number == 13 || $current_card_number == 25 || $current_card_number == 37) {
		$ppn = $player_number;
	} else {
		$ppn = $passing_player_number;
	}

		echo '<br>';
		echo 'ppn: '. $ppn;
		echo '<br>';

	$card_id = getRandomSimCard($conn, $ppn, $pack_number, $draft_id);

		echo '<br>';
		echo 'card_id: '. $card_id;
		echo '<br>';

	// Add $card_id to first available card_xx slot of "player_number = $player_number" deck
	
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
		
	// Extract the specific value from the array
	$cardCount = isset($deck_card_total[0]['deck_card_total']) ? (int)$deck_card_total[0]['deck_card_total'] : 0;
	
	// Add 1 to total cards in deck
	$cardCount++;
	
	// Make it a 2-digit number
	$deck_card_total_padded = str_pad((string)$cardCount, 2, "0", STR_PAD_LEFT);
	
	// Assign the correct field name to $slot
	$slot = "card_" . $deck_card_total_padded;
	
	// Write $card_id to $slot
	$sql = "UPDATE decks SET $slot = ? WHERE player_number = ? AND draft_id = ?";
	
	// Bind values to the placeholders
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("ssi", $card_id, $player_number, $draft_id);
	
	// Execute the prepared statement
	if ($stmt->execute()) {
		echo "<br>player_number $player_number deck updated successfully with card_id $card_id<br>";
	} else {
		echo "Error updating deck for player_number $player_number: " . $stmt->error;
	}
	
	// Close the prepared statement
	$stmt->close();

	// Remove $card_id from pack

	$query = "SELECT * FROM packs WHERE player_number = ? AND pack_number = ? AND draft_id = ?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("iii", $ppn, $pack_number, $draft_id); // Change 'iii' based on the types of your parameters
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
		$updateQuery = "UPDATE packs SET $first_matching_field = NULL WHERE player_number = ? AND pack_number = ? AND draft_id = ?";
		$updateStmt = $conn->prepare($updateQuery);
		$updateStmt->bind_param("iii", $ppn, $pack_number, $draft_id);
		$updateStmt->execute();
	
		if ($updateStmt->affected_rows > 0) {
			echo "<br>Card $card_id removed from player_number $player_number - pack_number $pack_number";
		} else {
			echo "$card_id not removed, error";
		}
	
		$updateStmt->close();
	}
			
	// Rev round_card_count
	$newCount = incrementRoundCardCount($conn, $draft_id);
	
	// Move on to the next player in loop
	$player_number++;
	
	echo '<br><br><hr>';
	
	}

}

//////////////////////////////////////////////////////////////////////////////////////////
// END LOOP
//////////////////////////////////////////////////////////////////////////////////////////

// Redirect to Owned Cards page
header('Location: owned_cards.php?player_number=' . $static_player_number . '&draft_id=' . $draft_id . '&pack_number=' . $pack_number);
exit;

?>
