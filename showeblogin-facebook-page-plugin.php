<?php
/*
Plugin Name: Showeblogin Facebook Page Plugin
Plugin URI: http://www.superwebtricks.com/blogger-beginner-guide/facebook-page-wordpress-plugin/
Description: Brings the power of simplicity to display Facebook Page Plugin (Like Box) into your WordPress Site.
Version: 1.0
Author: Suresh Prasad
Author URI: http://www.superwebtricks.com
License: GPLv3+

 * Copyright (C) 2015  Suresh Prasad  (email : spsmiter@gmail.com)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
	any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

global $theme;

$swt_fb_page_defaults = array(
    'title' => 'Showeblogin Facebook Page',
    'url' => 'https://www.facebook.com/SuperWebTricks',
    'width' => '340',
    'height' => '500',
    'show_faces' => 'true',
    'stream' => 'false',
    'data_hide_cover' => 'false'
);

$theme->options['widgets_options']['facebook'] =  isset($theme->options['widgets_options']['facebook'])
    ? array_merge($swt_fb_page_defaults, $theme->options['widgets_options']['facebook'])
    : $swt_fb_page_defaults;
        
add_action('widgets_init', create_function('', 'return register_widget("ShowebloginFacebookPagePlugin");'));

class ShowebloginFacebookPagePlugin extends WP_Widget 
{
    function __construct() 
    {
        $widget_options = array('description' => __('Showeblogin Facebook Page Plugin social widget. Enables Facebook Page owners to attract and gain Likes and share from their own website.', 'spsmiter') );
        $control_options = array( 'width' => 440);
		$this->WP_Widget('spsmiter_facebook', '&raquo; Facebook Page Like Box', $widget_options, $control_options);
    }

    function widget($args, $instance)
    {
        global $wpdb, $theme;
        extract( $args );
        $instance = ! empty( $instance ) ? $instance : $theme->options['widgets_options']['facebook'];
        $title = apply_filters('widget_title', $instance['title']);
        $url = $instance['url'];
        $width = $instance['width'];
        $height = $instance['height'];
        $show_faces = $instance['show_faces'] == 'true' ? 'true' : 'false';
        $stream = $instance['stream'] == 'true' ? 'true' : 'false';
        $data_hide_cover = $instance['data_hide_cover'] == 'true' ? 'true' : 'false';
        ?>
        <ul class="widget-container"><li class="facebook-widget">
        <?php  if ( $title ) {  ?> <h3 class="widgettitle"><?php echo $title; ?></h3> <?php }  ?>
            <div id="fb-root"></div><script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
			fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script><div class="fb-page" data-href="<?php echo $url; ?>" data-hide-cover="<?php echo $data_hide_cover; ?>" data-show-facepile="<?php echo $show_faces; ?>" data-show-posts="<?php echo $stream; ?>" data-width="<?php echo $width; ?>" data-height="<?php echo $height; ?>"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/SuperWebTricks"><a href="https://www.facebook.com/SuperWebTricks">Showeblogin</a></blockquote></div></div>            
        </li></ul>
     <?php
    }

    function update($new_instance, $old_instance) 
    {		
    	$instance = $old_instance;
    	$instance['title'] = strip_tags($new_instance['title']);
        $instance['url'] = strip_tags($new_instance['url']);
        $instance['width'] = strip_tags($new_instance['width']);
        $instance['height'] = strip_tags($new_instance['height']);
        $instance['show_faces'] = strip_tags($new_instance['show_faces']);
        $instance['stream'] = strip_tags($new_instance['stream']);
        $instance['data_hide_cover'] = strip_tags($new_instance['data_hide_cover']);
        return $instance;
    }
    
    function form($instance) 
    {	
        global $theme;
		$instance = wp_parse_args( (array) $instance, $theme->options['widgets_options']['facebook'] );
        
        ?>
        
            <div class="swt-fb-page-widget">
                <table width="100%">
                    <tr>
                        <td class="swt-fb-page-widget-label" width="30%"><label for="<?php echo $this->get_field_id('title'); ?>">Title:</label></td>
                        <td class="swt-fb-page-widget-content" width="70%"><input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" /></td>
                    </tr>
                    
                    <tr>
                        <td class="swt-fb-page-widget-label"><label for="<?php echo $this->get_field_id('url'); ?>">Facebook Page URL:</label></td>
                        <td class="swt-fb-page-widget-content"><input class="widefat" id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" type="text" value="<?php echo esc_attr($instance['url']); ?>" /></td>
                    </tr>
                    
                    <tr>
                        <td class="swt-fb-page-widget-label">Sizes:</td>
                        <td class="swt-fb-page-widget-content">
                            Width: <input type="text" style="width: 50px;" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo esc_attr($instance['width']); ?>" /> px. &nbsp; &nbsp;
                            Height: <input type="text" style="width: 50px;" name="<?php echo $this->get_field_name('height'); ?>" value="<?php echo esc_attr($instance['height']); ?>" /> px.
                        </td>
                    </tr>
                    
                    <tr>
                        <td class="swt-fb-page-widget-label">Header Cover:</td>
                        <td class="swt-fb-page-widget-content">
							<input type="checkbox" name="<?php echo $this->get_field_name('data_hide_cover'); ?>"  <?php checked('true', $instance['data_hide_cover']); ?> value="true" />  <?php _e('Hide Header Cover Photo', 'spsmiter'); ?>                     
                        </td>
                    </tr>

                    <tr>
                        <td class="swt-fb-page-widget-label">Misc Options:</td>
                        <td class="swt-fb-page-widget-content">
                            <input type="checkbox" name="<?php echo $this->get_field_name('show_faces'); ?>"  <?php checked('true', $instance['show_faces']); ?> value="true" />  <?php _e('Show Faces', 'spsmiter'); ?>
                            <br /><input type="checkbox" name="<?php echo $this->get_field_name('stream'); ?>"  <?php checked('true', $instance['stream']); ?> value="true" />  <?php _e('Show Stream', 'spsmiter'); ?>  
                        </td>
                    </tr>
                    
                </table>
            </div>
            
        <?php 
    }
} 
?>