<!DOCTYPE html>
<html>
<head>
    <title>Moderator Dashboard</title>
    <link rel="icon" type="image/x-icon" href="../images/randomize_ink.ico">
    <link rel="stylesheet" href="style_draft.css">
	<meta http-equiv="X-Content-Type-Options" content="nosniff">    
</head>
<body>
<center>

<img src="../images/randomize_ink.png" width="100">

<?php

include '../error_reporting.php';
include '../db_conn.php';
include '../functions.php';

if (isset($_GET['draft_id']) ) {
    // Extract the variables
    $draft_id = $_GET['draft_id'];

$player_count = getPlayerCount($conn, $draft_id);

$current_card_number = getCurrentCardNumber($conn, $draft_id);

$current_card_slot = sprintf("card_%02d", $current_card_number); // Format to have a leading zero if it is less than 10

echo "<h2>Draft #" . $draft_id . "</h2>";

}

if ($current_card_number != 49) {

echo "<h2 class='green'>Round $current_card_number is live</h2>";

echo "<table style='width: 100%; border-collapse: collapse;'>";

// First row for player headers
echo "<tr>";
for ($i = 1; $i <= $player_count; $i++) {
    echo "<th style='text-align: center; border: 2px solid #999;'>Player $i</th>";
}
echo "</tr>";

// Second row for results
echo "<tr>";

$allNotNull = true; // Flag to track if all results are NOT NULL

for ($player_number = 1; $player_number <= $player_count; $player_number++) {

$stmt = $conn->prepare("SELECT $current_card_slot FROM decks WHERE draft_id = ? AND player_number = ?");
$stmt->bind_param("ii", $draft_id, $player_number);
$stmt->execute();
$stmt->bind_result($the_card);
if ($stmt->fetch()) {

        // Check if $the_card is NULL
        if ($the_card === NULL) {
            echo "<td class='red' style='text-align: center; border: 2px solid #999;'>PENDING</td>";
            $allNotNull = false; // Set flag to false as we found a NULL
        } else {
            echo "<td class='green' style='text-align: center; border: 2px solid #999;'>&#x2714;</td>";
        }
    } else {
        // Handle the case where there is no row matching the criteria
        echo "<td style='text-align: center; border: 2px solid #999;'>No Data</td>";
        $allNotNull = false; // Set flag to false as we found no data
    }

    // Close statement
    $stmt->close();
}

echo "</tr></table>";

$next_round = $current_card_number + 1;

?>

<?php if ($current_card_number == 1) : ?>
<br><br>
    <span class="infobox">
	    <span class="please">Please bookmark this page!</span><br>
        The draft will advance automatically<br>
        Refresh to see the current status
    </span><br>

<?php endif; ?>

<?php
} // end if ($current_card_number != 49)
?>

<?php

if ($current_card_number == 49) {

?>

<h2 class='green'>YOUR DRAFT IS NOW COMPLETE</h2>

Each player should now have Pixelborn code for their finalized deck<br /><br />

Just have them import into Pixelborn and start playing!<br>

<br /><hr />


<?php
}
?>

<br>

<a href="https://www.randomize.ink/draft/instructions_popout.php?draft_id=<?php echo $draft_id; ?>&player_count=<?php echo $player_count; ?>" target="_blank">Instructions</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="red" href="delete_draft.php?draft_id=<?php echo $draft_id; ?>" onclick="return confirmDelete();">- Delete Draft #<?php echo $draft_id; ?> -</a><br><br>

<script>
    function confirmDelete() {
        if (confirm("Are you sure you want to delete this draft and all of its data?")) {
            // User confirmed, proceed with deletion
            return true; // Allow the link to navigate to delete_draft.php?draft_id=xxx
        } else {
            // User canceled, prevent the default link behavior
            return false; // Cancel the link navigation
        }
    }
</script>

</body>
</html>
