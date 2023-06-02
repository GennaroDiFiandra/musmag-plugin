<?php

namespace MusMagPlugin\Metabox;

defined('WPINC') || die;

class PostMetabox extends MetaboxAbstract
{
  public function __construct($name, $unique_identifier, $attach_to, $fields, $has_labels=true, $is_closed=false, $position='advanced', $importance='high', $load_default_styles=true)
  {
    $this->name = __($name, 'musmag-plugin');
    $this->unique_identifier = $unique_identifier;
    $this->attach_to = $attach_to;
    $this->fields = $this->get_fields_arr($fields);
    $this->has_labels = $has_labels;
    $this->is_closed = $is_closed;
    $this->position = $position;
    $this->importance = $importance;
    $this->load_default_styles = $load_default_styles;
    $this->args = [
      'title' => ucfirst($this->name),
      'id' => $this->unique_identifier,
      'object_types' => $this->attach_to,
      'show_names' => $this->has_labels,
      'context' => $this->position,
      'priority' => $this->importance,
      'closed' => $this->is_closed,
      'cmb_styles' => $this->load_default_styles,
      'fields' => $this->fields,
    ];
  }
}