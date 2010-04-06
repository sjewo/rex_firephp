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

// SESSION STARTEN
////////////////////////////////////////////////////////////////////////////////
session_start();

// ADDON COMMONS
////////////////////////////////////////////////////////////////////////////////
$addon = "firephp";
$REX['ADDON']['rxid'][$addon] = '374';
$REX['ADDON']['page'][$addon] = $addon;
$REX['ADDON']['name'][$addon] = 'FirePHP';
$REX['ADDON']['perm'][$addon] = 'firephp[]';
$REX['ADDON']['version'][$addon] = "0.4.2";
$REX['ADDON']['author'][$addon] = "jeandeluxe | rexdev.de";
$REX['ADDON']['supportpage'][$addon] = "forum.redaxo.de";
$REX['PERM'][] = 'firephp[]';

// PARAMS
////////////////////////////////////////////////////////////////////////////////
$page = rex_request('page', 'string');
$subpage = rex_request('subpage', 'string');
$chapter = rex_request('chapter', 'string');
$func = rex_request('func', 'string');
$mode = rex_request('mode', 'int');
$uselib = rex_request('uselib', 'int');

// LIB VERSIONS, MENU STRINGS, MODE STRINGS -> $REX
////////////////////////////////////////////////////////////////////////////////
$REX['ADDON'][$addon]['libs'] = array (
1=>'FirePHPCore-0.3.1',
2=>'FirePHPCore-0.3.2rc1'
);
$REX['ADDON'][$addon]['menustring'] = array (
1=>'FirePHP',
2=>'FirePHP <span>session</span>',
3=>'FirePHP <em>permanent</em>'
);
$REX['ADDON'][$addon]['modestring'] = array (
1=>'inaktiv',
2=>'SESSION Mode - während Admin Session aktiviert',
3=>'PERMANENT Mode - grundsätzlich aktiviert'
);

// DYNAMIC ADDON SETTINGS
////////////////////////////////////////////////////////////////////////////////
// --- DYN
$REX['ADDON']['firephp']['mode'] = 1;
$REX['ADDON']['firephp']['uselib'] = 1;
// --- /DYN

// BACKEND CSS
////////////////////////////////////////////////////////////////////////////////
if ($REX['REDAXO']) {
  require_once $REX['INCLUDE_PATH'].'/addons/'.$addon.'/functions/function.rex_'.$addon.'_css_add.inc.php';
  rex_register_extension('PAGE_HEADER', 'rex_'.$addon.'_css_add');
}

// LIB SWITCH
////////////////////////////////////////////////////////////////////////////////
$active_lib = 'libs/'.$REX['ADDON'][$addon]['libs'][$REX['ADDON'][$addon]['uselib']];

switch(intval(PHP_VERSION)):
  case 4:
    /* VERSION FÜR PHP 4 */
    require_once($active_lib.'/lib/FirePHPCore/FirePHP.class.php4');
    require_once($active_lib.'/lib/FirePHPCore/fb.php4');
    $firephp = FirePHP::getInstance(true);
    $firephp->setEnabled(false);
    break;
  
  case 5:
    /* VERSION FÜR PHP 5 */
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
    $mode = $REX['ADDON'][$addon]['mode'];
  }
  
switch ($mode):
  case 1:
    $REX['ADDON']['name'][$addon] = $REX['ADDON'][$addon]['menustring'][$mode];
    $firephp->setEnabled(false);
    break;
    
  case 2:
    if ($_SESSION[$REX['INSTNAME']]['UID']==1)
    {
      $REX['ADDON']['name'][$addon] = $REX['ADDON'][$addon]['menustring'][$mode];
      $firephp->setEnabled(true);
      fb('FirePHP Mode: SESSION.' ,FirePHP::INFO);
    }
    else
    {
      $REX['ADDON']['name'][$addon] = $REX['ADDON'][$addon]['menustring'][$mode];
      $firephp->setEnabled(false);
    }
    break;
  
  case 3:
    $REX['ADDON']['name'][$addon] = $REX['ADDON'][$addon]['menustring'][$mode];
    $firephp->setEnabled(true);
    fb('FirePHP Mode: PERMANENT!' ,FirePHP::WARN);
    break;
    
  default:
    $REX['ADDON']['name'][$addon] = $REX['ADDON'][$addon]['menustring'][1];
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