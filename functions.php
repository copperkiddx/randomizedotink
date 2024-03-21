<?php

//////////////////////////////////////////////////////////////////////////////////////////

function player_deck_size($draft_id, $player_number) {

    global $conn;

    $query = "
        SELECT 
          (CASE WHEN card_01 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_02 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_03 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_04 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_05 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_06 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_07 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_08 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_09 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_10 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_11 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_12 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_13 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_14 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_15 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_16 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_17 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_18 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_19 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_20 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_21 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_22 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_23 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_24 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_25 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_26 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_27 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_28 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_29 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_30 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_31 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_32 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_33 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_34 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_35 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_36 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_37 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_38 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_39 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_40 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_41 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_42 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_43 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_44 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_45 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_46 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_47 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_48 IS NOT NULL THEN 1 ELSE 0 END) AS player_deck_size
        FROM decks
        WHERE draft_id = ? AND player_number = ?";

    // Prepare and bind parameters to the SQL statement
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ii", $draft_id, $player_number);

        // Execute the query
        $stmt->execute();

        // Bind the result variable
        $stmt->bind_result($player_deck_size);

        // Fetch the value
        if ($stmt->fetch()) {
            return $player_deck_size;
        } else {
            return "No data found";
        }

        // Close the statement
        $stmt->close();
    } else {
        return "Error in query preparation";
    }
}

//////////////////////////////////////////////////////////////////////////////////////////

function player_remaining_pack_cards($draft_id, $player_number, $pack_number) {
    // Assuming $conn is your database connection variable
    global $conn;

    $query = "
        SELECT 
          (CASE WHEN card_01 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_02 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_03 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_04 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_05 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_06 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_07 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_08 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_09 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_10 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_11 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_12 IS NOT NULL THEN 1 ELSE 0 END) AS player_remaining_pack_cards
        FROM packs
        WHERE draft_id = ? AND player_number = ? AND pack_number = ?";

    // Prepare and bind parameters to the SQL statement
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("iii", $draft_id, $player_number, $pack_number);

        // Execute the query
        $stmt->execute();

        // Bind the result variable
        $stmt->bind_result($player_remaining_pack_cards);

        // Fetch the value
        if ($stmt->fetch()) {
            return $player_remaining_pack_cards;
        } else {
            return "No data found";
        }

        // Close the statement
        $stmt->close();
    } else {
        return "Error in query preparation";
    }
}

//////////////////////////////////////////////////////////////////////////////////////////

function next_player_remaining_pack_cards($draft_id, $next_player_number, $pack_number) {
    // Assuming $conn is your database connection variable
    global $conn;

    $query = "
        SELECT 
          (CASE WHEN card_01 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_02 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_03 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_04 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_05 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_06 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_07 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_08 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_09 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_10 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_11 IS NOT NULL THEN 1 ELSE 0 END) +
          (CASE WHEN card_12 IS NOT NULL THEN 1 ELSE 0 END) AS next_player_remaining_pack_cards
        FROM packs
        WHERE draft_id = ? AND player_number = ? AND pack_number = ?";

    // Prepare and bind parameters to the SQL statement
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("iii", $draft_id, $next_player_number, $pack_number);

        // Execute the query
        $stmt->execute();

        // Bind the result variable
        $stmt->bind_result($next_player_remaining_pack_cards);

        // Fetch the value
        if ($stmt->fetch()) {
            return $next_player_remaining_pack_cards;
        } else {
            return "No data found";
        }

        // Close the statement
        $stmt->close();
    } else {
        return "Error in query preparation";
    }
}

//////////////////////////////////////////////////////////////////////////////////////////

function getCurrentCardNumber($conn, $draft_id) {
    $stmt = $conn->prepare("SELECT current_card_number FROM drafts WHERE draft_id = ?");
    $stmt->bind_param("i", $draft_id);
    $stmt->execute();
    $stmt->bind_result($current_card_number);

    if ($stmt->fetch()) {
        $stmt->close();
        return $current_card_number;
    } else {
        $stmt->close();
        echo "No records found.";
        return 0; // Example default value
    }
}

function getPlayerCount($conn, $draft_id) {
    $stmt = $conn->prepare("SELECT player_count FROM drafts WHERE draft_id = ?");
    $stmt->bind_param("i", $draft_id);
    $stmt->execute();
    $stmt->bind_result($fetched_player_count);

    if ($stmt->fetch()) {
        $player_count = $fetched_player_count;
    } else {
        echo "No records found.";
        $player_count = 0; // Example default value
    }

    $stmt->close();

    return $player_count;
}

function getPlayerLoginInfo($conn, $draft_id) {
    $sql = "SELECT * FROM decks WHERE draft_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $draft_id); // Assuming draft_id is a string. Use "i" if it's an integer.
    $stmt->execute();

    $result = $stmt->get_result();
    $playerInfo = "";

    if ($result->num_rows > 0) {
        // Build player information
        while ($row = $result->fetch_assoc()) {
            $player_number = $row["player_number"];
            $player_code = $row["player_code"];
            
            // Append player information to the variable
            $playerInfo .= "Player $player_number\n";
            $playerInfo .= "Draft ID: $draft_id\n";
            $playerInfo .= "Player Code: $player_code\n";
            $playerInfo .= "https://www.randomize.ink/draft/player_login.php\n\n";
        }
    } else {
        $playerInfo = "No players found for draft ID: $draft_id";
    }

    $stmt->close();

    return $playerInfo;
}

function getPlayerLoginInfoSim($conn, $human_count, $draft_id) {
    $sql = "SELECT * FROM decks WHERE draft_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $draft_id); // Assuming draft_id is a string. Use "i" if it's an integer.
    $stmt->execute();

    $result = $stmt->get_result();
    $playerInfo = "";
    $playerCount = 0; // Counter to keep track of players processed

    if ($result->num_rows > 0) {
        // Build player information
        while ($row = $result->fetch_assoc()) {
            $player_number = $row["player_number"];
            $player_code = $row["player_code"];
            
            // Append player information to the variable
            $playerInfo .= "Player $player_number\n";
            $playerInfo .= "Draft ID: $draft_id\n";
            $playerInfo .= "Player Code: $player_code\n";
            $playerInfo .= "https://www.randomize.ink/simdraft/player_login.php\n\n";

            $playerCount++; // Increment the player counter

            if ($playerCount >= $human_count) {
                break; // Stop the loop after processing $human_count players
            }
        }
    } else {
        $playerInfo = "No players found for draft ID: $draft_id";
    }

    $stmt->close();

    return $playerInfo;
}

function getPlayerDeck($conn, $player_number, $draft_id) {
    // SQL statement with dynamic unions for each card
    $sql = "
    SELECT lc.*
    FROM (
        " . implode(" UNION ALL ", array_map(function($i) use ($player_number, $draft_id) {
            return "SELECT card_". str_pad($i, 2, "0", STR_PAD_LEFT) ." FROM decks WHERE player_number = $player_number AND draft_id = $draft_id";
        }, range(1, 48))) . "
    ) AS player_cards
    JOIN lorcana_cards lc ON player_cards.card_id = lc.id;";

    // Execute the query
    $result = $conn->query($sql);

    if ($result === false) {
        // Handle error - e.g., log it or return an error message
        return "Error in query execution: " . $conn->error;
    }

    // Fetch and return the results
    return $result->fetch_all(MYSQLI_ASSOC);
}

function displayOwnedCards($cards) {
    $current_pack = "";
    $image_count = 0;
    $checkbox_id = 0; // Initialize a counter for unique checkbox IDs
    $foil_counter = 0; // Counter for every 12th image

	include 'enchanted_cards.php';

    if ($cards && $cards->num_rows > 0) {
        echo "<div class='image-row'>"; // Start the first image row

        while ($row = $cards->fetch_assoc()) {
            if ($image_count == 6) {
                echo "</div><div class='image-row'>"; // Start a new row after 6 images
                $image_count = 0;
            }

            // Determine the correct image extension
            $foil_counter++;
            $image_name_raw = trim($row['image']); // Get the raw image name, trimmed

            // Logic for determining image extension
            if ($foil_counter % 12 == 0) {
                $random_chance = rand(0, 4);
                // Debug: Uncomment the line below for debugging
                // echo "<!-- Debug: Random Chance = $random_chance -->\n";

                if (in_array($image_name_raw, $enchanted_cards) && $random_chance === 0) {
                    $image_extension = ".webp"; // Set enchanted image extension
                    // Debug: Uncomment the line below for debugging
                    // echo "<!-- Debug: $image_name_raw is selected for enchanted -->\n";
                } else {
                    $image_extension = ".webp"; // Set foil image extension
                    // Debug: Uncomment the line below for debugging
                    // echo "<!-- Debug: $image_name_raw is selected for foil -->\n";
                }
            } else {
                $image_extension = ".webp"; // Default image extension
            }

            // Output each item with an image
            echo "<div class='image-container'>";
            $image_name = htmlspecialchars($image_name_raw, ENT_QUOTES);
            echo "<img src='../images/webp/" . $image_name . $image_extension . "' alt='" . htmlspecialchars($row['name'], ENT_QUOTES) . "' onclick='toggleCheckbox($checkbox_id)'>";
            echo "</div>";

            $image_count++;
            $checkbox_id++;
        }

        if ($image_count > 0) {
            echo "</div>"; // Close the last image row
        }

        echo "<br />";
    } else {
        echo "No drafted cards yet<br>";
    }
}

function getPlayerDeckForFinalSelection($conn, $player_number, $draft_id) {
    // Building the SQL query using UNION ALL for each card in the deck
    $cardFields = array_map(function($i) {
        return "SELECT card_" . str_pad($i, 2, "0", STR_PAD_LEFT) . " AS card_id";
    }, range(1, 48));
    $sql = "
    SELECT lc.*
    FROM (
        " . implode(" UNION ALL ", $cardFields) . " 
        WHERE player_number = ? AND draft_id = ?
    ) AS player_cards
    JOIN lorcana_cards lc ON player_cards.card_id = lc.id;";

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $player_number, $draft_id);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result === false) {
        // Handle error - e.g., log it or return an error message
        return "Error in query execution: " . $conn->error;
    }

    // Fetch and return the results
    return $result->fetch_all(MYSQLI_ASSOC);
}

function display48Cards($cards, $draft_id, $player_number) {
    $current_pack = "";
    $image_count = 0;
    $checkbox_id = 0; // Initialize a counter for unique checkbox IDs
    $foil_counter = 0; // Counter for every 12th image

	$enchanted_cards = array(
		"ROTF_003", "ROTF_025", "ROTF_035", "ROTF_047", "ROTF_159", "ROTF_070",
		"ROTF_088", "ROTF_110", "ROTF_126", "ROTF_137", "ROTF_181", "ROTF_189",
		"TFC_005", "TFC_021", "TFC_042", "TFC_051", "TFC_075", "TFC_088",
		"TFC_104", "TFC_114", "TFC_139", "TFC_142", "TFC_189", "TFC_193",
		"ITI_003", "ITI_007", "ITI_033", "ITI_042", "ITI_051", "ITI_065",
		"ITI_081", "ITI_091", "ITI_102", "ITI_105", "ITI_120", "ITI_136",
		"ITI_143", "ITI_154", "ITI_168", "ITI_182", "ITI_190", "ITI_195"
	);

    if (count($cards) > 0) {
        echo "<form id='checkboxForm' action='pixelborn_code.php' method='post'>";
        echo "<h1 class='redlink'>Choose 8 cards to remove</h1>";
        echo "<div class='image-row'>"; // Start the first image row

        foreach ($cards as $row) {
            if ($image_count == 6) {
                echo "</div><div class='image-row'>"; // Start a new row after 6 images
                $image_count = 0;
            }

            // Logic for determining image extension
            $foil_counter++;
            $image_name_raw = trim($row['image']); // Get the raw image name, trimmed
            // ... (rest of the logic for determining image extension)

            // Output each item with an image and an overlaid checkbox
            echo "<div class='image-container'>";
            $image_name = htmlspecialchars($image_name_raw, ENT_QUOTES);
            echo '<input type="checkbox" id="checkbox' . $checkbox_id . '" class="image-checkbox" name="item[]" value="' . htmlspecialchars($row['id'], ENT_QUOTES) . '" onchange="checkboxCounter()">';
            echo '<img src="../images/webp/' . $image_name . $image_extension . '" alt="' . htmlspecialchars($row['name'], ENT_QUOTES) . '" onclick="toggleCheckbox(' . $checkbox_id . ')">';
            echo "</div>";

            $image_count++;
            $checkbox_id++;
        }

        if ($image_count > 0) {
            echo "</div>"; // Close the last image row
        }

        echo "<br />";
        echo "<div>Selected card: <span id='checkedCount'>0</span>/8</div>";
        echo "<br />";
        echo "<input type='hidden' name='draft_id' value='" . $draft_id . "'>";
        echo "<input type='hidden' name='player_number' value='" . $player_number . "'>";
        echo "<input type='submit' id='submitButton' class='link-button' value='FINALIZE DECK' disabled>";
        echo "<br />";
        echo "</form>";

    } else {
        echo "0 results";
    }
}

function sendPushoverNotification($draft_id, $series) {
    $ch = curl_init("https://api.pushover.net/1/messages.json");

    $token = ""; // Replace with your actual token
    $user = ""; // Replace with your actual user key

    curl_setopt_array($ch, array(
        CURLOPT_POSTFIELDS => array(
            "token" => $token,
            "user" => $user,
            "message" => "Draft ($series)",
        ),
        CURLOPT_SAFE_UPLOAD => true,
        CURLOPT_RETURNTRANSFER => true,
    ));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        //echo 'Error:' . curl_error($ch);
    } else {
        //echo 'Response:' . $response;
    }

    curl_close($ch);
}

function sendSimPushoverNotification($draft_id, $series) {
    $ch = curl_init("https://api.pushover.net/1/messages.json");

    $token = ""; // Replace with your actual token
    $user = ""; // Replace with your actual user key

    curl_setopt_array($ch, array(
        CURLOPT_POSTFIELDS => array(
            "token" => $token,
            "user" => $user,
            "message" => "Sim Draft ($series)",
        ),
        CURLOPT_SAFE_UPLOAD => true,
        CURLOPT_RETURNTRANSFER => true,
    ));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        //echo 'Error:' . curl_error($ch);
    } else {
        //echo 'Response:' . $response;
    }

    curl_close($ch);
}

function insertNewDraft($conn, $timestamp, $human_count, $player_count, $series, $draft_id) {
    // Prepare the INSERT statement with round_card_count set to 0 and include human_count
    $stmt = $conn->prepare("INSERT INTO drafts (timestamp, human_count, player_count, series, draft_id, current_card_number, round_card_count) VALUES (?, ?, ?, ?, ?, ?, 0)");
    $current_card_number = 1; // Initialize the current card number

    // Bind parameters to the prepared statement including human_count
    $stmt->bind_param("siisii", $timestamp, $human_count, $player_count, $series, $draft_id, $current_card_number);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "<h2 class='green'>Draft #$draft_id successfully generated</h2>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
}

function insertPlayerDecks($conn, $draft_id, $player_count) {
    $stmt = $conn->prepare("INSERT INTO decks (draft_id, player_number, player_code) VALUES (?, ?, ?)");

    for ($player_number = 1; $player_number <= $player_count; $player_number++) {
        // Generate a random 4-digit player code
        $player_code = mt_rand(1000, 9999);

        // Bind parameters to the prepared statement
        $stmt->bind_param("iii", $draft_id, $player_number, $player_code);

        // Execute the statement and check for success
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
            // Optionally, break the loop if there's an error
            // break;
        }
    }

    // Close the prepared statement
    $stmt->close();
}

function getDeckForPixelborn($conn, $player_number, $draft_id) {
    // Building the SQL query using UNION ALL for each card in the deck
    $sqlParts = array();
    for ($i = 1; $i <= 48; $i++) {
        $cardField = "card_" . str_pad($i, 2, "0", STR_PAD_LEFT);
        $sqlParts[] = "SELECT $cardField AS card_id FROM decks WHERE player_number = $player_number AND draft_id = $draft_id";
    }
    $sql = "
    SELECT lc.id, lc.name
    FROM (" . implode(' UNION ALL ', $sqlParts) . ") AS player_cards
    JOIN lorcana_cards lc ON player_cards.card_id = lc.id;";

    // Execute the query
    $result = $conn->query($sql);

    if (!$result) {
        // Handle error
        return "Error: " . $conn->error;
    }

    // Fetch and return the results
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getPackCards($current_card_number, $player_number, $passing_player_number, $pack_number, $draft_id, $conn, $temp_player_number) {
    // Prepare the SQL query
    $sql = "
	SELECT lc.*, 1 AS card_order
	FROM lorcana_cards lc
	JOIN packs p ON lc.id = p.card_01 AND p.player_number = $temp_player_number AND p.pack_number = $pack_number AND draft_id = $draft_id
	
	UNION ALL
	
	SELECT lc.*, 2 AS card_order
	FROM lorcana_cards lc
	JOIN packs p ON lc.id = p.card_02 AND p.player_number = $temp_player_number AND p.pack_number = $pack_number AND draft_id = $draft_id
	
	UNION ALL
	
	SELECT lc.*, 3 AS card_order
	FROM lorcana_cards lc
	JOIN packs p ON lc.id = p.card_03 AND p.player_number = $temp_player_number AND p.pack_number = $pack_number AND draft_id = $draft_id
	
	UNION ALL
	
	SELECT lc.*, 4 AS card_order
	FROM lorcana_cards lc
	JOIN packs p ON lc.id = p.card_04 AND p.player_number = $temp_player_number AND p.pack_number = $pack_number AND draft_id = $draft_id
	
	UNION ALL
	
	SELECT lc.*, 5 AS card_order
	FROM lorcana_cards lc
	JOIN packs p ON lc.id = p.card_05 AND p.player_number = $temp_player_number AND p.pack_number = $pack_number AND draft_id = $draft_id
	
	UNION ALL
	
	SELECT lc.*, 6 AS card_order
	FROM lorcana_cards lc
	JOIN packs p ON lc.id = p.card_06 AND p.player_number = $temp_player_number AND p.pack_number = $pack_number AND draft_id = $draft_id
	
	UNION ALL
	
	SELECT lc.*, 7 AS card_order
	FROM lorcana_cards lc
	JOIN packs p ON lc.id = p.card_07 AND p.player_number = $temp_player_number AND p.pack_number = $pack_number AND draft_id = $draft_id
	
	UNION ALL
	
	SELECT lc.*, 8 AS card_order
	FROM lorcana_cards lc
	JOIN packs p ON lc.id = p.card_08 AND p.player_number = $temp_player_number AND p.pack_number = $pack_number AND draft_id = $draft_id
	
	UNION ALL
	
	SELECT lc.*, 9 AS card_order
	FROM lorcana_cards lc
	JOIN packs p ON lc.id = p.card_09 AND p.player_number = $temp_player_number AND p.pack_number = $pack_number AND draft_id = $draft_id
	
	UNION ALL
	
	SELECT lc.*, 10 AS card_order
	FROM lorcana_cards lc
	JOIN packs p ON lc.id = p.card_10 AND p.player_number = $temp_player_number AND p.pack_number = $pack_number AND draft_id = $draft_id
	
	UNION ALL
	
	SELECT lc.*, 11 AS card_order
	FROM lorcana_cards lc
	JOIN packs p ON lc.id = p.card_11 AND p.player_number = $temp_player_number AND p.pack_number = $pack_number AND draft_id = $draft_id
	
	UNION ALL
	
	SELECT lc.*, 12 AS card_order
	FROM lorcana_cards lc
	JOIN packs p ON lc.id = p.card_12 AND p.player_number = $temp_player_number AND p.pack_number = $pack_number AND draft_id = $draft_id
	ORDER BY card_order;
    ";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Execute the prepared statement (no need to bind parameters for SELECT queries)
    $stmt->execute();

    // Fetch the result (if necessary)
    $result = $stmt->get_result();
    $cards = $result->fetch_all(MYSQLI_ASSOC);

    // Close the prepared statement
    $stmt->close();

    // Return the cards
    return $cards;
}

function incrementRoundCardCount($conn, $draft_id) {
    // Begin a transaction
    mysqli_begin_transaction($conn);

    // Prepare the SELECT statement
    $selectStmt = mysqli_prepare($conn, "SELECT round_card_count FROM drafts WHERE draft_id = ?");
    if (!$selectStmt) {
        mysqli_rollback($conn);
        die("Prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($selectStmt, 'i', $draft_id);
    mysqli_stmt_execute($selectStmt);
    $result = mysqli_stmt_get_result($selectStmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $currentCount = $row['round_card_count'];
        $newCount = $currentCount + 1;

        // Prepare the UPDATE statement
        $updateStmt = mysqli_prepare($conn, "UPDATE drafts SET round_card_count = ? WHERE draft_id = ?");
        if (!$updateStmt) {
            mysqli_rollback($conn);
            die("Prepare failed: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($updateStmt, 'ii', $newCount, $draft_id);
        if (!mysqli_stmt_execute($updateStmt)) {
            mysqli_rollback($conn);
            die("Execute failed: " . mysqli_error($conn));
        }

        // Commit the transaction
        mysqli_commit($conn);

        // Close the statements
        mysqli_stmt_close($selectStmt);
        mysqli_stmt_close($updateStmt);

        return $newCount;
    } else {
        mysqli_rollback($conn);
        die("Draft ID not found.");
    }
}

function revCardAndCount($conn, $draft_id) {
    // Begin a transaction
    mysqli_begin_transaction($conn);

    // SELECT current_card_number FROM drafts WHERE draft_id = 94706307 AND round_card_count = 2 (example)
    $selectQuery = "SELECT current_card_number, player_count FROM drafts WHERE draft_id = ? AND round_card_count = player_count";
    $selectStmt = mysqli_prepare($conn, $selectQuery);
    if (!$selectStmt) {
        mysqli_rollback($conn);
        die("Prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($selectStmt, 'i', $draft_id);
    mysqli_stmt_execute($selectStmt);
    $result = mysqli_stmt_get_result($selectStmt);
	
    if ($row = mysqli_fetch_assoc($result)) {
        $newCurrentCardNumber = $row['current_card_number'] + 1;

    	// If it gets any results, all players have drafted so reset $round_card_count to 0 and rev $current_card_number by 1
        $updateStmt = mysqli_prepare($conn, "UPDATE drafts SET current_card_number = ?, round_card_count = 0 WHERE draft_id = ?");
        if (!$updateStmt) {
            mysqli_rollback($conn);
            die("Prepare failed: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($updateStmt, 'ii', $newCurrentCardNumber, $draft_id);
        if (!mysqli_stmt_execute($updateStmt)) {
            mysqli_rollback($conn);
            die("Execute failed: " . mysqli_error($conn));
        }

        mysqli_stmt_close($updateStmt);
    }

    mysqli_stmt_close($selectStmt);

    // Commit the transaction
    mysqli_commit($conn);
}

function calculatePassingPlayerNumber($current_card_number, $player_number, $player_count) {
    $passing_player_number = 0;

    // Round 1 - Receiving from player on your right
    if ($current_card_number >= 2 && $current_card_number <= 12) {
        $offset = $current_card_number - 1;
        $passing_player_number = $player_number + $offset;
        while ($passing_player_number > $player_count) {
            $passing_player_number -= $player_count;
        }
    }

    // Start of Round 2 - Card 13 needs its own rule because you are back to your own pack
    if ($current_card_number == 13) {
        $passing_player_number = $player_number;
    }

    // Round 2 - Receiving from player on your left
    if ($current_card_number >= 14 && $current_card_number <= 24) {
        $offset = $current_card_number - 13;
        $passing_player_number = $player_number - $offset;
        while ($passing_player_number < 1) {
            $passing_player_number += $player_count;
        }
    }

    // Start of Round 3 - Card 25 needs its own rule because you are back to your own pack
    if ($current_card_number == 25) {
        $passing_player_number = $player_number;
    }

    // Round 3 - Receiving from player on your right
    if ($current_card_number >= 26 && $current_card_number <= 36) {
        $offset = $current_card_number - 25;
        $passing_player_number = $player_number + $offset;
        while ($passing_player_number > $player_count) {
            $passing_player_number -= $player_count;
        }
    }

    // Start of Round 4 - Card 37 needs its own rule because you are back to your own pack
    if ($current_card_number == 37) {
        $passing_player_number = $player_number;
    }

    // Round 4 - Receiving from player on your left
    if ($current_card_number >= 38 && $current_card_number <= 48) {
        $offset = $current_card_number - 37;
        $passing_player_number = $player_number - $offset;
        while ($passing_player_number < 1) {
            $passing_player_number += $player_count;
        }
    }

    return $passing_player_number;
}

function getRandomSimCard($conn, $ppn, $pack_number, $draft_id) {
    $sql = "WITH RECURSIVE num AS (
        SELECT 1 AS n
        UNION ALL
        SELECT n + 1 FROM num WHERE n < 12
    ),
    cards AS (
        SELECT
            CASE
                WHEN card_10 IS NOT NULL THEN card_10
                WHEN card_11 IS NOT NULL THEN card_11
                WHEN card_12 IS NOT NULL THEN card_12
                WHEN n BETWEEN 1 AND 9 THEN
                    CASE n
                        WHEN 1 THEN card_01
                        WHEN 2 THEN card_02
                        WHEN 3 THEN card_03
                        WHEN 4 THEN card_04
                        WHEN 5 THEN card_05
                        WHEN 6 THEN card_06
                        WHEN 7 THEN card_07
                        WHEN 8 THEN card_08
                        WHEN 9 THEN card_09
                    END
            END AS card_value
        FROM
            packs, num
        WHERE
            player_number = ? AND
            pack_number = ? AND
            draft_id = ? AND
            (
                card_12 IS NOT NULL OR
                card_11 IS NOT NULL OR
                card_10 IS NOT NULL OR
                n BETWEEN 1 AND 9
            )
    )
    SELECT card_value FROM cards
    WHERE card_value IS NOT NULL
    ORDER BY 
        CASE 
            WHEN card_value IS NOT NULL THEN 0 
            ELSE 1 
        END, 
        RAND()
    LIMIT 1;";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $ppn, $pack_number, $draft_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $card_id = $row['card_value'];
        $result->close();
        return $card_id;
    } else {
        $result->close();
        return null;
    }
}

function getRandomSimCardBefore($conn, $ppn, $pack_number, $draft_id) {
    $sql = "WITH RECURSIVE num AS (
        SELECT 1 AS n
        UNION ALL
        SELECT n + 1 FROM num WHERE n < 12
    ),
    cards AS (
        SELECT
            CASE n
                WHEN 1 THEN card_01
                WHEN 2 THEN card_02
                WHEN 3 THEN card_03
                WHEN 4 THEN card_04
                WHEN 5 THEN card_05
                WHEN 6 THEN card_06
                WHEN 7 THEN card_07
                WHEN 8 THEN card_08
                WHEN 9 THEN card_09
                WHEN 10 THEN card_10
                WHEN 11 THEN card_11
                WHEN 12 THEN card_12
            END AS card_value
        FROM
            packs, num
        WHERE
            player_number = ? AND
            pack_number = ? AND
            draft_id = ? AND
            CASE n
                WHEN 1 THEN card_01
                WHEN 2 THEN card_02
                WHEN 3 THEN card_03
                WHEN 4 THEN card_04
                WHEN 5 THEN card_05
                WHEN 6 THEN card_06
                WHEN 7 THEN card_07
                WHEN 8 THEN card_08
                WHEN 9 THEN card_09
                WHEN 10 THEN card_10
                WHEN 11 THEN card_11
                WHEN 12 THEN card_12
            END IS NOT NULL
    )
    SELECT card_value FROM cards
    ORDER BY RAND()
    LIMIT 1;";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $ppn, $pack_number, $draft_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $card_id = $row['card_value'];
        $result->close();
        return $card_id;
    } else {
        $result->close();
        return null;
    }
}

function getHumanCount($conn, $draft_id) {
    $stmt = $conn->prepare("SELECT human_count FROM drafts WHERE draft_id = ?");
    $stmt->bind_param("i", $draft_id);
    $stmt->execute();
    $stmt->bind_result($fetched_human_count);

    if ($stmt->fetch()) {
        $human_count = $fetched_human_count;
    } else {
        echo "No records found.";
        $human_count = 0; // Example default value
    }

    $stmt->close();

    return $human_count;
}

?>
