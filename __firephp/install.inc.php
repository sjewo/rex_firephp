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

if (intval(PHP_VERSION) < 4)
{
	$REX['ADDON']['installmsg']['__firephp'] = 'Dieses Addon ben&ouml;tigt mind. PHP4, und f&uuml;r volle Funktionalit&auml;t PHP 5!';
	$REX['ADDON']['install']['__firephp'] = 0;	
}
else
{ 
	$REX['ADDON']['install']['__firephp'] = 1;
}


?>