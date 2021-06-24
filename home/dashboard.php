<?php include 'session.php'; include 'header.php'; include 'menubar.php'; ?>

<body>

<div align="center">

	<?php /* Load page based on user type */
	if ($_SESSION["type"] == 0) {include 'dashboard_job_seeker.php';}
	if ($_SESSION["type"] == 1) {include 'dashboard_employer.php';}
	?>

</div>

</body>

<script> /* Set menubar icons */
	$('#agenda').hide();
</script>