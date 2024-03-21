<?php

// Random count of unique inkable=0 cards
$inkable0Count = rand(10, 15);

// Fetching inkable=0 cards
$sql_uninkable = "SELECT name FROM lorcana_cards WHERE inkable = 0 ";

include 'sql_uninkable.php';

$sql_uninkable .= 'ORDER BY RAND() LIMIT ' . $inkable0Count;

$result0 = $conn->query($sql_uninkable);

$deck = [];
while ($row = $result0->fetch_assoc()) {
    $deck[] = $row['name']; // Add each inkable=0 card once
}

// Remaining slots for inkable=1 cards
$remainingSlots = 60 - count($deck);

// Fetching a pool of inkable=1 cards
// Exclude Te Ka - Heartless (because of Pixelborn bug)
$sql_inkable = "SELECT name FROM lorcana_cards WHERE inkable = 1 and id != 160 ";

include 'sql_inkable.php';

$sql_inkable .= 'ORDER BY RAND()';

$result1 = $conn->query($sql_inkable);

while (count($deck) < $deckSize) {
    $row = $result1->fetch_assoc();
    if (!$row) {
        // Re-run the query if all rows are exhausted
        $result1 = $conn->query($sql_inkable);
        $row = $result1->fetch_assoc();
    }

    // Randomly decide to add the card as a pair or a triple
    $addTriple = (rand(0, 1) == 0) && (count($deck) <= 60 - 3) && ($remainingSlots > 1);
    $numberOfCopies = $addTriple ? 3 : 2;

    // Add the card to the deck
    for ($i = 0; $i < $numberOfCopies; $i++) {
        if (count($deck) < 60) {
            $deck[] = $row['name'];
        }
    }
}

?>