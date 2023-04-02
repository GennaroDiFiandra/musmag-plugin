<?php

namespace MusMagPlugin;

defined('WPINC') || die;

class DateField extends Field
{
  const TYPE = 'text_date';

  public function __construct($name, $unique_identifier)
  {
    $this->name = __($name, 'musmag-plugin');
    $this->unique_identifier = $unique_identifier;
    $this->args = [
      'name' => ucfirst($this->name),
      'id' => $this->unique_identifier,
      'type' => self::TYPE,
    ];
  }
}