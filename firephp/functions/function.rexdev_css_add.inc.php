<?php
/**
* Generische Funktion zum Einbinden von CSS Stylesheets ins Redaxo Backend
*
* Beispiel:
* ---------------------------------------------------------------
* $css = '<link rel="stylesheet" type="text/css" href="../files/addons/'.$myself.'/backend.css" />';
* 
* if ($REX['REDAXO']) {
*   include_once $myroot.'/functions/function.rexdev_css_add.inc.php';
*   rex_register_extension('PAGE_HEADER', 'rexdev_css_add',array('css'=>$css));
* }
* ------------------------------------------------------------------------------
* 
* @author rexdev.de
*
* @package redaxo4
* @version 0.4.2
* $Id$: 
*
* 
* 
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