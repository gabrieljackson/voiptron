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


    <div id="downloadsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Interface Description Script</h3>
      </div>
      <div class="modal-body">
        <pre>
      <?php
      if(isset($_GET['building']))
      {
        $building = $_GET['building'];
        $MACs = $_GET['MACs'];
        $offices = $_GET['offices'];
        $CDP = $_GET['CDP'];
        
        
        $seperator = "*EXPLODE*";
        $MACs = preg_replace('/\n/', $seperator, $MACs);
        $offices = preg_replace('/\n/', $seperator, $offices);
        $CDP = preg_replace('/\n/', $seperator, $CDP);
        
        $MACs = explode($seperator, $MACs);
        $offices = explode($seperator, $offices);
        $CDP = explode($seperator, $CDP);
        
        // ###### Clean and format the arrays #######
        function trim_value(&$value) 
        {
          $value = trim($value); 
        }
        function upper_value(&$value) 
        {
          $value = strtoupper($value);
        }
        array_walk($MACs, 'trim_value');
        array_walk($MACs, 'upper_value');
        array_walk($offices, 'trim_value');
        // ##########################################
        
        function add_building(&$value)
        {
          global $building;
          $value = $value . " " . $building;
        }
        array_walk($offices, 'add_building');

        $warning = "";
        $CDPcount = count($CDP);
        for ($i=0; $i<$CDPcount; $i++)
        {
          if (substr($CDP[$i], 0, 3) == "SEP")
          {
  	        $curCDPMAC = strtoupper(substr($CDP[$i], 3, 12));
  	        $curCDPInt = substr($CDP[$i], 17, 10);
  	        $MACcount = count($MACs);
	        for ($ii=0; $ii<$MACcount; $ii++)
            {
              if ($MACs[$ii] == $curCDPMAC)
  	          {
  	  	        echo "interface " . $curCDPInt . "</br>";
    	        echo "desc " . $offices[$ii] . "</br>";
		        echo "!" . "</br>";
		        $foundMAC = 1;
              } 	
            }
            if ($foundMAC != 1)
            {
              if ($warning == "")
              {
                $warning = $curCDPMAC;
              }
              else
              {
                $warning = $warning . "</br>" . $curCDPMAC;
              }
            }
            unset($foundMAC);
          }
        }
      }
      echo "</pre>";
      echo "</div>";
      echo "<div class=\"modal-footer\">";
      if ($warning == "")
      {
        echo "<div class=\"alert alert-success\" style=\"text-align: left;\">";
        echo "<strong>Success!</strong> All CDP MAC addresses matched.";
        echo "</div>";
      }
      else
      {
        echo "<div class=\"alert alert-error\" style=\"text-align: left;\">";
        echo "<strong>Warning!</strong> No office match found on the following CDP MAC addresses.";
        echo "</br></br>";
        echo $warning;
        echo "</div>";
      }
      ?>
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

    <div class="container">
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">VoipTron</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="./index.php">Deploy Phones</a></li>
              <li class="active"><a href="./interface-description-builder.php">Interface Description Builder</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
      <form action='interface-description-builder.php' method='GET'>
        <fieldset>
          <div class="form-group">
            <input name="building" class="form-control" type="text" placeholder="Building">
          </div>
          <div class="row">
            <div class="col-md-2"><div class="form-group"><textarea name="offices" class="form-control" rows="25" placeholder="Offices/Locations"></textarea></div></div>
            <div class="col-md-2"><div class="form-group"><textarea name="MACs" class="form-control" rows="25" placeholder="MAC Addresses"></textarea></div></div>
            <div class="col-md-8"><div class="form-group"><textarea name="CDP" class="form-control" rows="25" placeholder="CDP Output"></textarea></div></div>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </fieldset>
      </form>
    </div>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>

<?php
  if(isset($_GET['building']))
  {
    echo "<script type=\"text/javascript\">$('#downloadsModal').modal('show');</script>";
  }
?>

  </body>
</html>
