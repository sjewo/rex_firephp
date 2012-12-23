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
* @version 0.5.0
*/

// SESSION
////////////////////////////////////////////////////////////////////////////////
if (session_id() == ''){
  session_start();
}

// PARAMS
////////////////////////////////////////////////////////////////////////////////
$mode = rex_request('mode', 'int');


// ADDON IDENTIFIER & ROOT DIR
////////////////////////////////////////////////////////////////////////////////
$mypage = '__firephp';
$myroot = $REX['INCLUDE_PATH'].'/addons/'.$mypage;


// ADDON REX COMMONS
////////////////////////////////////////////////////////////////////////////////
$REX['ADDON']['rxid'][$mypage]        = '374';
$REX['ADDON']['page'][$mypage]        = $mypage;
$REX['ADDON']['name'][$mypage]        = 'FirePHP';
$REX['ADDON']['version'][$mypage]     = '0.5.0';
$REX['ADDON']['author'][$mypage]      = 'rexdev.de';
$REX['ADDON']['supportpage'][$mypage] = 'forum.redaxo.de';
$REX['ADDON']['perm'][$mypage]        = $mypage.'[]';
$REX['PERM'][]                        = $mypage.'[]';


// ADDON VERSION, LIB VERSIONS, MENU STRINGS, MODE STRINGS -> $REX
////////////////////////////////////////////////////////////////////////////////

$REX['ADDON'][$mypage]['libs'] = array (
  'FirePHPCore-0.4.0rc3'=>'FirePHPCore-0.4.0rc3',
  'FirePHPCore-0.3.2'=>'FirePHPCore-0.3.2',
);
$REX['ADDON'][$mypage]['menustring'] = array (
  0=>'FirePHP',
  1=>'<em style="color:#02b902;">FirePHP</em>',
  2=>'<em style="color:#EA1144;">FirePHP</em>'
);
$REX['ADDON'][$mypage]['modestring'] = array (
  0=>'inaktiv',
  1=>'Session',
  2=>'permanent'
);
$REX['ADDON'][$mypage]['status2console'] = array (
  1=>'keine Statusmeldungen',
  2=>'FirePHP Konsole: Meldung nur für PERMANENT Mode',
  3=>'FirePHP Konsole: Meldung für SESSION & PERMANENT Mode'
);
$REX['ADDON'][$mypage]['sqllog'] = array (
  0=>'off',
  1=>'on',
);
$REX['ADDON'][$mypage]['ep_log'] = array (
  0=>'off',
  1=>'on',
);
$REX['ADDON'][$mypage]['js_bridge'] = array (
  0=>'off',
  1=>'on',
);


// DYNAMIC ADDON SETTINGS
////////////////////////////////////////////////////////////////////////////////
// --- DYN
$REX["ADDON"]["__firephp"]["settings"]["mode"] = 1;
$REX["ADDON"]["__firephp"]["settings"]["maxDepth"] = 10;
$REX["ADDON"]["__firephp"]["settings"]["maxArrayDepth"] = 5;
$REX["ADDON"]["__firephp"]["settings"]["maxObjectDepth"] = 5;
$REX["ADDON"]["__firephp"]["settings"]["sqllog"] = 0;
$REX["ADDON"]["__firephp"]["settings"]["ep_log"] = 0;
$REX["ADDON"]["__firephp"]["settings"]["ep_log_focus"] = '';
// --- /DYN

// CURRENTLY HIDDEN IN SETTINGS FORM
$REX["ADDON"]["__firephp"]["settings"]["js_bridge"] = 0;
$REX["ADDON"]["__firephp"]["settings"]["uselib"] = 'FirePHPCore-0.4.0rc3';


// INCLUDE ADDON CORE FUNCTIONS
////////////////////////////////////////////////////////////////////////////////
require_once($myroot.'/functions/function.firephp_core.inc.php');


// ADD OWN XFORM CLASSES
////////////////////////////////////////////////////////////////////////////////
rex_register_extension('ADDONS_INCLUDED', 'firephp_xform_classes');


// GENERAL INIT OF FIREPHP
////////////////////////////////////////////////////////////////////////////////
if(!class_exists('FirePHP'))
{
  $firephp = firephp_init();
}


// RUN BULTIN SERVICES
////////////////////////////////////////////////////////////////////////////////
if($REX['ADDON']['__firephp']['settings']['mode']!==0)
{
  # // DB CHANGES AUTODUMP
  # ////////////////////////////////////////////////////////////////////////////////
  # if($REX['ADDON']['__firephp']['settings']['db_changes_autodump']==1)
  # {
  #   require_once($myroot.'/extensions/extension.db_changes_autodump.inc.php');
  # }

  // FIREPHP SQL LOG
  ////////////////////////////////////////////////////////////////////////////////
  if($REX['ADDON']['__firephp']['settings']['sqllog']==1)
  {
    require_once($myroot.'/extensions/extension.firephp_sql_log.inc.php');
  }

  // FIREPHP EP LOG
  ////////////////////////////////////////////////////////////////////////////////
  if($REX['ADDON']['__firephp']['settings']['ep_log']==1)
  {
    require_once($myroot.'/extensions/extension.firephp_ep_log.inc.php');
  }

  // JS LOG TO FIREPHP BRIDGE
  ////////////////////////////////////////////////////////////////////////////////
  if($REX['ADDON']['__firephp']['settings']['js_bridge']==1)
  {
    require_once($myroot.'/extensions/extension.firephp_js_bridge.inc.php');
  }
}
