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

// ADDON IDENTIFIER
$mypage = "firephp";
// UNIQUE ID
$REX['ADDON']['rxid'][$mypage] = '374';
// FOLDERNAME
$REX['ADDON']['page'][$mypage] = $mypage;
// NAME SHOWN IN THE REDAXO MAIN MENU
$REX['ADDON']['name'][$mypage] = 'FirePHP';
// PERMISSION NEEDED FOR ACCESSING THE ADDON
$REX['ADDON']['perm'][$mypage] = 'firephp[]';
$REX['ADDON']['version'][$mypage] = "0.4";
$REX['ADDON']['author'][$mypage] = "jeandeluxe | rexdev.de";
$REX['ADDON']['supportpage'][$mypage] = "forum.redaxo.de";

// ADD DEFAULT PERM FOR ACCESSING THE ADDON TO USER-ADMINISTRATION
$REX['PERM'][] = 'firephp[]';

// BACKEND ACCESSIBLE ADDON SETTINGS

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
  if (intval(PHP_VERSION) < 5)
  {
    // VERSION FÜR PHP 4
    require('FirePHPCore-0.3.1/lib/FirePHPCore/FirePHP.class.php4');
    require('FirePHPCore-0.3.1/lib/FirePHPCore/fb.php4');
    $firephp = FirePHP::getInstance(true);
  }
  else
  {
    // VERSION FÜR PHP 5
    require('FirePHPCore-0.3.1/lib/FirePHPCore/FirePHP.class.php');
    require('FirePHPCore-0.3.1/lib/FirePHPCore/fb.php');
    $firephp = FirePHP::getInstance(true);
  }
	
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