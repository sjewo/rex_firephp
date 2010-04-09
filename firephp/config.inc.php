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
* $Revision$
* $Id$: 
*/

// SESSION STARTEN
////////////////////////////////////////////////////////////////////////////////
session_start();

// ADDON COMMONS
////////////////////////////////////////////////////////////////////////////////
$me = "firephp";
$REX['ADDON']['rxid'][$me] = '374';
$REX['ADDON']['page'][$me] = $me;
$REX['ADDON']['name'][$me] = 'FirePHP';
$REX['ADDON']['perm'][$me] = 'firephp[]';
$REX['ADDON']['version'][$me] = "0.4.2";
$REX['ADDON']['author'][$me] = "jeandeluxe | rexdev.de";
$REX['ADDON']['supportpage'][$me] = "forum.redaxo.de";
$REX['PERM'][] = 'firephp[]';

// PARAMS
////////////////////////////////////////////////////////////////////////////////
$page = rex_request('page', 'string');
$subpage = rex_request('subpage', 'string');
$chapter = rex_request('chapter', 'string');
$func = rex_request('func', 'string');
$mode = rex_request('mode', 'int');
$uselib = rex_request('uselib', 'int');

// ADDON VERSION, LIB VERSIONS, MENU STRINGS, MODE STRINGS -> $REX
////////////////////////////////////////////////////////////////////////////////
$REX['ADDON'][$me]['VERSION'] = array(
'VERSION' => 0,
'MINORVERSION' => 4,
'SUBVERSION' => 2,
'REVISION' => 73
);

$REX['ADDON'][$me]['libs'] = array (
1=>'FirePHPCore-0.3.1',
2=>'FirePHPCore-0.3.2rc1'
);
$REX['ADDON'][$me]['menustring'] = array (
1=>'FirePHP',
2=>'FirePHP <span>session</span>',
3=>'FirePHP <em>permanent</em>'
);
$REX['ADDON'][$me]['modestring'] = array (
1=>'inaktiv',
2=>'SESSION Mode - w&auml;hrend Admin Session aktiviert',
3=>'PERMANENT Mode - grunds&auml;tzlich aktiviert'
);
$REX['ADDON'][$me]['versioncheckstring'] = array (
1=>'Nein',
2=>'Standard Versionen',
3=>'Standard Versionen und Revisionen'
);

// DYNAMIC ADDON SETTINGS
////////////////////////////////////////////////////////////////////////////////
// --- DYN
$REX['ADDON']['firephp']['mode'] = 2;
$REX['ADDON']['firephp']['uselib'] = 1;
$REX['ADDON']['firephp']['versioncheck'] = 3;
// --- /DYN

// BACKEND CSS
////////////////////////////////////////////////////////////////////////////////
if ($REX['REDAXO']) {
  require_once $REX['INCLUDE_PATH'].'/addons/'.$me.'/functions/function.rex_'.$me.'_css_add.inc.php';
  rex_register_extension('PAGE_HEADER', 'rex_'.$me.'_css_add');
}

// LIB SWITCH
////////////////////////////////////////////////////////////////////////////////
$active_lib = 'libs/'.$REX['ADDON'][$me]['libs'][$REX['ADDON'][$me]['uselib']];

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
    $mode = $REX['ADDON'][$me]['mode'];
  }
  
switch ($mode):
  case 1:
    $REX['ADDON']['name'][$me] = $REX['ADDON'][$me]['menustring'][$mode];
    $firephp->setEnabled(false);
    break;
    
  case 2:
    if ($_SESSION[$REX['INSTNAME']]['UID']==1)
    {
      $REX['ADDON']['name'][$me] = $REX['ADDON'][$me]['menustring'][$mode];
      $firephp->setEnabled(true);
      fb('FirePHP Mode: SESSION.' ,FirePHP::INFO);
    }
    else
    {
      $REX['ADDON']['name'][$me] = $REX['ADDON'][$me]['menustring'][$mode];
      $firephp->setEnabled(false);
    }
    break;
  
  case 3:
    $REX['ADDON']['name'][$me] = $REX['ADDON'][$me]['menustring'][$mode];
    $firephp->setEnabled(true);
    fb('FirePHP Mode: PERMANENT!' ,FirePHP::WARN);
    break;
    
  default:
    $REX['ADDON']['name'][$me] = $REX['ADDON'][$me]['menustring'][1];
    $firephp->setEnabled(false);
    break;
endswitch;

/*
fb($REX,'backend $REX');
fb($REX['USER'],'backend $REX[USER]');
fb($REX['ADDON']['firephp'],'backend $REX[ADDON][firephp]');
fb($_SESSION[$REX['INSTNAME']]['UID'],'backend $_SESSION[$REX[INSTNAME]][UID]');
*/
?>