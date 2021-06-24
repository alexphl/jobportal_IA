<?php include 'session.php'; if ($_SESSION["type"] == '1') {redir("viewjob_employer.php?id=".$_GET["id"]);} include 'header.php'; include 'menubar.php';

	if ($_POST["apply"] == '1') {applytoJob($_GET["id"]);}
	if ($_POST["cancel"] == '1') {cancelApplication($_GET["id"]);}

	$pass = mysqli_query($mysqli,"SELECT * , JOBS.address as address FROM JOBS JOIN EMPLOYERS ON JOBS.company_email=EMPLOYERS.email WHERE JOBS.id='{$_GET["id"]}' limit 1");
	$pass2 = mysqli_query($mysqli,"SELECT * FROM JOB_APPLICATIONS WHERE job_id='{$_GET["id"]}' AND applicant_email='{$_SESSION["email"]}' limit 1");


	$result = mysqli_fetch_array($pass);
	$result2 = mysqli_fetch_array($pass2);


?>

<body> 

	<div id="imagemask" style="margin: auto; margin-top: 15vh;"> 

		<img style="width: 100%; height: 100%; object-fit: cover; border-radius: 100%;" src=<?php echo '"data/users/'.$result["company_email"].'/profilepic"'?> onerror="this.src='data/placeholder2.svg';">

	</div>

	<div class="banner" align="center" style="padding-top: 4vh;"><?php echo $result["name"]?><h1 style="font-size: 0.5em;"><br><br>at <?php echo $result["comname"]?></h1></div>

	<div align="center">



		<?php 
		if ($pass2->num_rows == 0) {if ($result["is_open"] == 1){echo "<form method='post' action='viewjob_seeker.php?id=".$_GET['id']."'><button name='apply' value='1' class='outlined'>APPLY</button></form>";}}
		if ($pass2->num_rows > 0) {if ($result2["app_status"]  == 'Pending'){echo "<form method='post' action='viewjob_seeker.php?id=".$_GET['id']."'><button name='cancel' value='1' class='red outlined'>CANCEL APPLICATION</button></form>";}}
		if ($result2["app_status"] == "Accepted") {echo "<font color='#4CAF50'>Application Accepted</font><br><br>";}
		if ($result2["app_status"] == "Rejected") {echo "<font color='#E57373'>Application Rejected</font><br><br>";}
		?>



		<div class="list">
			<?php if ($result['description'] != ' ') {echo 
				"<h3>DESCRIPTION</h3> <br>
				<p align='justify'>".nl2br($result['description'])."</p> <br>"
			;}?>

			<?php if ($result['category'] != null) {echo 
				"<h3>CATEGORY</h3> <br>
				<p>".$result['category']."</p> <br>"
			;}?>

			<h3>EMPLOYER'S EMAIL</h3> <br>
			<a href="mailto: <?php echo $result['email']?>" style="color: white;"><p><?php echo $result['email']?></p></a> <br>

			<?php if ($result['website'] != null) {echo 
				"<h3>EMPLOYER'S WEBSITE</h3> <br>
				<p>".$result['website']."</p> <br>"
			;}?>

			<?php if ($result['min_exp'] != null) {echo 
				"<h3>MINIMUM EXPERIENCE</h3> <br>
				<p>".$result['min_exp']." Years</p> <br>"
			;}?>

			<?php if ($result['country'] != null) {echo 
				"<h3>COUNTRY</h3> <br>
				<p>".$result['country']."</p> <br>";}
				else {echo 
				"<h3>LOCATION</h3> <br>
				<p>International / Remote Employment</p> <br>";}
			?>

			<?php if ($result['city'] != null) {echo 
				"<h3>CITY</h3> <br>
				<p>".$result['city']."</p> <br>"
			;}?>

			<?php if ($result['address'] != null) {echo 
				"<h3>ADDRESS</h3> <br>
				<p>".$result['address']."</p> <br>"
			;}?>


		</div>

	</div>

</body>