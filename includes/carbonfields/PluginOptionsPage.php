<?php

namespace MusMagPlugin\CarbonFields;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

defined('WPINC') || die;

class PluginOptionsPage
{
  public function register()
  {
    Container::make('theme_options', 'musmag_plugin', __('MusMag Plugin', 'musmag-plugin'))
    ->add_tab(__('MusMag Theme Event Customizations'), [
      Field::make('image', 'after_title_banner', __('After title banner', 'musmag-plugin'))
        ->set_value_type('url')
        ->set_visible_in_rest_api($visible = true),
      Field::make('image', 'after_content_banner', __('After content banner', 'musmag-plugin'))
        ->set_value_type('url')
        ->set_visible_in_rest_api($visible = true),
      Field::make('textarea', 'author_bio', __('Author bio', 'musmag-plugin'))
        ->set_visible_in_rest_api($visible = true),
    ]);
  }

  public function setup_hooks()
  {
    return [
      ['carbon_fields_register_fields', 'register',10,0],
    ];
  }
}

?>