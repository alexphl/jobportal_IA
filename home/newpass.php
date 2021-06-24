<?php include 'session.php'; include 'header.php'; include 'menubar.php'; ?>

<body>

<div align="center">

	<div class="banner" align="center"><?php echo $_SESSION["email"]?></div>

	<br>

	<form action="newpass.php" method="post">

	    <input type="password" placeholder="Old password" name="old" class="input" required>
	    <br>
	    <br>

	    <input type="password" placeholder="New password" name="password" class="input" required>
	    <br>
	    <br>

	    <input type="password" placeholder="Repeat new password" name="repass" class="input" required>
	    <br>
	    <br>

	    <font color="#E57373">
	    <?php
	    	if (isset($_POST["change"]) && $_POST["change"]) {
				if ($_POST["password"] == $_POST["repass"]) {
					if(password_verify($_POST["old"], $_SESSION["password"])) {
						$phash = password_hash($_POST["repass"], PASSWORD_DEFAULT);
						mysqli_query($mysqli,"UPDATE USERS SET pword='$phash' WHERE email='{$_SESSION["email"]}'");
						$_SESSION["password"] = $phash;
						$_POST["done"] = '1';
					}
					else {echo "Wrong password <br>";}
				}
				else {echo "Passwords don't match <br>";} 
				
			}
		?>
		</font>
		<font color="#4CAF50">
		<?php if (isset($_POST["done"]) && $_POST["done"] == '1') {
		echo "Password changed successfully <br>";} ?>
		</font>

	    <br>
	        
	    <button type="submit" class="outlined" name="change" value="1">CHANGE PASSWORD</button>

	</form>

</div>

</body>