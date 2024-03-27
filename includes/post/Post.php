<?php

namespace MusMagPlugin\Post;

defined('WPINC') || die;

class Post
{
  private string $name;
  private bool $is_public;
  private bool $has_archive;
  private bool $in_rest_api;
  private int $menu_position;
  private string $menu_icon;
  private array $features;
  private array $args;

  public function get_name()
  {
    return $this->name;
  }

  public function set($name, $is_public, $has_archive, $in_rest_api, $menu_position, $menu_icon, $features=['title'])
  {
    $this->name = $name;
    $this->is_public = $is_public;
    $this->has_archive = $has_archive;
    $this->in_rest_api = $in_rest_api;
    $this->menu_position = $menu_position;
    $this->menu_icon = $menu_icon;
    $this->features = $features;
    $this->args = [
      'public' => $this->is_public,
      'has_archive' => $this->has_archive,
      'show_in_rest' => $this->in_rest_api,
      'menu_position' => $this->menu_position,
      'menu_icon' => $this->menu_icon,
      'supports' => $this->features,
    ];
  }

  public function register()
  {
    register_post_type($this->name, $this->args);
  }

  public function setup_hooks()
  {
    return [
       ['init', 'register',10,0],
    ];
  }
}