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
* @version 0.4.1
* $Id$: 
*/

// rex_request();
$func = rex_request('func', 'string');
$enabled = rex_request('enabled', 'int');
$uselib = rex_request('uselib', 'int');


if ($func == "update")
{

  $REX['ADDON']['firephp']['enabled'] = $enabled;
  $REX['ADDON']['firephp']['uselib'] = $uselib;

  $content = '$REX[\'ADDON\'][\'firephp\'][\'enabled\'] = '.$enabled.';
$REX[\'ADDON\'][\'firephp\'][\'uselib\'] = '.$uselib.';
';

  $file = $REX['INCLUDE_PATH']."/addons/firephp/config.inc.php";
  rex_replace_dynamic_contents($file, $content);

  echo rex_info('Konfiguration wurde aktualisiert');
}


if ($REX['ADDON']['firephp']['enabled'] == 1)
{
  $enabled_option = '
    <option value="1" selected="selected">aktiviert</option>
    <option value="0">inaktiv</option>';
  $enabled_msg = 'Daten werden an die FirePHP Console geschickt - <a href="index.php?page=firephp&subpage=help">Sicherheitshinweise</a> beachten!';
    echo rex_info($enabled_msg);
    fb('Daten werden an die FirePHP Console geschickt - Sicherheitshinweise  beachten!' ,FirePHP::INFO);
}
else
{
  $enabled_option = '
    <option value="1">aktiviert</option>
    <option value="0" selected="selected">inaktiv</option>';
  $enabled_msg = '';

}
if ($REX['ADDON']['firephp']['uselib'] == 0)
{
  $lib_option = '
    <option value="0" selected="selected">'.$REX['ADDON']['libs'][0].'</option>
    <option value="1">'.$REX['ADDON']['libs'][1].'</option>';
  $dummy_msg = '';
}
else
{
  $lib_option = '
    <option value="0">'.$REX['ADDON']['libs'][0].'</option>
    <option value="1" selected="selected">'.$REX['ADDON']['libs'][1].'</option>';
  $lib_msg =  '';
}

echo '

<div class="rex-addon-output">
  <div class="rex-form">

<!--<script type="text/javascript">
onload = function(e)
{
  document.getElementById(\'sendit\').style.display = "none";
  
  document.getElementById(\'enabled\').onchange = function (e)
  {
    document.getElementById(\'sendit\').style.display = "inline";
  };
  
  document.getElementById(\'uselib\').onchange = function (e)
  {
    document.getElementById(\'sendit\').style.display = "inline";
  };
}
</script>-->

  <form action="index.php" method="post">
    <input type="hidden" name="page" value="firephp" />
    <input type="hidden" name="subpage" value="settings" />
    <input type="hidden" name="func" value="update" />

        <fieldset class="rex-form-col-1">
        <legend>Settings</legend>
        <div class="rex-form-wrapper">
        
        <div class="rex-form-row">
          <p class="rex-form-col-a rex-form-select">
            <label for="enabled">FirePHP Output:</label>
            <select id="enabled" name="enabled">
            '.$enabled_option.'
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