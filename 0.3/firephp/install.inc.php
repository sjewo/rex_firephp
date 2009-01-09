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

// Addon Identifier
$mypage = "firephp";

if (intval(PHP_VERSION) < 5)
{
	$REX['ADDON']['installmsg']['firephp'] = 'Dieses Addon ben&ouml;tigt PHP 5!';
	$REX['ADDON']['install']['firephp'] = 0;	
}
else
{ 
	$REX['ADDON']['install']['firephp'] = 1;
	header("Location: index.php?page=addon&spage=help&addonname=".$mypage."&mode=installcatch");
}


?>