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
* @version 0.4.7
*/



/**
 * Include FirePHP, init instance, en/disable output
 *
 * @return object FirePHP instance
 **/
function firephp_init()
{
  global $REX;
  $active_lib = $REX['INCLUDE_PATH'].'/addons/__firephp/libs/'.$REX['ADDON']['__firephp']['libs'][$REX['ADDON']['__firephp']['settings']['uselib']];
  $mode       = $REX["ADDON"]["__firephp"]["settings"]["mode"];

  // INCLUDE FIREPHP CLASSES
  require_once($active_lib.'/lib/FirePHPCore/FirePHP.class.php');
  require_once($active_lib.'/lib/FirePHPCore/fb.php');

  // INVOKE FIREPHP INSTANCE BUT DON'T ENABLE OUTPUT YET
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

  // CHECK IF OUTPUT SHALL BE ENABLED
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


/**
 * Pass SQL & EP logs to Firephp
 *
 **/
function firephp_logs()
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

      $firephp->table('REX_SQL LOG ('.rex_sql::$count.' queries, '.rex_sql::$writes.' writes, '.rex_sql::$err_count.' errors)',$table,array('Expanded'=>true));

      if(rex_sql::$writes>0){
        rex_register_extension_point('REX_SQL_DB_EDITED',array());
      }
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




/**
 * JS header include for firephp_js_brifge
 *
 **/
function firephp_js_bridge_header($params)
{
  global $REX;

  $script = '
<!-- FIREPHP ADDON -->
  <script type="text/javascript">
    // jQuery(function($){
      // SEND VAR FORM JS CONTEXT TO FIREPHP VIA BACKEND CALLBACK
      function fb(variable,label,logtype){
          label         = label || "";
          logtype       = logtype || "log";
          var data      = {};
          data.label    = label;
          data.variable = variable;
          data.logtype  = logtype;
          data.action   = "jsbridge";
          var request   = jQuery.ajax({
            url: "index.php",
            type: "POST",
            data: {
              firephp_callback: JSON.stringify(data)
            },
            success: function(msg) {
               // console.log(msg);
            },
            error: function(e) {
               // console.log(e);
            }
          });
      };
    // });
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



function firephp_xform_classes($params)
{
  global $REX;
  if(OOAddon::isAvailable('xform'))
  {
    $REX['ADDON']['xform']['classpaths']['value'][]    = $REX['INCLUDE_PATH'].'/addons/__firephp/xform/classes/value/';
    $REX['ADDON']['xform']['classpaths']['validate'][] = $REX['INCLUDE_PATH'].'/addons/__firephp/xform/classes/validate/';
    $REX['ADDON']['xform']['classpaths']['action'][]   = $REX['INCLUDE_PATH'].'/addons/__firephp/xform/classes/action/';
  }
}
