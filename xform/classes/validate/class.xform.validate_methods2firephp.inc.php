<?php
/**
* REXDEV XForm Plugins
*
* @link    https://github.com/jdlx/xform_plugins
* @author  rexdev.de
* @package redaxo 4.3.x/4.4.x
* @version 0.3.0
*/

class rex_xform_validate_methods2firephp extends rex_xform_validate_abstract
{
  private static $opts = array('Collapsed'=>true,'Color'=>'#B83C31');

  function loadParams(&$params, $elements)
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function setObjects(&$Objects)
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function enterObject()
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function getDescription()
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function getLongDescription()
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function getDefinitions()
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function getElement($i)
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

}
