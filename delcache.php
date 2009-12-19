<?
/**
 * This script will work as a cache admin. Give it another filename to get it to work.
 * Also, if you use another folder name than 'cache' you need to update this as well.
 */

$cachefolder = "cache"; // the folder where your cache is stored (read: THE FOLDER WHICH WILL BE DELETED)

if( !(strpos($HTTP_SERVER_VARS['PHP_SELF'], "delcache.php") === false)) die("This script will delete the contents of folder: '$cachefolder', you must edit script if folder name differ.<br><br> <font color='red'><b>For security reasons you must rename this script before it can run. </b></font><br>(Remember; anyone will be able to run it! so name it something crazy!)<br><br>Questions? -> ask in the <a href='http://www.bie.no/forum/'>phpODP - Open Directory Project script forum</a>");

$delete = $HTTP_POST_VARS["delete"];
$totalsize=0;

function getTotalSize($dir){
    global $totalsize;
    $handle = @opendir($dir);
    while ($file = @readdir ($handle)){
		if($file != "." && $file != "..") {
			$size=filesize($dir."/".$file);
			$totalsize=$totalsize+$size;
		}     
    }
    @closedir($handle);

    return($totalsize);
} 

function delcache($dir)
{
  $handle = opendir($dir);
  while (false!==($FolderOrFile = readdir($handle)))
  {
     if($FolderOrFile != "." && $FolderOrFile != "..")
     { 
       if(is_dir("$dir/$FolderOrFile"))
       { deldir("$dir/$FolderOrFile"); }  // recursive
       else
       { unlink("$dir/$FolderOrFile"); }
     } 
  }
} 

if($delete != "") {
	delcache($cachefolder);
}

$cacheSize = getTotalSize($cachefolder);

?>
<a href="<?=$HTTP_SERVER['PHP_SELF']?>">[Refresh]</a><br><br>
Total size of cache folder: <B><?=$cacheSize/1000000?> Mb.</B> (<?=$cacheSize?> bytes)
<br><br>
<form method="post" action="<?=$HTTP_SERVER_VARS['PHP_SELF']?>">
<input type="submit" name="delete" value="Delete" onclick="return confirm('Are you sure you want to delete everything in the folder:\n<?=$cachefolder?>')">
</form>