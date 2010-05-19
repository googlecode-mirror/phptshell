<?php 
/*
	pshell beta 1.0 author:zhaolei
*/	
define('SBUG', $argv[2]);

//get from bat argv
$shell_name = $argv[1];
$cmd_char = '#';
$br = chr(10);

//shell var init
$shell_str_arr = array("echo 'Hello';");
$eval_str = '';

while($eval_str = shell_v($shell_str_arr)) {
	
	(SBUG)?eval($eval_str):@eval($eval_str);
	
	echo $br;
	
	//arr init
	unset($shell_str_arr);
	$shell_str_arr = array();
	
	echo $shell_name.$cmd_char;
	$cmd_str = '';

	$cmd_str = trim(fgets(STDIN));
	$cmd_str = addslashes($cmd_str);
	$str_len = strlen($cmd_str);
	
	
	//if last is \
	if($cmd_str[$str_len-1] == '\\') {
		while($cmd_str[$str_len-1] == '\\') {
			$cmd_str = substr($cmd_str, 0, $str_len-1);
			
			//some Redundancy
			($cmd_str[$str_len-1] == ';') ? $cmd_str : $cmd_str .= ';';
			
			$shell_str_arr[] = $cmd_str;
			
			$cmd_str = trim(fgets(STDIN));
			//$cmd_str = addslashes($cmd_str);
			$str_len = strlen($cmd_str);
		}
	} else {
		($cmd_str[$str_len-1] == ';') ? $cmd_str : $cmd_str .= ';';

		$shell_str_arr[] = $cmd_str;
	}

	SBUG&&print($cmd_str.$br);
}

//echo '::'.$a;

function shell_v($shell_str_arr) {
	$quit_arr = array('exit', 'exit;', 'quit', 'quit;');
	$cmd_arr = array('help', 'set_char');
	
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

			return $cmd_str;		
			
			return true;
		} catch (Exception $e) {
			exit(1);
		}
	}
}

?>