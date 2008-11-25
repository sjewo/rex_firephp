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

if (intval(PHP_VERSION) < 5)
{
	$REX['ADDON']['installmsg']['firephp'] = 'Dieses Addon ben&ouml;tigt PHP 5!';
	$REX['ADDON']['install']['firephp'] = 0;	
}
else
{ 
	$REX['ADDON']['install']['firephp'] = 1;
}


?>