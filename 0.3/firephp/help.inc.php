<?php
/**
* FirePHP Addon
*
* @author rexdev[at]f-stop[dot]de Jan Camrda
* @author <a href="http://rexdev.f-stop.de">rexdev.f-stop.de</a>
*
* FirePHP Lib Copyright (c) 2006-2008, Christoph Dorn
* FirePHP Lib v 0.2.1
*
* @author rexdev[at]f-stop[dot]de Jan Camrda
* @author <a href="http://rexdev.f-stop.de">rexdev.f-stop.de</a>
*
* @package redaxo4
* @version 0.3
* $Id$: 
*/
// error_reporting(E_ALL ^ E_NOTICE); // Notices ausschalten
@ ini_set('error_reporting', E_ALL);
@ ini_set('display_errors', On);

if ( !isset( $mode)) $mode = '';
switch ($mode)
{
	case 'changelog':
		$file = '_changelog.txt';
		break;
	case 'libchangelog':
		$file = 'FirePHPCore/CHANGELOG';
		break;
	case 'liblicense':
		$file = 'FirePHPCore/LICENSE';
		break;
	case 'libreadme':
		$file = 'FirePHPCore/README';
		break;
		
  default: $file = '_readme.txt'; 
}

echo '
<style type="text/css" media="screen">
<!--
.backendoverride {font-size:100%;margin:0;padding:0}
.backendoverride h1 {font-size:20px;margin:0 0 8px 0;padding:0}
.backendoverride h2 {font-size:18px;margin:7px 0;padding:0}
.backendoverride h3 {font-size:16px;margin:6px 0;padding:0}
.backendoverride h4 {font-size:12px;margin:5px 0;padding:0}
.backendoverride h5 {font-size:10px;margin:4px 0;padding:0}
.backendoverride ul {margin:0;padding:2px 0 6px 20px;}
.backendoverride li {list-style-type:square;margin:0;padding:0;}
.backendoverride cite {color:blue;font-size:10px;font-family:monospace;font-style:normal;}
.backendoverride pre {color:blue;font-size:12px;margin:10px;font-family:monospace}
.backendoverride hr {height:1px;border:0;border-top:1px solid silver;margin:8px 0;padding:0;}
-->
</style>
<div class="backendoverride">
';

$file = dirname( __FILE__) .'/'. $file;
$fh = fopen($file, 'r');
$content = fread($fh, filesize($file));
$textile = htmlspecialchars_decode($content);
$textile = str_replace("<br />","",$textile);
$textile = str_replace("&#039;","'",$textile);
echo rex_a79_textile($textile).'</div>';

// echo str_replace( '+', '&nbsp;&nbsp;+', nl2br(file_get_contents( dirname( __FILE__) .'/'. $file)));

?>