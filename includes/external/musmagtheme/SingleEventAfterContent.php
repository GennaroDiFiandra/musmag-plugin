<?php

namespace MusMagPlugin\External\MusMagTheme;

use MusMagPlugin\Image\Image;

defined('WPINC') || die;

class SingleEventAfterContent
{
  private string $bottom_banner_container_id;
  private string $bottom_banner_field_id;
  private string $bottom_banner_url;
  private string $bottom_banner_id;
  private Image $image;

  public function __construct($bottom_banner_container_id, $bottom_banner_field_id)
  {
    $this->bottom_banner_container_id = $bottom_banner_container_id;
    $this->bottom_banner_field_id = $bottom_banner_field_id;
  }

  public function set_bottom_banner()
  {
    $this->bottom_banner_url = carbon_get_theme_option($this->bottom_banner_field_id, $this->bottom_banner_container_id);
    $this->image = new Image('url', $this->bottom_banner_url);
  }

  public function print_bottom_banner()
  {
    if ($this->bottom_banner_url === '' || $this->image->image_width() === false) return;

    echo '<img src='.esc_url($this->bottom_banner_url).' class="img-fluid d-block my-3" width="'.esc_attr($this->image->image_width()).'" height="'.esc_attr($this->image->image_height()).'" srcset="'.esc_attr($this->image->image_srcset()).'" sizes="'.esc_attr($this->image->image_sizes()).'">';
  }

  public function setup_hooks()
  {
    return [
      ['carbon_fields_register_fields', 'set_bottom_banner',11,0],
      ['musmag_theme/single_event/after_content', 'print_bottom_banner',10,0],
    ];
  }
}