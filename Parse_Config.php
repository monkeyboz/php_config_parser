<?php
class Parse_Config{
    public function parse_string($config){
		//preg_match the config file content to find the solution.
		$config = trim($config);
		$config = preg_replace('/\#\w+/s','',$config); //remove comments (needs to be fixed for code comments) PHP5.6+ possibly
		preg_match_all("/(.*)\=(.*)\=?/",$config,$peg); //regular expression used for parsing code
		
		$info = array();
		$bool_vals = array('on','off','true','false','yes','no'); //boolean array used for boolean responses
		//traverse through the array to find the different variables found in the config file
		foreach($peg[1] as $k=>$a){
		    $a = trim($a);
		    $peg[2][$k] = trim($peg[2][$k]);
		    if(is_numeric($peg[2][$k])){
		        switch(gettype($peg[2][$k])){
		            case 'float':
		                $peg[2][$k] = floatval($peg[2][$k]);
		                break;
		            case 'int':
		            default:
		                $peg[2][$k] = intval($peg[2][$k]);
		                break;
		        }
		        $info[$a] = $peg[2][$k];
		    } else {
		        $bool_check = array_search($peg[2][$k],$bool_vals);
		        if(is_numeric($bool_check)){
		           $info[$a] = ($bool_check%2 == 0)?true:false;
		        } else {
		           $info[$a] = $peg[2][$k];
		        }
		    }
		}
		return $info;
    }
    
    public function read_file($dir='uploads',$file='config'){
        $content = '';
        if(isset($_FILES['file'])){
            $upload_dir = 'uploads/';
    		//MAKE SURE THE UPLOAD DIRECTORY IS AVAILABLE AND WRITABLE!
    		if(!is_dir($upload_dir)){
    			mkdir($upload_dir,'777');
    			chmod($upload_dir,'777');
    		}
    		
    		if(!is_writable($upload_dir)){
    		    rmdir($upload_dir);
    		    $upload_dir = './';
    		}
    		
    		//create config-file based on date to make sure there is no file collision
    		$data_file = 'config-file-'.date('Y-m-d-h-i-s');
    		move_uploaded_file($_FILES['file']['tmp_name'],$upload_dir.$data_file);
    		
    		//read in the config-file to be parsed
    		$fh = fopen($upload_dir.$data_file, 'r+');
    		$content = fread($fh,filesize($upload_dir.$data_file));
    		fclose($fh);
        } else {
            $fh = fopen($dir.$file,'r+');
            $content = fread($fh,filesize($dir.$file));
            fclose($fh);
        }
        
        return $content;
    }
}
