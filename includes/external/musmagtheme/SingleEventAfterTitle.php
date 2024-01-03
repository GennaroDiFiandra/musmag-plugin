<?php

namespace MusMagPlugin\External\MusMagTheme;

use MusMagPlugin\Image\Image;

defined('WPINC') || die;

class SingleEventAfterTitle
{
  private string $top_banner_container_id;
  private string $top_banner_field_id;
  private string $top_banner_url;
  private string $top_banner_id;
  private Image $image;

  public function __construct($top_banner_container_id, $top_banner_field_id)
  {
    $this->top_banner_container_id = $top_banner_container_id;
    $this->top_banner_field_id = $top_banner_field_id;
  }

  public function set_top_banner()
  {
    $this->top_banner_url = carbon_get_theme_option($this->top_banner_field_id, $this->top_banner_container_id);
    $this->image = new Image('url', $this->top_banner_url);
  }

  public function print_top_banner()
  {
    if ($this->top_banner_url === '' || $this->image->image_width() === false) return;

    echo '<img src='.esc_url($this->top_banner_url).' class="img-fluid d-block my-3" width="'.esc_attr($this->image->image_width()).'" height="'.esc_attr($this->image->image_height()).'" srcset="'.esc_attr($this->image->image_srcset()).'" sizes="'.esc_attr($this->image->image_sizes()).'">';
  }

  public function setup_hooks()
  {
    return [
      'carbon_fields_register_fields' => ['set_top_banner',11,0],
      'musmag_theme/single_event/after_title' => ['print_top_banner',10,0],
    ];
  }
}