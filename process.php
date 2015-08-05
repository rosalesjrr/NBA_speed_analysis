<html><body>
<?php

//gets the team and homeaway variables from the user via gamepick.php
$team = $_POST['team'];
$homeaway = $_POST['homeaway'];

//prints out information based on user inputs from gamepick.php
echo "You've selected ". $team . " as the " . $homeaway . " team. <br />";

echo "Select the game ID which includes the date and the opposing team. <br />";

echo"<br />";

//Extend max execution time
set_time_limit (720);


//Connect to NBA database
$connection = mysql_connect("localhost", "root", "") or die ("Unable to connect!"); 
mysql_select_db("NBA") or die ("Unable to select database!");


//if user selects an away team then query gamelist based on AwayTeam selection. This populates the opposing team and date drop down in the form below
if ( $homeaway == 'Away' ) {
$result = mysql_query("Select game_date, game_id  from gamelist where AwayTeam = '" . $team. "'") or die(mysql_error());
} else {
$result = mysql_query("Select game_date, game_id from gamelist where HomeTeam = '" . $team. "'") or die(mysql_error());
}

//sets and creates an array of possible options to select different opponents and game date combinations
$options=""; 

while ($row=mysql_fetch_array($result)) { 

    $game_date=$row["game_date"];  
	$game_id=$row["game_id"];  
    $options.="<OPTION VALUE=\"$game_id\">".$game_id.'</option>';
} 
?>

<!--this is a form of picking different opponents and game_date combinations to see the runs analysis. game_id sent to gametable2.php-->
<form action="runsoutput.php" method="post"> 
<select name="game_id"> 
<OPTION VALUE=0>
<?php echo $options ?>
</select>
<input type="submit" />
</form>




</body></html>
