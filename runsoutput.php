<!DOCTYPE html>
<meta charset="utf-8">
<style>

.bar.positive {
  fill: steelblue;
}

.bar.negative {
  fill: brown;
}

.axis text {
  font: 10px sans-serif;
}

.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}
</style>
    <body>
	<?php

//Gets the game_id from process.php	
$game_id = $_POST['game_id'];

//Connect to NBA database
$connection = mysql_connect("localhost", "root", "") or die ("Unable to connect!"); 
mysql_select_db("NBA") or die ("Unable to select database!");

//queries the scoredifference table based on the game_id selection
$result = mysql_query("Select * from scoredifference WHERE game_id = '" . $game_id. "' ORDER BY game_line") or die(mysql_error());

//create an array of the scoredifference. Used as the data elements for the javascript chart
$my_data_array = "var data = [";

//create a runs analysis table for the game selected
echo "<table border='1'>";
echo "<tr> <th>Home</th> <th>Home Score</th> <th>Away</th> <th>Away Score</th><th>Time</th> <th>Score Difference (Home Score - Away Score)</th> </tr>";


// Print out the contents of the entry and prints to html table

while($row = mysql_fetch_array($result)){
echo "<tr><td>"; 
echo $row['HomeTeam'];
echo "</td><td>";
echo $row['HomeScore'];
echo "</td><td>"; 
echo $row['AwayTeam'];
echo "</td><td>"; 
echo $row['AwayScore'];
echo "</td><td>"; 
echo $row['game_time'];
echo "</td><td>"; 
echo $row['ScoreDiff'];
echo "</td></tr>"; 
$my_data_array = $my_data_array.$row['ScoreDiff'].","; //append the data into the array 

}

//take out the trailing comma (since the last item will have a comma after it but shouldn’t)
//use the substr function
$my_data_array = substr($my_data_array, 0, -1);

?>


<script src="http://d3js.org/d3.v3.min.js"></script>
<script>

<!--prints out var data = [my_data_array] used as the data to graph in javascript-->
<?php echo $my_data_array."]"?>;

<!-- d3js bar graphing code-->
var margin = {top: 30, right: 10, bottom: 10, left: 10},
    width = 960 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

var x0 = Math.max(-d3.min(data), d3.max(data));

var x = d3.scale.linear()
    .domain([-x0, x0])
    .range([0, width])
    .nice();

var y = d3.scale.ordinal()
    .domain(d3.range(data.length))
    .rangeRoundBands([0, height], .2);

var xAxis = d3.svg.axis()
    .scale(x)
    .orient("top");

var svg = d3.select("body").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
  .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

svg.selectAll(".bar")
    .data(data)
  .enter().append("rect")
    .attr("class", function(d) { return d < 0 ? "bar negative" : "bar positive"; })
    .attr("x", function(d) { return x(Math.min(0, d)); })
    .attr("y", function(d, i) { return y(i); })
    .attr("width", function(d) { return Math.abs(x(d) - x(0)); })
    .attr("height", y.rangeBand());

svg.append("g")
    .attr("class", "x axis")
    .call(xAxis);

svg.append("g")
    .attr("class", "y axis")
  .append("line")
    .attr("x1", x(0))
    .attr("x2", x(0))
    .attr("y1", 0)
    .attr("y2", height);

</script>
    </body>
</html>
