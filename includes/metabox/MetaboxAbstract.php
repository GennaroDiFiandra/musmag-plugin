<?php

namespace MusMagPlugin\Metabox;

defined('WPINC') || die;

abstract class MetaboxAbstract
{
  protected string $name;
  protected string $unique_identifier;
  protected array $attach_to;
  protected bool $has_labels;
  protected bool $is_closed;
  protected string $position;
  protected string $importance;
  protected bool $load_default_styles;
  protected string $page_unique_identifier;
  protected string $page_parent_slug;
  protected array $fields;
  protected array $args;

  protected function get_fields_arr($fields)
  {
    foreach ($fields as $field)
    {
      $fields_arr[] = $field->get_field();
    }

    return $fields_arr;
  }

  public function register_metabox()
  {
    new_cmb2_box($this->args);
  }

  public function setup_hooks()
  {
    return [
      'cmb2_admin_init' => ['register_metabox',10,1],
    ];
  }
}