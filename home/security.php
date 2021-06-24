<?php include 'session.php'; 

	if (isset($_POST["delete"]) && $_POST["delete"] == '1') {
		deleteAcc($_SESSION["email"]); redir('index.php'); die();}

	if (isset($_POST["logout"]) && $_POST["logout"] == '1') {
		logout(); die();}

	if (isset($_POST["logoutOthers"]) && $_POST["logoutOthers"] == '1') {
		logoutOthers(); header("Location: security.php"); die();}


	include 'header.php'; include 'menubar.php'; ?>

<body>

<div align="center">

	<div class="banner" align="center"><?php echo $_SESSION["email"]?></div>

	<br>

	<a class="smallbutton" href="newpass.php">CHANGE PASSWORD</a>
	<br><br>

	<form action="security.php" method="post"> 
	<button class="outlined" name="logout" value="1">LOGOUT</button>
	</form>

	<form action="security.php" method="post"> 
	<button class="outlined" name="logoutOthers" value="1">TERMINATE OTHER SESSIONS</button>
	</form>

	<form action="security.php" method="post" onsubmit="return confirm('Do you really want to delete your account?');"> 
	<button class="red outlined" name="delete" value="1">DELETE ACCOUNT</button>
	</form>


</div>

</body>