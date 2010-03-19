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

require $REX['INCLUDE_PATH'] . '/layout/top.php';

// Build Subnavigation
$subpages = array (
  	array ('','Settings'),
  	array ('help','Hilfe')
	);

rex_title('FirePHP '.$REX['ADDON']['version']['firephp'], $subpages);

// Include Current Page
switch($subpage)
{
  case 'help' :
  {
    break;
  }

  default:
  {
	  $subpage = 'settings';
    break;
  }
}

require $REX['INCLUDE_PATH'] . '/addons/firephp/pages/'.$subpage.'.inc.php';

require $REX['INCLUDE_PATH'] . '/layout/bottom.php';

?>