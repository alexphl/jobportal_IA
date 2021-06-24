<?php include 'session.php'; if ($_SESSION["type"] != '1') {redir("viewjob_seeker.php?id=".$_GET["id"]); die();} include 'header.php'; include 'menubar.php';

	$pass = mysqli_query($mysqli,"SELECT * FROM JOBS WHERE id='{$_GET["id"]}' AND company_email='{$_SESSION["email"]}' ORDER BY id DESC limit 1");

	$result = mysqli_fetch_array($pass);


?>

<body> 

	<div align="center">

		<div class="banner" align="center"><?php echo $result["name"]?></div>

			<a href="editjob.php?id=<?php echo $_GET["id"]?>"><button class="outlined">EDIT JOB DETAILS</button></a>
			<div class="list"> <h3 style="font-size: 1.2em;">APPLICANTS</h3>
				<br>
				<br>

			<table style="width:100%">
			  <tr>
			    <th><h3>NAME</th>
			    <th><h3>EMAIL</th> 
			    <th><h3>STATUS</th> 
			  </tr>

				<?php  

					$pass = mysqli_query($mysqli,"SELECT applicant_email, app_status FROM JOB_APPLICATIONS WHERE company_email='{$_SESSION["email"]}' AND app_status != 'Rejected' AND job_id='{$_GET["id"]}' ORDER BY app_status");
					$pass2 = mysqli_query($mysqli,"SELECT * FROM JOB_SEEKERS JOIN JOB_APPLICATIONS ON email=applicant_email WHERE job_id='{$_GET["id"]}' ORDER BY app_status");

					while ($result = mysqli_fetch_array($pass)) {
						$result2 = mysqli_fetch_array($pass2);
						echo "<tr class='clickable-row' data-href='viewapplicant.php?id=".$result2['id']."'>";
						echo "<td>". $result2['firstname']." ". $result2['lastname']. "</td>";
						echo "<td>". $result['applicant_email']. "</td>";
						if ($result["app_status"] == "Accepted") {echo "<td><font color='#4CAF50'>Accepted</font></td>";}
						else {echo "<td>". $result['app_status']. "</td>";}
					}

				?>

			</table>

		</div>

	</div>

</body>

<script>
jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});
</script>