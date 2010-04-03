<?php
/**
* FirePHP Addon
*
* FirePHP Lib Copyright (c) 2006-2010, Christoph Dorn, http://firephp.org
* FirePHP Lib v 0.3.1 & 0.3.2rc1
*
* @author <a href="http://rexdev.de">rexdev.de</a>
*
* @package redaxo4
* @version 0.4.1
* $Id$: 
*/

// GET PARAMS
////////////////////////////////////////////////////////////////////////////////
$page = rex_request('page', 'string');
$subpage = rex_request('subpage', 'string');
$chapter = rex_request('chapter', 'string');
$func = rex_request('func', 'string');

// Addon Identifier
$mypage = "firephp";

// ACTIVE LIB
$active_lib = 'libs/'.$REX['ADDON']['libs'][$REX['ADDON']['firephp']['uselib']];

// Subnavigation Items
$chapterpages = array (''             => 'Addon Hilfe', 
										'changelog'    => 'Addon Changelog', 
										'libchangelog' => 'FirePHP Changelog',
										'libreadme'    => 'FirePHP Readme',
										'liblicense'   => 'FirePHP License',
										'libcredits'   => 'FirePHP Credits');

//if (!isset($chapter)) $chapter = '';

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
		$file = $active_lib.'/CHANGELOG';
		$parse = false;
		break;
	case 'liblicense':
		$file = $active_lib.'/lib/FirePHPCore/LICENSE';
		$parse = false;
		break;
	case 'libreadme':
		$file = $active_lib.'/README';
		$parse = false;
		break;
	case 'libcredits':
		$file = $active_lib.'/CREDITS';
		$parse = false;
		break;
		
  default:
		$file = '_readme.txt';
		$parse = true;
}

echo '<div class="rex-addon-output">
  <h2 class="rex-hl2" style="font-size:1em">'.ltrim($chapternav, " | ").'</h2>
  <div class="rex-addon-content">
	<div class= "firephp">';

$file = $REX['INCLUDE_PATH']. '/addons/firephp/'.$file;
$fh = fopen($file, 'r');
$content = fread($fh, filesize($file));
if ($parse == true)
{
$textile = htmlspecialchars_decode($content);
$textile = str_replace("<br />","",$textile);
$textile = str_replace("&#039;","'",$textile);
if (strpos($REX['LANG'],'utf'))
{
  echo rex_a79_textile($textile);
}
else
{
  echo utf8_decode(rex_a79_textile($textile));
}
}
else
{
	echo '<pre class="plain">'.$content.'</pre>';
}

echo '</div>
</div>
</div>';


?>