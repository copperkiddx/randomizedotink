<!DOCTYPE html>
<html>
<head>
    <title>Sealed Results</title>
    <link rel="icon" type="image/x-icon" href="/images/randomize_ink.ico">
    <link rel="stylesheet" href="../style_main.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>

<center>

<img src="../images/randomize_ink.png" height=100 border=0>

<br />

<div class="results">

<h1 class='green center'>Sealed Results</h1>

<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

include "../captcha_header.php";
include "../db_conn.php";
include "../location_cards.php";
include "pack_logic.php";

// Retrieve generated pack data from the session
if (isset($_SESSION['generatedPacksData'])) {
    $generatedPacksData = $_SESSION['generatedPacksData'];
    $checkbox_id = 0;

echo "<form id='checkboxForm' action='sealed_results.php' method='post'>";

$currentPackNumber = 1;

foreach ($generatedPacksData as $packData) {
    if (is_array($packData) && !empty($packData)) {
        $firstCardImageName = $packData[0]['image'] ?? '';
        $packSetName = '';
        if (strpos($firstCardImageName, 'TFC') === 0) {
            $packSetName = "The First Chapter";
        } elseif (strpos($firstCardImageName, 'ROTF') === 0) {
            $packSetName = "Rise of the Floodborn";
        } elseif (strpos($firstCardImageName, 'ITI') === 0) {
            $packSetName = "Into the Inklands";
        } else {
            $packSetName = "Unknown Set";
        }

        echo "<h2>Pack #" . $currentPackNumber . " (" . $packSetName . ")</h2>";

        // Add the instruction below the <h2> for Pack 1
        if ($currentPackNumber === 1) {
            echo "<div class='zoom-instruction'>(Right-click any card to zoom in)</div><br />";
        }

        displayPack($packData, $checkbox_id, $location_cards_with_ext);
    } else {
        echo $packData; // "0 results" or similar message
    }

    $currentPackNumber++;
}

echo "<br />";
echo "<div class='centered-container'>";
echo "<div class='centered-text'>Selected cards: <span id='checkedCount'>0</span>/40</div>";
echo "<br />";
echo "<input type='submit' id='submitButton' class='link-button' value='FINALIZE DECK' disabled>";
echo "<br />";
echo "</div>";

echo "</form>";

} else {
    echo "No results to display."; // Or redirect to the form submission page
}

function displayPack($packData, &$checkbox_id, $location_cards_with_ext) {
    echo "<div class='image-row'>";
    foreach ($packData as $card) {
        if (!isset($card['image']) || $card['image'] === null) {
            continue;
        }

        $image_name = htmlspecialchars($card['image'], ENT_QUOTES);
        $card_name = htmlspecialchars($card['name'], ENT_QUOTES);

        // Check if the image name is in the list of images to rotate
        $shouldRotate = in_array($image_name, $location_cards_with_ext);

        echo "<div class='image-container'>";
        echo "<input type='checkbox' id='checkbox" . $checkbox_id . "' class='image-checkbox' name='item[]' value='" . $card_name . "' onchange='checkboxCounter()'>";

        // Conditionally add the data-rotate attribute
        if ($shouldRotate) {
            echo "<img src='../images/webp/" . $image_name . "' alt='" . $card_name . "' data-rotate='true' onclick='toggleCheckbox(" . $checkbox_id . ")'>";
        } else {
            echo "<img src='../images/webp/" . $image_name . "' alt='" . $card_name . "' onclick='toggleCheckbox(" . $checkbox_id . ")'>";
        }

        echo "</div>";
        $checkbox_id++;
    }
    echo "</div>";
}

$conn->close();
?>

</div>

<script>

function toggleCheckbox(checkboxId) {
    console.log("Toggling checkbox with ID:", checkboxId);
    var checkbox = document.getElementById('checkbox' + checkboxId);
    if (checkbox) {
        checkbox.checked = !checkbox.checked;
        checkboxCounter(); // Update the counter after toggling

        // Directly update opacity
        checkbox.style.opacity = checkbox.checked ? 1 : 0.8;
    } else {
        console.error("Checkbox with id 'checkbox" + checkboxId + "' not found.");
    }
}

// Function to count how many checkboxes are checked and update the submit button state
function checkboxCounter() {
    var checkboxes = document.querySelectorAll("input[type='checkbox']");
    var checkedCount = Array.from(checkboxes).filter(chk => chk.checked).length;

    // Update the checked count display
    document.getElementById('checkedCount').innerText = checkedCount;

    // Reference to the submit button
    var submitButton = document.getElementById('submitButton');

    // Enable the submit button if 40 or more checkboxes are checked
    submitButton.disabled = checkedCount < 40;

    // Update button style based on whether it's enabled or disabled
    if (submitButton.disabled) {
        submitButton.style.backgroundColor = "gray"; // Grayed out
        submitButton.style.color = "darkgray"; // Dimmed text color
    } else {
        submitButton.style.backgroundColor = ""; // Normal color
        submitButton.style.color = ""; // Normal text color
    }
}

document.addEventListener("DOMContentLoaded", function() {
    var checkboxes = document.querySelectorAll(".image-checkbox");
    checkboxes.forEach(function(checkbox) {
        // This ensures the correct class is added or removed based on the checkbox's initial state
        if (checkbox.checked) {
            checkbox.classList.add("checkbox-checked");
        } else {
            checkbox.classList.remove("checkbox-checked");
        }
    });

    // Update the count of checked checkboxes
    checkboxCounter();
});

// Event listeners for copy buttons, if they exist
document.getElementById("copyButtonDreamborn")?.addEventListener("click", function() {
    var codeOutput = document.getElementById("codeOutputDreamborn");
    codeOutput.select();
    document.execCommand("copy");
    alert("Dreamborn code copied!");
});

document.getElementById("copyButtonPixelborn")?.addEventListener("click", function() {
    var codeOutput = document.getElementById("codeOutputPixelborn");
    codeOutput.select();
    document.execCommand("copy");
    alert("Pixelborn code copied!");
});

document.addEventListener('contextmenu', function(event) {
    if (event.target.tagName === 'IMG') {
        event.preventDefault(); // Prevent the default context menu
        const shouldRotate = event.target.getAttribute('data-rotate') === 'true';
        if (shouldRotate) {
            // If the image should be rotated, toggle the class that applies both zoom and rotation
            event.target.classList.toggle('zoomed-and-rotated');
        } else {
            // If the image should not be rotated, toggle only the zoom class
            event.target.classList.toggle('zoomed');
        }
    }
});

</script>

<br />

</center>

</body>
</html>
