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
    <option value="2">SESSION Mode - während Admin Session aktiviert</option>
    <option value="1" selected="selected">PERMANENT Mode - grundsätzlich aktiviert</option>
    <option value="0">inaktiv</option>';
    echo rex_warning('Daten werden <b>permanent<b/> an die FirePHP Console geschickt!');
    echo rex_info('Generelle <a href="index.php?page=firephp&subpage=help">Sicherheitshinweise</a> beachten!');
    fb('Daten werden permanent an die FirePHP Console geschickt.' ,FirePHP::WARN);
    fb('Sicherheitshinweise beachten!' ,FirePHP::INFO);
}
elseif ($REX['ADDON']['firephp']['enabled'] == 2)
{
  $enabled_option = '
    <option value="2" selected="selected">SESSION Mode - während Admin Session aktiviert</option>
    <option value="1">PERMANENT Mode - grundsätzlich aktiviert</option>
    <option value="0">inaktiv</option>';
    echo rex_info('Daten werden w&auml;hrend Admin Session an die FirePHP Console geschickt.');
    echo rex_info('Generelle <a href="index.php?page=firephp&subpage=help">Sicherheitshinweise</a> beachten!');
    fb('Daten werden während Admin Session an die FirePHP Console geschickt.' ,FirePHP::INFO);
    fb('Sicherheitshinweise beachten!' ,FirePHP::INFO);
}
else
{
  $enabled_option = '
    <option value="2">SESSION Mode - während Admin Session aktiviert</option>
    <option value="1">PERMANENT Mode - grundsätzlich aktiviert</option>
    <option value="0" selected="selected">inaktiv</option>';
}

if ($REX['ADDON']['firephp']['uselib'] == 0)
{
  $lib_option = '
    <option value="0" selected="selected">'.$REX['ADDON']['firephp']['libs'][0].'</option>
    <option value="1">'.$REX['ADDON']['firephp']['libs'][1].'</option>';
}
else
{
  $lib_option = '
    <option value="0">'.$REX['ADDON']['firephp']['libs'][0].'</option>
    <option value="1" selected="selected">'.$REX['ADDON']['firephp']['libs'][1].'</option>';
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