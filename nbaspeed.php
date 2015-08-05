<!DOCTYPE html>
<meta charset="utf-8">
<style>

.bar {
  fill: steelblue;
}

.bar:hover {
  fill: brown;
}

.axis {
  font: 10px sans-serif;
}

.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

.x.axis path {
  display: none;
}

</style>

<style>
table, th, td
{
border-collapse:collapse;
border:1px solid black;
margin: 30px 0;
}
th, td
{
padding:3px;
}
</style>

<body>

<h1>NBA Speed Analytics</h1>
<p>Developed by Roger Rosales (roger@actuwaiters.com). Data comes from NBA.com SportsVU data.</p>

<p>The players in this study averaged over 25 minutes per game during the 2013-2014 regular season.</p>



<form method="post" action="nbaspeed.php">

	<p>
	<span style=background-color:steelblue;color:#ffffff;><strong>--- Select a Position --- </strong></span><br />
	<select name="position" size="1">
		<option value=""></option>
		<option value="PG">Point Guard</option>
		<option value="SG">Shooting Guard</option>
		<option value="SF">Small Forward</option>
		<option value="PF">Power Forward</option>
		<option value="Center">Center</option>
		<option value="Guard">Guard</option>
		<option value="Forward">Forward</option>
		<option value="Allpos">All Positions</option>
	</select>
	</p>

	<p>
	<input type="submit" value="Retrieve Information">
	</p>

</form>

<?php

	
	
	if (empty($_POST)) {
	
	 die ("Choose a position");
	 } 
	 
	 $position = $_POST['position'];

	echo "<p>Here is the distribution of NBA players playing <strong>$position</strong> by their average speed.</p>";
	echo "<p>Measured by miles per hour (MPH).</p>";
	?>

</body>

<script src="http://d3js.org/d3.v3.min.js"></script>
<script>

var margin = {top: 30, right: 40, bottom: 100, left: 50},
    width = 960 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

var x = d3.scale.ordinal()
    .rangeRoundBands([0, width], .1);

var y = d3.scale.linear()
    .range([height, 0]);

var xAxis = d3.svg.axis()
    .scale(x)
    .orient("bottom");

var yAxis = d3.svg.axis()
    .scale(y)
    .orient("left")
    .ticks(10);

var svg = d3.select("body").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
  .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

d3.tsv("<?php echo $position ?>.txt", type, function(error, data) {
  x.domain(data.map(function(d) { return d.LastName; }));
  y.domain([0, d3.max(data, function(d) { return d.AvgSpeed; })]);

  svg.append("g")
        .attr("class", "x axis")
        .attr("transform", "translate(0," + height + ")")
		.transition()
		.duration(1000)
        .call(xAxis)
        .selectAll("text")  
            .style("text-anchor", "end")
            .attr("dx", "-.8em")
            .attr("dy", ".15em")
            .attr("transform", function(d) {
                return "rotate(-65)" 
                });

  svg.append("g")
      .attr("class", "y axis")
      .call(yAxis)
    .append("text")
      .attr("transform", "rotate(-90)")
      .attr("y", 6)
      .attr("dy", ".71em")
      .style("text-anchor", "end")
      .text("AvgSpeed (MPH)");

  svg.selectAll(".bar")
      .data(data)
    .enter().append("rect")
      .attr("class", "bar")
      .attr("x", function(d) { return x(d.LastName); })
      .attr("width", x.rangeBand())
      .attr("y", function(d) { return y(d.AvgSpeed); })
      .attr("height", function(d) { return height - y(d.AvgSpeed); })
	 .transition()
	 .duration(1000);
	  
 
	  
	  

});



function type(d) {
  d.AvgSpeed = +d.AvgSpeed;
  return d;
}

</script>

<body>



<?php

//Connect to NBA database
	$connection = mysql_connect("db534612746.db.1and1.com", "dbo534612746", "NBAdb123@") or die ("Unable to connect!"); 
	mysql_select_db("db534612746") or die ("Unable to select database!");
	
	$result = mysql_query("Select COUNT(*) AS n, AVG(AvgSpeed), MAX(AvgSpeed), MIN(AvgSpeed), AVG(Age), AVG(Experience) from Speed where $position = 1 and MPG >= 25") or die(mysql_error());

echo "<table border='1' >";

echo "<tr style=background-color:steelblue;color:#ffffff;><th>Number of Players</th><th>Avg Speed</th> <th>Maximum Speed</th> <th>Minimum Speed (MPH)</th><th>Avg Age</th> <th>Avg Years of Experience</th></tr>";
	
	while($row = mysql_fetch_array($result)){
	echo "<tr><td align='center'>"; 
	echo $row['n'];
	echo "</td><td align='center'>";
	echo $row['AVG(AvgSpeed)'];
	echo "</td><td align='center'>";  
	echo $row['MAX(AvgSpeed)'];
	echo "</td><td align='center'>"; 
	echo $row['MIN(AvgSpeed)'];
	echo "</td><td align='center'>"; 
	echo $row['AVG(Age)'];
	echo "</td><td align='center'>";
	echo $row['AVG(Experience)'];
	echo "</td></tr>"; 

	}
	
	?>



<?php

//Connect to NBA database
	$connection = mysql_connect("db534612746.db.1and1.com", "dbo534612746", "NBAdb123@") or die ("Unable to connect!"); 
	mysql_select_db("db534612746") or die ("Unable to select database!");
	
	$result = mysql_query("Select LastName, FirstName, TeamAbbr, AvgSpeed, Age, Experience, MPG, Salary/1000000 as Asalary from Speed where $position = 1 and MPG >= 25") or die(mysql_error());

	//create an array of the scoredifference. Used as the data elements for the javascript chart
	$my_data_array = "var data = [";
	
	
	
	//create a speed table for the game selected

echo "<table border='1' >";

echo "<tr style=background-color:steelblue;color:#ffffff;> <th>Last Name</th> <th>First Name</th> <th>Team</th> <th>Average Speed (MPH)</th><th>Age</th> <th>NBA Years of Experience</th><th>Minutes Per Game (MPG)</th><th>Salary (millions)</th> </tr>";
	
	while($row = mysql_fetch_array($result)){
	echo "<tr><td align='center'>"; 
	echo $row['LastName'];
	echo "</td><td align='center'>";
	echo $row['FirstName'];
	echo "</td><td align='center'>"; 
	echo $row['TeamAbbr'];
	echo "</td><td align='center'>"; 
	echo $row['AvgSpeed'];
	echo "</td><td align='center'>"; 
	echo $row['Age'];
	echo "</td><td align='center'>"; 
	echo $row['Experience'];
	echo "</td><td align='center'>";
	echo $row['MPG'];
	echo "</td><td align='center'>";
	echo $row['Asalary'];
	echo "</td></tr>"; 

	}
	
	?>
	

	
	</body>
