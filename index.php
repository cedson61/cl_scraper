<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta property="og:title" content="">
  <meta property="og:type" content="">
  <meta property="og:url" content="">
  <meta property="og:image" content="">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <!-- Place favicon.ico in the root directory -->

  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/style.css">

  <meta name="theme-color" content="#fafafa">

<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
img {
    float: left;
    width:  100px;
    height: 100px;
    object-fit: cover;
}
</style>

</head>

<body>

<h1 style="text-align:center">Tesla Model 3 - Nationwide Search</h1>
<p style="text-align:center;"><button onclick="sortTable()">Sort</button></p>


<table id="listings">

<?php
$row = 1;
if (($handle = fopen("final.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
        $num = count($data);
        $row++;

        echo "<tr>";
        echo '<th><a target="_blank" href="' . $data[0] . '">' . $data[0] . '</a>'.'</th>';
        echo "<th>" . $data[1] . "</th>";
        echo "<td>" . $data[2] . "</td>";

        $imagestrings = str_replace("50x50c","600x450",$data[3]);

      	$imageurls = explode("|", $imagestrings);
      	echo "<th>";
      	foreach ($imageurls as $value) {
 			echo '<a target="_blank" href="'. $data[0] .'"><img style="max-width:20%" src="' . $value . '"></a>';
		}
      	echo "</th>";




 

        echo "</tr>";



    }
    fclose($handle);
}


?>
</table>
<script>

function sortTable() {
  var table, rows, switching, i, x, y, shouldSwitch;
  table = document.getElementById("listings");
  switching = true;
  /*Make a loop that will continue until
  no switching has been done:*/
  while (switching) {
    //start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /*Loop through all table rows (except the
    first, which contains table headers):*/
    for (i = 0; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements you want to compare,
      one from current row and one from the next:*/
      x = rows[i].getElementsByTagName("TD")[0];
      y = rows[i + 1].getElementsByTagName("TD")[0];
      //check if the two rows should switch place:
      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
        //if so, mark as a switch and break the loop:
        shouldSwitch = true;
        break;
      }
    }
    if (shouldSwitch) {
      /*If a switch has been marked, make the switch
      and mark that a switch has been done:*/
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
    }
  }
}


</script>
</body>

</html>