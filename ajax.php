<?php 
echo "string";
function readFile($file)
{
	$fd = fopen('/shaders/' . $file, 'r'); 

	echo ($fd);
}
switch($_REQUEST['cmd'])
{
	case "readFile":
	//readFile($_REQUEST['file']);
	//echo $_REQUEST['file'];
	echo "string";
	break;
}
 ?>