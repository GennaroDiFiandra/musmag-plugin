<?php

namespace MusMagPlugin;

defined('WPINC') || die;

class HooksActivator
{
  public function activate_actions($object)
  {
    $actions = $object->setup_actions();

    foreach ($actions as $action_name => $action_values)
    {
      $callback = $action_values[0];
      $priority = $action_values[1];
      $accepted_args = $action_values[2];

      add_action($action_name, [$object,$callback], $priority, $accepted_args);
    }
  }
}