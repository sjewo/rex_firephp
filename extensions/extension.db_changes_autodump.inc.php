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
* @version 1.1.1
*/

rex_register_extension('REX_SQL_DB_EDITED','firephp_auto_db_dump');

function firephp_auto_db_dump($params)
{
  global $REX;

  // SETTINGS -> TODO: VIA GUI..
  $mysqldump_path = '/Applications/MAMP/Library/bin/mysqldump';
  $u              = $REX['DB']['1']['LOGIN'];
  $p              = $REX['DB']['1']['PSW'];
  $tbl            = $REX['DB']['1']['NAME'];
  $dumpfile_path  = $REX['INCLUDE_PATH'].'/addons/import_export/backup/autodump.sql';

  $cmd            = $mysqldump_path.' -u '.$u.' -p'.$p.' --skip-extended-insert --ignore-table='.$tbl.'.rex_user '.$tbl.' > '.$dumpfile_path.';';
  system($cmd);
}
