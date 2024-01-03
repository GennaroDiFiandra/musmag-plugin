<?php

namespace MusMagPlugin;

defined('WPINC') || die;

class HooksActivator
{
  public function activate_hooks($object)
  {
    $hooks = $object->setup_hooks();

    foreach ($hooks as $hook_name => $hook_values)
    {
      $callback = $hook_values[0];
      $priority = $hook_values[1];
      $accepted_args = $hook_values[2];

      add_filter($hook_name, [$object,$callback], $priority, $accepted_args);
    }
  }
}