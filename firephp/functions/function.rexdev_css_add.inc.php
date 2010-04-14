<?php
/**
* Statische Funktion zum Einbinden von CSS Stylesheets ins Redaxo Backend
*
* @author rexdev.de
*
* @package redaxo4
* @version 0.4.2
* $Id$: 
*/

  if(!function_exists('rexdev_css_add'))
  {
    function rexdev_css_add($params) {
      global $REX;
      
      $params['subject'] .= "\n".$params['css'];
      
      return $params['subject'];
    }
  }
?>