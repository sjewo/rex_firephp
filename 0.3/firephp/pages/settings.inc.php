<?php
/**
* FirePHP Addon
*
* FirePHP Lib Copyright (c) 2006-2008, Christoph Dorn, http://firephp.org
* FirePHP Lib v 0.2.1
*
* @author rexdev[at]f-stop[dot]de Jan Camrda
* @author <a href="http://rexdev.f-stop.de">rexdev.f-stop.de</a>
*
* @package redaxo4
* @version 0.3 
* $Id$: 
*/

// rex_request();

$func = rex_request('func', 'string');
$enabled = rex_request('enabled', 'int');
$dummymode = rex_request('dummymode', 'int');


if ($func == "update")
{

	$REX['ADDON']['firephp']['enabled'] = $enabled;
	$REX['ADDON']['firephp']['dummymode'] = $dummymode;

	$content = '$REX[\'ADDON\'][\'firephp\'][\'enabled\'] = '.$enabled.';
$REX[\'ADDON\'][\'firephp\'][\'dummymode\'] = '.$dummymode.';
';

	$file = $REX['INCLUDE_PATH']."/addons/firephp/config.inc.php";
  rex_replace_dynamic_contents($file, $content);

  echo rex_warning('Konfiguration wurde aktualisiert');
}

echo '

<div class="rex-addon-output">
  <h2>Konfiguration</h2>
  <div class="rex-addon-content">

  <form action="index.php" method="post">
    <input type="hidden" name="page" value="firephp" />
    <input type="hidden" name="subpage" value="settings" />
    <input type="hidden" name="func" value="update" />

        <fieldset>
          <p>
            <label for="max_cachefiles">Aktiviert</label>
            <input type="text" id="enabled" name="enabled" value="'. htmlspecialchars($REX['ADDON']['firephp']['enabled']).'" />
          </p>
          <p>
            <label for="max_filters">Dummymode</label>
            <input type="text" id="dummymode" name="dummymode" value="'. htmlspecialchars($REX['ADDON']['firephp']['dummymode']).'" />
          </p>
          <p>
            <input type="submit" class="rex-sbmt" name="sendit" value="'.$I18N->msg("update").'" />
          </p>
        </fieldset>
  </form>
  </div>
</div>
  ';

?>