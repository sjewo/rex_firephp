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

// addon identifier
$mypage = "firephp";
// unique id
$REX['ADDON']['rxid'][$mypage] = '374';
// foldername
$REX['ADDON']['page'][$mypage] = $mypage;    
// name shown in the REDAXO main menu
$REX['ADDON']['name'][$mypage] = 'FirePHP';
// permission needed for accessing the addon
$REX['ADDON']['perm'][$mypage] = 'firephp[]';
$REX['ADDON']['version'][$mypage] = "0.3.1";
$REX['ADDON']['author'][$mypage] = "Jan Camrda | rexdev.f-stop.de";
$REX['ADDON']['supportpage'][$mypage] = "forum.redaxo.de";

// add default perm for accessing the addon to user-administration
$REX['PERM'][] = 'firephp[]';

// Addon Settings

// --- DYN
$REX['ADDON']['firephp']['enabled'] = 0;
$REX['ADDON']['firephp']['dummymode'] = 0;
// --- /DYN

if ($REX['ADDON']['firephp']['dummymode']==1)
{
	function fb() {
		echo '<div style="position:fixed;top:0;left:0;margin:0;padding:2px;color:red;background:white;font-size:9px;z-index:99">uncaught fb() call</div>';
	}
}
else
{
	require('FirePHPCore/FirePHP.class.php');
	require('FirePHPCore/fb.php');
	$firephp = FirePHP::getInstance(true);
	
	if ($REX['ADDON']['firephp']['enabled']==1)
	{
		$firephp->setEnabled(true);
	}
	else
	{
		$firephp->setEnabled(false);
	}
}

?>