<?php 
/*
	pshell beta 1.0 author:zhaolei
*/	
define('SBUG', $argv[2]);

//get from bat argv
$shell_name = $argv[1];
$shell_title = $argv[2];
$br = chr(10);

//shell var init
$shell_str_arr = array();

while(shell_v($shell_str_arr)) {
	
	//arr init
	unset($shell_str_arr);
	$shell_str_arr = array();
	
	echo $shell_name.'#';
	$cmd_str = '';

	$cmd_str = trim(fgets(STDIN)); 
	$str_len = strlen($cmd_str);
	
	
	//if last is \
	if($cmd_str[$str_len-1] == '\\') {
		while($cmd_str[$str_len-1] == '\\') {
			$cmd_str = substr($cmd_str, 0, $str_len-1);
			
			//some Redundancy
			($cmd_str[$str_len-1] == ';') ? $cmd_str : $cmd_str .= ';';
			
			$shell_str_arr[] = $cmd_str;
			
			$cmd_str = trim(fgets(STDIN));
			$str_len = strlen($cmd_str);
		}
	} else {
		($cmd_str[$str_len-1] == ';') ? $cmd_str : $cmd_str .= ';';
			
		$shell_str_arr[] = $cmd_str;
	}
	
	SBUG&&print($cmd_str.$br);
}



function shell_v($shell_str_arr) {
	$quit_arr = array('exit', 'exit;', 'quit', 'quit;');
	
	if(empty($shell_str_arr)) {
		return true;
	} else {
		try {
			//merge run
			SBUG&&print_r($shell_str_arr);
			
			if(in_array($shell_str_arr[0], $quit_arr)) {
				return false;
			}
			
			$cmd_str = implode("\n", $shell_str_arr);
			
			$str_len = strlen($cmd_str);
			//$cmd_str = substr($cmd_str, 0, $str_len-2);
			SBUG&&print($cmd_str.$br);
			
			eval($cmd_str);
			
			echo chr(10);
			
			return true;
		} catch (Exception $e) {
			echo 'bug';
			print_r($e);
			exit(1);
		}
	}
}

?>