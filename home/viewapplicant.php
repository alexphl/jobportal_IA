<?php include 'session.php'; if ($_SESSION["type"] != '1') {redir('dashboard.php');} include 'header.php'; include 'menubar.php';

	if (isset($_POST["accept"])) {mysqli_query($mysqli,"UPDATE JOB_APPLICATIONS SET app_status='{$_POST["accept"]}' WHERE id='{$_GET["id"]}'");}

	$pass = mysqli_query($mysqli,"SELECT * FROM JOB_APPLICATIONS JOIN JOB_SEEKERS ON applicant_email=email WHERE JOB_APPLICATIONS.id='{$_GET["id"]}' AND company_email='{$_SESSION["email"]}' limit 1");
	$result = mysqli_fetch_array($pass);

?>


<body> 

	<div id="imagemask" style="margin: auto; margin-top: 15vh;"> 

		<img style="width: 100%; height: 100%; object-fit: cover; border-radius: 100%;" src=<?php echo '"data/users/'.$result["email"].'/profilepic"'?> onerror="this.src='data/placeholder2.svg';">

	</div>

	<div class="banner" align="center" style="padding-top: 4vh;"><?php echo $result["firstname"]?> <?php echo $result["lastname"]?></div>

	<div align="center">



		<?php if ($result["app_status"] == "Pending") {
			echo "<form method='post' action='viewapplicant.php?id=".$_GET['id']."'' style='display:inline'><button name='accept' value='Accepted' class='outlined'>ACCEPT</button></form>";
			echo "<form method='post' action='viewapplicant.php?id=".$_GET['id']."' style='display:inline;'><button name='accept' value='Rejected' class='red outlined'>REJECT</button></form>";

			}

			if ($result["app_status"] == "Accepted") {echo "<font color='#4CAF50'>Application Accepted</font><br><br>";}
			if ($result["app_status"] == "Rejected") {echo "<font color='#E57373'>Application Rejected</font><br><br>";}

		?>


		<div class="list">
			<?php if ($result['about'] != null) {echo 
				"<h3>ABOUT</h3> <br>
				<p align='justify'>".nl2br($result['about'])."</p> <br>"
			;}?>

			<h3>EMAIL</h3> <br>
			<a href="mailto: <?php echo $result['email']?>" style="color: white;"><p><?php echo $result['email']?></p></a> <br>

			<?php if ($result['website'] != null) {echo 
				"<h3>WEBSITE</h3> <br>
				<p>".$result['website']."</p> <br>"
			;}?>

			<?php if ($result['phone'] != null) {echo 
				"<h3>PHONE NUMBER</h3> <br>
				<p>".$result['phone']."</p> <br>"
			;}?>

			<?php if ($result['gender'] != '0') {echo "<h3>GENDER</h3> <br>";}
				if ($result['gender'] == '1') {echo "<p>Male</p><br>";}
				if ($result['gender'] == '2') {echo "<p>Female</p><br>";}
			?>

			<?php if ($result['citizen_of'] != null) {echo 
				"<h3>CITIZENSHIP</h3> <br>
				<p>".$result['country']."</p> <br>";}
			?>

			<?php if ($result['country'] != null) {echo 
				"<h3>COUNTRY</h3> <br>
				<p>".$result['country']."</p> <br>";}
			?>

			<?php if ($result['city'] != null) {echo 
				"<h3>CITY</h3> <br>
				<p>".$result['city']."</p> <br>"
			;}?>


		</div>

	</div>

</body>