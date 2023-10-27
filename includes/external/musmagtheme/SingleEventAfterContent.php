<?php

namespace MusMagPlugin\External\MusMagTheme;

defined('WPINC') || die;

class SingleEventAfterContent
{
  private string $bottom_banner_container_id;
  private string $bottom_banner_field_id;
  private string $bottom_banner_url;

  public function __construct($bottom_banner_container_id, $bottom_banner_field_id)
  {
    $this->bottom_banner_container_id = $bottom_banner_container_id;
    $this->bottom_banner_field_id = $bottom_banner_field_id;
  }

  public function set_bottom_banner()
  {
    $this->bottom_banner_url = \carbon_get_theme_option($this->bottom_banner_field_id, $this->bottom_banner_container_id);
  }

  public function print_bottom_banner() {
    echo "<img src={$this->bottom_banner_url}>";
  }

  public function setup_hooks()
  {
    return [
      'carbon_fields_register_fields' => ['set_bottom_banner',11,0],
      'musmag_theme/single_event/after_content' => ['print_bottom_banner',10,0],
    ];
  }
}