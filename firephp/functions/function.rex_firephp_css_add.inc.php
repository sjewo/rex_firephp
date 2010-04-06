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

function rex_firephp_css_add($params) {
  $n ="\n";
  $params['subject'] .= $n.'<link rel="stylesheet" type="text/css" href="../files/addons/firephp/rex_firephp_backend.css" />'.$n;
  return $params['subject'];
}
?>