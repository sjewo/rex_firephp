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
* @version 1.1.4
*/


rex_register_extension('OUTPUT_FILTER_CACHE', 'firephp_sql_log');

/**
 * Pass SQL log to Firephp
 *
 **/
function firephp_sql_log()
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
  if(isset(rex_sql::$log) && is_object($firephp))
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

}
