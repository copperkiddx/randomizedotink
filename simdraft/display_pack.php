<!DOCTYPE html>
<html>
<head>
    <title>Card Selection</title>
    <link rel="icon" type="image/x-icon" href="../images/randomize_ink.ico">
    <link rel="stylesheet" href="style_simdraft.css">
	<meta http-equiv="X-Content-Type-Options" content="nosniff">
</head>
<body>

<?php

// $passing_player_number gets passed via GET from next_card.php

include '../error_reporting.php';
include '../db_conn.php';
include '../functions.php';
include '../enchanted_cards.php';
include '../location_cards.php';

if (isset($_GET['player_number']) && isset($_GET['draft_id'])) {
    $player_number = intval($_GET['player_number']); // Ensure it's an integer
    $draft_id = intval($_GET['draft_id']); // Ensure it's an integer
    $passing_player_number = intval($_GET['passing_player_number']); // Ensure it's an integer
    $pack_number = intval($_GET['pack_number']); // Ensure it's an integer    
}

include 'player_navbar.php';

$current_card_number = getCurrentCardNumber($conn, $draft_id);

$player_deck_size = player_deck_size($draft_id, $player_number);

// Determine the player number based on the current card number
if ($current_card_number == 1 || $current_card_number == 13 || $current_card_number == 25 || $current_card_number == 37) {
	$temp_player_number = $player_number;
} else {
	$temp_player_number = $passing_player_number;
}

$cards = getPackCards($current_card_number, $player_number, $passing_player_number, $pack_number, $draft_id, $conn, $temp_player_number);

// Display all 12 cards

$current_pack = "";
$image_count = 0;
$checkbox_id = 0; // Initialize a counter for unique checkbox IDs
$foil_counter = 0; // Counter for every 12th image

if (count($cards) > 0) {
    echo "<form id='checkboxForm' action='logic.php' method='post'>";
    echo "<h1 class='redlink'>Choose wisely! This cannot be undone</h1>";
	echo "<h2>Round " . htmlspecialchars($current_card_number, ENT_QUOTES, 'UTF-8') . " of 48</h2>You are choosing from: Player #" . htmlspecialchars($temp_player_number, ENT_QUOTES, 'UTF-8') . " - Pack #" . htmlspecialchars($pack_number, ENT_QUOTES, 'UTF-8') . "<br><br>";
    echo "(Right-click any card to zoom in)<br /><br />";
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
//      $image_extension = "_foil.webp";
        $image_extension = ".webp";

        // Debug: Output a message if this image is selected for enchanted
        echo "<!-- Debug: $image_name_raw is selected for enchanted -->\n";
    } else {
//      $image_extension = "_foil.webp";
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
    echo "<input type='checkbox' id='checkbox$checkbox_id' class='image-checkbox' name='item[]' value='" . htmlspecialchars($row['id'], ENT_QUOTES) . "' onchange='checkboxCounter()'>";

// Determine if the image is a location card
$is_location_card = in_array($image_name_raw, $location_cards_no_ext) ? 'true' : 'false';

// Include the data attribute in the image tag
echo "<img src='../images/webp/" . $image_name . $image_extension . "' alt='" . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8') . "' data-is-location-card='" . $is_location_card . "' onclick='toggleCheckbox($checkbox_id)'>";

    echo "</div>";

    $image_count++;
    $checkbox_id++;
}

if ($image_count > 0) {
    echo "</div>"; // Close the last image row
}

    echo "<br />";
    echo "<div>Selected card: <span id='checkedCount'>0</span>/1</div>";
    echo "<br />";
	echo "<input type='hidden' name='draft_id' value='" . $draft_id . "'>";
	echo "<input type='hidden' name='player_number' value='" . $player_number . "'>";
	echo "<input type='hidden' name='pack_number' value='" . $pack_number . "'>";
	echo "<input type='hidden' name='passing_player_number' value='" . $passing_player_number . "'>";
    echo "<input type='submit' id='submitButton' class='link-button' value='DRAFT CARD' disabled>";
    echo "<br />";
    echo "</form>";

} else {
    echo "0 results";
}

$conn->close()

?>

<script>
// Function to toggle the checkbox state when an image is clicked
function toggleCheckbox(checkboxId) {
    var checkboxes = document.querySelectorAll("input[type='checkbox']");
    // Uncheck all checkboxes
    checkboxes.forEach(chk => chk.checked = false);

    // Toggle the clicked checkbox
    var checkbox = document.getElementById('checkbox' + checkboxId);
    checkbox.checked = !checkbox.checked;
    checkboxCounter(); // Update the counter after toggling
}

// Function to count how many checkboxes are checked and update the submit button state
function checkboxCounter() {
    var checkboxes = document.querySelectorAll("input[type='checkbox']");
    var checkedCount = Array.from(checkboxes).filter(chk => chk.checked).length;

    // Update the checked count display
    document.getElementById('checkedCount').innerText = checkedCount;

    // Reference to the submit button
    var submitButton = document.getElementById('submitButton');

    // Enable the submit button if exactly 1 checkbox is checked
    submitButton.disabled = checkedCount !== 1;

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

document.addEventListener('contextmenu', function(event) {
  if (event.target.tagName === 'IMG') {
    event.preventDefault(); // Prevent the context menu

    // Check if the image is a location card
    var isLocationCard = event.target.getAttribute('data-is-location-card') === 'true';

    // Apply 'zoomed-and-rotated' class if it's a location card, otherwise 'zoomed'
    if (isLocationCard) {
      event.target.classList.toggle('zoomed-and-rotated');
    } else {
      event.target.classList.toggle('zoomed');
    }
  }
});

</script>

</body>
</html>
