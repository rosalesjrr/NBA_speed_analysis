<html>
<head>
<title>
</title>
</head>
<body>
<?php

//Extend max execution time
set_time_limit (720);


//Connect to NBA database
$connection = mysql_connect("localhost", "root", "") or die ("Unable to connect!"); 
mysql_select_db("NBA") or die ("Unable to select database!");

$theFile=fopen("pbp.txt","r");

//Initialize variables
$game_id = "";
$game_line = "";
$game_time = "";
$game_desc = "";

//creates an array of the elements from the play by play data
while (!feof($theFile)){ 

$string = fgets($theFile);
$game = explode("\t",$string);
$game_id = $game[0];
$game_line = $game[1];
$game_time = $game[2];
$game_desc = $game[3];

//Finds the game_date, HomeTeam, Away team from the game_id line
$game_date = substr($game_id,0,8);
$HomeTeam = substr($game_id,11,3);
$AwayTeam = substr($game_id,8,3);

//Checks if this game description is a score. Then calculates the HomeScore and AwayScore based on hyphen locations
$scoreyes = substr($game_desc,0,13);

if (strstr($scoreyes, '-') !== false){  
$HyphenPos = strpos($game_desc, "-");
$LastBracket = strpos($game_desc, "]");

if (substr($game_desc,1,3) == $HomeTeam){
	$HomeScore = (int)substr($game_desc,5,$HyphenPos - 5);
	$AwayScore = (int)substr($game_desc,$HyphenPos + 1,$LastBracket - $HyphenPos +1);
}else{
	$AwayScore = (int)substr($game_desc,5,$HyphenPos - 5);
	$HomeScore = (int)substr($game_desc,$HyphenPos + 1,$LastBracket - $HyphenPos +1);
}

//echo $HomeTeam . "=" . $HomeScore;
//echo "<br />";
//echo $AwayTeam . "=" . $AwayScore;
//echo "<br />";

//calculates the score difference to analyze runs throughout the game
$ScoreDiff = $HomeScore - $AwayScore;
echo $ScoreDiff;

// insert the data into the scoredifference table
mysql_query("INSERT INTO scoredifference (game_id, game_line, game_date, game_time, HomeTeam, AwayTeam, HomeScore, AwayScore, ScoreDiff) 
VALUES('$game_id', '$game_line', '$game_date', '$game_time', '$HomeTeam', '$AwayTeam', '$HomeScore', '$AwayScore', '$ScoreDiff') ") 
or die(mysql_error());
	
} //End Hyphen Find If

} //End of While
fclose($theFile);

?>
</body>
</html>
