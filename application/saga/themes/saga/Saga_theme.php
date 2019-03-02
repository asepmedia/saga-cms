<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @name Si_cms Core
 * @author Asep Yayat
 * @version v.0.0.1
 * @since 2018
 * @email asepmedia18@gmail.com
 */

 class Saga_theme extends Theme
 {

  /**
   * Css List
   */
  public function css()
  {
    $result = '';

    $css = array(
      'css/style.css',
    );

    foreach($css as $v) {
      $result .= "\t" . '<link rel="stylesheet" href="'.base_url().'assets/'. $this->current_theme . '/' .$v .'">' . PHP_EOL;
    }

    return $result;
  }

  /**
   *  list
   */
  public function js()
  {
    $result = '';

    $js = array(
      'js/jquery-3.2.1.min.js',
    );

    foreach($js as $v) {
      $result .= "\t" .'<script src="'.base_url().'assets/'. $this->current_theme . '/' . $v .'"></script>' . PHP_EOL;
    }

    return $result;
  }
 }