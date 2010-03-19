<?php
/**
* FirePHP Addon
*
* FirePHP Lib Copyright (c) 2006-2010, Christoph Dorn, http://firephp.org
* FirePHP Lib v 0.3.1
*
* @author <a href="http://rexdev.de">rexdev.de</a>
*
* @package redaxo4
* @version 0.4
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
.backendoverride pre code {color:blue;border:0;background:transparent;font-size:12px;margin:0;padding:0;font-family:monospace;}
.backendoverride pre.plain {color:black;border:0;background:transparent;margin:0;padding:0;font-family:monospace;}
.backendoverride hr {height:1px;border:0;border-top:1px solid silver;margin:8px 0;padding:0;}
.backendoverride p.helpnav {background:transparent;margin:0;padding:0;font-weight:bold;}
-->
</style>
';

// Addon Identifier
$mypage = "firephp";

// Subnavigation Items
$chapterpages = array (''             => 'Addon Hilfe', 
										'changelog'    => 'Addon Changelog', 
										'libchangelog' => 'FirePHP Changelog',
										'libreadme'    => 'FirePHP Readme',
										'liblicense'   => 'FirePHP License',
										'libcredits'   => 'FirePHP Credits');

if (!isset($chapter)) $chapter = '';

// Build Help Subnavigation
$chapternav = '';
foreach ($chapterpages as $thischapter => $chaptertitle)
{
	if ($chapter != $thischapter)
	{
	$chapternav .= ' | <a href="?page='.$mypage.'&subpage=help&chapter='.$thischapter.'">'.$chaptertitle.'</a>';
	}
	else
	{
	$chapternav .= ' | '.$chaptertitle;
	}
}
// echo '<p class="helpnav">'.ltrim($chapternav, " | ").'</p><hr />';

// Assign Include Files
switch ($chapter)
{
	case 'changelog':
		$file = '_changelog.txt';
		$parse = true;
		break;
	case 'libchangelog':
		$file = 'FirePHPCore-0.3.1/CHANGELOG';
		$parse = false;
		break;
	case 'liblicense':
		$file = 'FirePHPCore-0.3.1/lib/FirePHPCore/LICENSE';
		$parse = false;
		break;
	case 'libreadme':
		$file = 'FirePHPCore-0.3.1/README';
		$parse = false;
		break;
	case 'libcredits':
		$file = 'FirePHPCore-0.3.1/CREDITS';
		$parse = false;
		break;
	case 'installcatch':
		$file = '_warning.txt';
		$parse = true;
		break;
		
  default:
		$file = '_readme.txt';
		$parse = true;
}

echo '<div class="rex-addon-output">
  <h2>'.ltrim($chapternav, " | ").'</h2>
  <div class="rex-addon-content">
	<div class= "backendoverride">';

$file = $REX['INCLUDE_PATH']. '/addons/firephp/'.$file;
$fh = fopen($file, 'r');
$content = fread($fh, filesize($file));
if ($parse == true)
{
$textile = htmlspecialchars_decode($content);
$textile = str_replace("<br />","",$textile);
$textile = str_replace("&#039;","'",$textile);
echo rex_a79_textile($textile);
}
else
{
	echo '<pre class="plain">'.$content.'</pre>';
}

echo '</div>
</div>
</div>';


?>