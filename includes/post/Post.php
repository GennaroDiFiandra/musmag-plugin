<?php

namespace MusMagPlugin\Post;

defined('WPINC') || die;

class Post
{
  private string $name;
  private string $plural_name;
  private bool $is_public;
  private bool $in_rest_api;
  private int $menu_position;
  private string $menu_icon;
  private array $features;
  private array $labels;
  private array $args;

  public function get_name()
  {
    return $this->name;
  }

  public function set($name, $plural_name, $is_public, $in_rest_api, $menu_position, $menu_icon, $features=['title'])
  {
    $this->name = $name;
    $this->plural_name = $plural_name;
    $this->is_public = $is_public;
    $this->in_rest_api = $in_rest_api;
    $this->menu_position = $menu_position;
    $this->menu_icon = $menu_icon;
    $this->features = $features;
    $this->labels = [
      'name' => _x(ucwords($this->plural_name), 'Post type plural name', 'musmag-plugin'),
      'singular_name' => _x(ucwords($this->name), 'Post type singular name', 'musmag-plugin'),
    ];
    $this->args = [
      'labels' => $this->labels,
      'public' => $this->is_public,
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
      'init' => ['register',10,0],
    ];
  }
}