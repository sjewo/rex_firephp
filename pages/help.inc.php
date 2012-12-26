<?php

/**
 * Debug Addon
 *
 * @author markus.staab[at]redaxo[dot]de Markus Staab
 *
 * @package redaxo5
 */

// GET CONTENT & TRANSLATE LANG STRINGS
$textile = preg_replace_callback('#\[(translate:\S+)\]#',
  function($matches)
  {
    return rex_i18n::translate($matches[1]);
  },
  rex_file::get($this->getBasePath('lang/de_de.help_settings.textile'))
);

// demo via extended i18n - rex_i18n::translateBlock()
#$textile = rex_i18n::translateBlock(
#    rex_file::get($this->getBasePath('lang/de_de.help_settings.textile')),
#    false
#  );

// PARSE
$content = rex_textile::parse($textile);

echo rex_view::contentBlock($content);
