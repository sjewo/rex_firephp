<?php
/**
* FirePHP Addon
*
* FirePHP Lib Copyright (c) 2006-2010, Christoph Dorn, http://firephp.org
* FirePHP Lib v 0.3.1 & 0.3.2rc1
*
* @author <a href="http://rexdev.de">rexdev.de</a>
*
* @package redaxo 4.3.x/4.4.x
* @version 0.5.0
*/


function firephp_recursive_copy($source, $target, $rename_prepend = false, $makedir = true, $counter = 1, $folderPermission = '', $filePermission = '', $result = array())
{
  global $REX;
  $folderPermission = (empty($folderPermission)) ? $REX['DIRPERM']      : $folderPermission;
  $filePermission   = (empty($filePermission))   ? $REX['FILEPERM']     : $filePermission;
  $rename_prepend   = !$rename_prepend           ? date("d.m.y_H.i.s_") : $rename_prepend;

  // SCAN SOURCE DIR WHILE IGNORING  CERTAIN FILES
  $ignore  = array('.DS_Store','.svn','.','..');
  $dirscan = array_diff(scandir($source), $ignore);

  // WALK THROUGH RESULT RECURSIVELY
  foreach($dirscan as $item)
  {

    // DO DIR STUFF
    if (is_dir($source.$item)) /* ITEM IS A DIR */
    {
      if(!is_dir($target.$item) && $makedir=TRUE) /* DIR NONEXISTANT IN TARGET */
      {
        if(mkdir($target.$item)) /* CREATE DIR IN TARGET */
        {
          if(!chmod($source.$item,$folderPermission))
          {
            echo rex_warning('Rechte für "'.$target.$item.'" konnten nicht gesetzt werden!');
          }
        }
        else
        {
          echo rex_warning('Das Verzeichnis '.$source.$item.' konnte nicht angelegt werden!');
        }
      }

      // RECURSION
      firephp_recursive_copy($source.$item.'/', $target.$item.'/', $rename_prepend, $makedir, $counter, $folderPermission, $filePermission, $result);
    }

    // DO FILE STUFF
    elseif (is_file($source.$item)) /* ITEM IS A FILE */
    {
      if (rex_is_writable($target)) /* CHECK WRITE PERMISSION */
      {
        if(is_file($target.$item)) /* FILE EXISTS IN TARGET */
        {
          if(!rename($target.$item,$target.$rename_prepend.$item))
          {
            echo rex_warning('Datei "'.$target.$item.'" konnte nicht umbenannt werden!');
          }
          else
          {
            if(!copy($source.$item,$target.$item))
            {
              $result[$counter]['path'] = $target;
              $result[$counter]['item'] = $item;
              $result[$counter]['copystate'] = 0;
              echo rex_warning('Datei "'.$target.$item.'" konnte nicht geschrieben werden!');
            }
            else
            {
              $result[$counter]['path'] = $target;
              $result[$counter]['item'] = $item;
              if(chmod($target.$item,$filePermission))
              {
                $result[$counter]['copystate'] = 1;
                echo rex_info('Datei "'.$target.$item.'" wurde erfolgreich angelegt.');
              }
              else
              {
                $result[$counter]['copystate'] = 0;
                echo rex_warning('Rechte für "'.$target.$item.'" konnten nicht gesetzt werden!');
              }
            }
          }
        }
        else
        {
          if(!copy($source.$item,$target.$item))
          {
            $result[$counter]['path'] = $target;
            $result[$counter]['item'] = $item;
            $result[$counter]['copystate'] = 0;
            echo rex_warning('Datei "'.$target.$item.'" konnte nicht geschrieben werden!');
          }
          else
          {
            $result[$counter]['path'] = $target;
            $result[$counter]['item'] = $item;
            if(chmod($target.$item,$filePermission))
            {
              $result[$counter]['copystate'] = 1;
              echo rex_info('Datei "'.$target.$item.'" wurde erfolgreich angelegt.');
            }
            else
            {
              $result[$counter]['copystate'] = 0;
              echo rex_warning('Rechte für "'.$target.$item.'" konnten nicht gesetzt werden!');
            }
          }
        }
      }
      else
      {
        echo rex_warning('Keine Schreibrechte für das Verzeichnis "'.$target.'" !');
      }
    }
    $counter++;
  }
  return $result;
}



/**
 * CONTENT PARSER FUNKTIONEN
 * @author rexdev.de
 * @package redaxo 4.3.x
 * @version svn:$Id$
 */

// INCLUDE PARSER FUNCTION
////////////////////////////////////////////////////////////////////////////////
function firephp_incparse($root,$source,$parsemode,$return=false)
{

  switch ($parsemode)
  {
    case 'textile':
    $source = $root.$source;
    $new_redirects = file_get_contents($source);
    $html = firephp_textileparser($new_redirects,true);
    break;

    case 'txt':
    $source = $root.$source;
    $new_redirects = file_get_contents($source);
    $html =  '<pre class="plain">'.$new_redirects.'</pre>';
    break;

    case 'raw':
    $source = $root.$source;
    $new_redirects = file_get_contents($source);
    $html = $new_redirects;
    break;

    case 'php':
    $source = $root.$source;
    $html =  firephp_get_include_contents($source);
    break;



    case 'iframe':
    $html = '<iframe src="'.$source.'" width="99%" height="600px"></iframe>';
    break;

    case 'jsopenwin':
    $html = 'Externer link: <a href="'.$source.'">'.$source.'</a>
    <script language="JavaScript">
    <!--
    window.open(\''.$source.'\',\''.$source.'\');
    //-->
    </script>';
    break;

    case 'extlink':
    $html = 'Externer link: <a href="'.$source.'">'.$source.'</a>';
    break;
  }

  if($return)
  {
    return $html;
  }
  else
  {
    echo $html;
  }

}

// TEXTILE PARSER FUNCTION
////////////////////////////////////////////////////////////////////////////////
function firephp_textileparser($textile,$return=false)
{
  if(OOAddon::isAvailable("textile"))
  {
    global $REX;

    if($textile!='')
    {
      $textile = htmlspecialchars_decode($textile);
      $textile = str_replace("<br />","",$textile);
      $textile = str_replace("&#039;","'",$textile);
      if (rex_lang_is_utf8())
      {
        $html = rex_a79_textile($textile);
      }
      else
      {
        $html =  utf8_decode(rex_a79_textile($textile));
      }
      $html = preg_replace('|<span class="caps">([^<]+)</span>|','\1',$html);

      if($return)
      {
        return $html;
      }
      else
      {
        echo $html;
      }
    }

  }
  else
  {
    $html = rex_warning('WARNUNG: Das <a href="index.php?page=addon">Textile Addon</a> ist nicht aktiviert! Der Text wird ungeparst angezeigt..');
    $html .= '<pre>'.$textile.'</pre>';

    if($return)
    {
      return $html;
    }
    else
    {
      echo $html;
    }
  }
}

// ECHO TEXTILE FORMATED STRING
////////////////////////////////////////////////////////////////////////////////
if (!function_exists('echotextile'))
{
  function echotextile($msg) {
    global $REX;
    if(OOAddon::isAvailable("textile")) {
      if($msg!='') {
         $msg = str_replace("	","",$msg); // tabs entfernen
         if (rex_lang_is_utf8()) {
          echo rex_a79_textile($msg);
        } else {
          echo utf8_decode(rex_a79_textile($msg));
        }
      }
    } else {
      $fallback = rex_warning('WARNUNG: Das <a href="index.php?page=addon">Textile Addon</a> ist nicht aktiviert! Der Text wird ungeparst angezeigt..');
      $fallback .= '<pre>'.$msg.'</pre>';
      echo $fallback;
    }
  }
}


// http://php.net/manual/de/function.include.php
////////////////////////////////////////////////////////////////////////////////
function firephp_get_include_contents($filename) {
  if (is_file($filename)) {
    ob_start();
    include $filename;
    $new_redirectss = ob_get_contents();
    ob_end_clean();
    return $new_redirectss;
  }
  return false;
}


function firephp_header_add($params) {

  if (is_array($params) && count($params)>2) {
    foreach($params as $key => $val) {
      if($key !== 'subject' && $key !== 'extension_point') {
      $params['subject'] .= "\n".$val;
      }
    }
  }

  return $params['subject'];
}
