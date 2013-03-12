<?php

function add_building(&$value)
{
  global $building;
  $value = $value . " " . $building;
}

$building = $_GET['building'];
$get_phoneModel = $_GET['phoneModel'];
$get_MAC = $_GET['MAC'];
$get_Extension = $_GET['extension'];
$get_Office = $_GET['office'];

$seperator = "*EXPLODE*";

$phoneModel = explode($seperator, $get_phoneModel);
$MAC = explode($seperator, $get_MAC);
$Extension = explode($seperator, $get_Extension);
$Location = explode($seperator, $get_Office);

array_walk($Location, 'add_building');

// output headers so that the file is downloaded rather than displayed
header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=" . $building . "-" . $phoneModel[0] . "-UCM.csv");

// Make CSV Header
echo "MAC ADDRESS,DESCRIPTION,DIRECTORY NUMBER  1,ROUTE PARTITION  1,LINE DESCRIPTION  1,DISPLAY  1,ASCII DISPLAY  1,ALERTING NAME  1,ASCII ALERTING NAME  1" . "\n";

$count = count($phoneModel);
for ($i=0; $i<$count; $i++)
{
  echo $MAC[$i] . ",DESCRIPTION," . $Extension[$i] . ",AllPhones,LINE DESCRIPTION," .  $Location[$i] . "," .  $Location[$i] . "," .  $Location[$i] . "," .  $Location[$i] . "," . "\n";
}

header("Connection: close");
?>
