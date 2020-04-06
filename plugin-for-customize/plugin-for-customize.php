<?php
/*
Plugin Name: plugin-for-customize
Plugin URI:
Description: plugin-for-customize
Author: plugin-for-customize
Contributor: plugin-for-customize
Author URI: plugin-for-customize
Version: 1.0
*/ 


//plugin directory
define( 'PLUGIN_FOR_CUSTOMIZE__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
require_once plugin_dir_path(__FILE__) . 'includes/function.php';
wp_register_script( 'script_pfc', plugins_url( '/js/script.js', __FILE__ ) );

//=================================================

// подключаем функцию активации мета блока для добавления картинок в редакторе
add_action('add_meta_boxes', 'images_fields', 25);
function images_fields() {
add_meta_box('add_imd_in_the_property_custom','Картинки','images_box_func','the_property','normal','high');}

//регистрация и подключение стиля
wp_register_style( 'plugin_for_my_theme', plugins_url( 'css/style.css', __FILE__ ) );
wp_enqueue_style( 'plugin_for_my_theme',PLUGIN_FOR_MY_THEME_URL. 'css/style.css' );

?>