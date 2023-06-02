<?php

namespace MusMagPlugin\External\MusMagTheme;

use MusMagPlugin\Metabox\OptionsPageMetabox;

defined('WPINC') || die;

final class SingleEventAuthor
{
  private string $author_bio_text;

  public function set_author_bio($author_box_metabox)
  {
    $this->author_bio_text = $author_box_metabox->get_field_value('author_box');
  }

  public function alter_author_bio($author, $id)
  {
    return '<p>'.$author.'</p>'.'<div>'.$this->author_bio_text.'</div>';
  }

  public function setup_filters()
  {
    return [
      'musmag_theme/single_event/author' => ['alter_author_bio',10,2],
    ];
  }
}