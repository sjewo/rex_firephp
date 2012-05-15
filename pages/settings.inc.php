<?php
/**
* FirePHP Addon
*
* FirePHP Lib Copyright (c) 2006-2010, Christoph Dorn, http://firephp.org
* FirePHP Lib v 0.3.1 & 0.3.2rc1
*
* @author <a href="http://rexdev.de">rexdev.de</a>
*
* @package redaxo 4.3.x
* @version 0.4.3
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
  FB::table('Table (click to expand)',$table);
}
elseif($func == 'sql-error')
{
  $err = new rex_sql;
  $err->setQuery('“Observation: Couldn’t see a thing. Conclusion: Dinosaurs.”');
}

// MODE SELECT
////////////////////////////////////////////////////////////////////////////////
FB::info('FirePHP ist installiert und aktiv für die Dauer der Admin Session.. diese Mittelung ist für sie kostenlos! ;)');

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

// maxDepth SELECT
////////////////////////////////////////////////////////////////////////////////
$id = 'maxDepth';
$tmp = new rex_select();
$tmp->setSize(1);
$tmp->setName($id);
for ($i=2; $i<15; $i++) // minimum level = 2, else logs won't show
{
  $tmp->addOption($i .' Level',$i);
}
$tmp->setSelected($myREX['settings'][$id]);
$maxDepth_select = $tmp->get();

// maxArrayDepth SELECT
////////////////////////////////////////////////////////////////////////////////
$id = 'maxArrayDepth';
$tmp = new rex_select();
$tmp->setSize(1);
$tmp->setName($id);
for ($i=2; $i<15; $i++) // minimum level = 2, else logs won't show
{
  $tmp->addOption($i .' Level',$i);
}
$tmp->setSelected($myREX['settings'][$id]);
$maxArrayDepth_select = $tmp->get();

// maxObjectDepth SELECT
////////////////////////////////////////////////////////////////////////////////
$id = 'maxObjectDepth';
$tmp = new rex_select();
$tmp->setSize(1);
$tmp->setName($id);
for ($i=2; $i<15; $i++) // minimum level = 2, else logs won't show
{
  $tmp->addOption($i .' Level',$i);
}
$tmp->setSelected($myREX['settings'][$id]);
$maxObjectDepth_select = $tmp->get();

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

// SQL_LOG SELECT
////////////////////////////////////////////////////////////////////////////////
$id = 'ep_log';
$tmp = new rex_select();
$tmp->setSize(1);
$tmp->setName($id);
foreach($REX['ADDON'][$mypage]['ep_log'] as $key => $string)
{
  $tmp->addOption($string,$key);
}
$tmp->setSelected($myREX['settings'][$id]);
$ep_log_select = $tmp->get();

// JS_BRIDGE SELECT
////////////////////////////////////////////////////////////////////////////////
$id = 'js_bridge';
$tmp = new rex_select();
$tmp->setSize(1);
$tmp->setName($id);
foreach($REX['ADDON'][$mypage]['js_bridge'] as $key => $string)
{
  $tmp->addOption($string,$key);
}
$tmp->setSelected($myREX['settings'][$id]);
$js_bridge = $tmp->get();

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
              <label for="maxDepth">maxDepth:</label>
              '.$maxDepth_select.'
            </p>
          </div><!-- .rex-form-row -->

          <div class="rex-form-row">
            <p class="rex-form-col-a rex-form-select">
              <label for="maxArrayDepth">maxArrayDepth:</label>
              '.$maxArrayDepth_select.'
            </p>
          </div><!-- .rex-form-row -->

          <div class="rex-form-row">
            <p class="rex-form-col-a rex-form-select">
              <label for="maxObjectDepth">maxObjectDepth:</label>
              '.$maxObjectDepth_select.'
            </p>
          </div><!-- .rex-form-row -->

        </div><!-- .rex-form-wrapper -->
      </fieldset>


      <fieldset class="rex-form-col-1">
        <legend>SQL Log</legend>
        <div class="rex-form-wrapper">

          <div class="rex-form-row">
            <p class="rex-form-col-a rex-form-select">
              <label for="status2console">Activate:</label>
              '.$sqllog_select.'
            </p>
          </div><!-- .rex-form-row -->

        </div><!-- .rex-form-wrapper -->
      </fieldset>


      <fieldset class="rex-form-col-1">
        <legend>EP Log</legend>

        <div class="rex-form-wrapper">
          <div class="rex-form-row">
            <p class="rex-form-col-a rex-form-select">
              <label for="status2console">Activate:</label>
              '.$ep_log_select.'
            </p>
          </div><!-- .rex-form-row -->

          <div class="rex-form-row">
            <p class="rex-form-col-a rex-form-text">
              <label for="ep_log_focus">Focus on EP:</label>
              <input id="ep_log_focus" class="rex-form-text" type="text" name="ep_log_focus" value="'.stripslashes($myREX['settings']['ep_log_focus']).'" />
            </p>
          </div><!-- .rex-form-row -->

        </div><!-- .rex-form-wrapper -->
      </fieldset>


      <fieldset class="rex-form-col-1">
        <legend>JS Bridge (experimental)</legend>
        <div class="rex-form-wrapper">

          <div class="rex-form-row">
            <p class="rex-form-col-a rex-form-select">
              <label for="js_bridge">Activate:</label>
              '.$js_bridge.'
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
        <legend>Test: FirePHP Konsole</legend>
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
        <legend>Test: rex_ql log</legend>
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
