<?php

$building = $_GET['building'];
$get_extension = $_GET['extension'];

// output headers so that the file is downloaded rather than displayed
header("Content-Type: text/txt; charset=utf-8");
header("Content-Disposition: attachment; filename=" . $building . "-EVG.txt");

$seperator = "*EXPLODE*";

$extension = explode($seperator, $get_extension);

$count = count($extension);
for ($i=0; $i<$count; $i++)
{
echo "!" . "\n";
echo "dial-peer voice " . $extension[$i] . "1 voip" . "\n";
echo "preference 1" . "\n";
echo "destination-pattern " . $extension[$i] . "\n";
echo "progress_ind disconnect enable 8" . "\n";
echo "voice-class codec 1" . "\n";
echo "session target ipv4:141.210.3.11" . "\n";
echo "dtmf-relay h245-alphanumeric" . "\n";
echo "no call fallback" . "\n";
echo "fax rate disable" . "\n";
echo "no vad" . "\n";
echo "!" . "\n";
echo "dial-peer voice " . $extension[$i] . "2 voip" . "\n";
echo "preference 2" . "\n";
echo "destination-pattern " . $extension[$i] . "\n";
echo "progress_ind disconnect enable 8" . "\n";
echo "voice-class codec 1" . "\n";
echo "session target ipv4:141.210.3.12" . "\n";
echo "dtmf-relay h245-alphanumeric" . "\n";
echo "no call fallback" . "\n";
echo "fax rate disable" . "\n";
echo "no vad" . "\n";   
echo "!" . "\n";
}


header("Connection: close");
?>
