<div id="sidepanel"> 

		<form method="get">

			<h3>NAME CONTAINS...</h3> <br><br>
		    <input type="text" placeholder="All" name="search" class="input" value="<?php echo $name ?>">
		    <br>
		    <br>
		    <br>

	    	<h3>CATEGORY </h3> <br><br>
		    <select name="category" class="input">
		    	<option value="">Any</option>
		    	<?php include 'job_categories.php' ?>
			</select>
			<br>
		    <br>
		    <br>

		    <h3>COMPANY </h3> <br><br>
		    <select name="company" class="input">
		    	<option value="">Any</option>

		    	<?php 
		    	while ($result3 = mysqli_fetch_array($pass3)) {
    				echo '<option value="'.$result3['email'].'">'.$result3['comname'].'</option>';
				}

				?>
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
			<input type="text" placeholder="Enter city" name="city" class="input" value="<?php echo $city ?>">
 			<br>
		    <br>
		    <br>
		    </div>

		    <h3>MAXIMUM REQUIRED YEARS OF EXPERIENCE </h3> <br><br>
		    <input type="number" placeholder="Any" name="min_exp" class="input" value="<?php echo $_GET["min_exp"]?>">
		    <br>
		    <br>
		    <br>
		        
		    <button type="submit" class="outlined" name="refresh" value="1" style="margin: auto; right: 40; position: absolute; min-width: 0; height: 60px; width: 60px; border-radius: 100%; padding: 0;"><i class="material-icons" style="font-size: 2em;">arrow_forward</i></button>

		</form>

	</div>