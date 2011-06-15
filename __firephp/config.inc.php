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
/*ini_set('error_reporting', 'E_ALL');
ini_set('display_errors', 'On');*/

// PARAMS
////////////////////////////////////////////////////////////////////////////////
$mode = rex_request('mode', 'int');


// ADDON IDENTIFIER & ROOT DIR
////////////////////////////////////////////////////////////////////////////////
$mypage = '__firephp';
$myroot = $REX['INCLUDE_PATH'].'/addons/'.$mypage;
$Revision = '';


// ADDON VERSION
////////////////////////////////////////////////////////////////////////////////
$Revision = '';
$REX['ADDON'][$mypage]['VERSION'] = array
(
  'VERSION'      => 0,
  'MINORVERSION' => 4,
  'SUBVERSION'   => preg_replace('/[^0-9]/','',"$Revision$")
);


// ADDON REX COMMONS
////////////////////////////////////////////////////////////////////////////////
$REX['ADDON']['rxid'][$mypage]        = '374';
$REX['ADDON']['page'][$mypage]        = $mypage;
$REX['ADDON']['name'][$mypage]        = 'FirePHP';
$REX['ADDON']['version'][$mypage]     = implode('.', $REX['ADDON'][$mypage]['VERSION']);
$REX['ADDON']['author'][$mypage]      = 'rexdev.de';
$REX['ADDON']['supportpage'][$mypage] = 'forum.redaxo.de';
$REX['ADDON']['perm'][$mypage]        = $mypage.'[]';
$REX['PERM'][]                        = $mypage.'[]';


// ADDON VERSION, LIB VERSIONS, MENU STRINGS, MODE STRINGS -> $REX
////////////////////////////////////////////////////////////////////////////////

$REX['ADDON'][$mypage]['libs'] = array (
  'FirePHPCore-0.3.2'=>'FirePHPCore-0.3.2',
  '0.0.0master1106021548-firephp'=>'0.0.0master1106021548-firephp',
);
$REX['ADDON'][$mypage]['menustring'] = array (
  1=>'FirePHP',
  2=>'<span style="color:#7CE321;">FirePHP</span>',
  3=>'<em style="color:#EA1144;">FirePHP</em>'
);
$REX['ADDON'][$mypage]['modestring'] = array (
  1=>'inaktiv',
  2=>'SESSION Mode - während Admin Session aktiviert',
  3=>'PERMANENT Mode - grundsätzlich aktiviert'
);
$REX['ADDON'][$mypage]['status2console'] = array (
  1=>'keine Statusmeldungen',
  2=>'FirePHP Konsole: Meldung nur für PERMANENT Mode',
  3=>'FirePHP Konsole: Meldung für SESSION & PERMANENT Mode'
);


// DYNAMIC ADDON SETTINGS
////////////////////////////////////////////////////////////////////////////////
// --- DYN
$REX["ADDON"]["__firephp"]["settings"]["mode"] = 2;
$REX["ADDON"]["__firephp"]["settings"]["uselib"] = 'FirePHPCore-0.3.2';
$REX["ADDON"]["__firephp"]["settings"]["status2console"] = 1;
// --- /DYN


// LIB SWITCH
////////////////////////////////////////////////////////////////////////////////
$active_lib = 'libs/'.$REX['ADDON'][$mypage]['libs'][$REX['ADDON'][$mypage]['settings']['uselib']];

switch(intval(PHP_VERSION))
{
  case 4:
    /* VERSION F&Uuml;R PHP 4 */
    require_once($active_lib.'/lib/FirePHPCore/FirePHP.class.php4');
    require_once($active_lib.'/lib/FirePHPCore/fb.php4');
    $firephp = FirePHP::getInstance(true);
    $firephp->setEnabled(false);
    break;

  default:
    /* VERSION F&Uuml;R PHP 5 */
    require_once($active_lib.'/lib/FirePHPCore/FirePHP.class.php');
    require_once($active_lib.'/lib/FirePHPCore/fb.php');
    $firephp = FirePHP::getInstance(true);
    $firephp->setEnabled(false);
    $firephp->setOption('maxDepth', 4);
}


// FIREPHP ON/OFF
////////////////////////////////////////////////////////////////////////////////

// Configure FirePHP
//define('INSIGHT_DEBUG', true);
//define('INSIGHT_SERVER_PATH', '/index.php'); // assumes /index.php exists on your hostname
//define('INSIGHT_IPS', '*');
//define('INSIGHT_AUTHKEYS', '');
//define('INSIGHT_PATHS', '__DIR__');
// NOTE: Based on this configuration /index.php MUST include FirePHP

if(!intval($mode))
  {
    $mode = $REX['ADDON'][$mypage]['settings']['mode'];
  }

switch ($mode):
  case 1:
    $REX['ADDON']['name'][$mypage] = $REX['ADDON'][$mypage]['menustring'][$mode];
    $firephp->setEnabled(false);
    break;

  case 2:
    if (isset($_SESSION[$REX['INSTNAME']]['UID']) && $_SESSION[$REX['INSTNAME']]['UID']==1)
    {
      $REX['ADDON']['name'][$mypage] = $REX['ADDON'][$mypage]['menustring'][$mode];
      $firephp->setEnabled(true);
      if($REX['ADDON'][$mypage]['settings']['status2console'] > 2)
      {
        fb('FirePHP Mode: SESSION.' ,FirePHP::INFO);
      }
    }
    else
    {
      $REX['ADDON']['name'][$mypage] = $REX['ADDON'][$mypage]['menustring'][$mode];
      $firephp->setEnabled(false);
    }
    break;

  case 3:
    $REX['ADDON']['name'][$mypage] = $REX['ADDON'][$mypage]['menustring'][$mode];
    $firephp->setEnabled(true);
      if($REX['ADDON'][$mypage]['settings']['status2console'] > 1)
      {
        fb('FirePHP Mode: PERMANENT!' ,FirePHP::WARN);
      }
    break;

  default:
    $REX['ADDON']['name'][$mypage] = $REX['ADDON'][$mypage]['menustring'][1];
    $firephp->setEnabled(false);
    break;
endswitch;


/*fb($REX['EXTENSIONS']['PAGE_HEADER'],'REX');
fb($REX,'backend $REX');
fb($REX['USER'],'backend $REX[USER]');
fb($REX['ADDON']['__firephp'],'backend $REX[ADDON][firephp]');
fb($_SESSION[$REX['INSTNAME']]['UID'],'backend $_SESSION[$REX[INSTNAME]][UID]');*/

?>