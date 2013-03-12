<?php

$building = $_GET['building'];
$get_phoneModel = $_GET['phoneModel'];
$get_MAC = $_GET['MAC'];

// output headers so that the file is downloaded rather than displayed
header("Content-Type: text/csv; charset=utf-8");
header("Content-Disposition: attachment; filename=" . $building . "-Bradford.csv");

$seperator = "*EXPLODE*";

$phoneModel = explode($seperator, $get_phoneModel);
$MAC = explode($seperator, $get_MAC);

// Make CSV Header
echo "adap.mac,host.devType,host.topo,host.expireDate,host.hwType,host.host,host.inact,host.owner,host.role,siblings" . "\n";

$count = count($phoneModel);
for ($i=0; $i<$count; $i++)
{
  echo $MAC[$i] . ",IP Phone,,,IP Phone - " . $phoneModel[$i] . ",SEP" . $MAC[$i] . ",,,NAC-Default," . $MAC[$i]  . "\n";
}

header("Connection: close");
?>
