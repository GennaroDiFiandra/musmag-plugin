<?php

namespace MusMagPlugin;

defined('WPINC') || die;

class Field
{
  const TYPE = 'text';
  protected string $name;
  protected string $unique_identifier;
  protected array $args;

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