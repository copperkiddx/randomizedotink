<?php

if(!empty($_POST['no_amber'])) {
	$sql_inkable .= 'AND color != "Amber" ';
}

if(!empty($_POST['no_amethyst'])) {
	$sql_inkable .= 'AND color != "Amethyst" ';
}

if(!empty($_POST['no_emerald'])) {
	$sql_inkable .= 'AND color != "Emerald" ';
}

if(!empty($_POST['no_ruby'])) {
	$sql_inkable .= 'AND color != "Ruby" ';
}

if(!empty($_POST['no_sapphire'])) {
	$sql_inkable .= 'AND color != "Sapphire" ';
}

if(!empty($_POST['no_steel'])) {
	$sql_inkable .= 'AND color != "Steel" ';
}

if(!empty($_POST['no_actions'])) {
	$sql_inkable .= 'AND type != "Action" ';
}

if(!empty($_POST['no_items'])) {
	$sql_inkable .= 'AND type != "Item" ';
}

if(!empty($_POST['no_locations'])) {
	$sql_inkable .= 'AND type != "Location" ';
}

if(!empty($_POST['no_songs'])) {
	$sql_inkable .= 'AND type != "Song" AND type != "Action - Song" ';
}

if(!empty($_POST['no_shift'])) {
	$sql_inkable .= 'AND shift != "1" ';
}

if(!empty($_POST['no_evasive'])) {
	$sql_inkable .= 'AND evasive != "1" ';
}

if(!empty($_POST['no_reckless'])) {
	$sql_inkable .= 'AND reckless != "1" ';
}

if(!empty($_POST['no_resist'])) {
	$sql_inkable .= 'AND resist != "1" ';
}

if(!empty($_POST['no_ward'])) {
	$sql_inkable .= 'AND ward != "1" ';
}

if(!empty($_POST['no_support'])) {
	$sql_inkable .= 'AND support != "1" ';
}

if(!empty($_POST['no_singer'])) {
	$sql_inkable .= 'AND singer != "1" ';
}

if(!empty($_POST['no_rush'])) {
	$sql_inkable .= 'AND rush != "1" ';
}

if(!empty($_POST['no_bodyguard'])) {
	$sql_inkable .= 'AND bodyguard != "1" ';
}

if(!empty($_POST['no_challenger'])) {
	$sql_inkable .= 'AND challenger != "1" ';
}

if(!empty($_POST['no_1_ink'])) {
	$sql_inkable .= 'AND cost != "1" ';
}

if(!empty($_POST['no_2_ink'])) {
	$sql_inkable .= 'AND cost != "2" ';
}

if(!empty($_POST['no_3_ink'])) {
	$sql_inkable .= 'AND cost != "3" ';
}

if(!empty($_POST['no_4_ink'])) {
	$sql_inkable .= 'AND cost != "4" ';
}

if(!empty($_POST['no_5_ink'])) {
	$sql_inkable .= 'AND cost != "5" ';
}

if(!empty($_POST['no_6_ink'])) {
	$sql_inkable .= 'AND cost != "6" ';
}

if(!empty($_POST['no_7_ink'])) {
	$sql_inkable .= 'AND cost != "7" ';
}

if(!empty($_POST['no_8_ink'])) {
	$sql_inkable .= 'AND cost != "8" ';
}

if(!empty($_POST['no_9_ink'])) {
	$sql_inkable .= 'AND cost != "9" ';
}

if(!empty($_POST['no_0_lore'])) {
	$sql_inkable .= 'AND lore != "0" ';
}

if(!empty($_POST['no_1_lore'])) {
	$sql_inkable .= 'AND lore != "1" ';
}

if(!empty($_POST['no_2_lore'])) {
	$sql_inkable .= 'AND lore != "2" ';
}

if(!empty($_POST['no_3_lore'])) {
	$sql_inkable .= 'AND lore != "3" ';
}

if(!empty($_POST['no_4_lore'])) {
	$sql_inkable .= 'AND lore != "4" ';
}

if(!empty($_POST['no_triggers'])) {
	$sql_inkable .= 'AND trigger_onplay != "1" ';
}

if(!empty($_POST['no_series1'])) {
	$sql_inkable .= 'AND series != "TFC" ';
}

if(!empty($_POST['no_series2'])) {
	$sql_inkable .= 'AND series != "ROTF" ';
}

if(!empty($_POST['no_series3'])) {
	$sql_inkable .= 'AND series != "ITI" ';
}

if(!empty($_POST['no_uninkables'])) {
	$sql_inkable .= 'AND inkable != "0" ';
}

if(!empty($_POST['no_commons'])) {
	$sql_inkable .= 'AND rarity != "Common" ';
}

if(!empty($_POST['no_uncommons'])) {
	$sql_inkable .= 'AND rarity != "Uncommon" ';
}

if(!empty($_POST['no_rares'])) {
	$sql_inkable .= 'AND rarity != "Rare" ';
}

if(!empty($_POST['no_superrares'])) {
	$sql_inkable .= 'AND rarity != "Super Rare" ';
}

if(!empty($_POST['no_legendaries'])) {
	$sql_inkable .= 'AND rarity != "Legendary" ';
}

if(!empty($_POST['no_awnw'])) {
	$sql_inkable .= 'AND name != "A Whole New World" ';
}

if(!empty($_POST['no_be_prepared'])) {
	$sql_inkable .= 'AND name != "Be Prepared" ';
}

if(!empty($_POST['no_dragon_fire'])) {
	$sql_inkable .= 'AND name != "Dragon Fire" ';
}

if(!empty($_POST['no_ursulas_cauldron'])) {
	$sql_inkable .= 'AND name != "Ursula\'s Cauldron" ';
}

?>