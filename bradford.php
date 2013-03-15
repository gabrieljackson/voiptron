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
header("Content-Disposition: attachment; filename=" . $building . "-Bradford.csv");


// Make CSV Header
echo "adap.mac,host.devType,host.topo,host.expireDate,host.hwType,host.host,host.inact,host.owner,host.role,siblings" . "\n";

$count = count($phoneModels);
for ($i=0; $i<$count; $i++)
{
  echo $MACs[$i] . ",IP Phone,,,IP Phone - " . $phoneModels[$i] . ",SEP" . $MACs[$i] . ",,,NAC-Default," . $MACs[$i]  . "\n";
}

header("Connection: close");
?>