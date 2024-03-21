<!DOCTYPE html>
<html>
<head>
    <title>Custom Random Deck Generator</title>
    <link rel="icon" type="image/x-icon" href="../images/randomize_ink.ico">
    <link rel="stylesheet" href="../style_main.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>

<center>
<a href="."><img src="../images/randomize_ink.png" height=100 border=0></a>
<h2>Custom Random Deck Generator</h2>
</center>

<div class="form-container">

    <form id="deckform" action="deck_results.php" method="post">

<h3>DECK SIZE</h3>
<div class="checkbox-container">
<input type="radio" id="size60" name="deck_size" value="60" checked>
<label for="size60">60 Cards</label><br>
<input type="radio" id="size50" name="deck_size" value="50">
<label for="size50">50 Cards</label><br>
<input type="radio" id="size40" name="deck_size" value="40">
<label for="size40">40 Cards</label>
</div>
<br />

<h3>INK EXCLUSIONS</h3>
<div class="checkbox-container">
<input type="checkbox" name="no_amber[]" value="1"> Amber<br />
<input type="checkbox" name="no_amethyst[]" value="1"> Amethyst<br />
<input type="checkbox" name="no_emerald[]" value="1"> Emerald<br />
<input type="checkbox" name="no_ruby[]" value="1"> Ruby<br />
<input type="checkbox" name="no_sapphire[]" value="1"> Sapphire<br />
<input type="checkbox" name="no_steel[]" value="1"> Steel<br /><br />
</div>

<h3>TYPE EXCLUSIONS</h3>
<div class="checkbox-container">
<input type="checkbox" name="no_actions[]" value="1"> Actions<br />
<input type="checkbox" name="no_items[]" value="1"> Items<br />
<input type="checkbox" name="no_locations[]" value="1"> Locations<br />
<input type="checkbox" name="no_songs[]" value="1"> Songs<br /><br />
</div>

<h3>KEYWORD EXCLUSIONS</h3>
<div class="checkbox-container">
<input type="checkbox" name="no_bodyguard[]" value="1"> Bodyguard<br />
<input type="checkbox" name="no_challenger[]" value="1"> Challenger<br />
<input type="checkbox" name="no_evasive[]" value="1"> Evasive<br />
<input type="checkbox" name="no_reckless[]" value="1"> Reckless<br />
<input type="checkbox" name="no_resist[]" value="1"> Resist<br />
<input type="checkbox" name="no_rush[]" value="1"> Rush<br />
<input type="checkbox" name="no_shift[]" value="1"> Shift<br />
<input type="checkbox" name="no_singer[]" value="1"> Singer<br />
<input type="checkbox" name="no_support[]" value="1"> Support<br />
<input type="checkbox" name="no_ward[]" value="1"> Ward<br /><br />
</div>

<h3>INK COST EXCLUSIONS</h3>
<div class="checkbox-container">
<input type="checkbox" name="no_1_ink[]" value="1"> 1 Ink Cost<br />
<input type="checkbox" name="no_2_ink[]" value="1"> 2 Ink Cost<br />
<input type="checkbox" name="no_3_ink[]" value="1"> 3 Ink Cost<br />
<input type="checkbox" name="no_4_ink[]" value="1"> 4 Ink Cost<br />
<input type="checkbox" name="no_5_ink[]" value="1"> 5 Ink Cost<br />
<input type="checkbox" name="no_6_ink[]" value="1"> 6 Ink Cost<br />
<input type="checkbox" name="no_7_ink[]" value="1"> 7 Ink Cost<br />
<input type="checkbox" name="no_8_ink[]" value="1"> 8 Ink Cost<br />
<input type="checkbox" name="no_9_ink[]" value="1"> 9 Ink Cost<br /><br />
</div>

<h3>LORE EXCLUSIONS</h3>
<div class="checkbox-container">
<input type="checkbox" name="no_0_lore[]" value="1"> 0 Lore Questers<br />
<input type="checkbox" name="no_1_lore[]" value="1"> 1 Lore Questers<br />
<input type="checkbox" name="no_2_lore[]" value="1"> 2 Lore Questers<br />
<input type="checkbox" name="no_3_lore[]" value="1"> 3 Lore Questers<br />
<input type="checkbox" name="no_4_lore[]" value="1"> 4 Lore Questers<br /><br />
</div>

<h3>SET EXCLUSIONS</h3>
<div class="checkbox-container">
<input type="checkbox" name="no_series1[]" value="1"> The First Chapter<br />
<input type="checkbox" name="no_series2[]" value="1"> Rise of the Floodborn<br />
<input type="checkbox" name="no_series3[]" value="1"> Into the Inklands<br /><br />
</div>

<h3>RARITY EXCLUSIONS</h3>
<div class="checkbox-container">
<input type="checkbox" name="no_commons[]" value="1"> Commons<br />
<input type="checkbox" name="no_uncommons[]" value="1"> Uncommons<br />
<input type="checkbox" name="no_rares[]" value="1"> Rares<br />
<input type="checkbox" name="no_superrares[]" value="1"> Super Rares<br />
<input type="checkbox" name="no_legendaries[]" value="1"> Legendaries<br /><br />
</div>

<h3>MISC EXCLUSIONS</h3>
<div class="checkbox-container">
<input type="checkbox" name="no_triggers[]" value="1"> Trigger Characters<br />
<input type="checkbox" name="no_uninkables[]" value="1"> Uninkables<br /><br />
</div>

<h3>BAN LIST</h3>
<div class="checkbox-container">
<input type="checkbox" name="no_awnw[]" value="1"> "A Whole New World"<br />
<input type="checkbox" name="no_be_prepared[]" value="1"> "Be Prepared"<br />
<input type="checkbox" name="no_dragon_fire[]" value="1"> "Dragon Fire"<br />
<input type="checkbox" name="no_ursulas_cauldron[]" value="1"> "Ursula's Cauldron"<br /><br />
</div>

<br />

<div align="center" class="g-recaptcha" data-sitekey="6Lf1LzkpAAAAAFDbmN_U_GaqzDOiidb1L_5IfzyH"></div>

<br /><br />

<input type="submit" value="GENERATE DECK" class="link-button">

        <br /><br />
    </form>

</div>

<br />

<?php include '../linkbar.php';?>
   
<script>
document.querySelector("form").addEventListener("submit", function(event){
    var recaptcha = document.querySelector('.g-recaptcha-response').value;
    if (recaptcha === "") {
        event.preventDefault();
        alert("Please check the CAPTCHA box.");
    }
});
</script>
    
</body>
</html>
