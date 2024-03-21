<?php

include 'error_reporting.php';
include 'db_conn.php';

try {
    // Begin transaction
    $conn->begin_transaction();

    // SQL to get draft_ids of drafts older than 7 days
    $sql = "SELECT draft_id FROM drafts WHERE timestamp < NOW() - INTERVAL 7 DAY";
    $result = $conn->query($sql);

    $draftIds = [];
    while ($row = $result->fetch_assoc()) {
        $draftIds[] = $row['draft_id'];
    }

    if (count($draftIds) > 0) {
        // Convert draft IDs to a comma-separated string for SQL IN clause
        $draftIdStr = implode(',', $draftIds);

        // SQL to delete entries from decks, drafts, and packs tables
        $sqlDecks = "DELETE FROM decks WHERE draft_id IN ($draftIdStr)";
        $sqlDrafts = "DELETE FROM drafts WHERE draft_id IN ($draftIdStr)";
        $sqlPacks = "DELETE FROM packs WHERE draft_id IN ($draftIdStr)";

        // Execute deletion queries
        $conn->query($sqlDecks);
        $conn->query($sqlDrafts);
        $conn->query($sqlPacks);
    }

    // Commit transaction
    $conn->commit();
    echo "Deletion successful for drafts older than 7 days.";
} catch (Exception $e) {
    // Rollback transaction in case of error
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

// Close connection
$conn->close();
?>

