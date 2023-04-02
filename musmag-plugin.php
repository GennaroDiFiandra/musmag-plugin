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
use MusMagPlugin\MoneyField;
use MusMagPlugin\FieldsGenerator;
use MusMagPlugin\Metabox;
use MusMagPlugin\HooksActivator;

class MusMagPlugin
{
  private Post $event;
  private HooksActivator $activator;
  private array $event_details_fields;
  private Metabox $event_details_metabox;

  public function __construct()
  {
    $this->require_files();

    add_action('plugins_loaded', [$this,'init']);
  }

  private function require_files()
  {
    // autoload all classes from includes directory
    require_once __DIR__.'/vendor/autoload.php';
  }

  public function init()
  {
    // add Event post
    $this->event = new Post('event', 'events', true, true, 5, 'dashicons-calendar-alt');

    // // add Event fields
    $this->event_details_fields[] = new DateField('event date', 'event_date');
    $this->event_details_fields[] = new Field('event duration (giorni)', 'event_duration');
    $this->event_details_fields[] = new Field('event city', 'event_city');
    $this->event_details_fields[] = new MoneyField('event price', 'event_price');

    // add Event metabox
    $this->event_details_metabox = new Metabox('event details', 'event_details', [$this->event->get_name()], $this->event_details_fields);

    // activate hooks
    $this->activator = new HooksActivator();
    $this->activator->activate_actions($this->event);
    $this->activator->activate_actions($this->event_details_metabox);
  }
}
new MusMagPlugin();