<!DOCTYPE html>
<html>
<head>
    <title>Player Login</title>
    <link rel="icon" type="image/x-icon" href="../images/randomize_ink.ico">
    <link rel="stylesheet" href="style_draft.css">
	<meta http-equiv="X-Content-Type-Options" content="nosniff">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
    <style>
        /* Style for the text fields */
        input[type="number"],
        input[type="text"] {
            width: 50%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            margin-bottom: 10px;
            text-align: center; /* Center-align the text content */
        }

        /* Style for the labels */
        label {
            font-size: 16px;
            text-align: center; /* Center-align the text content */
        }
    </style>
</head>
<body>
<center>

<img src="../images/randomize_ink.png" width="100">

<h2>Player Login</h2>

<form action="process_login.php" method="get" style="text-align: center;">

    <label for="draft_id">Draft ID</label><br>
    <input type="text" id="draft_id" name="draft_id" pattern="\d{8}" title="Draft ID must be exactly 8 digits" style="width: 5em;" required><br><br>

    <label for="player_number">Player Code</label><br>
    <input type="number" id="player_code" name="player_code" min="1" max="9999" oninput="this.value = this.value.slice(0, 4)" style="width: 5em;" required><br><br>

    <input type="hidden" name="action" value="display_pack">

    <div class="g-recaptcha" data-sitekey="6Lf1LzkpAAAAAFDbmN_U_GaqzDOiidb1L_5IfzyH"></div>

    <br />

    <input type="submit" value="LOGIN" class="link-button">
</form>

<br />

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
