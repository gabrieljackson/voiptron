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
header("Content-Disposition: attachment; filename=" . $building . "-EVG.txt");


$count = count($extensions);
for ($i=0; $i<$count; $i++)
{
  if (substr($extensions[$i], 0, 1) != "5")
  {
    echo "!" . "\n";
    echo "dial-peer voice " . $extensions[$i] . "1 voip" . "\n";
    echo "preference 1" . "\n";
    echo "destination-pattern " . $extensions[$i] . "\n";
    echo "progress_ind disconnect enable 8" . "\n";
    echo "voice-class codec 1" . "\n";
    echo "session target ipv4:141.210.3.11" . "\n";
    echo "dtmf-relay h245-alphanumeric" . "\n";
    echo "no call fallback" . "\n";
    echo "fax rate disable" . "\n";
    echo "no vad" . "\n";
    echo "!" . "\n";
    echo "dial-peer voice " . $extensions[$i] . "2 voip" . "\n";
    echo "preference 2" . "\n";
    echo "destination-pattern " . $extensions[$i] . "\n";
    echo "progress_ind disconnect enable 8" . "\n";
    echo "voice-class codec 1" . "\n";
    echo "session target ipv4:141.210.3.12" . "\n";
    echo "dtmf-relay h245-alphanumeric" . "\n";
    echo "no call fallback" . "\n";
    echo "fax rate disable" . "\n";
    echo "no vad" . "\n";   
    echo "!" . "\n";
  }
}


header("Connection: close");
?>