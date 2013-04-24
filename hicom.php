<?php

function add_building(&$value)
{
  global $building;
  $value = $value . " " . $building;
}

$building = $_GET['building'];
$phoneModels = $_GET['phoneModels'];
$MACs = $_GET['MACs'];
$extensions = $_GET['extensions'];
$offices = $_GET['offices'];

$seperator = "*EXPLODE*";

$phoneModels = explode($seperator, $phoneModels);
$MACs = explode($seperator, $MACs);
$extensions = explode($seperator, $extensions);
$offices = explode($seperator, $offices);
array_walk($offices, 'add_building');


// output headers so that the file is downloaded rather than displayed
header("Content-Type: text/txt; charset=utf-8");
header("Content-Disposition: attachment; filename=" . $building . "-hicom.txt");

echo "PASTE ONE COMMAND AT A TIME\n";

$count = count($extensions);
for ($i=0; $i<$count; $i++)
{
echo "#\n";
echo "DEA-DSSU:,STNO," . $extensions[$i] . ",;\n";
echo "DEL-SCSU:" . $extensions[$i] . ",all;\n";
echo "CHANGE-DPLN:DGTS," . $extensions[$i] . ",10;\n";
}


header("Connection: close");
?>