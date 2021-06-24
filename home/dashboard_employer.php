<div align="center">

<div id="imagemask"> 

	<img style="width: 100%; height: 100%; object-fit: cover; border-radius: 100%;" src=<?php echo '"data/users/'.$_SESSION["email"].'/profilepic"'?> onerror="this.src='data/placeholder2.svg';">

</div>


<div class="banner" align="center" style="padding-top: 4vh;"><?php echo $_SESSION["name"]?></div>

	<a href="createjob.php"><button class="outlined">NEW JOB</button></a>

	<div class="list"><h3 style="font-size: 1.2em;">DASHBOARD</h3> <br><br>

	<table style="width:100%; padding: 0;">
	  <tr>
	    <th width="60%"><h3>JOB TITLE</th>
	    <th><h3>STATUS</th> 
	    <th><h3>PENDING APPLICANTS</th> 
	  </tr>

		<?php  

			// Loads hosted jobs
			$pass = mysqli_query($mysqli,"SELECT * FROM JOBS WHERE company_email='{$_SESSION["email"]}' ORDER BY id DESC");

			while ($result = mysqli_fetch_array($pass)) {

				// Finds the number of pending applications
				$pass2 = mysqli_query($mysqli,"SELECT 0 FROM JOB_APPLICATIONS WHERE job_id='{$result["id"]}' AND app_status = 'Pending'");
				$rows2 = $pass2->num_rows;

				echo "<tr class='clickable-row' data-href='viewjob_employer.php?id=".$result['id']."'>";
				echo "<td>". $result["name"]. "</td>";
				echo "<td>";
				if ($result['is_open'] == '1'){echo "Open";}
				if ($result['is_open'] == '0'){echo "Closed";}
				echo "</td>";
				echo "<td>". $rows2. "</td>";
			}

		?>

	</table>


	</div>

</div>

<script>
jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});
</script>