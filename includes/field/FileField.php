<?php

namespace MusMagPlugin\Field;

defined('WPINC') || die;

class FileField extends Field
{
  const TYPE = 'file';

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

  public function get_field()
  {
    return $this->args;
  }
}