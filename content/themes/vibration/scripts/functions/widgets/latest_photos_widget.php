<?php

/**
 * Plugin Name: Skyali Latest Photos
 * Plugin URI: http://londonthemes.com/index.php?themeforest=true
 * Description: A widget that allows you to display your latest photos.
 * Version: 1.0
 * Author: skyali
 * Author URI: http://londonthemes.com/index.php?themeforest=true
 *
 */

/**
 * Add function to widgets_init that'll load our widget.
 */
add_action( 'widgets_init', 'skyali_latest_photos_widgets' );

function skyali_latest_photos_widgets() {
	register_widget( 'skyali_latest_photos_widget' );
}

/**
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 */
class skyali_latest_photos_widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function skyali_latest_photos_widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'skyali_latest_photos_widget', 'description' => __('Display recent photos.', 'vibration') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'skyali_latest_photos_widget' );

		/* Create the widget. */
		$this->WP_Widget( 'skyali_latest_photos_widget', __('Skyali - Latest Photos', 'vibration'), $widget_ops, $control_ops );
	}

	/**
	 *display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );
	    $title = apply_filters('widget_title', $instance['title'] );
		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title )
		echo $before_title . $title . $after_title;
	   
	   $video_embed =@$instance['video_embed'];
	   
       ?>
       
      <div class="footer_latest_photos">
       <?php
	   $entries_display = @$instance['entries_display'];
	   if(empty($entries_display)){ $entries_display = '5'; }
	   $display_category = $instance['display_category'];
       //show latest blog posts
        $latest_posts = new WP_Query();
        $latest_posts->query('ignore_sticky_posts=1&showposts='.$entries_display.'&orderby=date&gallery_categories='.$display_category .'&post_type=gallery');
        while ($latest_posts->have_posts()) : $latest_posts->the_post();
       ?>
<?php  $image_full = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), ''); ?>
      
 <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'latest_video'); ?>
   
<div class="image_container"><a href="<?php echo $image_full[0]; ?>" rel="fancybox2"><div class="img_hover"><img src="<?php echo get_template_directory_uri(); ?>/images/photos_icon.png" /></div><!-- img_hover --><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" class="imgf" /></a></div>

	  <?php endwhile; ?><?php wp_reset_query(); ?>
       </div><!--- footer_latest_photos -->
	   <?php
		
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		//$defaults = array( 'title' => __('Example', 'example'), 'name' => __('John Doe', 'example'), 'sex' => 'male', 'show_sex' => true );
		//$instance = wp_parse_args( (array) $instance, $defaults ); ?>

     <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'vibration'); ?></label>
        <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" /></p>
		
  <p><label for="<?php echo $this->get_field_id( 'entries_display' ); ?>"><?php _e('How many entries to display?', 'vibrations'); ?></label>
 <input type="text" id="<?php echo $this->get_field_id('entries_display'); ?>" name="<?php echo $this->get_field_name('entries_display'); ?>" value="<?php echo $instance['entries_display']; ?>" style="width:100%;" /></p>
 
   <p><label for="<?php echo $this->get_field_id( 'display_category' ); ?>"><?php _e('Display Certain Categories? Place the category id and seperate with a comma (e.g. - 1, 22, 35)', 'vibration'); ?></label>
 <input type="text" id="<?php echo $this->get_field_id('display_category'); ?>" name="<?php echo $this->get_field_name('display_category'); ?>" value="<?php echo $instance['display_category']; ?>" style="width:100%;" /></p>
	<?php
	}
}

?>