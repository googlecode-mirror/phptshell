#! /usr/bin/php
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
$i = 0;

while($eval_str = shell_v($shell_str_arr)) {

	(SBUG)?(is_string($eval_str)?eval($eval_str):''):(is_string($eval_str)?@eval($eval_str):'');
	
	echo $br."--------------------------------------debug------------------------------";
	echo $br."line: $i".$br;
	
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
	$i++;
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

				echo "$shell_str_arr[0] is function";
				return true;
			}elseif(r_str($shell_str_arr[0]) == 'help'){
				cmd_hello();
				return true;
			}elseif($cmd_str = cmd_v($shell_str_arr)) {
				return 'system(\''.$cmd_str.'\');';
			} elseif(value_v($shell_str_arr)) {
				return value_v($shell_str_arr);
			}else{
				$cmd_str = implode("\n", $shell_str_arr);
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

function value_v($shell_str_arr){
	if(count($shell_str_arr) == 1) {
		$cmd_str = r_str($shell_str_arr[0]);
		$r_pices = explode(';', $cmd_str);
		
		if(count($r_pices) == 1) {
			$p_1 = preg_match("/^print/", $cmd_str);
			$p_2 = preg_match("/^echo/", $cmd_str);
			$p_3 = preg_match("/^var_dump/", $cmd_str);
			if($p_1 || $p_2 || $p_3) {
				return false;
			} else {
				return '$t_shell_value=('.$cmd_str.');result_v(); echo $t_shell_value;';
			}
			
		}
	}
	
	return false;
}

function cmd_v($shell_str_arr){
	$cmd_arr = array();
	if(count($shell_str_arr) == 1) {
		$p_1 = preg_match_all("/cmd\:(\w*)/i", $shell_str_arr[0], $cmd_arr);
		if(!empty($cmd_arr[1])) {
			return $cmd_arr[1][0];
		} else {
			return false;
		}

	}
	
	return false;
}

function result_v(){
	$br = chr(10);
	echo $br;
	echo '-------------------------------------out-----------------------';
	echo $br;
}

function r_str($str){
	$len = strlen($str);
	return substr($str,0, $len-1);
}




?>
