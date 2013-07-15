<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>VoIP Tron</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

    <style>
      body {
        padding-top: 20px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="../assets/ico/favicon.png">

  </head>
  <body>

    <?php
      if(isset($_GET['building']))
      {
        $building = $_GET['building'];
        $extensions = $_GET['extensions'];
        $MACs = $_GET['MACs'];
        $phoneModels = $_GET['phoneModels'];
        $offices = $_GET['offices'];
        
        $seperator = "*EXPLODE*";
        $extensions = preg_replace('/\n/', $seperator, $extensions);
        $MACs = preg_replace('/\n/', $seperator, $MACs);
        $phoneModels = preg_replace('/\n/', $seperator, $phoneModels);
        $offices = preg_replace('/\n/', $seperator, $offices);
        
        $extensionArray = explode($seperator, $extensions);
        $MACArray = explode($seperator, $MACs);
        $phoneModelArray = explode($seperator, $phoneModels);
        $officeArray = explode($seperator, $offices);
        
        // ###### Clean and format the arrays #######
        function trim_value(&$value) 
        {
          $value = trim($value); 
        }
        function upper_value(&$value) 
        {
          $value = strtoupper($value);
        }
        array_walk($extensionArray, 'trim_value');
        array_walk($MACArray, 'trim_value');
        array_walk($MACArray, 'upper_value');
        array_walk($phoneModelArray, 'trim_value');
        array_walk($officeArray, 'trim_value');
        // ##########################################
        
        $uniquePhoneModels = array_unique($phoneModelArray);
        
        $extensions = "";
        foreach ($extensionArray as &$value)
        {
          $extensions = $extensions . $value . "*EXPLODE*";
        }
        $extensions = substr($extensions, 0, -9);
        unset($value); // break the reference with the last element
        $MACs = "";
        foreach ($MACArray as &$value)
        {
          $MACs = $MACs . $value . "*EXPLODE*";
        }
        $MACs = substr($MACs, 0, -9);
        unset($value); // break the reference with the last element
        $phoneModels = "";
        foreach ($phoneModelArray as &$value)
        {
          $phoneModels = $phoneModels . $value . "*EXPLODE*";
        }
        $phoneModels = substr($phoneModels, 0, -9);
        unset($value); // break the reference with the last element
        $offices = "";
        foreach ($officeArray as &$value)
        {
          $offices = $offices . $value . "*EXPLODE*";
        }
        $offices = substr($offices, 0, -9);
        unset($value); // break the reference with the last element
      }
    ?>

    <div id="downloadsModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <h3 id="downloadsModalLabel">Downloads</h3>
      </div>
      <div class="modal-body">
        <p>Get them while they're hot!</p>
        <a href="bradford.php?<?php echo "building=" . $building . "&extensions=" . $extensions . "&MACs=" . $MACs . "&phoneModels=" . $phoneModels . "&offices=" . $offices ?>" type="submit" class="btn btn-block btn-info">Bradford Host CSV</a>
        <a href="evg.php?<?php echo "building=" . $building . "&extensions=" . $extensions . "&MACs=" . $MACs . "&phoneModels=" . $phoneModels . "&offices=" . $offices ?>" type="submit" class="btn btn-block btn-info">EVG Script</a>
        <a href="hicom.php?<?php echo "building=" . $building . "&extensions=" . $extensions . "&MACs=" . $MACs . "&phoneModels=" . $phoneModels . "&offices=" . $offices ?>" type="submit" class="btn btn-block btn-info">Hicom Script</a>
    <?php
      function make_ucm_button(&$value)
      {
        global $building, $extensionArray, $MACArray, $phoneModelArray, $officeArray;
        $ucmExtensions = "";
        $ucmMACs = "";
        $ucmPhoneModels = "";
        $ucmOffices = "";
        $count =  count($phoneModelArray);
        for ($i=0; $i<$count; $i++)
        {
          if ($phoneModelArray[$i] == $value)
          {
            $ucmExtensions = $ucmExtensions . $extensionArray[$i] . "*EXPLODE*";
            $ucmMACs = $ucmMACs . $MACArray[$i] . "*EXPLODE*";
            $ucmPhoneModels = $ucmPhoneModels . $phoneModelArray[$i] . "*EXPLODE*";
            $ucmOffices = $ucmOffices . $officeArray[$i] . "*EXPLODE*";
          }
        }
      $ucmExtensions = substr($ucmExtensions, 0, -9);
      $ucmMACs = substr($ucmMACs, 0, -9);
      $ucmPhoneModels = substr($ucmPhoneModels, 0, -9);
      $ucmOffices = substr($ucmOffices, 0, -9);
      echo "<div style=\"margin-left: 0px;\" class=\"btn-group btn-block\">";
      echo "<a style=\"width: 240px;\" href=\"ucm.php?building=$building&extensions=$ucmExtensions&MACs=$ucmMACs&phoneModels=$ucmPhoneModels&offices=$ucmOffices&css=AllPhones\" type=\"submit\" class=\"btn btn-info\">Cisco $value UCM CSV</a>";
      echo "<a style=\"width: 240px;\" href=\"ucm.php?building=$building&extensions=$ucmExtensions&MACs=$ucmMACs&phoneModels=$ucmPhoneModels&offices=$ucmOffices&css=The_Workbench\" type=\"submit\" class=\"btn btn-info\">Cisco $value Setup UCM CSV</a>";
      echo "\n";
      echo "</div>";
      // Reset the UCM variables
      $ucmExtensions = "";
      $ucmMACs = "";
      $ucmPhoneModels = "";
      }
      array_walk($uniquePhoneModels, 'make_ucm_button');
    ?>
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
      </div>
    </div>

    <div class="container">
      <div class="navbar navbar-inverse">
        <div class="navbar-inner">
          <a class="brand" href="#">VoIP Tron</a>
          <ul class="nav">
          </ul>
        </div>
      </div>
      <form action='index.php' method='GET'>
        <fieldset>
          <input name="building" class="input-block-level" type="text" placeholder="Building">
          <div class="row">
            <div class="span3"><textarea name="extensions" class="input-block-level" rows="25" placeholder="Extensions"></textarea></div>
            <div class="span3"><textarea name="phoneModels" class="input-block-level" rows="25" placeholder="Phone Models"></textarea></div>
            <div class="span3"><textarea name="MACs" class="input-block-level" rows="25" placeholder="MAC Addresses"></textarea></div>
            <div class="span3"><textarea name="offices" class="input-block-level" rows="25" placeholder="Offices/Locations"></textarea></div>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </fieldset>
      </form>
    </div>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

<?php
  if(isset($_GET['building']))
  {
    echo "<script type=\"text/javascript\">$('#downloadsModal').modal('show');</script>";
  }
?>

  </body>
</html>
