<?
/**
 * You do not need to upload this script to your server if you don't experience any problems! :)
 * 
 * testscript.php - will check to see if you can access the dmoz server from your host/server.
 *
 * If you experience any problems with odp.php, please run this script to see what errors are shown. Search for these errors in the phpODP forum
 * at http://www.bie.no/forum/ - and remember to refer to the error messages if you need to ask a question in the forum.
 *
 */

function error_handler($severity, $msg, $filename, $linenum) {
	echo $severity . " " . $msg . " ($filename:$linenum)<br>";
}

error_reporting(E_ALL);
set_error_handler("error_handler");

if($fp = fopen("http://www.dmoz.org", "r")) {
	echo "Congrats! Everything seems to be working";
}

?>