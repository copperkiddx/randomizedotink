<!DOCTYPE html>
<html>
<head>
    <title>Process Login</title>
    <link rel="icon" type="image/x-icon" href="../images/randomize_ink.ico">
    <link rel="stylesheet" href="style_draft.css">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
</head>
<body>

<?php
include '../error_reporting.php';
include '../db_conn.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $player_code = $_GET['player_code'] ?? '';
    $draft_id = $_GET['draft_id'] ?? '';
    $action = $_GET['action'] ?? '';

    // Define your SQL query with placeholders
    $sql = "SELECT player_number FROM decks WHERE draft_id = ? AND player_code = ?";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters to the placeholders
        $stmt->bind_param("ii", $draft_id, $player_code);

        // Execute the query
        if ($stmt->execute()) {
            // Get the result
            $result = $stmt->get_result();

            // Check if a row was found
            if ($result->num_rows === 1) {
                // Fetch the data
                $row = $result->fetch_assoc();
                $player_number = $row['player_number'];

                if ($action == 'display_pack') {
                    // Redirect to display_pack.php with the player_number and draft_id
                    header("Location: owned_cards.php?player_number=" . urlencode($player_number) . "&draft_id=" . urlencode($draft_id));
                    exit();
                }
            } else {
                // Handle case where no matching rows were found (Wrong player_code)
				echo 'Login failed. Please check your Draft ID and Player Code<br><br><a href="https://www.randomize.ink/draft/player_login.php">Back</a>';
            }
        } else {
            // Handle query execution error
            echo "Query execution failed: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // Handle statement preparation error
        echo "Statement preparation failed: " . $conn->error;
    }

    // Close the database connection when done
    $conn->close();
}
?>
</body>
</html>
