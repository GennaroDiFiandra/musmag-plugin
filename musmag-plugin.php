<?php defined('WPINC') || die;

/*
  Plugin Name: MusMag Plugin
  Plugin URI: #
  Author: Gennaro Di Fiandra
  Author URI: #
  Description: Add the Event post type and related fields
  Version: 1.0.0
  Text Domain: musmag-plugin
  Domain Path: /languages
  Requires at least: 6.2
  Requires PHP: 7.4
  License: GPLv2 or later
  License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

use MusMagPlugin\Post;
use MusMagPlugin\Field;
use MusMagPlugin\DateField;
use MusMagPlugin\FileField;
use MusMagPlugin\WysiwygField;
use MusMagPlugin\MoneyField;
use MusMagPlugin\FieldsGenerator;
use MusMagPlugin\PostMetabox;
use MusMagPlugin\OptionsPageMetabox;
use MusMagPlugin\HooksActivator;

final class MusMagPlugin
{
  private HooksActivator $activator;
  private Post $event;
  private array $event_details_fields;
  private PostMetabox $event_details_metabox;
  private array $banners_details_fields;
  private OptionsPageMetabox $banners_details_metabox;
  private array $author_box_fields;
  private OptionsPageMetabox $author_box_metabox;

  public function __construct()
  {
    $this->require_files();
    $this->init();
  }

  private function require_files()
  {
    // autoload all classes from includes directory
    require_once __DIR__.'/vendor/autoload.php';
  }

  public function init()
  {
    // add Event post
    $this->event = new Post('event', 'events', true, true, 5, 'dashicons-calendar-alt', ['title','editor','author','thumbnail']);

    // // add Event fields
    $this->event_details_fields[] = new DateField('event date', 'event_date');
    $this->event_details_fields[] = new Field('event duration (giorni)', 'event_duration');
    $this->event_details_fields[] = new Field('event city', 'event_city');
    $this->event_details_fields[] = new MoneyField('event price', 'event_price');

    // add Event metabox
    $this->event_details_metabox = new PostMetabox('event details', 'event_details', [$this->event->get_name()], $this->event_details_fields);

    // add Banners fields
    $this->banners_details_fields[] = new FileField('top banner', 'top_banner');
    $this->banners_details_fields[] = new FileField('bottom banner', 'bottom_banner');

    // add Banners options page metabox
    $this->banners_details_metabox = new OptionsPageMetabox('banners details', 'banners_details', $this->banners_details_fields, 'banners', 'options-general.php');

    // add AuthorBox fields
    $this->author_box_fields[] = new WysiwygField('author box', 'author_box');

    // add AuthorBox options page metabox
    $this->author_box_metabox = new OptionsPageMetabox('author box details', 'author_box_details', $this->author_box_fields, 'author box', 'options-general.php');

    // activate hooks
    $this->activator = new HooksActivator();
    $this->activator->activate_actions($this->event);
    $this->activator->activate_actions($this->event_details_metabox);
    $this->activator->activate_actions($this->banners_details_metabox);
    $this->activator->activate_actions($this->author_box_metabox);


    // todo: create a php class for the follow code
    // hook into theme action musmag_theme/single_event/after_title and print a banner
    add_action('musmag_theme/single_event/after_title', function() {
      $banner_url = $this->banners_details_metabox->get_field_value('top_banner');
      echo '<img src="'.$banner_url.'">';
    });
    // hook into theme action musmag_theme/single_event/after_title and print a banner
    add_action('musmag_theme/single_event/after_content', function() {
      $banner_url = $this->banners_details_metabox->get_field_value('bottom_banner');
      echo '<img src="'.$banner_url.'">';
    });
    // hook into theme filter musmag_theme/single_event/author and alter the author signature
    add_filter('musmag_theme/single_event/author', function($author, $id) {
      $author_bio = $this->author_box_metabox->get_field_value('author_box');
      return '<p>'.$author.'</p>'.'<div>'.$author_bio.'</div>';
    }, 10, 3);
  }
}
new MusMagPlugin();