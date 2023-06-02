<?php

namespace MusMagPlugin\Field;

defined('WPINC') || die;

class MoneyField extends Field
{
  const TYPE = 'text_money';
  private string $money_sign;

  public function __construct($name, $unique_identifier, $money_sign='€')
  {
    $this->name = __($name, 'musmag-plugin');
    $this->unique_identifier = $unique_identifier;
    $this->money_sign = $money_sign;
    $this->args = [
      'name' => ucfirst($this->name),
      'id' => $this->unique_identifier,
      'type' => self::TYPE,
      'before_field' => $this->money_sign,
    ];
  }
}