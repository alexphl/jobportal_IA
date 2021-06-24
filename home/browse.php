<?php include 'session.php'; if ($_SESSION["type"] == 1) {redir('dashboard.php'); die();} include 'header.php'; include 'menubar.php'; 

	// SQL injection mitigation
	$name = mysqli_real_escape_string($mysqli,$_GET["search"]);
	$city = mysqli_real_escape_string($mysqli,$_GET["city"]);
	$category = mysqli_real_escape_string($mysqli,$_GET["category"]);
	$country = mysqli_real_escape_string($mysqli,$_GET["country"]);
	$company = mysqli_real_escape_string($mysqli,$_GET["company"]);
	$min_exp = mysqli_real_escape_string($mysqli,$_GET["min_exp"]);

	if ($min_exp == '') {$min_exp = 99;}	// User will filter exp by setting upper boundary so the default value must be the maximum possible

	// Main query
	$pass = mysqli_query($mysqli,"SELECT id FROM JOBS WHERE is_open='1' AND name LIKE '%{$name}%' AND company_email LIKE '%{$company}%' AND country LIKE '%{$country}%' AND city LIKE '%{$city}%' AND min_exp <= '{$min_exp}' AND category LIKE '%{$category}%' ORDER BY id DESC");

	// Filter out the jobs the user has already applied to
	$pass2 = mysqli_query($mysqli,"SELECT job_id FROM JOB_APPLICATIONS WHERE applicant_email='{$_SESSION["email"]}' ORDER BY job_id DESC"); 
	$result2 = array();
	while ($row = mysqli_fetch_array($pass2)) {$result2[] = $row[0];} // Create an array from fetched results

	$pass3 = mysqli_query($mysqli,"SELECT comname, email FROM EMPLOYERS"); // Used in per-company filter (sidebar.php)

?>

<body> 

	<div id="allgrid">

		<?php include 'sidepanel.php' ?>

		<div class="banner" align="center" style="padding-bottom: 5vh;"><?php echo "Welcome, ". $_SESSION["name"]."<br>"?><h1 style="font-size: 0.5em;"><br>Here's what we found for you</h1></div>


		<div id="cardgrid" style="padding-top: 10vh;">

			<?php  

				while ($result = mysqli_fetch_array($pass)) {
					// Don't show jobs the user has already applied to
					if (in_array($result["id"], $result2) == 0) {
						callCard($result['id']); $q = $q + 1;
					}
				}
			?>

		</div>

		<?php  // Let user know if nothing was found

		if ($q == 0) {echo "<div class='banner' align='center' style='padding-top:0; color: grey;'><h1 style='font-size: 0.5em;'><br><br>No jobs have been found</h1></div>";} 
		?>

	</div>

	<div id="shadow" style="position: fixed; height: 100%; width: 100%; z-index: 79; background-color: rgba(0,0,0,0.5); top: 0; left: 0;" onclick="showFilters()" hidden></div>

</body>

<script> /* Set menubar icons */
	$('#browse').hide();
	$('#filter_list').show();

    function showFilters() {

    	$('#sidepanel').toggle(100);
    	$('#shadow').toggle();

    } 
</script>

<script> /* Restore user selections after page reload */
	document.getElementsByName('country')[0].value="<?php echo $country?>";
	document.getElementsByName('category')[0].value="<?php echo $category?>";
	document.getElementsByName('company')[0].value="<?php echo $company?>";
	if (document.getElementsByName('country')[0].value != '') {$('#dynamic').show();}
</script>

<script> /* Hide address filters if no country filter is set */
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