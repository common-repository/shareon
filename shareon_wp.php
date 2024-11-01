<?php
/*
 Plugin Name: Shareon WP
 Description: Lightweight, stylish and ethical share buttons for WordPress.
 Version: 1.0.2
 Author: Gareth Gillman
 Text Domain: ggshareonwp
*/

class shareon_widget extends WP_Widget {
  
  function __construct() {
    
    parent::__construct(
      'shareon_widget', 
      __( 'Shareon Widget', 'ggshareonwp' )
    );
	  
	add_action( 'wp_enqueue_scripts', array( $this, 'shareon_assets' ) );
    
  }
	
  function shareon_assets() {
    wp_enqueue_style( 'shareon-css', plugin_dir_url( __FILE__ ) . 'shareon.min.css', array(), '1.0.0' );
    wp_enqueue_script( 'shareon-js', plugin_dir_url( __FILE__ ) . 'shareon.min.js', array(), '1.0.0', true );
  }
  
  public function widget( $args, $instance ) {
    	  
    echo $args['before_widget'];
    
    $title = apply_filters( 'widget_title', $instance['title'] );
    if ( ! empty( $title ) )
    echo $args['before_title'] . $title . $args['after_title'];
  
    $share_list = $instance['share_list'];
	if( !empty( $share_list ) ) {
	  echo '<div class="shareon">';
	    foreach( $share_list as $share ) {
	      echo '<button class="'.$share.'"></button>';
	    }
	  echo '</div>';
	}
    
    echo $args['after_widget'];
    
  }
          
  public function form( $instance ) {
  
    if ( isset( $instance[ 'title' ] ) ) {
      $title = esc_attr( $instance[ 'title' ] );
    } else {
      $title = __( 'Share this content', 'ggshareonwp' );
    }
    echo '<p>'.__( "Widget Title" ).'</p>';
	echo '<input class="widefat" id="'.$this->get_field_id( "title" ).'" name="'.$this->get_field_name( "title" ).'" type="text" value="'.$title.'" /></p>';
    
	$share_list = $instance['share_list'];
    $share_array = array(
      'facebook', 'linkedin', 'messenger', 'odnoklassniki', 'pinterest', 'pocket', 'reddit', 'telegram', 'twitter', 'viber', 'vkontakte', 'whatsapp'
    );
    echo '<div class="share_listn">';
	  echo '<p>'.__( "Select Share Services", "ggshareonwp").'</p>';
      foreach( $share_array as $share ) {
        echo '<div class="select">';
          echo '<label><input type="checkbox" name="'.$this->get_field_name( "share_list" ).'[]" value="'.$share.'" '.((in_array( $share, $share_list ) ) ? "checked" : "" ).' />'.$share.'</label><br /><br />';
        echo '</div>';
      }
    echo '</div>';
	
  }
      
  public function update( $new_instance, $old_instance ) {

    $instance = array();
    
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    
    $instance['share_list'] = $new_instance['share_list'];
    
    return $instance;
    
  }
 
}
 
function shareon_load_widget() {
  register_widget( 'shareon_widget' );
}
add_action( 'widgets_init', 'shareon_load_widget' );