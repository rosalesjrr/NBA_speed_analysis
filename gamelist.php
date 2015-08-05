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

$theFile=fopen("gamelist.txt","r");

//Initialize variables
$league = "";
$year = "";
$game_date = "";
$game_id = "";
$boxscoreurl = "";
$pbpurl = "";
$homenamef = "";
$HomeTeam = "";
$awaynamef = "";
$AwayTeam = "";
$HaveBox = "";
$Havepbp = "";
$analypbp = "";

//create various arrays of the gamelist.txt file
while (!feof($theFile)){ 

$string = fgets($theFile);
$game = explode("\t",$string);
$league = $game[0];
$year = $game[1];
$game_date = $game[2];
$game_id = $game[3];
$boxscoreurl = $game[4];
$pbpurl = $game[5];
$homenamef = $game[6];
$HomeTeam = $game[7];
$awaynamef = $game[8];
$AwayTeam = $game[9];
$HaveBox = $game[10];
$Havepbp = $game[11];
$analypbp = $game[12];

// insert data into the gamelist table. Used as drop downs for selecting opposing opponent/game_date combinations
mysql_query("INSERT INTO gamelist (game_date, game_id, homenamef, HomeTeam, awaynamef, AwayTeam)
VALUES('$game_date', '$game_id', '$homenamef', '$HomeTeam', '$awaynamef', '$AwayTeam') ") 
or die(mysql_error());
	


} //End of While
fclose($theFile);

?>
</body>
</html>
