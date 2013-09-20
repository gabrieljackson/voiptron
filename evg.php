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

$voiceXML = simplexml_load_file('config/voice.xml');

if ($voiceXML)
{
  $count = count($extensions);
  for ($i=0; $i<$count; $i++)
  {
    if (substr($extensions[$i], 0, 1) != "5")
    {
      $nodeCount = 0;
      foreach($voiceXML->voice_services->cucm->ip as $key => $cucm_ip)
      {
        $nodeCount += 1;
        echo "!" . "\n";
        echo "dial-peer voice " . $extensions[$i] . $nodeCount . " voip" . "\n";
        echo "preference " . $nodeCount . "\n";
        echo "destination-pattern " . $extensions[$i] . "\n";
        echo "progress_ind disconnect enable 8" . "\n";
        echo "voice-class codec 1" . "\n";
        echo "session target ipv4:" . $cucm_ip . "\n";
        echo "dtmf-relay h245-alphanumeric" . "\n";
        echo "no call fallback" . "\n";
        echo "fax rate disable" . "\n";
        echo "no vad" . "\n";
      }
      echo "!" . "\n";
    }
  }
}
else
{
  echo "No voice.xml configuration found in .config/voice.xml\n\n";
  echo "View README for details on how to build this file.";
}


header("Connection: close");
?>