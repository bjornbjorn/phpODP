<?
Header("Content-Type: text/html; charset=\"UTF-8\"");

/**
 * This file will recieve info about a specific site and show the user a custom "portal page"
 */

$url= strip_tags($_GET['url']); 
$title = strip_tags($_GET['title']);
$desc = strip_tags($_GET["desc"]);

/*
 // only works for PHP5
 $title= html_entity_decode($_GET['title'],ENT_COMPAT,'utf-8');
 $desc= html_entity_decode($_GET['desc'],ENT_COMPAT,'utf-8');
*/
$img = "http://open.thumbshots.org/image.pxf?url=$url";
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
     <meta http-equiv="content-type" content="text/html; charset=utf-8" />
     <title>Site information: <?=$title?> </title>
</head>
<body>
<center>
<table border="0" width="500" bgcolor="black" cellspacing="1" cellpadding="0">
<tr><td>
	<table border="0" bgcolor="white" cellspacing=4 width="100%">
	<tr><td colspan=2><center><h1><?=$title?></h1></center></td></tr>
	<tr><td><img src="<?=$img?>"></td><td><?=$desc?></td></tr>
	<tr><td colspan="2"><center><a href="<?=$url?>">[Click here to visit the site]</a></td></tr>
	</table>
</td></tr>
</table>
</center>
 </body>