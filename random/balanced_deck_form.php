<!DOCTYPE html>
<html>
<head>
    <title>Balanced Random Deck Generator</title>
    <link rel="icon" type="image/x-icon" href="../images/randomize_ink.ico">
    <link rel="stylesheet" href="../style_main.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>

<center>
<a href="."><img src="../images/randomize_ink.png" height=100 border=0></a>
<h2>Balanced Random Deck Generator</h2>
</center>

<div class="form-container">
<form id="deckform" action="balanced_deck.php" method="post">

<h3>INK COLORS (Choose 2)</h3>
<div class="checkbox-container">
<input type="checkbox" name="ink_choice[]" value="Amber"> Amber<br />
<input type="checkbox" name="ink_choice[]" value="Amethyst"> Amethyst<br />
<input type="checkbox" name="ink_choice[]" value="Emerald"> Emerald<br />
<input type="checkbox" name="ink_choice[]" value="Ruby"> Ruby<br />
<input type="checkbox" name="ink_choice[]" value="Sapphire"> Sapphire<br />
<input type="checkbox" name="ink_choice[]" value="Steel"> Steel<br />
</div>

<br />

<h3>CARD SETS</h3>
<div class="checkbox-container">
    <input type="checkbox" name="set_choice[]" value="TFC"> The First Chapter<br />
    <input type="checkbox" name="set_choice[]" value="ROTF"> Rise of the Floodborn<br />
    <input type="checkbox" name="set_choice[]" value="ITI"> Into the Inklands<br />
    <input type="checkbox" name="set_choice[]" value="ALL"> All Sets<br />
</div>

<br />

<div align="center" class="g-recaptcha" data-sitekey="6Lf1LzkpAAAAAFDbmN_U_GaqzDOiidb1L_5IfzyH"></div>

<br />
<a href="#" id="shuffle-inks">Click to Shuffle Inks</a> <!-- Shuffle link -->
<br /><br />

<input type="submit" value="GENERATE DECK" class="link-button">
<br /><br />
</form>

<script>

// JavaScript for randomizing ink selections
document.getElementById('shuffle-inks').addEventListener('click', function(e) {
    e.preventDefault();
    var inkCheckboxes = document.querySelectorAll('input[name="ink_choice[]"]');
    var randomChoices = Array.from(inkCheckboxes).sort(() => 0.5 - Math.random()).slice(0, 2);
    
    // Uncheck all ink checkboxes
    inkCheckboxes.forEach(cb => cb.checked = false);

    // Check the randomly selected ink checkboxes
    randomChoices.forEach(cb => cb.checked = true);
});

// JavaScript to enforce selecting exactly 2 checkboxes for INK COLORS
var inkCheckboxes = document.querySelectorAll('input[name="ink_choice[]"]');
var maxInkAllowed = 2;

inkCheckboxes.forEach(function(inkCheckbox) {
    inkCheckbox.addEventListener('change', function() {
        var checkedInkCheckboxes = document.querySelectorAll('input[name="ink_choice[]"]:checked');
        
        if (checkedInkCheckboxes.length > maxInkAllowed) {
            this.checked = false;
        }
    });
});

// Updated JavaScript for CARD SETS selection logic
var setCheckboxes = document.querySelectorAll('input[name="set_choice[]"]');

setCheckboxes.forEach(function(setCheckbox) {
    setCheckbox.addEventListener('change', function() {
        if (this.value === "ALL" && this.checked) {
            // Uncheck all other checkboxes if "All Sets" is checked
            setCheckboxes.forEach(function(box) {
                if (box.value !== "ALL") box.checked = false;
            });
        } else if (this.value !== "ALL") {
            // Uncheck "All Sets" if any other option is checked
            document.querySelector('input[name="set_choice[]"][value="ALL"]').checked = false;
        }
    });
});

// Updated JavaScript for form submission, including validation for ink colors
document.querySelector("form").addEventListener("submit", function(event){
    var recaptcha = document.querySelector('.g-recaptcha-response').value;
    if (recaptcha === "") {
        event.preventDefault();
        alert("Please check the CAPTCHA box.");
        return; // Exit early if CAPTCHA is not filled
    }
    
    // Validate selected ink colors
    var checkedInkCheckboxes = document.querySelectorAll('input[name="ink_choice[]"]:checked').length;
    if (checkedInkCheckboxes !== 2) {
        event.preventDefault(); // Prevent form submission
        alert("Please select exactly 2 ink colors.");
        return; // Exit early
    }
    
    // If all validations pass, form will be submitted
});

</script>

</div>
<br />
<?php include '../linkbar.php';?>
</body>
</html>
