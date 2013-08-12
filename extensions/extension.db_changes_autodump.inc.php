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

rex_register_extension('REX_SQL_DB_EDITED','firephp_auto_db_dump');

function firephp_auto_db_dump($params)
{
  global $REX;

  // SETTINGS -> TODO: VIA GUI..
  $mysqldump_path = $REX["ADDON"]["__firephp"]["settings"]["mysqldmp_path"];
  $dumpfile_path  = $REX["ADDON"]["__firephp"]["settings"]["db_changes_autodump_path"];

  $u              = $REX['DB']['1']['LOGIN'];
  $p              = $REX['DB']['1']['PSW'];
  $h              = $REX['DB']['1']['HOST'];
  $t              = $REX['DB']['1']['NAME'];

  $cmd            = $mysqldump_path.' --user='.$u.' --password='.$p.' --host='.$h.' --skip-extended-insert --ignore-table='.$t.'.rex_user '.$t.' > '.$dumpfile_path.';';

  exec($cmd, $out, $ret);
  if($ret>0) {
    FB::warning('__firephp: autodump creation failed!');
  }
}
