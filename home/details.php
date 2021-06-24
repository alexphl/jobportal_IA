<?php include 'session.php'; 

	if ($_FILES['upload']['name'] != "" ) {processUpload();}

	if (isset($_POST["details_update"]) && $_POST["details_update"] == '1') {
		updateAcc($_POST["email"], $_POST["firstname"], $_POST["lastname"], $_POST["comname"], $_POST["gender"], $_POST["phone"], $_POST["website"], $_POST["citizen_of"], $_POST["country"], $_POST["city"], $_POST["address"], $_POST["fax"], $_POST["about"]);}


	include 'header.php'; include 'menubar.php';

	if ($_SESSION['type'] == 0) {$x = mysqli_query($mysqli,"SELECT * FROM JOB_SEEKERS WHERE email='{$_SESSION["email"]}' limit 1");} 
	if ($_SESSION['type'] == 1) {$x = mysqli_query($mysqli,"SELECT * FROM EMPLOYERS WHERE email='{$_SESSION["email"]}' limit 1");} 

	$result = mysqli_fetch_array($x);

?>

<?php if (isset($_GET["msg"]) && $_GET["msg"] == 'new') {echo "<script>alert('Welcome. For the best experience, please add extra details to your account information.');</script>";} ?>

<body>

<div align="center">


	<div id="imagemask"> 

		<img style="width: 100%; height: 100%; object-fit: cover; border-radius: 100%;" src=<?php echo '"data/users/'.$_SESSION["email"].'/profilepic"'?> onerror="this.src='data/placeholder.svg';">

	</div>

	<form action="details.php" method="post" enctype="multipart/form-data">
    	<input type="file" name="upload" id="fileToUpload" onchange ="form.submit()" style="display: none;">
	</form> 

	<div class="banner" align="center" style="padding-top: 4vh;"><?php echo $_SESSION["email"]?></div>

	<br> 
	 

	<div class="list"> <h3 style="font-size: 1.2em;">DETAILS</h3>

		<br>
		<br>
		<br>

		<form action="details.php" method="post">

			<input type="text" placeholder="Email" name="email" class="input" required value="<?php echo $_SESSION["email"]?>" style="display: none;">
			
			<div id="dynamic1">

				<h3>ABOUT ME </h3> <br><br>
		    	<textarea name="about" class="input" style="min-height: 200px; display: block; vertical-align: top !important;"><?php echo $result["about"]?></textarea>
		    	<br>
		    	<br>

				<h3>FIRST NAME</h3> <br><br>
			    <input type="text" placeholder="First name" name="firstname" class="input" required value="<?php echo $result["firstname"] ?>">
			    <br>
			    <br>
			    <br>

			    <h3>LAST NAME</h3> <br><br>
			    <input type="text" placeholder="Last name" name="lastname" class="input" required value="<?php echo $result["lastname"] ?>">
			    <br>
			    <br>
			    <br>

			    <h3>GENDER</h3> <br><br>
			    <select name="gender" class="input">
					<option value="0">Not chosen</option>
					<option value="1">Male</option>
					<option value="2">Female</option>
				</select>
				<br>
			    <br>
			    <br>

			    <h3>PHONE NUMBER</h3> <br><br>
				<input type='tel' placeholder="Phone number" name="phone" class="input" value="<?php echo $result["phone"] ?>">
	 			<br>
			    <br>
			    <br>

			    <h3>COUNTRY OF CITIZENSHIP</h3> <br><br>
			    <select name="citizen_of" class="input">
					<option value="">Not chosen</option>
			    	<?php include 'countries.php' ?>
				</select>
				<br>
			    <br>
			    <br>

			    <h3>COUNTRY OF RESIDENSE</h3> <br><br>
			    <select name="country" class="input">
					<option value="">Not chosen</option>
			    	<?php include 'countries.php' ?>
				</select>
				<br>
			    <br>
			    <br>

			    <h3>CITY OF RESIDENSE</h3> <br><br>
				<input type="text" placeholder="City of residense" name="city" class="input" value="<?php echo $result["city"] ?>">
	 			<br>
			    <br>
			    <br>

			    <h3>WEBSITE</h3> <br><br>
				<input type="url" placeholder="URL" name="website" class="input" value="<?php echo $result["website"] ?>">
	 			<br>
			    <br>
			    <br>

			</div>

			<div id="dynamic2">

				<h3>COMPANY NAME</h3> <br><br>
			    <input type="text" placeholder="Company name" name="comname" class="input" required value="<?php echo $result["comname"] ?>">
			    <br>
			    <br>
			    <br>

			    <h3>WEBSITE</h3> <br><br>
			    <input type="url" placeholder="URL" name="website" class="input" value="<?php echo $result["websiste"] ?>">
			    <br>
			    <br>
			    <br>

			    <h3>BUSINESS ADDRESS</h3> <br><br>
			    <input type="text" placeholder="Address" name="address" class="input" value="<?php echo $result["address"] ?>">
			    <br>
			    <br>
			    <br>

			    <h3>BUSINESS PHONE NUMBER</h3> <br><br>
			    <input type="tel" placeholder="Business phone number" name="phone" class="input" value="<?php echo $result["phone"] ?>">
			    <br>
			    <br>
			    <br>

			    <h3>FAX</h3> <br><br>
			    <input type="text" placeholder="Fax" name="fax" class="input" value="<?php echo $result["fax"] ?>">
			    <br>
			    <br>
			    <br>

			</div>

			<font color="#4CAF50">
				<?php if (isset($_GET["msg"]) && $_GET["msg"] == 'success') {
				echo "Details updated <br>";} ?>
			</font>
		    
		    <br>
		    <button type="submit" class="outlined" name="details_update" value="1">UPDATE</button>

		</form>

	</div>

</div>

</body>

<script>
			document.getElementsByName('gender')[0].value="<?php echo $result["gender"]?>";
			document.getElementsByName('citizen_of')[0].value="<?php echo $result["citizen_of"]?>";
			document.getElementsByName('country')[0].value="<?php echo $result["country"]?>";

</script>

<script>

	if (<?php echo $_SESSION["type"] ?> == "1") {
        	$('#dynamic1').hide();
        	$('#dynamic1 :input').prop('required',null);
        	$('#dynamic1 :input').prop('disabled',1);
        } 

        else {
        	$('#dynamic2').hide();
        	$('#dynamic2 :input').prop('required',null);
        	$('#dynamic2 :input').prop('disabled',1);
        }

</script>

<script> /* Hide xity if no country is set */
function yesnoCheck(that) {

        if (that.value == "") {
        	$('#dynamic').hide();
        	document.getElementsByName('city')[0].value = '';
        } 

        else {
        	$('#dynamic').show();
        }
    }
</script>

<script>
var imgBtn = document.getElementById('imagemask');
var fileInp = document.querySelector('[type="file"]');

imgBtn.addEventListener('click', function() {
  fileInp.click();
})
</script>