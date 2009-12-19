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
<title>Open Directory Project <?=$addTitle?></title>
<center>
<h2>Open Directory Project</h2>
<form method=POST action="odp.php">
Search: <input type="textfield" name="search">
<input type="submit" name="submit" value="Search">
<input type=hidden name=cat value="<?=$onlyInCat?>">
<small><select name=all><option selected value=yes>the entire directory
<option value=no>only in <?=$displayOnlyInCat?>
</select>
</small>
</form>
</center>
<font size="+1">
<?
	$cat = $browse;
	echo "<a href=\"" . $filename . "\">Top</a>: ";

	$array = explode("/", $browse );
	foreach ($array as $stritem) {
		if( $stritem != "" ) {
			$add = $add . "/" . $stritem;
			echo "<a href=\"" . $replace . $add . "\">" . $stritem  . "</a>: ";
			$searchstring = $stritem;		// needed for browse_sponsor include php
		}
	}
?>
</font>