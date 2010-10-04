<html>
<head>
<?
// this is the header include for the main page, you can put whatever you want here. 
// Typically a logo and a search box
if($browse != "") {
	$addTitle = str_replace("_", " ", $browse);
	$addTitle = str_replace("/", "> ", $addTitle);
	
	$onlyInCat = trim($browse, "/");
	$arr = explode("/", $onlyInCat);

	if(sizeof($arr) > 1) {
		$displayOnlyInCat = $arr[sizeof($arr)-2] . "/" . $arr[sizeof($arr)-1];
	} else {
		$displayOnlyInCat = $arr[0];
	}

}
?>
<!-- <link rel="stylesheet" type="text/css" href=/dmoznew.css />
-->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Goan Internet Portal -<?=$addTitle?></title>
</head>
<body BGCOLOR="#000000" TEXT="#00FF00" LINK="#00FFFF" VLINK="#FFFF00">
<style type="text/css">
<!--
a:active{color:red}
a:hover{color:#09c}

hr {
color: #404040;
width: 99%;
}
span.current {
	background-color:#669933;
	border:1px solid #000099;
	color:#fff
	font-weight:bold;
	margin-right:4px;
	padding:0 2px;
}
ul.language{
	margin-left:1.5em;width:50%;
}
ul.language li{
	display:block;
	float:left;
	width:180px;
}
ul.language a{
	font-size:1em;
}
ul.directory-url{
	list-style:none;
}
BODY {
SCROLLBAR-FACE-COLOR: #282828;
SCROLLBAR-HIGHLIGHT-COLOR: #808080;
SCROLLBAR-SHADOW-COLOR: #202020;
SCROLLBAR-3DLIGHT-COLOR: #000000;
SCROLLBAR-ARROW-COLOR: #FF0000;
SCROLLBAR-TRACK-COLOR: #000000;
SCROLLBAR-DARKSHADOW-COLOR: #202020;
}
-->
</style>
<center>
<h1><font color="#ff9900">Goan Internet Portal</font></h1>
<form method=POST action="odp.php">
<input type="textfield" name="search">
<input type="submit" name="submit" value="Search">
<input type=hidden name=cat value="<?=$onlyInCat?>">
<small><select name=all><option selected value=yes>the entire directory
<option value=no>only in <?=$displayOnlyInCat?>
</select>
</small>
</form>
</center>
<sub><font size="+1"><img src="\big_folder.gif" border=0 alt="goan.com"></sub>
<?
	$cat = $browse;
//	echo "<a href=\"" . $filename . "\"><font color='#ff9900'> Top </font></a><font color='#ffffff'> </font>";
	echo "<a href='http://goan.com/'><font color='#ff9900'>Top</font></a><font color='#ffffff'> >  </font>";

	$array = explode("/", $browse );
	foreach ($array as $stritem) {
		if( $stritem != "" ) {
			$add = $add . "/" . $stritem;
			echo "<a href=\"" . $replace . $add . "\"><font color='#ff9900'>" . $stritem  . "</a></font><font color='#ffffff'>: </font>";
			$searchstring = $stritem;		// needed for browse_sponsor include php
		}
	}
?>
</font>