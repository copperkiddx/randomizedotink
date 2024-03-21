<!DOCTYPE html>
<html>
<head>
    <title>Nuke Complete</title>
    <link rel="icon" type="image/x-icon" href="../images/randomize_ink.ico">
    <link rel="stylesheet" href="style_simdraft.css">
	<meta http-equiv="X-Content-Type-Options" content="nosniff">
</head>
<body>

<?php
include '../error_reporting.php';
include '../db_conn.php';

    $sql1 = "TRUNCATE TABLE decks;";
    $sql2 = "TRUNCATE TABLE drafts;";
    $sql3 = "TRUNCATE TABLE packs;";

    // Prepare and execute the statements
    if ($stmt1 = $conn->prepare($sql1)) {
        $stmt1->execute();
        $stmt1->close();
    } else {
        echo "Error preparing SQL statement 1: " . $conn->error;
    }

    if ($stmt2 = $conn->prepare($sql2)) {
        $stmt2->execute();
        $stmt2->close();
    } else {
        echo "Error preparing SQL statement 2: " . $conn->error;
    }

    if ($stmt3 = $conn->prepare($sql3)) {
        $stmt3->execute();
        $stmt3->close();
    } else {
        echo "Error preparing SQL statement 3: " . $conn->error;
    }

    // Log the action (you can implement logging logic here)

    echo "<br /><center>Tables reset successfully.</center>";

$conn->close();
?>

<br /><br />

<center>
	
<?php include '../linkbar.php'; ?>

</center>
</body>
</html>
