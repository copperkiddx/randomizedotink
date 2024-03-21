<!DOCTYPE html>
<html>
<head>
    <title>Draft Instructions</title>
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
include '../functions.php';

$draft_id = isset($_GET['draft_id']) ? (int)$_GET['draft_id'] : 0;
$human_count = isset($_GET['human_count']) ? (int)$_GET['human_count'] : 0;

?>

<h2 class="green">Draft #<?php echo $draft_id; ?></h2>

1. Copy the text below and save it to a file on your computer:<br /><br />

<?php $playerInfo = getPlayerLoginInfoSim($conn, $human_count, $draft_id); ?>

<textarea id="playerInfoTextarea" rows="10" cols="50"><?php echo $playerInfo; ?></textarea><br>
<button id="copyButton">COPY TEXT</button>
    
<br><br>

2. Send the relevant information to each of your players<br /><br />

3. Players can then log in and begin drafting!<br /><br />

<u>Pass Direction</u><br><br>Round 1 <-- Left<br>Round 2 --> Right<br>Round 3 <-- Left<br>Round 4 --> Right<br><br>

*All drafts will be deleted 7 days after creation<br>

<br>

<a href="dashboard.php?draft_id=<?php echo $draft_id; ?>" class="link-button">Click here to proceed</a><br><br>

</center>

 <script>
        // Function to copy text to clipboard
        function copyToClipboard() {
            var textarea = document.getElementById("playerInfoTextarea");
            var textToCopy = textarea.value.trim(); // Remove trailing white space
            textarea.value = textToCopy; // Update the textarea content
            textarea.select();
            document.execCommand("copy");
            alert("Text copied to clipboard!");
        }

        // Add click event listener to the "COPY TEXT" button
        var copyButton = document.getElementById("copyButton");
        copyButton.addEventListener("click", copyToClipboard);
    </script>
    
</body>
</html>
