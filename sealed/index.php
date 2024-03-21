<!DOCTYPE html>
<html>
<head>
    <title>Sealed Event</title>
    <link rel="icon" type="image/x-icon" href="../images/randomize_ink.ico">
    <link rel="stylesheet" href="../style_main.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>

<center>

<a href="https://www.randomize.ink/"><img src="../images/randomize_ink.png" height=100 border=0></a>

<br />

<h2>Sealed Event</h2>

<form id="sealedform" action="process_form.php" method="post">
	<input type="radio" name="option" value="option1"> 6 Packs of "The First Chapter"<br />
	<input type="radio" name="option" value="option2"> 6 Packs of "Rise of the Floodborn"<br />
	<input type="radio" name="option" value="option3"> 6 Packs of "Into the Inklands"<br />
	<input type="radio" name="option" value="option4"> 2 Packs each of set<br />
	<br />
    <div class="g-recaptcha" data-sitekey="6Lf1LzkpAAAAAFDbmN_U_GaqzDOiidb1L_5IfzyH"></div>
	<br />
	<input type="submit" class="link-button" value="GENERATE PACKS">

</form>

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
    
</center>
</body>
</html>
