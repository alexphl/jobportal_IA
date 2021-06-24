	<div id="menubar"> 		


	    <button class="inmenubar" id="filter_list" onclick="showFilters()" hidden><i class="material-icons">filter_list</i></button>

	    <?php if ($_SESSION["type"] == 0) {echo "<button class='inmenubar' id='browse'><a href='browse.php' style='color: white;''><i class='material-icons'>explore</i></a></button>";}?>
		

		<button class="inmenubar" id="agenda"><a href="dashboard.php" style="color: white;"><i class="material-icons">all_inbox</i></a></button>

		<button class="inmenubar" id="profile"><a href="profile.php" style="color: white;"><i class="material-icons">account_circle</i></a></button>


	</div>