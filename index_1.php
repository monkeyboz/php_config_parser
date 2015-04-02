<?php
    //this file takes in a config file and returns the options that make it a valid configuration file.
    //we use several options to create a better more robust system which allows users to use this script
    //both on the commandline as well as the front-end.
    //--------------------------------------------------
	//error_reporting(E_ALL);
	//ini_set('display_errors', 1);
	
	include_once('./Parse_Config.php');
    $parse = new Parse_Config();

	//check if gui is not needed
	if(!isset($_GET['gui'])){
		$file = $argv[1];
		$dir = $argv[2];
        	
		$content = $parse->read_file($dir,$file);
		print '<pre>'.print_r($parse->parse_string($content),true).'</pre>';
		//otherwise make sure to do the following procedures showing the gui.
	} else {
		if(isset($_FILES['file'])){
		    $content = $parse->read_file();
			print '<pre>'.print_r($parse->parse_string($content),true).'</pre>';
        } else {
?>
	<html>
	<head>
		<title>PHP Test</title>
	</head>
		<body>
			<form action="?gui=true" method="POST" enctype="multipart/form-data">
				<div>
					<div>Config File Upload</div>
					<input type="file" name="file"/>
					<input type="submit" name="submit" value="Submit File"/>
				</div>
			</form>
		</body>
	</html>
<?php 
		}
	} ?>
