<!DOCTYPE html>
<html>
<head>
    <title>Deck Selection</title>
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
include '../enchanted_cards.php';

if (isset($_GET['draft_id'])  && isset($_GET['player_number'])) {
    // Validate and sanitize input
    $draft_id = intval($_GET['draft_id']);
    $player_number = intval($_GET['player_number']);

include 'player_navbar.php';

$current_card_number = getCurrentCardNumber($conn, $draft_id);

$player_deck_size = player_deck_size($draft_id, $player_number);

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

$result = $conn->query($sql);

$cards = mysqli_fetch_all($result, MYSQLI_ASSOC);

///////////////////////////////////////////////////////////////////////////////////////

// Display all 12 cards

$current_pack = "";
$image_count = 0;
$checkbox_id = 0; // Initialize a counter for unique checkbox IDs
$foil_counter = 0; // Counter for every 12th image

if (count($cards) > 0) {
    echo "<form id='checkboxForm' action='pixelborn_code.php' method='post'>";
    echo "<h1 class='redlink'>Choose up to 8 cards to remove (Optional)</h1>";
    
echo "<div class='image-row'>"; // Start the first image row
$image_count = 0;

foreach ($cards as $row) {
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
	echo '<input type="checkbox" id="checkbox' . $checkbox_id . '" class="image-checkbox" name="item[]" value="' . htmlspecialchars($row['id'], ENT_QUOTES) . '" onchange="checkboxCounter()">';
	echo '<img src="../images/webp/' . $image_name . $image_extension . '" alt="' . htmlspecialchars($row['name'], ENT_QUOTES) . '" onclick="toggleCheckbox(' . $checkbox_id . ')">';
    echo "</div>";

    $image_count++;
    $checkbox_id++;
}

if ($image_count > 0) {
    echo "</div>"; // Close the last image row
}

    echo "<br />";
    echo "<div>Selected card: <span id='checkedCount'>0</span>/8</div>";
    echo "<br />";
	echo "<input type='hidden' name='draft_id' value='" . $draft_id . "'>";
	echo "<input type='hidden' name='player_number' value='" . $player_number . "'>";
    echo "<input type='submit' id='submitButton' class='link-button' value='FINALIZE DECK' disabled>";
    echo "<br />";
    echo "</form>";

} else {
    echo "0 results";
}

}

$conn->close()

?>

<script>
// Function to toggle the checkbox state when an image is clicked
function toggleCheckbox(checkboxId) {
    var checkbox = document.getElementById('checkbox' + checkboxId);
    checkbox.checked = !checkbox.checked;
    checkboxCounter(); // Update the counter after toggling
}

// Function to count how many checkboxes are checked and update the submit button state
// Function to count how many checkboxes are checked and update the submit button state
function checkboxCounter() {
    var checkboxes = document.querySelectorAll("input[type='checkbox']");
    var checkedCount = Array.from(checkboxes).filter(chk => chk.checked).length;

    // Reference to the submit button
    var submitButton = document.getElementById('submitButton');

    // Update the checked count display
    document.getElementById('checkedCount').innerText = checkedCount;

    // Enable the submit button if the checked count is between 0 and 8 (inclusive)
    submitButton.disabled = checkedCount > 8;

    // Update button style based on whether it's enabled or disabled
    if (submitButton.disabled) {
        submitButton.style.backgroundColor = "gray"; // Grayed out
        submitButton.style.color = "darkgray"; // Dimmed text color
    } else {
        submitButton.style.backgroundColor = ""; // Normal color
        submitButton.style.color = ""; // Normal text color
    }
}

// Initialize the state on page load
document.addEventListener("DOMContentLoaded", function() {
    checkboxCounter();
});
</script>


</body>
</html>