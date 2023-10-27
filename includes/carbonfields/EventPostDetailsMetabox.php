<?php

namespace MusMagPlugin\CarbonFields;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

defined('WPINC') || die;

class EventPostDetailsMetabox
{
  public function register()
  {
    Container::make('post_meta', 'event_details',  __('Event Details', 'musmag-plugin'))
    ->set_context('side')
    ->set_priority('low')
    ->where('post_type', '=', 'event')
    ->add_fields([
      Field::make('date', 'event_date', __('When start', 'musmag-plugin'))
        ->set_visible_in_rest_api($visible = true),
      Field::make('text', 'event_duration', __('Duration (in days)', 'musmag-plugin'))
        ->set_attribute('type', 'number')
        ->set_help_text(__('Not use a separator for thousands.', 'musmag-plugin'))
        ->set_visible_in_rest_api($visible = true),
      Field::make('text', 'event_city', __('City', 'musmag-plugin'))
        ->set_visible_in_rest_api($visible = true),
      Field::make('text', 'event_price', __('Price', 'musmag-plugin'))
        ->set_attribute('type', 'number')
        ->set_help_text(__('Use comma as decimals separator. Not use a separator for thousands.', 'musmag-plugin'))
        ->set_visible_in_rest_api($visible = true),
    ]);
  }

  public function setup_hooks()
  {
    return [
      'carbon_fields_register_fields' => ['register',10,0],
    ];
  }
}

?>