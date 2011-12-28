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

////////////////////////////////////////////////////////////////////////////////
$mypage    = rex_request('page'   , 'string');
$subpage   = rex_request('subpage', 'string');
$func      = rex_request('func'   , 'string');

// ADDON RELEVANTES AUS $REX HOLEN
////////////////////////////////////////////////////////////////////////////////
$myREX = $REX['ADDON'][$mypage];

// FORMULAR PARAMETER SPEICHERN
////////////////////////////////////////////////////////////////////////////////
if ($func == 'savesettings')
{
  $content = '';
  foreach($_GET as $key => $val)
  {
    if(!in_array($key,array('page','subpage','func','submit','PHPSESSID')))
    {
      $myREX['settings'][$key] = $val;
      if(is_array($val))
      {
        $content .= '$REX["ADDON"]["'.$mypage.'"]["settings"]["'.$key.'"] = '.var_export($val,true).';'."\n";
      }
      else
      {
        if(is_numeric($val))
        {
          $content .= '$REX["ADDON"]["'.$mypage.'"]["settings"]["'.$key.'"] = '.$val.';'."\n";
        }
        else
        {
          $content .= '$REX["ADDON"]["'.$mypage.'"]["settings"]["'.$key.'"] = \''.$val.'\';'."\n";
        }
      }
    }
  }

  $file = $REX['INCLUDE_PATH'].'/addons/'.$mypage.'/config.inc.php';
  rex_replace_dynamic_contents($file, $content);
  echo rex_info('Einstellungen wurden gespeichert.');
}
elseif($func == 'firephp-demo')
{
  FB::group('Test Group');
  FB::log('Log message');
  FB::info('Info message');
  FB::warn('Warn message');
  FB::error('Error message');
  FB::groupEnd();
  $table   = array();
  $table[] = array('#','Rows','Query');
  $table[] = array('Row 1 Col 1','Row 1 Col 2','Query');
  $table[] = array('Row 2 Col 1','Row 2 Col 2','Query');
  $table[] = array('Row 3 Col 1','Row 3 Col 2','Query');
  FB::table('SQL log',$table);
}
elseif($func == 'sql-error')
{
  $err = new rex_sql;
  $err->setQuery('“Observation: Couldn’t see a thing. Conclusion: Dinosaurs.”');
}

// MODE SELECT
////////////////////////////////////////////////////////////////////////////////
$id = 'mode';
$tmp = new rex_select();
$tmp->setSize(1);
$tmp->setName($id);
foreach($REX['ADDON'][$mypage]['modestring'] as $key => $string)
{
  $tmp->addOption($string,$key);
}
$tmp->setSelected($myREX['settings'][$id]);
$mode_select = $tmp->get();

// LIB SELECT
////////////////////////////////////////////////////////////////////////////////
$id = 'uselib';
$tmp = new rex_select();
$tmp->setSize(1);
$tmp->setName($id);
foreach($REX['ADDON'][$mypage]['libs'] as $key => $string)
{
  $tmp->addOption($string,$key);
}
$tmp->setSelected($myREX['settings'][$id]);
$lib_select = $tmp->get();

// STATUS MSG SELECT
////////////////////////////////////////////////////////////////////////////////
$id = 'status2console';
$tmp = new rex_select();
$tmp->setSize(1);
$tmp->setName($id);
foreach($REX['ADDON'][$mypage]['status2console'] as $key => $string)
{
  $tmp->addOption($string,$key);
}
$tmp->setSelected($myREX['settings'][$id]);
$status_select = $tmp->get();

// MAXDEPTH SELECT
////////////////////////////////////////////////////////////////////////////////
$id = 'maxdepth';
$tmp = new rex_select();
$tmp->setSize(1);
$tmp->setName($id);
foreach($REX['ADDON'][$mypage]['maxdepth'] as $key => $string)
{
  $tmp->addOption($string,$key);
}
$tmp->setSelected($myREX['settings'][$id]);
$maxdepth_select = $tmp->get();

// SQL_LOG SELECT
////////////////////////////////////////////////////////////////////////////////
$id = 'sqllog';
$tmp = new rex_select();
$tmp->setSize(1);
$tmp->setName($id);
foreach($REX['ADDON'][$mypage]['sqllog'] as $key => $string)
{
  $tmp->addOption($string,$key);
}
$tmp->setSelected($myREX['settings'][$id]);
$sqllog_select = $tmp->get();

// MAIN
////////////////////////////////////////////////////////////////////////////////
echo '
<div class="rex-addon-output">

  <div class="rex-form">
    <form action="index.php" method="get">
      <input type="hidden" name="page" value="'.$mypage.'" />
      <input type="hidden" name="subpage" value="'.$subpage.'" />
      <input type="hidden" name="func" value="savesettings" />

      <fieldset class="rex-form-col-1">
        <legend>FirePHP Settings</legend>
        <div class="rex-form-wrapper">

          <div class="rex-form-row">
            <p class="rex-form-col-a rex-form-select">
              <label for="mode">FirePHP Output:</label>
              '.$mode_select.'
            </p>
          </div><!-- .rex-form-row -->
  
          <div class="rex-form-row">
            <p class="rex-form-col-a rex-form-select">
              <label for="uselib">Core Version:</label>
              '.$lib_select.'
            </p>
          </div><!-- .rex-form-row -->
  
          <div class="rex-form-row">
            <p class="rex-form-col-a rex-form-select">
              <label for="status2console">Status-Meldung:</label>
              '.$status_select.'
            </p>
          </div><!-- .rex-form-row -->
  
          <div class="rex-form-row">
            <p class="rex-form-col-a rex-form-select">
              <label for="status2console">MaxDepth:</label>
              '.$maxdepth_select.'
            </p>
          </div><!-- .rex-form-row -->

        </div><!-- .rex-form-wrapper -->
      </fieldset>


        <legend>Switches</legend>
        <div class="rex-form-wrapper">

          <div class="rex-form-row">
            <p class="rex-form-col-a rex-form-select">
              <label for="status2console">rex_sql Log:</label>
              '.$sqllog_select.'
            </p>
          </div><!-- .rex-form-row -->
  
          <div class="rex-form-row rex-form-element-v2">
            <p class="rex-form-submit">
              <input class="rex-form-submit" type="submit" id="submit" name="submit" value="Einstellungen speichern" />
            </p>
          </div><!-- .rex-form-row -->

        </div><!-- .rex-form-wrapper -->
      </fieldset>


    </form>
  </div><!-- rex-form -->

  <div class="rex-form">
    <form action="index.php" method="get">
      <input type="hidden" name="page" value="'.$mypage.'" />
      <input type="hidden" name="subpage" value="'.$subpage.'" />
      <input type="hidden" name="func" value="firephp-demo" />

      <fieldset class="rex-form-col-1">
        <legend>FirePHP</legend>
        <div class="rex-form-wrapper">

        <div class="rex-form-row rex-form-element-v2">
          <p class="rex-form-submit">
            <input class="rex-form-submit" type="submit" id="firephp-demo" name="firephp-demo" value="Testausgabe in Konsole" />
          </p>
        </div><!-- .rex-form-row -->

        </div>
      </fieldset>
    </form>
  </div><!-- rex-form -->

  <div class="rex-form">
    <form action="index.php" method="get">
      <input type="hidden" name="page" value="'.$mypage.'" />
      <input type="hidden" name="subpage" value="'.$subpage.'" />
      <input type="hidden" name="func" value="sql-error" />

      <fieldset class="rex-form-col-1">
        <legend>REX_SQL LOG</legend>
        <div class="rex-form-wrapper">


        <div class="rex-form-row rex-form-element-v2">
          <p class="rex-form-submit">
            <input class="rex-form-submit" type="submit" id="sql-log-error" name="sql-log-error" value="Fehlerhafte Query aufrufen." />
          </p>
        </div><!-- .rex-form-row -->

        </div>
      </fieldset>
    </form>
  </div><!-- rex-form -->

  </div><!-- rex-addon-output -->
';
?>