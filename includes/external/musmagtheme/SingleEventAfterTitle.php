<?php

namespace MusMagPlugin\External\MusMagTheme;

defined('WPINC') || die;

class SingleEventAfterTitle
{
  private string $top_banner_container_id;
  private string $top_banner_field_id;
  private string $top_banner_url;

  public function __construct($top_banner_container_id, $top_banner_field_id)
  {
    $this->top_banner_container_id = $top_banner_container_id;
    $this->top_banner_field_id = $top_banner_field_id;
  }

  public function set_top_banner()
  {
    $this->top_banner_url = \carbon_get_theme_option($this->top_banner_field_id, $this->top_banner_container_id);
  }

  public function print_top_banner() {
    echo "<img src={$this->top_banner_url}>";
  }

  public function setup_hooks()
  {
    return [
      'carbon_fields_register_fields' => ['set_top_banner',11,0],
      'musmag_theme/single_event/after_title' => ['print_top_banner',10,0],
    ];
  }
}