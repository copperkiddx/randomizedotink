<!DOCTYPE html>
<html>
<head>
    <title>Draft Your Next Card</title>
    <link rel="icon" type="image/x-icon" href="../images/randomize_ink.ico">
    <link rel="stylesheet" href="style_simdraft.css">
	<meta http-equiv="X-Content-Type-Options" content="nosniff">
</head>
<body>

<center>

<?php

// !!!! Determine $passing_player_number later on this page
// It is then passed to display_pack.php via redirect url variables

include '../error_reporting.php';
include '../db_conn.php';
include '../functions.php';

$draft_id = isset($_GET['draft_id']) ? (int)$_GET['draft_id'] : 0;
$player_number = isset($_GET['player_number']) ? (int)$_GET['player_number'] : 0;
$pack_number = isset($_GET['pack_number']) ? (int)$_GET['pack_number'] : 0;

include 'player_navbar.php';

echo '<br>';

$current_card_number = getCurrentCardNumber($conn, $draft_id);

$player_count = getPlayerCount($conn, $draft_id);

$player_deck_size = player_deck_size($draft_id, $player_number);

$passing_player_number = calculatePassingPlayerNumber($current_card_number, $player_number, $player_count);

if ($current_card_number > 48) {
    header('Location: deck_selection.php');
    exit;
}

if ($current_card_number == $player_deck_size + 1) {
    echo "Yes! Showing next pack...";
    header("Location: display_pack.php?draft_id=$draft_id&player_number=$player_number&passing_player_number=$passing_player_number&pack_number=$pack_number");
    exit();
} elseif ($player_deck_size == $current_card_number) {
    echo '<script>setTimeout(function() { window.location.reload(1); }, 3500);</script>';
    echo '<h1 class="red">This page will automatically refresh</h1>';
    echo '<h2>Waiting for other players to draft...</h2><br><br><div class="loader"></div>';
}

?>

</center>

</body>
</html>
