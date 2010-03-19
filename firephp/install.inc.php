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

// Addon Identifier
$mypage = "firephp";

if (intval(PHP_VERSION) < 4)
{
	$REX['ADDON']['installmsg'][$mypage] = 'Dieses Addon ben&ouml;tigt mind. PHP4, und für Volle Funktionalität PHP 5!';
	$REX['ADDON']['install'][$mypage] = 0;	
}
else
{ 
	$REX['ADDON']['install'][$mypage] = 1;
}


?>