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
* @version 1.1.3
*/


rex_register_extension('OUTPUT_FILTER_CACHE', 'firephp_ep_log');

/**
 * Pass EP log to Firephp
 *
 **/
function firephp_ep_log()
{
  global $REX, $firephp;

  ob_start();

  if(!$firephp) {
    $firephp = firephp_init();
  }

  // EP LOG
  ////////////////////////////////////////////////////////////////////////////
  if(is_object($firephp))
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
            $level = isset($v['level']) ? ' ['.$v['level'].']' : '' ;
            $table[] = array($i,$v['type'],$timing,$v['name'].$level,$v['$callable'],'–',$v['$params'],'–','–','–');
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
