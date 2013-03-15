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
header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=" . $building . "-" . $phoneModels[0] . "-UCM.csv");


// Make CSV Header
echo "MAC ADDRESS,DESCRIPTION,DIRECTORY NUMBER  1,ROUTE PARTITION  1,LINE DESCRIPTION  1,DISPLAY  1,ASCII DISPLAY  1,ALERTING NAME  1,ASCII ALERTING NAME  1" . "\n";

$count = count($phoneModels);
for ($i=0; $i<$count; $i++)
{
  echo $MACs[$i] . ",DESCRIPTION," . $extensions[$i] . ",AllPhones,LINE DESCRIPTION," .  $offices[$i] . "," .  $offices[$i] . "," .  $offices[$i] . "," .  $offices[$i] . "," . "\n";
}

header("Connection: close");
?>