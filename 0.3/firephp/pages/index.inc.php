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
* @version 0.3 
* $Id$: 
*/

require $REX['INCLUDE_PATH'] . '/layout/top.php';

// Build Subnavigation
$subpages = array (
  	array ('','Hilfe'),
  	array ('settings','Konfiguration'),
	);

rex_title('Image Resize', $subpages);

// Include Current Page
switch($subpage)
{
  case 'settings' :
  {
    break;
  }

  default:
  {
  	if (isset ($msg) and $msg != '')
		  echo rex_warning($msg);

	  $subpage = 'overview';
  }
}

require $REX['INCLUDE_PATH'] . '/addons/image_resize/pages/'.$subpage.'.inc.php';

require $REX['INCLUDE_PATH'] . '/layout/bottom.php';

?>