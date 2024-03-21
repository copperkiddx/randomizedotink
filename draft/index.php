<!DOCTYPE html>
<html>
<head>
    <title>Live Draft</title>
    <link rel="icon" type="image/x-icon" href="../images/randomize_ink.ico">
    <link rel="stylesheet" href="style_draft.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
    <style>
        /* Style for the dropdown box */
        select#player_count {
            width: 150px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Center-align the numbers within the dropdown */
        select#player_count option {
            text-align: center;
        }

        /* Style for the radio buttons */
        input[type="radio"] {
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #028acb;
            border-radius: 50%;
            outline: none;
            cursor: pointer;
            margin-right: 10px;
            vertical-align: middle; /* Align the radio button vertically in the middle */
        }

        /* Style for the radio button labels with slightly larger font size */
        input[type="radio"] + label {
            font-size: 20px; /* Adjust the font size as needed */
            vertical-align: middle; /* Align the label text vertically in the middle */
        }

        /* Style for the checked radio buttons */
        input[type="radio"]:checked {
            background-color: #028acb;
        }
    </style>
</head>
<body>
<center>

<a href="https://www.randomize.ink/"><img src="../images/randomize_ink.png" height=100 border=0></a>

<h2>Live Draft</h2>

<form action="draft_generation_results.php" method="post">
    <!-- Number of Players -->
    <label for="player_count">Number of Players</label><br><br>
    <select id="player_count" name="player_count" required>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8" selected>8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
    </select><br><br>

	<!-- Radio Buttons for Series Selection -->
	<input type="radio" id="tfc" name="series" value="TFC" required>
	<label for="tfc">The First Chapter</label><br>
	<input type="radio" id="roth" name="series" value="ROTF" required>
	<label for="rotf">Rise of the Floodborn</label><br>
	<input type="radio" id="iti" name="series" value="ITI" required>
	<label for="iti">Into the Inklands</label><br>
	<input type="radio" id="all" name="series" value="ALL" required>
	<label for="all">All Series</label><br><br>

    <div align="center" class="g-recaptcha" data-sitekey="6Lf1LzkpAAAAAFDbmN_U_GaqzDOiidb1L_5IfzyH"></div>
    
    <br />

    <!-- Hidden Timestamp -->
    <?php
    echo '<input type="hidden" name="timestamp" value="'.date('Y-m-d H:i:s').'">';
    ?>

    <!-- Submit Button -->
    <input type="submit" value="GENERATE DRAFT" class="link-button"><br>
</form>

<br />

<?php include '../linkbar.php'; ?>

</center>
	
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
