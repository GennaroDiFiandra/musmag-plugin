<?php

namespace MusMagPlugin;

defined('WPINC') || die;

class OptionsPageMetabox extends MetaboxAbstract
{
  public function __construct($name, $unique_identifier, $fields, $page_unique_identifier, $page_parent_slug)
  {
    $this->name = __($name, 'musmag-plugin');
    $this->unique_identifier = $unique_identifier;
    $this->attach_to = ['options-page'];
    $this->fields = $this->get_fields_arr($fields);
    $this->page_unique_identifier = $page_unique_identifier;
    $this->page_parent_slug = $page_parent_slug;
    $this->args = [
      'title' => ucfirst($this->name),
      'id' => $this->unique_identifier,
      'object_types' => $this->attach_to,
      'option_key' => $this->page_unique_identifier,
      'parent_slug' => $this->page_parent_slug,
      'fields' => $this->fields,
    ];
  }

  public function get_field_value($field)
  {
    return get_option($this->page_unique_identifier)[$field];
  }
}