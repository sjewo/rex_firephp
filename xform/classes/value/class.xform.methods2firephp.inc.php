<?php
/**
* FirePHP Addon
*
* FirePHP Lib Copyright (c) 2006-2010, Christoph Dorn, http://firephp.org
* FirePHP Lib v 0.3.1 & 0.3.2rc1
*
* @author <a href="http://rexdev.de">rexdev.de</a>
*
* @package redaxo 4.3.x/4.4.x/4.5.x
* @version 1.1.4
*/

class rex_xform_methods2firephp extends rex_xform_abstract
{
  private static $opts = array('Collapsed'=>true,'Color'=>'#2E6E89');
  private static $shortname;

  function __construct()
  {
    self::$shortname = str_replace('rex_xform_','',__CLASS__);
  }

  function setId($id)
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function setArticleId($aid)
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  // **************************

  function setValue($value)
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function getValue()
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  // **************************

  function setKey($k,$v)
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function getKeys()
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function getValueFromKey($v = "")
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function emptyKeys()
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  // **************************

  function loadParams(&$params, $elements = array())
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function setName($name)
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function getName()
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function setObjects(&$obj)
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function enterObject()
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function init()
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function preValidateAction()
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function postValidateAction()
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function postFormAction()
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function postAction()
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function postSQLAction($sql,$flag="insert")
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function getElement($i)
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function setElement($i,$value)
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function getId()
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function getFieldId($k="")
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function getFieldName($k="")
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function getHTMLId($suffix = "")
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function getHTMLClass()
  {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

  function getDescription()
  {
    #FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);FB::groupEnd();
    return '<strong>
              '.self::$shortname.'
            </strong> :
            <em>
              Gibt alle abstract Methoden dieses Klassen-Typs als Group in Firephp aus.
            </em><br />
            <code class="xform-form-code">
              '.self::$shortname.'
            </code>';
  }

  function getDefinitions() {
    FB::group(__CLASS__.'::'.__FUNCTION__,self::$opts);

    FB::groupEnd();
  }

}
