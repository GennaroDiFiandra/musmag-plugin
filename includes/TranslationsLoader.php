<?php

namespace MusMagPlugin;

defined('WPINC') || die;

class TranslationsLoader
{
  public function load_translations()
  {
    load_plugin_textdomain('musmag-plugin', false, 'musmag-plugin/languages');
  }

  public function setup_hooks()
  {
    return [
      'after_setup_theme' => ['load_translations',10,0],
    ];
  }
}