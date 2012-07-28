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
* @version 0.4.5
*/

// SESSION
////////////////////////////////////////////////////////////////////////////////
if (session_id() == '')
{
  session_start();
}

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
  'SUBVERSION'   => 5,
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
//  '0.0.0master1106021548-firephp'=>'0.0.0master1106021548-firephp',
  'firephp-1.0b1rc1'=>'firephp-1.0b1rc1'
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
$REX["ADDON"]["__firephp"]["settings"]["mode"] = 2;
$REX["ADDON"]["__firephp"]["settings"]["uselib"] = 'FirePHPCore-0.4.0rc3';
$REX["ADDON"]["__firephp"]["settings"]["maxDepth"] = 10;
$REX["ADDON"]["__firephp"]["settings"]["maxArrayDepth"] = 5;
$REX["ADDON"]["__firephp"]["settings"]["maxObjectDepth"] = 5;
$REX["ADDON"]["__firephp"]["settings"]["sqllog"] = 0;
$REX["ADDON"]["__firephp"]["settings"]["ep_log"] = 0;
$REX["ADDON"]["__firephp"]["settings"]["ep_log_focus"] = '';
$REX["ADDON"]["__firephp"]["settings"]["js_bridge"] = 0;
// --- /DYN


/**
 * Include FirePHP and init
 *
 * @return onject FirePHP instance
 **/
function firephp_init()
{
  global $REX;
  $active_lib = $REX['INCLUDE_PATH'].'/addons/__firephp/libs/'.$REX['ADDON']['__firephp']['libs'][$REX['ADDON']['__firephp']['settings']['uselib']];
  $mode       = $REX["ADDON"]["__firephp"]["settings"]["mode"];

  require_once($active_lib.'/lib/FirePHPCore/FirePHP.class.php');
  require_once($active_lib.'/lib/FirePHPCore/fb.php');
  $firephp = FirePHP::getInstance(true);

  // FIREPHP SETTINGS
  $options = array(
    'maxObjectDepth'      => $REX['ADDON']['__firephp']['settings']['maxObjectDepth'],// default: 5
    'maxArrayDepth'       => $REX['ADDON']['__firephp']['settings']['maxArrayDepth'], // default: 5
    'maxDepth'            => $REX['ADDON']['__firephp']['settings']['maxDepth'],      // default: 10
    'useNativeJsonEncode' => true,                                                    // default: true
    'includeLineNumbers'  => true,                                                    // default: true
    );
  $firephp->setOptions($options);
  $firephp->setEnabled(false);

  switch ($REX['ADDON']['__firephp']['settings']['mode'])
  {
    case 1:
      if (isset($_SESSION[$REX['INSTNAME']]['UID']) && $_SESSION[$REX['INSTNAME']]['UID']>0)
      {
        $REX['ADDON']['name']['__firephp'] = $REX['ADDON']['__firephp']['menustring'][$mode];
        $firephp->setEnabled(true);
      }
      else
      {
        $REX['ADDON']['name']['__firephp'] = $REX['ADDON']['__firephp']['menustring'][$mode];
        $firephp->setEnabled(false);
      }
      break;

    case 2:
      $REX['ADDON']['name']['__firephp'] = $REX['ADDON']['__firephp']['menustring'][$mode];
      $firephp->setEnabled(true);
      break;

    default:
      $REX['ADDON']['name']['__firephp'] = $REX['ADDON']['__firephp']['menustring'][0];
      $firephp->setEnabled(false);
  }

  return $firephp;
}


// MAIN
////////////////////////////////////////////////////////////////////////////////
if(!class_exists('FirePHP'))
{
  $firephp = firephp_init();

// FIREPHP OUTPUT OF LOGS
////////////////////////////////////////////////////////////////////////////////
rex_register_extension('OUTPUT_FILTER_CACHE', 'send_to_firephp');

function send_to_firephp()
{
  global $REX, $firephp;

  if($REX['ADDON']['__firephp']['settings']['mode']==0)
  {
    return false;
  }

  ob_start();

  if(!$firephp)
  {
    $firephp = firephp_init();
  }


  // SQL LOG
  ////////////////////////////////////////////////////////////////////////////
  if($REX['ADDON']['__firephp']['settings']['sqllog']==1 && isset(rex_sql::$log) && is_object($firephp))
  {
    $sql_log = rex_sql::$log;
    if(count($sql_log)>0)
    {
      $table = array();
      $table[] = array('#','Rows','Query','Errno','Error','File','Line');
      $group_opts = rex_sql::$err_count>0
        ? array('Expanded' => true,'Color' => 'red')
        : array('Collapsed' => true,'Color' => 'green');
      foreach($sql_log as $k => $v)
      {
        $n    = str_pad('#'.$k,         4, ' ', STR_PAD_LEFT);
        $rows = isset($v['rows']) ? str_pad('('.$v['rows'].' rows) ', 11, ' ', STR_PAD_LEFT) : '';
        $backtrace = '';
        $file = '';
        $line = '';
        $errno = '';
        $error = '';
        $query = preg_replace('#[\n|\r]#','',$v['query']);
        $query = preg_replace('#\s+#',' ',$v['query']);

        if(isset($v['error']) && $v['error']!=null)
        {
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
          $table[] = array($k,'ERROR',$v['query'],$v['errno'],$v['error'],$file,$line,);
        }
        else
        {
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

          $table[] = array($k,$v['rows'],$v['query'],$errno,$error,$file,$line,);
        }
      }

      $firephp->table('REX_SQL LOG ('.rex_sql::$count.' queries, '.rex_sql::$err_count.' errors)',$table,array('Expanded'=>true));
    }
  }


  // EP LOG
  ////////////////////////////////////////////////////////////////////////////
  if($REX['ADDON']['__firephp']['settings']['ep_log']==1 && is_object($firephp))
  {
    if(isset($REX['EXTENSION_POINT_LOG']))
    {
      $focus = explode(',',$REX["ADDON"]["__firephp"]["settings"]["ep_log_focus"]);
      if(count($focus)===1 && $focus[0]==''){
        $focus = null;
      }

      function focus_match($name,$focus){
        foreach($focus as $pattern){
          $pattern = str_replace('*','(.)*',$pattern);
          if(preg_match('/'.$pattern.'/',$name)){
            return true;
          }
        }
        return false;
      }

      $registered_eps = array();
      $table = array();
      $table[] = array('#','Type','Timing','ExtensionPoint','Callable','$subject','$params','$read_only','$REX[EXTENSIONS]','$result');

      foreach($REX['EXTENSION_POINT_LOG'] as $k=>$v)
      {
        $i = $k+1;
        switch($v['type'])
        {
          case'EP':
            if($focus!==null && (!in_array($v['name'],$focus) && focus_match($v['name'],$focus)===false) ) {
              break;
            }
            $registered_eps[] = $v['name'];
            $table[] = array($i,$v['type'],'–',$v['name'],'–',$v['$subject'],$v['$params'],$v['$read_only'],$v['$REX[EXTENSIONS]'],$v['$result']);
            break;

          case'EXT':
            if($focus!==null && (!in_array($v['name'],$focus) && focus_match($v['name'],$focus)===false) ) {
              break;
            }
            $timing = in_array($v['name'],$registered_eps) ? 'late' : 'ok';
            if(is_array($v['$callable']))
            {
              if(is_object($v['$callable'][0])){
                $v['$callable'][0] = get_class($v['$callable'][0]);
              }
              $v['$callable'] = implode('::',$v['$callable']);
            }
            $table[] = array($i,$v['type'],$timing,$v['name'],$v['$callable'],'–',$v['$params'],'–','–','–');
            break;
        }
      }

      $firephp->table('EP LOG ('.$i.' calls)',$table);
    }
    else
    {
      $firephp->warn('EP Log nicht verfügbar.. vermutl. ist die gepatchte Datei "function_rex_extension.inc.php" nicht installiert worden.');
    }
  }

}

  // JS LOG TO FIREPHP BRIDGE
  ////////////////////////////////////////////////////////////////////////////////
  if($REX['ADDON']['__firephp']['settings']['js_bridge']==1 && is_object($firephp))
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
