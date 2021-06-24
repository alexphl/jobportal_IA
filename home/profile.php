<?php include 'session.php'; 

	if (isset($_POST["logout"]) && $_POST["logout"] == '1') {
		logout(); die();}

	include 'header.php'; include 'menubar.php'; 

	if ($_SESSION["type"] == 0) {$var1 = "Personal "; $var2 = "account_box"; $pass = mysqli_query($mysqli,"SELECT * FROM JOB_SEEKERS WHERE email='{$_SESSION["email"]}' limit 1");}
	else {$var1 = "Company "; $var2 = "business"; $pass = mysqli_query($mysqli,"SELECT * FROM EMPLOYERS WHERE email='{$_SESSION["email"]}' limit 1");}

	$result = mysqli_fetch_array($pass);

?>

<body>

<div align="center">

	<div id="imagemask"> 

		<img style="width: 100%; height: 100%; object-fit: cover; border-radius: 100%;" src=<?php echo '"data/users/'.$_SESSION["email"].'/profilepic"'?> onerror="this.src='data/placeholder2.svg';">

	</div>

	<div class="banner" style="padding-top: 4vh;" align="center"><?php echo $result["firstname"]?> <?php echo $result["lastname"]?><?php echo $result["comname"]?><h1 style="font-size: 0.5em;"><br><br><?php echo $_SESSION["email"]?></div>

	<br>

	<form action="profile.php" method="post"> 
	<button class="outlined" name="logout" value="1">LOGOUT</button>
	</form>

	<div class="list"> <h1>Settings</h1>
		<br>
		<br>
		<br>

		<a href="details.php"><button class="listitem"><i class="material-icons" style="padding-right: 15px; padding-bottom: 3px;"><?php echo $var2 ?></i><?php echo $var1 ?>Details</button></a>
		<a href="security.php"><button class="listitem"><i class="material-icons" style="padding-right: 15px; padding-bottom: 3px;">lock</i>Security</button></a>

	</div>

</div>

</body>

<script>

	$('#profile').hide();

</script>