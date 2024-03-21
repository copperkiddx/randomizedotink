<?php

if(!empty($_POST['no_amber'])) {
	$sql_uninkable .= 'AND color != "Amber" ';
}

if(!empty($_POST['no_amethyst'])) {
	$sql_uninkable .= 'AND color != "Amethyst" ';
}

if(!empty($_POST['no_emerald'])) {
	$sql_uninkable .= 'AND color != "Emerald" ';
}

if(!empty($_POST['no_ruby'])) {
	$sql_uninkable .= 'AND color != "Ruby" ';
}

if(!empty($_POST['no_sapphire'])) {
	$sql_uninkable .= 'AND color != "Sapphire" ';
}

if(!empty($_POST['no_steel'])) {
	$sql_uninkable .= 'AND color != "Steel" ';
}

if(!empty($_POST['no_actions'])) {
	$sql_uninkable .= 'AND type != "Action" ';
}

if(!empty($_POST['no_items'])) {
	$sql_uninkable .= 'AND type != "Item" ';
}

if(!empty($_POST['no_locations'])) {
	$sql_uninkable .= 'AND type != "Location" ';
}

if(!empty($_POST['no_songs'])) {
	$sql_uninkable .= 'AND type != "Song" AND type != "Action - Song" ';
}

if(!empty($_POST['no_shift'])) {
	$sql_uninkable .= 'AND shift != "1" ';
}

if(!empty($_POST['no_evasive'])) {
	$sql_uninkable .= 'AND evasive != "1" ';
}

if(!empty($_POST['no_reckless'])) {
	$sql_uninkable .= 'AND reckless != "1" ';
}

if(!empty($_POST['no_resist'])) {
	$sql_uninkable .= 'AND resist != "1" ';
}

if(!empty($_POST['no_ward'])) {
	$sql_uninkable .= 'AND ward != "1" ';
}

if(!empty($_POST['no_support'])) {
	$sql_uninkable .= 'AND support != "1" ';
}

if(!empty($_POST['no_singer'])) {
	$sql_uninkable .= 'AND singer != "1" ';
}

if(!empty($_POST['no_rush'])) {
	$sql_uninkable .= 'AND rush != "1" ';
}

if(!empty($_POST['no_bodyguard'])) {
	$sql_uninkable .= 'AND bodyguard != "1" ';
}

if(!empty($_POST['no_challenger'])) {
	$sql_uninkable .= 'AND challenger != "1" ';
}

if(!empty($_POST['no_1_ink'])) {
	$sql_uninkable .= 'AND cost != "1" ';
}

if(!empty($_POST['no_2_ink'])) {
	$sql_uninkable .= 'AND cost != "2" ';
}

if(!empty($_POST['no_3_ink'])) {
	$sql_uninkable .= 'AND cost != "3" ';
}

if(!empty($_POST['no_4_ink'])) {
	$sql_uninkable .= 'AND cost != "4" ';
}

if(!empty($_POST['no_5_ink'])) {
	$sql_uninkable .= 'AND cost != "5" ';
}

if(!empty($_POST['no_6_ink'])) {
	$sql_uninkable .= 'AND cost != "6" ';
}

if(!empty($_POST['no_7_ink'])) {
	$sql_uninkable .= 'AND cost != "7" ';
}

if(!empty($_POST['no_8_ink'])) {
	$sql_uninkable .= 'AND cost != "8" ';
}

if(!empty($_POST['no_9_ink'])) {
	$sql_uninkable .= 'AND cost != "9" ';
}

if(!empty($_POST['no_0_lore'])) {
	$sql_uninkable .= 'AND lore != "0" ';
}

if(!empty($_POST['no_1_lore'])) {
	$sql_uninkable .= 'AND lore != "1" ';
}

if(!empty($_POST['no_2_lore'])) {
	$sql_uninkable .= 'AND lore != "2" ';
}

if(!empty($_POST['no_3_lore'])) {
	$sql_uninkable .= 'AND lore != "3" ';
}

if(!empty($_POST['no_4_lore'])) {
	$sql_uninkable .= 'AND lore != "4" ';
}

if(!empty($_POST['no_triggers'])) {
	$sql_uninkable .= 'AND trigger_onplay != "1" ';
}

if(!empty($_POST['no_series1'])) {
	$sql_uninkable .= 'AND series != "TFC" ';
}

if(!empty($_POST['no_series2'])) {
	$sql_uninkable .= 'AND series != "ROTF" ';
}

if(!empty($_POST['no_series3'])) {
	$sql_uninkable .= 'AND series != "ITI" ';
}

if(!empty($_POST['no_uninkables'])) {
	$sql_uninkable .= 'AND inkable != "0" ';
}

if(!empty($_POST['no_commons'])) {
	$sql_uninkable .= 'AND rarity != "Common" ';
}

if(!empty($_POST['no_uncommons'])) {
	$sql_uninkable .= 'AND rarity != "Uncommon" ';
}

if(!empty($_POST['no_rares'])) {
	$sql_uninkable .= 'AND rarity != "Rare" ';
}

if(!empty($_POST['no_superrares'])) {
	$sql_uninkable .= 'AND rarity != "Super Rare" ';
}

if(!empty($_POST['no_legendaries'])) {
	$sql_uninkable .= 'AND rarity != "Legendary" ';
}

if(!empty($_POST['no_awnw'])) {
	$sql_uninkable .= 'AND name != "A Whole New World" ';
}

if(!empty($_POST['no_be_prepared'])) {
	$sql_uninkable .= 'AND name != "Be Prepared" ';
}

if(!empty($_POST['no_dragon_fire'])) {
	$sql_uninkable .= 'AND name != "Dragon Fire" ';
}

if(!empty($_POST['no_ursulas_cauldron'])) {
	$sql_uninkable .= 'AND name != "Ursula\'s Cauldron" ';
}

?>