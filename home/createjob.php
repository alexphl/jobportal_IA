<?php include 'session.php'; if ($_SESSION["type"] != '1') {redir('dashboard.php');} 

	if ($_POST["create_job"] == '1') {createJob($_POST["name"], $_POST["description"], $_POST["country"], $_POST["city"], $_POST["address"], $_POST["min_exp"], $_POST["category"], $_POST["is_open"]); redir("dashboard.php");}

	include 'header.php'; include 'menubar.php'; 

?>

<body>

<div align="center">

	<div class="banner" align="center">Job Creation</div>

	<br>
	 

	<div class="list"> 

		<form action="createjob.php" method="post">

			<h3>JOB TITLE / POSITION </h3> <br><br>
		    <input type="text" placeholder="Enter job title" name="name" class="input" required>
		    <br>
		    <br>
		    <br>

		    <h3>DESCRIPTION </h3> <br><br>
		    <textarea name="description" class="input" style="min-height: 200px; display: block; vertical-align: top !important;"> </textarea>
		    <br>
		    <br>

		    <h3>CATEGORY </h3> <br><br>
		    <select name="category" class="input" required>
		    	<option value="" disabled selected>Choose a category for the job</option>
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
			<input type="text" placeholder="Enter city" name="city" class="input">
 			<br>
		    <br>
		    <br>

		    <h3>ADDRESS </h3> <br><br>
		    <input type="text" placeholder="Enter address" name="address" class="input">
		    <br>
		    <br>
		    <br>
		    </div>

		    <h3>MINIMUM REQUIRED YEARS OF EXPERIENCE </h3> <br><br>
		    <input type="number" placeholder="None" name="min_exp" class="input">
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
		    <button type="submit" class="outlined" name="create_job" value="1">UPDATE</button>

		</form>

	</div>

</div>

</body>

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