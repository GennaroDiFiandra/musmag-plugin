<?php

namespace MusMagPlugin\External\MusMagTheme;

use MusMagPlugin\Metabox\OptionsPageMetabox;

defined('WPINC') || die;

class SingleEventAfterContent
{
  private string $bottom_banner_url;

  public function set_bottom_banner($banners_details_metabox)
  {
    $this->bottom_banner_url = $banners_details_metabox->get_field_value('bottom_banner');
  }

  public function print_bottom_banner() {
    echo '<img src="'.$this->bottom_banner_url.'">';
  }

  public function setup_hooks()
  {
    return [
      'musmag_theme/single_event/after_content' => ['print_bottom_banner',10,0],
    ];
  }
}