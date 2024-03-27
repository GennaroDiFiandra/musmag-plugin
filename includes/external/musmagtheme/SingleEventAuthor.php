<?php

namespace MusMagPlugin\External\MusMagTheme;

defined('WPINC') || die;

class SingleEventAuthor
{
  private string $author_bio_container_id;
  private string $author_bio_field_id;
  private string $author_bio_text;

  public function __construct($author_bio_container_id, $author_bio_field_id)
  {
    $this->author_bio_container_id = $author_bio_container_id;
    $this->author_bio_field_id = $author_bio_field_id;
  }

  public function set_author_bio()
  {
    $this->author_bio_text = carbon_get_theme_option($this->author_bio_field_id, $this->author_bio_container_id);
  }

  public function alter_author_bio($author, $id)
  {
    if ($this->author_bio_text === '') return;

    return '<p>'.esc_html($author).'('.\esc_html($id).')</p><div>'.\esc_html($this->author_bio_text).'</div>';
  }

  public function setup_hooks()
  {
    return [
      ['carbon_fields_register_fields', 'set_author_bio',11,0],
      ['musmag_theme/single_event/author', 'alter_author_bio',10,2],
    ];
  }
}