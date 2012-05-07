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
* @version 0.4.2
* $Id$: 
*/

// GET PARAMS
////////////////////////////////////////////////////////////////////////////////
$mypage  = rex_request('page', 'string');
$subpage = rex_request('subpage', 'string');
$chapter = rex_request('chapter', 'string');
$func    = rex_request('func', 'string');

// ACTIVE LIB
$active_lib = 'libs/'.$REX['ADDON'][$mypage]['libs'][$REX['ADDON'][$mypage]['settings']['uselib']];

// Subnavigation Items
$chapterpages = array (
''             => array('Addon Hilfe',       '_readme.txt',                         'textile'),
//'changelog'    => array('Addon Changelog',   '_changelog.txt',                      'textile'),
//'libchangelog' => array('FirePHP Changelog', $active_lib.'/CHANGELOG',              'txt'),
//'libreadme'    => array('FirePHP Readme',    $active_lib.'/README',                 'txt'),
//'liblicense'   => array('FirePHP License',   $active_lib.'/lib/FirePHPCore/LICENSE','txt'),
//'libcredits'   => array('FirePHP Credits',   $active_lib.'/CREDITS',                'txt')
);

// BUILD CHAPTER NAVIGATION
////////////////////////////////////////////////////////////////////////////////
$chapternav = '';
foreach ($chapterpages as $chapterparam => $chapterprops)
{
  if ($chapter != $chapterparam) {
    $chapternav .= ' | <a href="?page='.$mypage.'&subpage=help&chapter='.$chapterparam.'">'.$chapterprops[0].'</a>';
  } else {
    $chapternav .= ' | '.$chapterprops[0];
  }
}
$chapternav = ltrim($chapternav, " | ");

// BUILD CHAPTER OUTPUT
////////////////////////////////////////////////////////////////////////////////
$myroot = $REX['INCLUDE_PATH']. '/addons/'.$mypage.'/';
$source    = $chapterpages[$chapter][1];
$parse     = $chapterpages[$chapter][2];

$html = firephp_incparse($myroot,$source,$parse,true);

// ADDON OUTPUT
////////////////////////////////////////////////////////////////////////////////
echo '
<div class="rex-addon-output">
  <h2 class="rex-hl2" style="font-size:1em">'.$chapternav.'</h2>
  <div class="rex-addon-content">
    <div class= "firephp">
    '.$html.'
    </div>
  </div>
</div>';

?>