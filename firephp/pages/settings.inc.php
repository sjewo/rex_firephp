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

// PARAMS
////////////////////////////////////////////////////////////////////////////////
$myself = rex_request('page', 'string');
$subpage = rex_request('subpage', 'string');
$chapter = rex_request('chapter', 'string');
$func = rex_request('func', 'string');
$mode = rex_request('mode', 'int');
$uselib = rex_request('uselib', 'int');
$versioncheck = rex_request('versioncheck', 'int');

// UPDATE/WRITE SETTINGS
////////////////////////////////////////////////////////////////////////////////
if ($func == "update")
{
  $REX['ADDON'][$myself]['mode'] = $mode;
  $REX['ADDON'][$myself]['uselib'] = $uselib;
  $REX['ADDON'][$myself]['versioncheck'] = $versioncheck;

  $content = '$REX[\'ADDON\'][\'firephp\'][\'mode\'] = '.$mode.'; 
$REX[\'ADDON\'][\'firephp\'][\'uselib\'] = '.$uselib.';
$REX[\'ADDON\'][\'firephp\'][\'versioncheck\'] = '.$versioncheck.';
';

  $file = $REX['INCLUDE_PATH'].'/addons/'.$myself.'/config.inc.php';
  rex_replace_dynamic_contents($file, $content);
  echo rex_info('Einstellungen wurden gespeichert.');
}

// MODE SELECT BOX OPTION
////////////////////////////////////////////////////////////////////////////////
$mode_option = '';
foreach($REX['ADDON'][$myself]['modestring'] as $key => $string)
{
  if($REX['ADDON'][$myself]['mode']!=$key)
  {
    $mode_option .= '<option value="'.$key.'">'.$string.'</option>';
  }
  else
  {
    $mode_option .= '<option value="'.$key.'" selected="selected">'.$string.'</option>';
  }
}

// LIB SELECT BOX OPTION
////////////////////////////////////////////////////////////////////////////////
$lib_option = '';
foreach($REX['ADDON'][$myself]['libs'] as $key => $string)
{
  if($REX['ADDON'][$myself]['uselib']!=$key)
  {
    $lib_option .= '<option value="'.$key.'">'.$string.'</option>';
  }
  else
  {
    $lib_option .= '<option value="'.$key.'" selected="selected">'.$string.'</option>';
  }
}

// VERSIONCHECK SELECT BOX OPTION
////////////////////////////////////////////////////////////////////////////////
$versioncheck_option = '';
foreach($REX['ADDON'][$myself]['versioncheckstring'] as $key => $string)
{
  if($REX['ADDON'][$myself]['versioncheck']!=$key)
  {
    $versioncheck_option .= '<option value="'.$key.'">'.$string.'</option>';
  }
  else
  {
    $versioncheck_option .= '<option value="'.$key.'" selected="selected">'.$string.'</option>';
  }
}

// VERSION CHECK
////////////////////////////////////////////////////////////////////////////////
if ($REX['ADDON'][$myself]['versioncheck']>1)
{
  /* -- http://de.php.net/manual/en/function.get-object-vars.php#62470 -- */
  function object_to_array($obj) {
    $_arr = is_object($obj) ? get_object_vars($obj) : $obj;
    foreach ($_arr as $key => $val) {
      $val = (is_array($val) || is_object($val)) ? object_to_array($val) : $val;
      $arr[$key] = $val;
    }
    return $arr;
  }/* -- http://de.php.net/manual/en/function.get-object-vars.php#62470 -- */
  
  $current = $REX['ADDON'][$myself];
  $latest = file_get_contents('http://versioncheck.rexdev.de');
  $latest = object_to_array(json_decode($latest));
  
  $compare = array('VERSION','MINORVERSION','SUBVERSION');
  if($REX['ADDON'][$myself]['versioncheck'] == 3)
  {
    array_push($compare,'REVISION');
  }

  $update = false;
  foreach($compare as $key)
    {
      if(intval($latest['VERSION'][$key])>intval($current['VERSION'][$key]))
      {
        $update=true;
      }
    }
  
  if ($update)
  {
    $current_str = implode('.', $current['VERSION']);
    $latest_str  = implode('.', $latest['VERSION']);
    
    echo rex_info('Neue Version des '.ucwords($latest['TYPE']).' verfügbar: <em>'.$latest_str.'</em> (installiert: <em>'.$current_str.'</em>)<br /><br />
    Changelog: <a target="_blank" href="'.$latest['CHANGELOG'].'">'.$latest['CHANGELOG'].'</a><br />
    Download: <a target="_blank" href="'.$latest['DOWNLOAD'].'">'.$latest['DOWNLOAD'].'</a>');
  }
}

echo '
<div class="rex-addon-output">
  <div class="rex-form">

  <form action="index.php" method="get">
    <input type="hidden" name="page" value="'.$myself.'" />
    <input type="hidden" name="subpage" value="settings" />
    <input type="hidden" name="func" value="update" />

        <fieldset class="rex-form-col-1">
          <legend>Settings</legend>
          <div class="rex-form-wrapper">
          
          <div class="rex-form-row">
            <p class="rex-form-col-a rex-form-select">
              <label for="mode">FirePHP Output:</label>
              <select id="mode" name="mode">
              '.$mode_option.'
              </select>
            </p>
          </div>
          
          <div class="rex-form-row">
            <p class="rex-form-col-a rex-form-select">
              <label for="uselib">Core Version:</label>
              <select id="uselib" name="uselib">
              '.$lib_option.'
              </select>
            </p>
          </div>
        </fieldset>

        <fieldset class="rex-form-col-1">
          <legend>Versioncheck</legend>
          <div class="rex-form-wrapper">
          
          <div class="rex-form-row">
            <p class="rex-form-col-a rex-form-select">
              <label for="versioncheck">Auf neue Version prüfen:</label>
              <select id="versioncheck" name="versioncheck">
              '.$versioncheck_option.'
              </select>
            </p>
          </div>
  
          <div class="rex-form-row rex-form-element-v2">
            <p class="rex-form-submit">
              <input class="rex-form-submit" type="submit" id="sendit" name="sendit" value="Einstellungen speichern" />
            </p>
          </div>
  
            
          </div>
        </fieldset>
  </form>
  </div>
</div>
';
?>