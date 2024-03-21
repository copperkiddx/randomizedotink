<!DOCTYPE html>
<html>
<head>
    <title>My Drafted Cards</title>
    <link rel="icon" type="image/x-icon" href="../images/randomize_ink.ico">
    <link rel="stylesheet" href="style_simdraft.css">
	<meta http-equiv="X-Content-Type-Options" content="nosniff">
</head>
<body class="owned-cards-stop-zoom">

<center>

<?php

include '../error_reporting.php';
include '../db_conn.php';
include '../functions.php';
include '../enchanted_cards.php';
include '../location_cards.php';

$player_number = isset($_GET['player_number']) ? (int)$_GET['player_number'] : 0;
$draft_id = isset($_GET['draft_id']) ? (int)$_GET['draft_id'] : 0;

include 'player_navbar.php';

$current_card_number = getCurrentCardNumber($conn, $draft_id);

$player_deck_size = player_deck_size($draft_id, $player_number);

revCardAndCount($conn, $draft_id);

?>

<h2>Player #<?php echo $player_number; ?> Drafted Cards</h2>

<?php
if ($current_card_number > 1) {
    echo "(Right-click any card to zoom in)<br /><br />";
}
?>

<?php

$sqlInkableCount = "
SELECT
  SUM(CASE WHEN lc.inkable = 1 THEN 1 ELSE 0 END) AS inkable_count,
  SUM(CASE WHEN lc.inkable = 0 THEN 1 ELSE 0 END) AS uninkable_count
FROM (
    SELECT card_01 AS card_id FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_02 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_03 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_04 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_05 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_06 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_07 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_08 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_09 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_10 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_11 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_12 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_13 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_14 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_15 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_16 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_17 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_18 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_19 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_20 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_21 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_22 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_23 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_24 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_25 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_26 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_27 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_28 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_29 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_30 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_31 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_32 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_33 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_34 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_35 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_36 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_37 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_38 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_39 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_40 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_41 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_42 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_43 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_44 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_45 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_46 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_47 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_48 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
) AS player_cards
JOIN lorcana_cards lc ON player_cards.card_id = lc.id;
";

// Execute the query
$result = $conn->query($sqlInkableCount);

// Initialize variables to store counts
$inkableCount = 0;
$uninkableCount = 0;

// Check if the result was successful and has at least one row
if ($result && $result->num_rows > 0) {
    // Fetch the result row
    $row = $result->fetch_assoc();

    // Assign the counts from the row to variables
    $inkableCount = $row['inkable_count'];
    $uninkableCount = $row['uninkable_count'];
}

?>

<?php

$sql = "
SELECT lc.*
FROM (
    SELECT card_01 AS card_id FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_02 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_03 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_04 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_05 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_06 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_07 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_08 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_09 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_10 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_11 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_12 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_13 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_14 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_15 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_16 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_17 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_18 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_19 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_20 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_21 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_22 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_23 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_24 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_25 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_26 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_27 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_28 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_29 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_30 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_31 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_32 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_33 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_34 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_35 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_36 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_37 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_38 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_39 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_40 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_41 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_42 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_43 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_44 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_45 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_46 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_47 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
    UNION ALL
    SELECT card_48 FROM decks WHERE player_number = $player_number AND draft_id = $draft_id
) AS player_cards
JOIN lorcana_cards lc ON player_cards.card_id = lc.id
ORDER BY cost ASC, color ASC, name ASC;
";

$cards = $conn->query($sql);

// Display all drafted cards

$current_pack = "";
$image_count = 0;
$checkbox_id = 0; // Initialize a counter for unique checkbox IDs
$foil_counter = 0; // Counter for every 12th image

// Check if the query was successful and has rows
if ($cards && $cards->num_rows > 0) {

    echo "<div class='image-row'>"; // Start the first image row
    $image_count = 0;

    while ($row = $cards->fetch_assoc()) {
    if ($image_count == 6) {
        echo "</div><div class='image-row'>"; // Close the current row and start a new row after every 6 images
        $image_count = 0;
    }
        
// Determine the correct image extension
$foil_counter++;
$image_name_raw = trim($row['image']); // Get the raw image name, trimmed

if ($foil_counter % 12 == 0) {
    // Generate a random number between 0 and 4 for a 20% chance
    // (0,1 for 50%, 0,2 for 33%, 0,3 for 25%, 0,4 for 20%, 0,5 for 16.67%)
    // (0,6 for 14.29%, 0,7 for 12.5%, 0,8 for 11.11%, 0,9 for 10%)
    $random_chance = rand(0, 4);

    // Debug: Output the random chance
    echo "<!-- Debug: Random Chance = $random_chance -->\n";

    if (in_array($image_name_raw, $enchanted_cards) && $random_chance === 0) {
        $image_extension = ".webp";

        // Debug: Output a message if this image is selected for enchanted
        echo "<!-- Debug: $image_name_raw is selected for enchanted -->\n";
    } else {
        $image_extension = ".webp";

        // Debug: Output a message if this image is not selected for enchanted
        echo "<!-- Debug: $image_name_raw is selected for foil -->\n";
    }
} else {
    $image_extension = ".webp";
}

    // Output each item with an image and an overlaid checkbox
    // Getting "id" as value instead of "name" for choosing one card
    echo "<div class='image-container'>"; // Ensure this class matches your CSS
    $image_name = htmlspecialchars($image_name_raw, ENT_QUOTES); // Convert the image name for HTML display

$is_location_card = in_array($image_name_raw, $location_cards_no_ext) ? 'true' : 'false'; // Check if it's a location card

echo "<img src='../images/webp/" . $image_name . $image_extension . "' alt='" . htmlspecialchars($row['name'], ENT_QUOTES) . "' data-is-location-card='" . $is_location_card . "' onclick='toggleCheckbox($checkbox_id)'>";

    echo "</div>";

    $image_count++;
    $checkbox_id++;
}

if ($image_count > 0) {
    echo "</div>"; // Close the last image row
}

    echo "<br />";

} else {
    echo "No drafted cards yet<br>";
}

// Set pack_number based on $player_deck_size
if ($player_deck_size <= 11) {
    // If the card number is 11 or less, set pack number to 1
    $pack_number = 1;
} elseif ($player_deck_size >= 12 && $player_deck_size <= 23) {
    // If the card number is between 12 and 24 (inclusive), set pack number to 2
    $pack_number = 2;
} elseif ($player_deck_size >= 24 && $player_deck_size <= 35) {
    // If the card number is between 24 and 35 (inclusive), set pack number to 3
    $pack_number = 3;
} elseif ($player_deck_size >= 36) {
    // If the card number is 36 or more, set pack number to 4
    $pack_number = 4;
}

?>

<?php
if ($image_count > 0) {
    echo "Inkable: " . $inkableCount . " Uninkable: " . $uninkableCount . "<br /><br />";
} else {
    echo "<br>";
}
?>

<?php

if ($player_deck_size >= 48) {
    echo '<a href="deck_selection.php?player_number=' . $player_number . '&draft_id=' . $draft_id . '" class="link-button" id="newButton">Proceed to card selection</a>';
} else {
    echo '<a href="next_card.php?player_number=' . $player_number . '&draft_id=' . $draft_id . '&pack_number=' . $pack_number . '" class="link-button" id="newButton">Draft Next Card</a>';
}

?>

<br /><br />

</center>

<script>

document.addEventListener('contextmenu', function(event) {
  if (event.target.tagName === 'IMG') {
    event.preventDefault(); // Prevent the context menu

    // Determine if the clicked image is a location card
    var isLocationCard = event.target.getAttribute('data-is-location-card') === 'true';

    // Apply the appropriate class based on whether it's a location card
    if (isLocationCard) {
      // This assumes you want both zoom and rotate for location cards
      event.target.classList.toggle('zoomed-and-rotated');
    } else {
      // Just zoom for non-location cards
      event.target.classList.toggle('zoomed');
    }
  }
});

</script>

</body>
</html>
