<?php 			
	$mysqli = new mysqli("127.0.0.1", "anon", "123", "SIT");
	$pass = mysqli_query($mysqli,"SELECT * FROM JOBS JOIN EMPLOYERS ON company_email=email WHERE JOBS.id='$job_id' ORDER BY JOBS.id DESC");
	$result = mysqli_fetch_array($pass);
?>

<div id="card">
		    
	<div id="cardpic">

		<div id="imagemask" class="cardlogo" style="margin: 0; margin-left: auto; margin-right: auto;"> 

		<img style="width: 100%; height: 100%; object-fit: cover; border-radius: 100%;" src=<?php echo '"data/users/'.$result["company_email"].'/profilepic"'?> onerror="this.src='data/placeholder2.svg';">

		</div>

		<div style="grid-column: 2; box-sizing: border-box; padding-right: 20; padding-top: 10; overflow: scroll;">
			<?php echo $result["name"]?>
			<br>
			<p style="font-size: 0.65em; line-height: 0%; font-weight: 500;">at <?php echo $result["comname"];?></p>
		</div>

	</div>


	<div id="cardcontent"> 
		<a href="viewjob_seeker.php?id=<?php echo $job_id?>"><button class="incard">MORE</button></a> 

		<p style="grid-row-end: 1; margin: 0; padding: 0; font-size: 0.95em; overflow: scroll; height: 100%; padding-bottom: 10%;" align="justify"><?php echo nl2br($result["description"]) ?></p>
	</div> 

</div>