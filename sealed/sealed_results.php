<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize $itemCounts as an empty array to ensure it's always defined
$itemCounts = array();

// Process the form submission and create $itemCounts array
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if any items were checked
    if (isset($_POST['item']) && is_array($_POST['item'])) {
        // Loop through each checked item and count duplicates
        foreach ($_POST['item'] as $name) {
            if (!isset($itemCounts[$name])) {
                $itemCounts[$name] = 0;
            }
            $itemCounts[$name]++;
        }
    } else {
        echo "No items were selected.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Sealed Results</title>
    <link rel="icon" type="image/x-icon" href="../images/randomize_ink.ico">
    <link rel="stylesheet" href="../style_main.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>

<center>

<div class="results">
<?php
$servername = "localhost";
$username = "root"; // Replace with your username
$password = "shanikylEli101010!"; // Replace with your password
$dbname = "lorcana"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

////////////////////////////////////////////////////////////////////////////////

// Sort the $name_counts array by key (name) in alphabetical order
ksort($itemCounts);

//echo '<pre>';
//print_r($deckCards);
//echo '</pre>';

$output = "";

// Loop through the item counts array to create the output string for Dreamborn
foreach ($itemCounts as $name => $count) {
    $output .= $count . "x " . $name . "\n"; // Concatenates count and name
}

// Trim the trailing newline character
$output = rtrim($output);

?>

<center><h2>Code for Dreamborn</h2>

<textarea id="codeOutputDreamborn" rows="10" cols="50" readonly>
<?php echo htmlspecialchars($output); ?>
</textarea>


<br /><br />

<button id="copyButtonDreamborn">Copy Dreamborn Code</button>

<br />

<?php

// Process $itemCounts for Pixelborn output
$concatenatedResult = "";
foreach ($itemCounts as $name => $count) {
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

<br /><br />

<?php include '../linkbar.php';?>

</center>

</body>
</html>
