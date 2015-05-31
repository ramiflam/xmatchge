<?php
include "navigationBar.php";
include "alert.php";
 $db=getDbConnection();
if ($db->connect_error) {
echo '<p>connection failed</p>';
}
$browserLanguage='en';
$langAllignment=getLangAllingment($db, $browserLanguage);
if ($langAllignment=='R2L') {
	$class='hebrew';
}
else {
	$class='english';
}

	 $query="SELECT bull_no,bull_name,CVM,KG_ECM,match_status,Heifer_status,Planned_usage,Actuall_inseminations,	Usage_order,From_insemination,To_insemination,Limited,General_size,General_udder,Teats_location,Udder_depth,General_legs,Pelvis_stucture,KG_milk,Fat_percentage,Protein_percentage,MGS,PGS,SCC,sire,StrawColor,StrawSize,StrawType
	  FROM `bulls_details`";
        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
        $result = mysqli_query($db, $query);
                $result_list = array();
                $counter=0;
         while($row = mysqli_fetch_array($result))
         {
          $sem_result[$counter]=$row[0]; //save sem results into array
          $counter=$counter+1;
}

/*************************************/

?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html/php" charset='utf-8' >
    <link rel="stylesheet" type="text/css" href="graph.css" />

</head>
<a id="try">nomi</a>
<span id="try">hello world!!!!!!!!!!!</span>
<button class="submit" type="submit" name="showall" id="try"
value="now" onclick="drawVisualization()">now</button>
<ul class="graph">
	<li class="percent20">20%</li>
	<li class="percent40">40%</li>
	<li class="percent60">60%</li>
	<li class="percent80">80%</li>
	<li class="percent100">100%</li>
</ul>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  <div id="chart_div"><div>
  <script>
google.load('visualization', '1', {packages: ['corechart', 'bar']});
google.setOnLoadCallback(drawMultSeries);

function drawMultSeries() {
      var data = google.visualization.arrayToDataTable([
        ['City', '2010 Population', '2000 Population'],
        ['New York City, NY', 1175000, 808000],
        ['Los Angeles, CA', 3792000, 3694000],
        ['Chicago, IL', 2695000, 2896000],
        ['Houston, TX', 2099000, 1953000],
        ['Philadelphia, PA', 1000000, 1517000],
        ['Philadelphia, PA', -1000000, -1517000]
      ]);

      var options = {
        title: 'Population of Largest U.S. Cities',
        chartArea: {width: '50%'},
        hAxis: {
          title: 'Total Population',
          minValue: 0
        },
        vAxis: {
          title: 'City'
        }
      };

      var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }


  </script>