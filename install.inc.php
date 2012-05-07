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

// INSTALL SETTINGS
////////////////////////////////////////////////////////////////////////////////
$myself            = '__firephp';
$myroot            = $REX['INCLUDE_PATH'].'/addons/'.$myself;

$minimum_REX       = '4.2.0';
$this_REX          = $REX['VERSION'].'.'.$REX['SUBVERSION'].'.'.$REX['MINORVERSION'];
$minimum_PHP       = 5;
$required_addons   = array();
$disable_addons    = array();
$error             = array();
$autoinstall       = true;

// CHECK REDAXO VERSION
////////////////////////////////////////////////////////////////////////////////
if(version_compare($this_REX, $minimum_REX, '<'))
{
  $error[] = 'Dieses Addon ben&ouml;tigt Redaxo Version '.$minimum_REX.' oder h&ouml;her.';
}


// CHECK PHP VERSION
////////////////////////////////////////////////////////////////////////////////
if(version_compare(PHP_VERSION, $minimum_PHP, '<'))
{
  $error[] = 'Dieses Addon ben&ouml;tigt mind. PHP '.$minimum_PHP.'!';
}


// CHECK REQUIRED ADDONS
////////////////////////////////////////////////////////////////////////////////
foreach($required_addons as $a)
{
  if (!OOAddon::isInstalled($a))
  {
    $error[] = 'Addon "'.$a.'" ist nicht installiert.  <span style="float:right;">[ <a href="index.php?page=addon&addonname='.$a.'&install=1">'.$a.' installieren</a> ]</span>';
  }
  else
  {
    if (!OOAddon::isAvailable($a))
    {
      $error[] = 'Addon "'.$a.'" ist nicht aktiviert.  <span style="float:right;">[ <a href="index.php?page=addon&addonname='.$a.'&activate=1">'.$a.' aktivieren</a> ]</span>';
    }
  }
}


// CHECK ADDONS TO DISABLE
////////////////////////////////////////////////////////////////////////////////
foreach($disable_addons as $a)
{
  if (OOAddon::isInstalled($a) || OOAddon::isAvailable($a))
  {
    $error[] = 'Addon "'.$a.'" muß erst deinstalliert werden.  <span style="float:right;">[ <a href="index.php?page=addon&addonname='.$a.'&uninstall=1">'.$a.' de-installieren</a> ]</span>';
  }
}



// DO INSTALL
////////////////////////////////////////////////////////////////////////////////
if(count($error)==0)
{

  // INSTALL/COPY FILES
  //////////////////////////////////////////////////////////////////////////////
  if($autoinstall)
  {
    require_once $myroot.'/functions/function.firephp_helpers.inc.php';
    // SQL LOG PATCH
    $source = $REX['INCLUDE_PATH'].'/addons/'.$myself.'/install/sql_log_patch/'.$this_REX.'/';
    $target = $REX['HTDOCS_PATH'];
    $result = firephp_recursive_copy($source, $target);
    // EP LOG PATCH
    $source = $REX['INCLUDE_PATH'].'/addons/'.$myself.'/install/ep_log_patch/'.$this_REX.'/';
    $target = $REX['HTDOCS_PATH'];
    $result = firephp_recursive_copy($source, $target);
  }

  $REX['ADDON']['install'][$myself] = 1;
}
else

{
  $REX['ADDON']['installmsg'][$myself] = '<br />'.implode($error,'<br />');
  $REX['ADDON']['install'][$myself] = 0;
}

?>