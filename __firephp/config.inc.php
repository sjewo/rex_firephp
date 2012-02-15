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
  'FirePHPCore-0.4.0rc3'=>'FirePHPCore-0.4.0rc3',
  'FirePHPCore-0.3.2'=>'FirePHPCore-0.3.2',
  '0.0.0master1106021548-firephp'=>'0.0.0master1106021548-firephp',
  'firephp-1.0b1rc1'=>'firephp-1.0b1rc1'
);
$REX['ADDON'][$mypage]['menustring'] = array (
  1=>'FirePHP',
  2=>'<span style="color:#7CE321;">FirePHP</span>',
  3=>'<em style="color:#EA1144;">FirePHP</em>'
);
$REX['ADDON'][$mypage]['modestring'] = array (
  1=>'inaktiv',
  //2=>'während Admin Session aktiviert - SESSION Mode - ',
  3=>'aktiv'
);
$REX['ADDON'][$mypage]['status2console'] = array (
  1=>'keine Statusmeldungen',
  2=>'FirePHP Konsole: Meldung nur für PERMANENT Mode',
  3=>'FirePHP Konsole: Meldung für SESSION & PERMANENT Mode'
);
$REX['ADDON'][$mypage]['maxdepth'] = array (
  0=>'infinte',
  1=>'1 level',
  2=>'2 levels',
  3=>'3 levels',
  4=>'4 levels',
  5=>'5 levels',
  6=>'6 levels',
  7=>'7 levels',
  8=>'8 levels',
  9=>'9 levels',
);
$REX['ADDON'][$mypage]['sqllog'] = array (
  0=>'off',
  1=>'backend',
  2=>'frontend',
  3=>'backend & frontend',
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
$REX["ADDON"]["__firephp"]["settings"]["mode"] = 3;
$REX["ADDON"]["__firephp"]["settings"]["uselib"] = 'FirePHPCore-0.4.0rc3';
$REX["ADDON"]["__firephp"]["settings"]["maxdepth"] = 7;
$REX["ADDON"]["__firephp"]["settings"]["sqllog"] = 3;
$REX["ADDON"]["__firephp"]["settings"]["ep_log"] = 0;
$REX["ADDON"]["__firephp"]["settings"]["js_bridge"] = 0;
// --- /DYN


// LIB SWITCH
////////////////////////////////////////////////////////////////////////////////
$active_lib = 'libs/'.$REX['ADDON'][$mypage]['libs'][$REX['ADDON'][$mypage]['settings']['uselib']];

if(!class_exists('FirePHP'))
{
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
      if($REX['ADDON'][$mypage]['settings']['maxdepth']>0)
      {
        $firephp->setOption('maxDepth',$REX['ADDON'][$mypage]['settings']['maxdepth']);
      }
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

  switch ($mode)
  {
    case 1:
      $REX['ADDON']['name'][$mypage] = $REX['ADDON'][$mypage]['menustring'][$mode];
      $firephp->setEnabled(false);
      break;

    case 2:
      if (isset($_SESSION[$REX['INSTNAME']]['UID']) && $_SESSION[$REX['INSTNAME']]['UID']==1)
      {
        $REX['ADDON']['name'][$mypage] = $REX['ADDON'][$mypage]['menustring'][$mode];
        $firephp->setEnabled(true);
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
      break;

    default:
      $REX['ADDON']['name'][$mypage] = $REX['ADDON'][$mypage]['menustring'][1];
      $firephp->setEnabled(false);
  }

// FIREPHP OUTPUT OF LOGS
////////////////////////////////////////////////////////////////////////////////
rex_register_extension('OUTPUT_FILTER_CACHE', 'send_to_firephp');

function send_to_firephp()
{
  global $REX, $firephp;
  ob_start();

  // SQL LOG
  ////////////////////////////////////////////////////////////////////////////
  $ctrl = $REX['ADDON']['__firephp']['settings']['sqllog'];
  if(($ctrl==2 || $ctrl==3) && isset(rex_sql::$log))
  {
    $sql_log = rex_sql::$log;
    if(count($sql_log)>0)
    {
      #$firephp = FirePHP::getInstance(true);
      #$firephp->setEnabled(true);
      #$firephp->info($REX,'REX');
      $table = array();
      $table[] = array('#','Rows','Query','Errno','Error','File','Line');
      $group_opts = rex_sql::$err_count>0
        ? array('Expanded' => true,'Color' => 'red')
        : array('Collapsed' => true,'Color' => 'green');
      $firephp->group('REX_SQL LOG ('.rex_sql::$count.' queries, '.rex_sql::$err_count.' errors)',$group_opts);
      #$firephp->group('  #,ROWS, QUERY',array('Collapsed' => true,'Color'=>'gray'));$firephp->groupEnd();
      foreach($sql_log as $k => $v)
      {
        $n    = str_pad('#'.$k,         4, ' ', STR_PAD_LEFT);
        $rows = isset($v['rows']) ? str_pad('('.$v['rows'].' rows) ', 11, ' ', STR_PAD_LEFT) : '';
        $backtrace = '';
        $file = '';
        $line = '';
        $errno = '';
        $error = '';
        #$v['query'] = str_replace(array("\n","\r"),'',$v['query']);
        $query = preg_replace('#[\n|\r]#','',$v['query']);
        $query = preg_replace('#\s+#',' ',$v['query']);

        if(isset($v['error']) && $v['error']!=null)
        {
          $firephp->group($n.'| ERROR @ QUERY: '.$query);
          $firephp->error('error #'.$v['errno'].': '.$v['error']);
          foreach($v['backtrace'] as $t)
          {
            if(isset($t['object']) &&
               is_object($t['object']) &&
               isset($t['object']->query) &&
               $t['object']->query == $v['query'])
            {
              $backtrace = 'line '.$t['line'].' @ '.str_replace($REX['FRONTEND_PATH'],'.',$t['file']);
              $file = str_replace($REX['FRONTEND_PATH'],'.',$t['file']);
              $line = $t['line'];
            }
          }
          $firephp->info($backtrace,'backtrace');
          #$table[] = array('SQL ERROR >>>','–','–','–','–');
          $table[] = array($k,'ERROR',$v['query'],$v['errno'],$v['error'],$file,$line,);
          #$table[] = array('<<< SQL ERROR','–','–','–','–');
          $firephp->groupEnd();
        }
        else
        {
          #$firephp->log('#'.$k.': '.$rows.' ROWS @ QUERY: '.$v['query']);
          $firephp->group($n.$rows.$query,array('Collapsed' => true,'Color'=>'#44578A'));
          foreach($v['backtrace'] as $t)
          {
            if(isset($t['object']) &&
               is_object($t['object']) &&
               isset($t['object']->query) &&
               $t['object']->query == $v['query'])
            {
              $backtrace = 'line '.$t['line'].' @ '.str_replace($REX['FRONTEND_PATH'],'.',$t['file']);
              $file = str_replace($REX['FRONTEND_PATH'],'.',$t['file']);
              $line = $t['line'];
            }
          }

          $firephp->log($backtrace,'backtrace');
          $firephp->groupEnd();

          #$firephp->log('#'.$k.': '.$rows.' ROWS @ QUERY: '.$v['query']);
          $table[] = array($k,$v['rows'],$v['query'],$errno,$error,$file,$line,);
        }
      }
      $firephp->groupEnd();
      $firephp->table('REX_SQL LOG ('.rex_sql::$count.' queries, '.rex_sql::$err_count.' errors)',$table,array('Expanded'=>true));
      #$firephp->table('REX_SQL LOG ('.rex_sql::$count.' queries, '.rex_sql::$err_count.' errors)',$table,$group_opts);
    }
  }

  // EP LOG
  ////////////////////////////////////////////////////////////////////////////
  if($REX['ADDON']['__firephp']['settings']['ep_log']==1)
  {
    $i = 1;
    $firephp->group('EP LOG',array('Collapsed' => true,'Color' => 'green'));
    foreach($REX['EXTENSION_POINT_LOG'] as $e)
    {
      $opts = array('Collapsed' => true);
      $opts['Color'] = $e['type']=='point' ? 'black' : 'blue';
      $firephp->group($e['group'],$opts);
      unset($e['group'],$e['type']);
      foreach($e as $k=>$v)
      {
        $firephp->log($v,$k);
      }
      $firephp->groupEnd();
    }
    //$firephp->log($REX['EXTENSION_POINT_LOG'],'LOG');
    $firephp->groupEnd();
  }

}

  // JS LOG TO FIREPHP BRIDGE
  ////////////////////////////////////////////////////////////////////////////////
  if($REX['ADDON']['__firephp']['settings']['js_bridge']==1)
  {
    function firephp_header($params)
    {
      global $REX;
    
      $script = '
    <!-- FIREPHP ADDON -->
      <script type="text/javascript">
    
        // SEND VAR FORM JS CONTEXT TO FIREPHP VIA BACKEND CALLBACK
        function fb(variable,label,logtype){
            label = label || "";
            logtype = logtype || "log";
    
            var data        = {};
            data.label      = label;
            data.variable   = variable;
            data.logtype    = logtype;
    
            var request  = jQuery.ajax({
              url: "index.php",
              type: "POST",
              data: {
                firephp  : "jsbridge",
                data       : JSON.stringify(data)
              },
              success: function(msg) {
                //...
              }
            });
        };
    
      </script>
    <!-- /FIREPHP ADDON -->
      ';
      switch($REX['REDAXO'])
      {
        case false: // frontend
          return str_replace('</head>',$script.'</head>',$params['subject']);
        break;
    
        case true: // backend
          return $params['subject'].$script;
        break;
      }
    }
    
    switch($REX['REDAXO'])
    {
      case false: // frontend
        rex_register_extension('OUTPUT_FILTER', 'firephp_header');
        break;
    
      case true: // backend
        rex_register_extension('PAGE_HEADER', 'firephp_header');
        break;
    }
    
    // JS LOG TO FIREPHP AJAX VOODOO
    //////////////////////////////////////////////////////////////////////////////
    $firephp    = rex_request('firephp','string',false);
    $data       = rex_request('data', 'string',false);
    if($data!=false && $firephp=='jsbridge')
    {
      $data = get_object_vars(json_decode(stripslashes($data)));
      if(isset($data['variable']) && isset($data['label']) && isset($data['logtype']))
      {
        switch ($data['logtype'])
        {
          case 'log':
            FB::log($data['variable'],$data['label']);
            break;
          case 'info':
            FB::info($data['variable'],$data['label']);
            break;
          case 'warn':
            FB::warn($data['variable'],$data['label']);
            break;
          case 'error':
            FB::error($data['variable'],$data['label']);
            break;
        }
      }
    }
  }


} # /!class_exists('FirePHP')
?>