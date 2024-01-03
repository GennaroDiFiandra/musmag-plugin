<?php

namespace MusMagPlugin\Image;

defined('WPINC') || die;

class Image
{
  private string $input_type;
  private string $input;
  private string $id;

  /**
   * Set the image id used by the others methods
   *
   * @param  string $input_type Expected value is "id" or "url"
   * @param  string $input Expected value is the id o the url based on the provided $input_type
   */
  public function __construct($input_type, $input)
  {
    $this->input_type = $input_type;
    $this->input = $input;
    $this->set_id();
  }

  private function set_id()
  {
    if ($this->input_type === 'id')
      $this->id = $this->input;
    elseif ($this->input_type === 'url')
      $this->id = attachment_url_to_postid($this->input);
  }

  public function image_width()
  {
    return wp_get_attachment_metadata($this->id)['width'];
  }

  public function image_height()
  {
    return wp_get_attachment_metadata($this->id)['height'];
  }

  public function image_srcset()
  {
    return wp_get_attachment_image_srcset($this->id);
  }

  public function image_sizes()
  {
    return wp_get_attachment_image_sizes($this->id);
  }
}