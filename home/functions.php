<?php
	error_reporting(E_ERROR);

	function callCard($job_id) {
		include 'card.php';
	}

	function removeDirectory($path) {
	 	$files = glob($path . '/*');
		foreach ($files as $file) {
			is_dir($file) ? removeDirectory($file) : unlink($file);
		}
		rmdir($path);
	}

	function login($email, $password) {
		$mysqli = new mysqli("127.0.0.1", "root", "zoolook22", "SIT");

		// SQL injection mitigation
		$email = mysqli_real_escape_string($mysqli,$email);

		// Grab password hash from db
		$pass = mysqli_query($mysqli,"SELECT pword FROM USERS WHERE email='{$email}' limit 1");
		$result = mysqli_fetch_array($pass); 

		if ($pass->num_rows > 0) { // Check if account exists

		$phash = $result['pword'];	// Verify password

			if(password_verify($password, $phash)) {
				initSession($email, $phash);
			}

			// Output error if password is wrong
			else {header("Location: index.php?msg=failed"); die();}
		}

		// Output error if email doesn't exist
		else {header("Location: index.php?msg=nomail"); die();}
	}

	function initSession($email, $phash) {
		$mysqli = new mysqli("127.0.0.1", "root", "zoolook22", "SIT");

		$_SESSION["email"] = $email;	// Set session variables
		$_SESSION["password"] = $phash;

		$work1 = mysqli_query($mysqli,"SELECT shash, type FROM USERS WHERE email='{$email}' limit 1");
		$result1 = mysqli_fetch_array($work1);

		if ($result1['shash'] > 0) {$_SESSION["shash"] = $result1['shash'];}	// Assign session hash

		else {	// Create new hash if null
		$_SESSION["shash"] = makeShash();
		mysqli_query($mysqli,"UPDATE USERS SET shash='{$_SESSION["shash"]}' WHERE email='{$email}'");
		} 

		$_SESSION["type"] = $result1['type'];	// Init based on acc type

		if ($_SESSION["type"] == '0') {

			$work3 = mysqli_query($mysqli,"SELECT firstname FROM JOB_SEEKERS WHERE email='{$email}' limit 1");
			$result3 = mysqli_fetch_array($work3);

			$_SESSION["name"] = $result3['firstname'];

		}

		if ($_SESSION["type"] == '1') {

			$work4 = mysqli_query($mysqli,"SELECT comname FROM EMPLOYERS WHERE email='{$email}' limit 1");
			$result4 = mysqli_fetch_array($work4);

			$_SESSION["name"] = $result4['comname'];

		}
	}

	function makeShash() {
		$mysqli = new mysqli("127.0.0.1", "root", "zoolook22", "SIT");

		$shash = bin2hex(random_bytes(10));

		// Check if hash is unique
		$work = mysqli_query($mysqli,"SELECT shash FROM USERS WHERE shash='$shash' limit 1"); 

		if ($work->num_rows > 0) {makeShash();} // If not unique, recalculate
		else {return $shash;}
	}

	function logout() {
		session_destroy(); 
		header("Location: index.php");
		die();
	}

	function redir($dir) {
		header("Location: $dir");
		die();
	}

	function logoutOthers() {
		$mysqli = new mysqli("127.0.0.1", "root", "zoolook22", "SIT");
		$_SESSION["shash"] = makeShash();
		mysqli_query($mysqli,"UPDATE USERS SET shash='{$_SESSION["shash"]}' WHERE email='{$_SESSION["email"]}'");
	}

	function makeAcc($firstname, $lastname, $comname, $email, $password, $repass, $type) {
		$mysqli = new mysqli("127.0.0.1", "root", "zoolook22", "SIT");

		// SQL injection mitigation
		$email = mysqli_real_escape_string($mysqli,$email);
		$password = mysqli_real_escape_string($mysqli,$password);
		$repass = mysqli_real_escape_string($mysqli,$repass);
		$firstname = mysqli_real_escape_string($mysqli,$firstname);
		$lastname = mysqli_real_escape_string($mysqli,$lastname);
		$comname = mysqli_real_escape_string($mysqli,$comname);

		// Validate email
		if (strpos($email, '@') == false OR strpos($email, '.') == false) {session_destroy(); header("Location: signup.php?msg=badmail"); die();}
		// Validate repeat password
		if ($password != $repass) {session_destroy(); header("Location: signup.php?msg=mismatch"); die();}

		// Return error if email already in use
		$pass = mysqli_query($mysqli,"SELECT email FROM USERS WHERE email='{$email}' limit 1");
		if ($pass->num_rows > 0) {session_destroy(); header("Location: signup.php?msg=mailinuse"); die();}
		
		$phash = password_hash($password, PASSWORD_DEFAULT); // Hash password

		// Run database queries
		mysqli_query($mysqli,"INSERT INTO USERS (email, pword, type) VALUES ('{$email}', '{$phash}', '{$type}')"); 
		if ($type == 0) {mysqli_query($mysqli,"INSERT INTO JOB_SEEKERS (email, firstname, lastname) VALUES ('{$email}', '{$firstname}', '{$lastname}')");}
		if ($type == 1) {mysqli_query($mysqli,"INSERT INTO EMPLOYERS (email, comname) VALUES ('{$email}', '{$comname}')");} 

		mkdir('data/users/'.$email, 0777, true); // Create user dir
	}

	function updateAcc($email, $firstname, $lastname, $comname, $gender, $phone, $website, $citizen_of, $country, $city, $address, $fax, $about) {
		$mysqli = new mysqli("127.0.0.1", "root", "zoolook22", "SIT");

		// SQL injection mitigation
		$email = mysqli_real_escape_string($mysqli,$email);
		$password = mysqli_real_escape_string($mysqli,$password);
		$phone = mysqli_real_escape_string($mysqli,$phone);
		$firstname = mysqli_real_escape_string($mysqli,$firstname);
		$lastname = mysqli_real_escape_string($mysqli,$lastname);
		$comname = mysqli_real_escape_string($mysqli,$comname);
		$website = mysqli_real_escape_string($mysqli,$website);
		$city = mysqli_real_escape_string($mysqli,$city);
		$address = mysqli_real_escape_string($mysqli,$address);
		$fax = mysqli_real_escape_string($mysqli,$fax);
		$about = mysqli_real_escape_string($mysqli,$about);

		mysqli_query($mysqli,"UPDATE JOB_SEEKERS SET about='{$about}', firstname='{$firstname}', lastname='{$lastname}', gender='{$gender}', phone='{$phone}', website='{$website}', citizen_of='{$citizen_of}', country='{$country}', city='{$city}' WHERE email='{$email}'");
		mysqli_query($mysqli,"UPDATE EMPLOYERS SET comname='{$comname}', phone='{$phone}', website='{$website}', address='{$address}', fax='{$fax}' WHERE email='{$email}'");

		$x = mysqli_query($mysqli,"SELECT pword FROM USERS WHERE email='{$email}' limit 1");

		$y = mysqli_fetch_array($x);

		initSession($email, $y['pword']);

		header("Location: details.php?msg=success");
		die();

	}

	function deleteAcc($email) {
		$mysqli = new mysqli("127.0.0.1", "root", "zoolook22", "SIT");

		removeDirectory("data/users/".$email);
		mysqli_query($mysqli,"DELETE FROM USERS WHERE email = '{$email}'");

		mysqli_query($mysqli,"DELETE FROM JOB_SEEKERS WHERE email = '{$email}'");
		mysqli_query($mysqli,"DELETE FROM JOB_APPLICATIONS WHERE applicant_email = '{$email}'");

		mysqli_query($mysqli,"DELETE FROM EMPLOYERS WHERE email = '{$email}'");
		mysqli_query($mysqli,"DELETE FROM JOBS WHERE company_email = '{$email}'");
		mysqli_query($mysqli,"DELETE FROM JOB_APPLICATIONS WHERE company_email = '{$email}'");
	}

	function createJob($name, $description, $country, $city, $address, $min_exp, $category, $is_open) {

		$mysqli = new mysqli("127.0.0.1", "root", "zoolook22", "SIT");

		// SQL injection mitigation
		$name = mysqli_real_escape_string($mysqli,$name);
		$description = mysqli_real_escape_string($mysqli,$description);
		$city = mysqli_real_escape_string($mysqli,$city);
		$address = mysqli_real_escape_string($mysqli,$address);
		$category = mysqli_real_escape_string($mysqli,$category);

		mysqli_query($mysqli,"INSERT INTO JOBS (company_email, name, description, country, city, address, category, is_open, min_exp) VALUES ('{$_SESSION["email"]}', '{$name}', '{$description}', '{$country}', '{$city}', '{$address}', '{$category}', '{$is_open}', '{$min_exp}')");
	}

	function updateJob($id ,$name, $description, $country, $city, $address, $min_exp, $category, $is_open) {

		$mysqli = new mysqli("127.0.0.1", "root", "zoolook22", "SIT");

		// SQL injection mitigation
		$name = mysqli_real_escape_string($mysqli,$name);
		$description = mysqli_real_escape_string($mysqli,$description);
		$city = mysqli_real_escape_string($mysqli,$city);
		$address = mysqli_real_escape_string($mysqli,$address);
		$category = mysqli_real_escape_string($mysqli,$category);

		mysqli_query($mysqli,"UPDATE JOBS SET name='{$name}', description='{$description}', country='{$country}', city='{$city}', address='{$address}', category='{$category}', is_open='{$is_open}', min_exp='{$min_exp}' WHERE id='$id' ");
	}

	function deleteJob($id) {
		$mysqli = new mysqli("127.0.0.1", "root", "zoolook22", "SIT");
		mysqli_query($mysqli,"DELETE FROM JOBS WHERE id = '$id' ");
		mysqli_query($mysqli,"DELETE FROM JOB_APPLICATIONS WHERE job_id = '$id' ");
	}

	function applytoJob($id) {
		$mysqli = new mysqli("127.0.0.1", "root", "zoolook22", "SIT");

		$q = mysqli_query($mysqli,"SELECT company_email FROM JOBS WHERE id='$id' limit 1");
		$z = mysqli_fetch_array($q);

		$r = mysqli_query($mysqli,"SELECT * FROM JOB_APPLICATIONS WHERE job_id='$id' AND applicant_email='{$_SESSION["email"]}' limit 1");
		
		if ($r->num_rows==0) {
			mysqli_query($mysqli,"INSERT INTO JOB_APPLICATIONS (job_id, applicant_email, company_email, app_status) VALUES ('$id', '{$_SESSION["email"]}', '{$z["company_email"]}', 'Pending')");
		}

	}

	function cancelApplication($id) {
		$mysqli = new mysqli("127.0.0.1", "root", "zoolook22", "SIT");
		mysqli_query($mysqli,"DELETE FROM JOB_APPLICATIONS WHERE job_id = '$id' AND applicant_email = '{$_SESSION["email"]}' limit 1");
	}

	function processUpload() {

		$allowed = array('png','jpg','jpeg'); 	// Allowed formats
		$filename = $_FILES['upload']['name'];	// Fetches file
		$ext = pathinfo($filename, PATHINFO_EXTENSION); // Check format against $allowed
		if(!in_array($ext,$allowed) ) {echo "<div align='center' class='red'><br><br>Wrong upload format</div>";}

		// Limit files size (in bytes)
		else if ($_FILES['upload']['size'] > 5000000) {echo "<div align='center' class='red'><br><br>File size must be below 5MB</div>";} 

		// Move to user folder
		else {move_uploaded_file($_FILES['upload']['tmp_name'], "data/users/".$_SESSION["email"]."/profilepic");}


	}

?>