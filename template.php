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
				
		if (!empty($crumbs)) {      
			      foreach(
				  	$breadcrumb as $value) {
			           $crumbs .= '<li>'.$value.'</li>';
					}
				
		      $crumbs .= '</ol>';
		    }
		      return $crumbs;
		}
  }
  
/**
 * Implements theme_menu_tree__main_menu.
 */
function saltire_menu_tree__main_menu($variables) {
  global $level;
  $class = ($level == 1) ? 'menu' : 'submenu';
  return '<ul class="'.$class.'">' . $variables['tree'] . '</ul>';
}

/**
 * Implements theme_menu_link__main_menu.
 */
function saltire_menu_link__main_menu($variables) {

  $element = $variables['element'];
  $sub_menu = '';   

  // set the global variable in order to use it in hook_menu_tree()
  // I called it "level" to avoid confusing with the $depth
  global $level;

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
    $level = 1; // set the level as first for each list with submenu
  }
  else {
    $level = $element['#original_link']['depth'];
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}  

/**
 * Override or insert variables into the html template.
 */
function saltire_preprocess_html(&$variables, $hook) {
  _saltire_set_path($variables);
}

/**
 * Override or insert variables into the page template.
 */
function saltire_preprocess_page(&$variables, $hook) {
  _saltire_set_path($variables);
}

/**
 * Helper function to set the path to the theme for templates.
 */
function _saltire_set_path(&$variables) {
  $variables['base_path'] = base_path();
  $variables['theme_base'] = drupal_get_path('theme', 'saltire');
  $secure = 'http' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's' : '') . '://';
  $variables['theme_base'] = str_replace('http://', $secure, $variables['theme_base']);
}

?>
