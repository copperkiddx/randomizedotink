<?php

$sql = "
SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_01 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_02 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_03 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_04 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_05 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_06 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_07 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_08 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_09 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_10 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_11 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_12 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_13 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_14 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_15 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_16 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_17 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_18 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_19 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_20 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_21 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_22 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_23 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_24 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_25 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_26 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_27 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_28 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_29 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_30 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_31 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_32 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_33 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_34 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_35 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_36 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_37 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_38 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_39 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_40 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_41 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_42 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_43 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_44 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_45 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_46 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_47 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id

UNION ALL

SELECT c.name
FROM decks d
JOIN lorcana_cards c ON d.card_48 = c.id
WHERE d.player_number = $player_number AND d.draft_id = $draft_id;

";

?>