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

use MusMagPlugin\Post\Post;

use MusMagPlugin\Field\Field;
use MusMagPlugin\Field\DateField;
use MusMagPlugin\Field\FileField;
use MusMagPlugin\Field\WysiwygField;
use MusMagPlugin\Field\MoneyField;

use MusMagPlugin\Metabox\PostMetabox;
use MusMagPlugin\Metabox\OptionsPageMetabox;

use MusMagPlugin\External\MusMagTheme\SingleEventAfterTitle;
use MusMagPlugin\External\MusMagTheme\SingleEventAfterContent;
use MusMagPlugin\External\MusMagTheme\SingleEventAuthor;

final class MusMagPlugin
{
  private static ?MusMagPlugin $instance = null;

  private HooksActivator $activator;
  private array $hooks_book = [];

  private Post $event;
  private array $event_details_fields;
  private PostMetabox $event_details_metabox;

  private array $banners_details_fields;
  private OptionsPageMetabox $banners_details_metabox;

  private array $author_box_fields;
  private OptionsPageMetabox $author_box_metabox;

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

  private function require_files()
  {
    // autoload all classes from includes directory
    require_once __DIR__.'/vendor/autoload.php';
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
    $this->require_files();

    // add Event post
    $this->event = new Post();
    $this->event->set('event', 'events', true, true, 5, 'dashicons-calendar-alt', ['title','editor','author','thumbnail']);
    $this->add_to_hooks_book($this->event);

    // // add Event fields
    $this->event_details_fields[] = new DateField('event date', 'event_date');
    $this->event_details_fields[] = new Field('event duration (giorni)', 'event_duration');
    $this->event_details_fields[] = new Field('event city', 'event_city');
    $this->event_details_fields[] = new MoneyField('event price', 'event_price');

    // add Event metabox
    $this->event_details_metabox = new PostMetabox('event details', 'event_details', [$this->event->get_name()], $this->event_details_fields);
    $this->add_to_hooks_book($this->event_details_metabox);

    // add Banners fields
    $this->banners_details_fields[] = new FileField('top banner', 'top_banner');
    $this->banners_details_fields[] = new FileField('bottom banner', 'bottom_banner');

    // add Banners options page metabox
    $this->banners_details_metabox = new OptionsPageMetabox('banners details', 'banners_details', $this->banners_details_fields, 'banners', 'options-general.php');
    $this->add_to_hooks_book($this->banners_details_metabox);

    // add AuthorBox fields
    $this->author_box_fields[] = new WysiwygField('author box', 'author_box');

    // add AuthorBox options page metabox
    $this->author_box_metabox = new OptionsPageMetabox('author box details', 'author_box_details', $this->author_box_fields, 'author box', 'options-general.php');
    $this->add_to_hooks_book($this->author_box_metabox);

    // run callbacks attached to musmag_theme/single_event/after_title action hook
    $this->single_event_after_title = new SingleEventAfterTitle();
    $this->single_event_after_title->set_top_banner($this->banners_details_metabox);
    $this->add_to_hooks_book($this->single_event_after_title);

    // run callbacks attached to musmag_theme/single_event/after_content action hook
    $this->single_event_after_content = new SingleEventAfterContent();
    $this->single_event_after_content->set_bottom_banner($this->banners_details_metabox);
    $this->add_to_hooks_book($this->single_event_after_content);

    // run callbacks attached to musmag_theme/single_event/author filter hook
    $this->single_event_author = new SingleEventAuthor();
    $this->single_event_author->set_author_bio($this->author_box_metabox);
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