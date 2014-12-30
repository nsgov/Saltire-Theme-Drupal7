<?php
/**
 * Implements hook_html_head_alter().
 * We are overwriting the default meta character type tag with HTML5 version.
 */
 
/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return a string containing the breadcrumb output.
 */




function saltire_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];
  $site_name = variable_get('site_name');
  if (!empty($breadcrumb)) {
  
 	array_shift($breadcrumb);
    // Provide a navigational heading to give context for breadcrumb links to
    // screen-reader users. Make the heading invisible with .element-invisible.
    
      $crumbs = '<ol><li><a href="http://www.novascotia.ca">novascotia.ca</a></li><li><a href="/">' . $site_name . '</a></li>';
      foreach(
$breadcrumb as $value) {
           $crumbs .= '<li>'.$value.'</li>';
      }
      $crumbs .= '</ol>';
    }
      return $crumbs;
  }
?>