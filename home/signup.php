<?php 

    include 'functions.php';

    if (isset($_POST["newuser"]) && $_POST["newuser"] == '1') {
        session_start();
        makeAcc($_POST["firstname"], $_POST["lastname"], $_POST["comname"], $_POST["email"], $_POST["password"], $_POST["repass"], $_POST["acctype"]); 
        login($_POST["email"], $_POST["password"]); 
        redir('details.php?msg=new');
    }


    include 'header.php'
?>

<body align="center">

<div class="banner">Sign Up</div>

<form action="signup.php" method="post">

	<select class="input" name="acctype" onchange="yesnoCheck(this);">
 		<option value="0">Job Seeker</option>
 		<option value="1">Employer</option>
	</select>

	<br>
	<br>

	<div id="dynamic1">
    <input type="text" placeholder="First name" name="firstname" class="input" required>
    <br>
    <br>

    <input type="text" placeholder="Last name" name="lastname" class="input" required>
    <br>
    <br>
	</div>

	<div id="dynamic2">
    <input type="text" placeholder="Company name" name="comname" class="input" required>
    <br>
    <br>
	</div>

    <input type="email" placeholder="Email" name="email" class="input" required>
    <br>
    <br>

    <input type="password" placeholder="Password" name="password" class="input" required>
    <br>
    <br>

    <input type="password" placeholder="Repeat password" name="repass" class="input" required>
    <br>
    <br>

    <font color="#E57373">
	<?php if (isset($_GET["msg"]) && $_GET["msg"] == 'badmail') {
	echo "Please enter a valid email <br>";} ?>

    <?php if (isset($_GET["msg"]) && $_GET["msg"] == 'mismatch') {
	echo "Password mismatch <br>";} ?>

	<?php if (isset($_GET["msg"]) && $_GET["msg"] == 'mailinuse') {
	echo "An account already exists for this email <br>";} ?>
	</font>

    
    <br>
        
    <button type="submit" class="outlined" name="newuser" value="1">SIGN UP</button>

</form>

</body>

<script>
	$('#dynamic2').hide();
	$('#dynamic2 :input').prop('required',null);

function yesnoCheck(that) {

        if (that.value == "1") {
        	$('#dynamic1').hide();
        	$('#dynamic1 :input').prop('required',null);
        	$('#dynamic2').show();
        	$('#dynamic2 :input').prop('required',1);
        } 

        else {
        	$('#dynamic2').hide();
        	$('#dynamic2 :input').prop('required',null);
        	$('#dynamic1').show();
        	$('#dynamic1 :input').prop('required',1);
        }
    }

</script>
