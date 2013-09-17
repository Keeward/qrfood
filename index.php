<!DOCTYPE html>
<?php
	$qr=false;
	$meal_name='QRFood - QRcode generator that contains meals nutritional informations for your menus';

	// converts string to hexadecimal string (for foursquare id)
	function str2hex($hex)
	{
		$tmp='';
		for ($i = 0; $i < strlen($hex); $i++) {
			$tmp .= (dechex(ord(substr($hex,$i,1))));
		}
		return $tmp;
	}
	
	
	if(strlen($_SERVER["REQUEST_URI"])>1 && strpos($_SERVER["REQUEST_URI"],'/index.php')===false){
		$qr=true;
		
		// decode base64 data
		$data= base64_decode(substr($_SERVER["REQUEST_URI"],1));
		
		// name is after 32nd byte
		$meal_name = substr($data,32);
		
		// foursquare id is between byte 20 and byte 32
		$foursquare_id=str2hex(substr($data,20,12));
		
		// get all int values
		$weight			=	ord(substr($data,0,1))*256+ord(substr($data,1,1));
		$calories		=	ord(substr($data,2,1))*256+ord(substr($data,3,1));
		$saturated_fat		=	ord(substr($data,4,1))*256+ord(substr($data,5,1));
		$unsaturated_fat	=	ord(substr($data,6,1))*256+ord(substr($data,7,1));
		$sodium			=	ord(substr($data,8,1))*256+ord(substr($data,9,1));
		$carbohydrates		=	ord(substr($data,10,1))*256+ord(substr($data,11,1));
		$fiber			=	ord(substr($data,12,1))*256+ord(substr($data,13,1));
		$sugar			=	ord(substr($data,14,1))*256+ord(substr($data,15,1));
		$protein		=	ord(substr($data,16,1))*256+ord(substr($data,17,1));
		$cholesterol		=	ord(substr($data,18,1))*256+ord(substr($data,19,1));
		
		// create QRCode with phpqrcode
		$PHPQRCODE_DIR = 'phpqrcode';
		
		//set it to writable location, a place for temp generated PNG files
		$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.$PHPQRCODE_DIR.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
		
		//html PNG location prefix
		$PNG_WEB_DIR = 'temp/';
		
		include $PHPQRCODE_DIR.DIRECTORY_SEPARATOR."qrlib.php";  
		
		$filename = $PNG_TEMP_DIR.'test.png';
		$errorCorrectionLevel = 'L';
		$matrixPointSize = 3;
		
		$filename = $PNG_TEMP_DIR.'QRFood_'.md5($_SERVER["REQUEST_URI"].'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
		QRcode::png('http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"], $filename, $errorCorrectionLevel, $matrixPointSize, 2);
		
		//$filename2 = $PNG_TEMP_DIR.'QRFood_'.md5($data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
		//QRcode::png($data, $filename2, $errorCorrectionLevel, $matrixPointSize, 2);
				
		
	}

?>    
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo($meal_name); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen" />
    <link href="css/qrfood.css" rel="stylesheet" />
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" /> 

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="/js/html5shiv.js"></script>
      <script src="/js/respond.min.js"></script>
    <![endif]-->
    <script src="/qrfood.js"></script>
    
  </head>
  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/"><span class="glyphicon glyphicon-qrcode"></span> QRFood <span class="glyphicon glyphicon-cutlery"></span> </a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="https://github.com/Keeward/qrfood">Get source code</a></li>
          </ul>
        </div><!--/.navbar-collapse -->
      </div>
    </div>


    <div class="container" style="margin-top: 70px;">
    <?php
	//display generated file
	if($qr) {
		echo '<button class="btn btn-primary" onclick="setQRValues('."'".$meal_name."'".', '."'".$foursquare_id."'".', '.$weight.', '.$calories.', '.$saturated_fat.', '.$unsaturated_fat.', '.$sodium.', '.$carbohydrates.', '.$fiber.', '.$sugar.', '.$protein.', '.$cholesterol.');"  style="float: right;"><span class="glyphicon glyphicon-pencil"></span> Edit</button>';
				
		echo '<table class="table-bordered">';
		echo '<tr>';
		echo '<td rowspan="3"><img src="'.$PHPQRCODE_DIR.DIRECTORY_SEPARATOR.$PNG_WEB_DIR.basename($filename).'" alt="QRFood" /></td>';
		echo '<td colspan="5">';
		echo '<span style="float: left;"><h5>'.$meal_name.'</h5></span>';
		echo '<span style="float: right;"><a href="https://foursquare.com/v/'.$foursquare_id.'" target="_blank" title="'.$foursquare_id.'"><img src="foursquare.png" alt="'.$foursquare_id.'" /></a></span>';
		echo '</td>';
		echo '</tr>';
		echo '<tr>';
			echo '<td><h6><span class="label label-default">weight</span> '.$weight.'</h6></td>';
			echo '<td><h6><span class="label label-default">Kcal</span> '.$calories.'</h6></td>';
			echo '<td><h6><span class="label label-default">sat. fat</span> '.$saturated_fat.'</h6></td>';
			echo '<td><h6><span class="label label-default">uns. fat</span> '.$unsaturated_fat.'</h6></td>';
			echo '<td><h6><span class="label label-default">sodium</span> '.$sodium.'</h6></td>';			
		echo '</tr>';
		echo '<tr>';
			echo '<td><h6><span class="label label-default">carbs</span> '.$carbohydrates.'</h6></td>';
			echo '<td><h6><span class="label label-default">fiber</span> '.$fiber.'</h6></td>';
			echo '<td><h6><span class="label label-default">sugar</span> '.$sugar.'</h6></td>';
			echo '<td><h6><span class="label label-default">protein</span> '.$protein.'</h6></td>';
			echo '<td><h6><span class="label label-default">cholesterol</span> '.$cholesterol.'</h6></td>';			
		echo '</tr>';
		
		echo '</table>';

		

		
	}
	
    ?>

    <form method="get" class="form-horizontal" role="form" onsubmit="return(qrSubmit());">

<fieldset>

<!-- Form Name -->
<legend>QRFood</legend>

<!-- Text input-->

<div class="form-group">
	<label class="col-lg-3 control-label">Name of the meal</label>
	<div class="col-lg-9 input-append">
		<input type="text" class="form-control span2" id="meal_name" name="meal_name" placeholder="Salade saveur, 김치, hamburger…" required="" />
		<span class="help-block">Enter the complete name</span>
	</div>
</div>  


<div class="form-group">
  <label class="col-lg-3 control-label">Restaurant Foursquare ID</label>
  <div class="col-lg-9">
    <input type="text" class="form-control" id="foursquare_id" name="foursquare_id" placeholder="4ac759c9f964a520eab620e3" required="" />
    <span class="help-block">Enter the restaurant Foursquare ID</span>
  </div>
</div>


<div class="form-group">
	<label class="col-lg-3 control-label">Weight</label>
	<div class="col-lg-9 input-append">
		<div class="input-group">
			<input type="text" class="form-control span2" id="weight" name="weight" placeholder="100" />
			<span class="input-group-addon">g</span>
		</div>
		<span class="help-block">per serving, in grams</span>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-3 control-label">Calories</label>
	<div class="col-lg-9 input-append">
		<div class="input-group">
			<input type="text" class="form-control span2" id="calories" name="calories" placeholder="100" />
			<span class="input-group-addon">Kcal</span>
		</div>
		<span class="help-block">per serving, in Kilocalories</span>
	</div>
</div>


<div class="form-group">
	<label class="col-lg-3 control-label">Saturated fat</label>
	<div class="col-lg-9 input-append">
		<div class="input-group">
			<input type="text" class="form-control span2" id="saturated_fat" name="saturated_fat" placeholder="100" />
			<span class="input-group-addon">g</span>
		</div>
		<span class="help-block">per serving, in grams</span>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-3 control-label">Unsaturated fat</label>
	<div class="col-lg-9 input-append">
		<div class="input-group">
			<input type="text" class="form-control span2" id="unsaturated_fat" name="unsaturated_fat" placeholder="100" />
			<span class="input-group-addon">g</span>
		</div>
		<span class="help-block">per serving, in grams</span>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-3 control-label">Sodium</label>
	<div class="col-lg-9 input-append">
		<div class="input-group">
			<input type="text" class="form-control span2" id="sodium" name="sodium" placeholder="100" />
			<span class="input-group-addon">mg</span>
		</div>
		<span class="help-block">per serving, in milligrams</span>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-3 control-label">Carbohydrates</label>
	<div class="col-lg-9 input-append">
		<div class="input-group">
			<input type="text" class="form-control span2" id="carbohydrates" name="carbohydrates" placeholder="100" />
			<span class="input-group-addon">g</span>
		</div>
		<span class="help-block">per serving, in grams</span>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-3 control-label">Fiber</label>
	<div class="col-lg-9 input-append">
		<div class="input-group">
			<input type="text" class="form-control span2" id="fiber" name="fiber" placeholder="100" />
			<span class="input-group-addon">g</span>
		</div>
		<span class="help-block">per serving, in grams</span>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-3 control-label">Sugar</label>
	<div class="col-lg-9 input-append">
		<div class="input-group">
			<input type="text" class="form-control span2" id="sugar" name="sugar" placeholder="100" />
			<span class="input-group-addon">g</span>
		</div>
		<span class="help-block">per serving, in grams</span>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-3 control-label">Protein</label>
	<div class="col-lg-9 input-append">
		<div class="input-group">
			<input type="text" class="form-control span2" id="protein" name="protein" placeholder="100" />
			<span class="input-group-addon">g</span>
		</div>
		<span class="help-block">per serving, in grams</span>
	</div>
</div>

<div class="form-group">
	<label class="col-lg-3 control-label">Cholesterol</label>
	<div class="col-lg-9 input-append">
		<div class="input-group">
			<input type="text" class="form-control span2" id="cholesterol" name="cholesterol" placeholder="100" />
			<span class="input-group-addon">mg</span>
		</div>
		<span class="help-block">per serving, in milligrams</span>
	</div>
</div>


<div class="col-lg-3"></div>
<div class="col-lg-9 input-append"><button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-check"></span> Generate QRFood</button></div>


</fieldset>
</form>


    </div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="//code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
