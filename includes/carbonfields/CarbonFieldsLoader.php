<?php

namespace MusMagPlugin\CarbonFields;

defined('WPINC') || die;

class CarbonFieldsLoader
{
  public function register()
  {
    \Carbon_Fields\Carbon_Fields::boot();
  }

  public function setup_hooks()
  {
    return [
      'after_setup_theme' => ['register',10,0],
    ];
  }
}

?>