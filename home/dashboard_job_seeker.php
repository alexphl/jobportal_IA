<div align="center">


<div class="banner" align="center">Applications</div>

	<div class="list"><h3 style="font-size: 1.2em;">DASHBOARD</h3> <br><br>

	<table style="width:100%">
	  <tr>
	    <th><h3>JOB TITLE</th>
	    <th><h3>EMPLOYER</th>
	    <th><h3>STATUS</th> 
	  </tr>

		<?php  

			$pass1 = mysqli_query($mysqli,"SELECT * FROM JOB_APPLICATIONS JOIN JOBS ON JOB_APPLICATIONS.job_id=JOBS.id JOIN EMPLOYERS ON JOBS.company_email=EMPLOYERS.email WHERE applicant_email='{$_SESSION["email"]}' ORDER BY JOBS.id DESC");

			while ($result1 = mysqli_fetch_array($pass1)) { // Output as table rows

				echo "<tr class='clickable-row' data-href='viewjob_seeker.php?id=".$result1['job_id']."'>";
				echo "<td>". $result1['name']. "</td>";
				echo "<td>". $result1['comname']. "</td>";
				// Use appropriate color coding
				if ($result1["app_status"] == "Accepted") {echo "<td><font color='#4CAF50'>Accepted</font></td>";}
				else if ($result1["app_status"] == "Rejected") {echo "<td><font color='#E57373'>Rejected</font></td>";}
				else {echo "<td>". $result1['app_status']. "</td>";}
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