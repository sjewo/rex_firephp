<?php
/**
* FirePHP Addon
*
* FirePHP Lib Copyright (c) 2006-2008, Christoph Dorn, http://firephp.org
* FirePHP Lib v 0.2.1
*
* @author rexdev[at]f-stop[dot]de Jan Camrda
* @author <a href="http://rexdev.f-stop.de">rexdev.f-stop.de</a>
*
* @package redaxo4
* @version 0.3.1
* $Id$: 
*/

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
.backendoverride pre {color:blue;border:1px dashed #C0C0C0;background:#FAF9F5;font-size:12px;margin:6px 4px 6px 0;padding:8px;font-family:monospace;}
.backendoverride hr {height:1px;border:0;border-top:1px solid silver;margin:8px 0;padding:0;}
.backendoverride p.helpnav {background:transparent;margin:0;padding:0;font-weight:bold;}
-->
</style>
<div class="backendoverride">
';

// Addon Identifier
$mypage = "firephp";

// Subnavigation Items
$helppages = array (''             => 'Addon Hilfe', 
										'changelog'    => 'Addon Changelog', 
										'libchangelog' => 'FirePHP Changelog',
										'libreadme'    => 'FirePHP Readme',
										'liblicense'   => 'FirePHP License');

if (!isset($mode)) $mode = '';

// Build Help Subnavigation
$helpnav = '';
foreach ($helppages as $helppage => $name)
{
	if ($mode != $helppage)
	{
	$helpnav .= ' | <a href="?page=addon&spage=help&addonname='.$mypage.'&mode='.$helppage.'">'.$name.'</a>';
	}
	else
	{
	$helpnav .= ' | '.$name;
	}
}
echo '<p class="helpnav">'.ltrim($helpnav, " | ").'</p><hr />';

// Assign Include Files
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
	case 'installcatch':
		$file = '_warning.txt';
		break;
		
  default: $file = '_readme.txt'; 
}

$file = dirname( __FILE__) .'/'. $file;
$fh = fopen($file, 'r');
$content = fread($fh, filesize($file));
$textile = htmlspecialchars_decode($content);
$textile = str_replace("<br />","",$textile);
$textile = str_replace("&#039;","'",$textile);
echo rex_a79_textile($textile).'</div>';

// echo str_replace( '+', '&nbsp;&nbsp;+', nl2br(file_get_contents( dirname( __FILE__) .'/'. $file)));

?>