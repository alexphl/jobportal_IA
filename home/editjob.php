<?php include 'session.php'; 

	if ($_SESSION["type"] != '1') {redir('dashboard.php');} 

	if ($_POST["deletejob"] == '1') {deleteJob($_GET["id"]); redir('browse.php');} 

	if ($_POST["update_job"] == '1') {updateJob($_GET["id"], $_POST["name"], $_POST["description"], $_POST["country"], $_POST["city"], $_POST["address"], $_POST["min_exp"], $_POST["category"], $_POST["is_open"]); redir("editjob.php?id=".$_GET["id"]); }

	include 'header.php'; include 'menubar.php';

	$pass = mysqli_query($mysqli,"SELECT * FROM JOBS WHERE id='{$_GET["id"]}' AND company_email='{$_SESSION["email"]}' ORDER BY id DESC limit 1");

	$result = mysqli_fetch_array($pass);


?>

<body> 

	<div align="center">


		<div class="banner" align="center"><?php echo $result["name"]?></div>

		<form action="editjob.php?id=<?php echo $result["id"]?>" method="post" onsubmit="return confirm('Are you sure? This will also detele application details associated with this job.');"> 
			<button class="red outlined" name="deletejob" value="1">DELETE JOB</button>
		</form>

		<div class="list">

			<form action="editjob.php?id=<?php echo $result["id"]?>" method="post">

				<h3>JOB TITLE / POSITION </h3> <br><br>
			    <input type="text" placeholder="Enter job name" name="name" class="input" required value="<?php echo $result["name"]?>">
			    <br>
			    <br>
			    <br>

			    <h3>DESCRIPTION </h3> <br><br>
			    <textarea name="description" class="input" style="min-height: 200px; display: block; vertical-align: top !important;"><?php echo $result["description"]?></textarea>
			    <br>
			    <br>

			    <h3>CATEGORY </h3> <br><br>
			    <select name="category" class="input" required>
			    	<option value="" disabled>Choose a category for the job</option>
			    	<?php include 'job_categories.php' ?>
				</select>
				<br>
			    <br>
			    <br>

			    <h3>COUNTRY </h3> <br><br>
			    <select name="country" class="input" onchange="yesnoCheck(this);">
					<option value="">Any / Remote employment</option>
			    	<?php include 'countries.php' ?>
				</select>
				<br>
			    <br>
			    <br>

			    <div id="dynamic" hidden>
			    <h3>CITY </h3> <br><br>
				<input type="text" placeholder="Enter city" name="city" class="input" value="<?php echo $result["city"]?>">
	 			<br>
			    <br>
			    <br>

			    <h3>ADDRESS </h3> <br><br>
			    <input type="text" placeholder="Enter address" name="address" class="input" value="<?php echo $result["address"]?>">
			    <br>
			    <br>
			    <br>
			    </div>

			    <h3>MINIMUM REQUIRED YEARS OF EXPERIENCE </h3> <br><br>
			    <input type="number" placeholder="None" name="min_exp" class="input" value="<?php echo $result["min_exp"]?>">
			    <br>
			    <br>
			    <br>

			    <h3>APPLICATION STATUS </h3> <br><br>
			    <select name="is_open" class="input">
					<option value="1">Open</option>
					<option value="0">Closed</option>
				</select>
				<br>
			    <br>
			    <br>

				<font color="#4CAF50">

				</font>
			    
			    <br>
			    <button type="submit" class="outlined" name="update_job" value="1">UPDATE</button>

			</form>

		</div>	

	</div>
	
</body>

<script>
	document.getElementsByName('country')[0].value="<?php echo $result["country"]?>";
	document.getElementsByName('is_open')[0].value="<?php echo $result["is_open"]?>";
	document.getElementsByName('category')[0].value="<?php echo $result["category"]?>";
	if (document.getElementsByName('country')[0].value != '') {$('#dynamic').show(); $('#dynamic :input').prop('required',1);}
</script>

<script>

function yesnoCheck(that) {

        if (that.value == "") {
        	$('#dynamic').hide();
        	$('#dynamic :input').prop('required',null);
        	document.getElementsByName('city')[0].value = '';
        } 

        else {
        	$('#dynamic').show();
        	$('#dynamic :input').prop('required',1);
        }
    }

</script>