<?php 
/*
	pshell beta 1.0 author:zhaolei
*/	
define('SBUG', $argv[2]);

//get from bat argv
$shell_name = $argv[1];
$cmd_char = '#';
$br = chr(10);

//Usage
cmd_hello();


//shell var init
$shell_str_arr = array("echo 'Hello';");
$eval_str = '';

while($eval_str = shell_v($shell_str_arr)) {
	
	(SBUG)?(is_string($eval_str)?eval($eval_str):''):(is_string($eval_str)?@eval($eval_str):'');
	
	echo $br;
	
	//arr init
	unset($shell_str_arr);
	$shell_str_arr = array();
	
	echo $shell_name.$cmd_char;
	$cmd_str = '';

	$cmd_str = trim(fgets(STDIN));
	//$cmd_str = addslashes($cmd_str);
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
			
			if(fun_v($shell_str_arr)) {
				echo 'B';
				echo "$shell_str_arr[0] is function";
				return true;
			} elseif (var_v($shell_str_arr)) {
				echo 'aww';
				echo $$shell_str_arr[0];
				return true;
			} else {
				echo 'dd';
				return $cmd_str;
			}

		} catch (Exception $e) {
			exit(1);
		}
	}
}

function cmd_hello(){
	$br = chr(10);
	echo "*****************************************************************************".$br;
	echo "************** PHP TERMINAL SHELL v1.0 **************************************".$br;
	echo "*****************************************************************************".$br;
	echo "***** Usag : php pshell.php name".$br;
	echo "***** help get more".$br;
}


function fun_v($shell_str_arr) {
	
	$cmd_str = implode("\n", $shell_str_arr);
	if(count($shell_str_arr) == 1) {
		if(function_exists(r_str($cmd_str))) {
			return true;
		}
	}
	
	return false;
}

function var_v($shell_str_arr) {
	$cmd_str = implode("\n", $shell_str_arr);
	$r_cmd = r_str($cmd_str);
	if(count($shell_str_arr) == 1) {
		if($r_cmd[0] == '$') {
			return true;
		}
	}
	return false;
}

function r_str($str){
	$len = strlen($str);
	return substr($str,0, $len-1);
}




?>