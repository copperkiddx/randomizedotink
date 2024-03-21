<?php
include '../db_conn.php';

if (isset($_GET['draft_id'])) {
    $draft_id = $_GET['draft_id'];
    
    // Create prepared statements
    $query1 = "DELETE FROM decks WHERE draft_id = ?";
    $query2 = "DELETE FROM drafts WHERE draft_id = ?";
    $query3 = "DELETE FROM packs WHERE draft_id = ?";
    
    // Prepare the statements
    $stmt1 = mysqli_prepare($conn, $query1);
    $stmt2 = mysqli_prepare($conn, $query2);
    $stmt3 = mysqli_prepare($conn, $query3);
    
    // Bind the parameters
    mysqli_stmt_bind_param($stmt1, "i", $draft_id);
    mysqli_stmt_bind_param($stmt2, "i", $draft_id);
    mysqli_stmt_bind_param($stmt3, "i", $draft_id);
    
    // Execute the statements
    $result1 = mysqli_stmt_execute($stmt1);
    $result2 = mysqli_stmt_execute($stmt2);
    $result3 = mysqli_stmt_execute($stmt3);
    
    // Check if the deletion was successful
    if ($result1 && $result2 && $result3) {
        // Redirect to index.php upon successful deletion
        header("Location: draft_delete_success.php");
        exit(); // Make sure to exit to prevent further execution
    } else {
        echo "Error deleting records: " . mysqli_error($conn);
    }
    
    // Close the statements
    mysqli_stmt_close($stmt1);
    mysqli_stmt_close($stmt2);
    mysqli_stmt_close($stmt3);
    
    // Close the database connection
    mysqli_close($conn);
}

?>
