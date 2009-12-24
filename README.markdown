About phpODP
============
phpODP is a script to put the content of dmoz.org directory on your own homepage. It has support for:

* Template based - change looks by editing includes/header & footer files
* Dynamic content; the content is retrieved from ODP in real time! When they update, you update. Which of course leads us to ..
* Caching - both categories & search results can ba cachec locally. You can specify cache lifetime (e.g. 40 days before it should be updated)
* Thumbnails (preview of sites in the directory)
* Amazon targeted book advertising
* Adult filter - dmoz.org contains a lot of adult material (see dmoz.org/Adult). If you do not want this on your site, you can block the /Adult/ categories, in addition to blocking specific search keywords.
* Custom 404 / Not found pages 

For more information: [http://www.bybjorn.com/phpodp/](http://www.bybjorn.com/phpodp/)

How to install
==============
1. Upload all files to your server
2. If caching is enabled (default) then you must create a directory in the same folder as odp.php called 'cache' and make it writeable by odp.php (chmod 777)

*finished*

Note: delcache.php is used to delete the cache directory. For security reasons it needs to be renamed to run. If you don't intend to use it, delete the file.
Use testscript.php if you experience any problems. If you don't have any problems, just delete the file.

If you want, you can:
- Edit the files in the includes/ directory give it the same design as the rest of your site
- Set a couple of options in odp.php (eg. show thumbnails, or show amazon sponsor link)

dmoz.org contains a lot of adult sites by default (see dmoz.org/Adult). If you do not want these categories on your site, please set $adult_filter to true in odp.php.
You may also block certain searches there. Edit includes/block.php to change the message the user sees when he tries to do a blocked search or browse blocked category.

TERMS OF USE
============
This script is free of charge. I do not take any responsibility for damages caused by the use of this script either directly or indirectly.

This work is licensed under a Creative Commons License, for more info visit this page:
http://creativecommons.org/licenses/by/3.0/