<?php 
    session_start(); include 'functions.php';

    if (isset($_POST["login"]) && $_POST["login"] == '1') {
        $_SESSION["email"]=$_POST["email"]; // Restore email field on page reload
        login($_POST["email"], $_POST["password"]);
    }

    // Redirect if already logged in
	if ($_SESSION["shash"] > 0) {redir('dashboard.php'); die();}

	include 'header.php';
?>


<body align="center">

    <div class="banner">Simplifying IT</div>

    <form action="index.php" method="post">

        <input type="email" placeholder="Email" name="email" class="input" value="<?php echo $_SESSION['email'] ?>" required>
        <br>
        <br>

        <input type="password" placeholder="Password" name="password" class="input" required>
        <br>
        <br>

        <font color="#E57373">
            <?php // Error outputs
                if ($_GET["msg"] == 'nomail') {echo "Email not found <br>";} 
                if ($_GET["msg"] == 'failed') {echo "Wrong Password <br>";} 
            ?>
    	</font>

    	<br>
            
        <button type="submit" class="outlined" name="login" value="1">LOGIN</button>

    </form>

    <a class="smallbutton" href="signup.php">SIGN UP</a>

</body>