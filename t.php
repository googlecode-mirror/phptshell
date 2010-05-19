<?php
	$a = 10;
	//$str = '$a=1000;';
	$str = trim(fgets(STDIN));
	//eval($str);
	//$str = addslashes($str); 
	eval($str);
	echo 'e:'.$a.chr(10);
	
	$cmd_str = trim(fgets(STDIN));
	eval($cmd_str);

