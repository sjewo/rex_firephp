<?php
/**
* FirePHP Addon
*
* FirePHP Lib Copyright (c) 2006-2010, Christoph Dorn, http://firephp.org
* FirePHP Lib v 0.3.1 & 0.3.2rc1
*
* @author <a href="http://rexdev.de">rexdev.de</a>
*
* @package redaxo 4.3.x/4.4.x
* @version 0.4.7
*/


// INCLUDE HEADER JS
////////////////////////////////////////////////////////////////////////////////
switch($REX['REDAXO'])
{
  case false: // frontend
    rex_register_extension('OUTPUT_FILTER', 'firephp_js_bridge_header');
    break;

  case true: // backend
    rex_register_extension('PAGE_HEADER', 'firephp_js_bridge_header');
    break;
}

// JS LOG TO FIREPHP AJAX VOODOO
////////////////////////////////////////////////////////////////////////////////
$data  = rex_request('firephp_callback','string',false);

if($data!=false)
{
  $data = get_object_vars(json_decode(stripslashes($data)));
  if(isset($data['variable']) && isset($data['label']) && isset($data['logtype']))
  {
    switch ($data['logtype'])
    {
      case 'log':
        FB::log($data['variable'],$data['label']);
        die;
        break;
      case 'info':
        FB::info($data['variable'],$data['label']);
        die;
        break;
      case 'warn':
        FB::warn($data['variable'],$data['label']);
        die;
        break;
      case 'error':
        FB::error($data['variable'],$data['label']);
        die;
        break;
    }
  }
}
