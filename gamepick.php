<!--Form to select team for runs analysis. Team name sent tot process.php.-->
<html><body>
<h4>Runs Analysis</h4>
<form action="process.php" method="post"> 
<select name="team"> 
<option>ATL</option>
<option>BOS</option>
<option>CHA</option>
<option>CHI</option>
<option>CLE</option>
<option>DAL</option>
<option>DEN</option>
<option>DET</option>
<option>GSW</option>
<option>HOU</option>
<option>IND</option>
<option>LAC</option>
<option>LAL</option>
<option>MEM</option>
<option>MIA</option>
<option>MIL</option>
<option>MIN</option>
<option>NJN</option>
<option>NOH</option>
<option>NYK</option>
<option>OKC</option>
<option>ORL</option>
<option>PHI</option>
<option>PHX</option>
<option>POR</option>
<option>SAC</option>
<option>SAS</option>
<option>TOR</option>
<option>UTA</option>
<option>WAS</option>

</select>

<!--User then selects if their team is playing at home or away-->
<select name="homeaway"> 
<option>Home</option>
<option>Away</option>
</select> 
<input type="submit" />
</form>
</body></html>
