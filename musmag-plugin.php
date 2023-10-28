<?php declare(strict_types=1); defined('WPINC') || die;

/*
  Plugin Name: MusMag Plugin
  Plugin URI: #
  Author: Gennaro Di Fiandra
  Author URI: #
  Description: Add the Event post type and related fields. Plus, manipulate others modules by hooks that they expose.
  Version: 1.0.0
  Text Domain: musmag-plugin
  Domain Path: /languages
  Requires at least: 6.2
  Requires PHP: 7.4
  License: GPLv2 or later
  License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

use MusMagPlugin\HooksActivator;

use MusMagPlugin\CarbonFields\CarbonFieldsLoader;
use MusMagPlugin\CarbonFields\PluginOptionsPage;

use MusMagPlugin\Post\Post;
use MusMagPlugin\CarbonFields\EventPostDetailsMetabox;

use MusMagPlugin\External\MusMagTheme\SingleEventAfterTitle;
use MusMagPlugin\External\MusMagTheme\SingleEventAfterContent;
use MusMagPlugin\External\MusMagTheme\SingleEventAuthor;

final class MusMagPlugin
{
  private static ?MusMagPlugin $instance = null;

  private HooksActivator $activator;
  private array $hooks_book = [];

  private CarbonFieldsLoader $carbon_fields_loader;

  private PluginOptionsPage $plugin_options_page;

  private const PLUGINOPTIONSPAGEID = 'carbon_fields_container_musmag_plugin';

  private Post $event;
  private EventPostDetailsMetabox $event_post_details_metabox;

  private SingleEventAfterTitle $single_event_after_title;

  private SingleEventAfterContent $single_event_after_content;

  private SingleEventAuthor $single_event_author;

  public static function instance():MusMagPlugin
  {
    if (self::$instance === null)
    {
      self::$instance = new self();
      return self::$instance;
    }
  }

  public static function get_instance()
  {
    return self::$instance;
  }

  private function __construct()
  {}

  private function __clone()
  {}

  private function __wakeup()
  {
    throw new Exception('Cannot unserialize singleton');
  }

  private function require_resources()
  {
    // autoload all classes from includes directory
    require_once __DIR__.'/vendor/autoload.php';

    // load carbon fields manager
    $this->carbon_fields_loader = new CarbonFieldsLoader();
    $this->add_to_hooks_book($this->carbon_fields_loader);
  }

  public function hooks_book()
  {
    return $this->hooks_book;
  }

  private function add_to_hooks_book($object)
  {
    $this->hooks_book[] = $object;
  }

  public function init()
  {
    $this->require_resources();

    // add plugin options page
    $this->plugin_options_page = new PluginOptionsPage();
    $this->add_to_hooks_book($this->plugin_options_page);

    // add Event post
    $this->event = new Post();
    $this->event->set('event', 'events', true, true, 5, 'dashicons-calendar-alt', ['title','editor','author','thumbnail']);
    $this->add_to_hooks_book($this->event);
    // add Event metabox and fields
    $this->event_post_details_metabox = new EventPostDetailsMetabox();
    $this->add_to_hooks_book($this->event_post_details_metabox);

    // run callbacks attached to musmag_theme/single_event/after_title action hook
    $this->single_event_after_title = new SingleEventAfterTitle(self::PLUGINOPTIONSPAGEID, 'after_title_banner');
    $this->add_to_hooks_book($this->single_event_after_title);

    // run callbacks attached to musmag_theme/single_event/after_content action hook
    $this->single_event_after_content = new SingleEventAfterContent(self::PLUGINOPTIONSPAGEID, 'after_content_banner');
    $this->add_to_hooks_book($this->single_event_after_content);

    // run callbacks attached to musmag_theme/single_event/author filter hook
    $this->single_event_author = new SingleEventAuthor(self::PLUGINOPTIONSPAGEID, 'author_bio');
    $this->add_to_hooks_book($this->single_event_author);

    // activate hooks
    $this->activator = new HooksActivator();
    foreach ($this->hooks_book as $object)
    {
      $this->activator->activate_hooks($object);
    }
  }
}
MusMagPlugin::instance()->init();