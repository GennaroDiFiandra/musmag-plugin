<?php

namespace MusMagPlugin\External\MusMagTheme;

use MusMagPlugin\Metabox\OptionsPageMetabox;

defined('WPINC') || die;

class SingleEventAfterTitle
{
  private string $top_banner_url;

  public function set_top_banner($banners_details_metabox)
  {
    $this->top_banner_url = $banners_details_metabox->get_field_value('top_banner');
  }

  public function print_top_banner() {
    echo '<img src="'.$this->top_banner_url.'">';
  }

  public function setup_hooks()
  {
    return [
      'musmag_theme/single_event/after_title' => ['print_top_banner',10,0],
    ];
  }
}