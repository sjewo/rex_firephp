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

// ERROR_REPORTING
////////////////////////////////////////////////////////////////////////////////
@ ini_set('error_reporting', E_ALL);
@ ini_set('display_errors', On);

// PARAMS
////////////////////////////////////////////////////////////////////////////////
$mode = rex_request('mode', 'int');

// ADDON IDENTIFIER & ROOT DIR
////////////////////////////////////////////////////////////////////////////////
$myself = 'firephp';
$myroot = $REX['INCLUDE_PATH'].'/addons/'.$myself;
$Revision = '';

// ADDON VERSION
////////////////////////////////////////////////////////////////////////////////
$Revision = '';
$REX['ADDON'][$myself]['VERSION'] = array
(
  'VERSION'      => 0,
  'MINORVERSION' => 4,
  'SUBVERSION'   => preg_replace('/[^0-9]/','',"$Revision$")
);

// ADDON REX COMMONS
////////////////////////////////////////////////////////////////////////////////
$REX['ADDON']['rxid'][$myself] = '374';
$REX['ADDON']['page'][$myself] = $myself;
$REX['ADDON']['name'][$myself] = 'FirePHP';
$REX['ADDON']['version'][$myself] = implode('.', $REX['ADDON'][$myself]['VERSION']);
$REX['ADDON']['author'][$myself] = 'rexdev.de';
$REX['ADDON']['supportpage'][$myself] = 'forum.redaxo.de';
$REX['ADDON']['perm'][$myself] = $myself.'[]';
$REX['PERM'][] = $myself.'[]';

// ADDON VERSION, LIB VERSIONS, MENU STRINGS, MODE STRINGS -> $REX
////////////////////////////////////////////////////////////////////////////////

$REX['ADDON'][$myself]['libs'] = array (
1=>'FirePHPCore-0.3.1',
2=>'FirePHPCore-0.3.2rc1'
);
$REX['ADDON'][$myself]['menustring'] = array (
1=>'FirePHP',
2=>'<span>FirePHP</span>',
3=>'<em>FirePHP</em>'
);
$REX['ADDON'][$myself]['modestring'] = array (
1=>'inaktiv',
2=>'SESSION Mode - w&auml;hrend Admin Session aktiviert',
3=>'PERMANENT Mode - grunds&auml;tzlich aktiviert'
);
$REX['ADDON'][$myself]['versioncheckstring'] = array (
1=>'Nein',
2=>'Standard Versionen',
3=>'Standard Versionen und Revisionen'
);


// DYNAMIC ADDON SETTINGS
////////////////////////////////////////////////////////////////////////////////
// --- DYN
$REX['ADDON']['firephp']['mode'] = 3;
$REX['ADDON']['firephp']['uselib'] = 1;
$REX['ADDON']['firephp']['versioncheck'] = 0;
// --- /DYN

// BACKEND CSS
////////////////////////////////////////////////////////////////////////////////
$header = array(
'  <link rel="stylesheet" type="text/css" href="../files/addons/'.$myself.'/backend.css" media="screen, projection, print" />'
);

if ($REX['REDAXO']) {
  include_once $myroot.'/functions/function.rexdev_header_add.inc.php';
  rex_register_extension('PAGE_HEADER', 'rexdev_header_add',$header);
}

// LIB SWITCH
////////////////////////////////////////////////////////////////////////////////
$active_lib = 'libs/'.$REX['ADDON'][$myself]['libs'][$REX['ADDON'][$myself]['uselib']];

switch(intval(PHP_VERSION)):
  case 4:
    /* VERSION F&Uuml;R PHP 4 */
    require_once($active_lib.'/lib/FirePHPCore/FirePHP.class.php4');
    require_once($active_lib.'/lib/FirePHPCore/fb.php4');
    $firephp = FirePHP::getInstance(true);
    $firephp->setEnabled(false);
    break;

  case 5:
    /* VERSION F&Uuml;R PHP 5 */
    require_once($active_lib.'/lib/FirePHPCore/FirePHP.class.php');
    require_once($active_lib.'/lib/FirePHPCore/fb.php');
    $firephp = FirePHP::getInstance(true);
    $firephp->setEnabled(false);
    break;

  default:
    break;
endswitch;


// FIREPHP ON/OFF
////////////////////////////////////////////////////////////////////////////////
if(!intval($mode))
  {
    $mode = $REX['ADDON'][$myself]['mode'];
  }

switch ($mode):
  case 1:
    $REX['ADDON']['name'][$myself] = $REX['ADDON'][$myself]['menustring'][$mode];
    $firephp->setEnabled(false);
    break;

  case 2:
    if ($_SESSION[$REX['INSTNAME']]['UID']==1)
    {
      $REX['ADDON']['name'][$myself] = $REX['ADDON'][$myself]['menustring'][$mode];
      $firephp->setEnabled(true);
      //fb('FirePHP Mode: SESSION.' ,FirePHP::INFO);
    }
    else
    {
      $REX['ADDON']['name'][$myself] = $REX['ADDON'][$myself]['menustring'][$mode];
      $firephp->setEnabled(false);
    }
    break;

  case 3:
    $REX['ADDON']['name'][$myself] = $REX['ADDON'][$myself]['menustring'][$mode];
    $firephp->setEnabled(true);
    fb('FirePHP Mode: PERMANENT!' ,FirePHP::WARN);
    break;

  default:
    $REX['ADDON']['name'][$myself] = $REX['ADDON'][$myself]['menustring'][1];
    $firephp->setEnabled(false);
    break;
endswitch;

/*
fb($REX['EXTENSIONS']['PAGE_HEADER'],'REX');
fb($REX,'backend $REX');
fb($REX['USER'],'backend $REX[USER]');
fb($REX['ADDON']['firephp'],'backend $REX[ADDON][firephp]');
fb($_SESSION[$REX['INSTNAME']]['UID'],'backend $_SESSION[$REX[INSTNAME]][UID]');
*/
?>