<?php

namespace MusMagPlugin\Post;

defined('WPINC') || die;

class LabelsTranslator
{
  function translate_event_labels($labels)
  {
    $labels->name = __('Events', 'musmag-plugin');
    $labels->singular_name = __('Event', 'musmag-plugin');
    $labels->menu_name = __('Events', 'musmag-plugin');
    $labels->name_admin_bar = __('Event', 'musmag-plugin');

    return $labels;
  }

  public function setup_hooks()
  {
    return [
      'post_type_labels_event' => ['translate_event_labels',10,1],
    ];
  }
}