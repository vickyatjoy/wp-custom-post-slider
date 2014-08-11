<?php
/*
Plugin Name: Custom Post Slider
Plugin URI: http://www.loveyourcodes.com/
Description: A simple plugin that can slide post based on its type
Version: 1.0
Author: Vignesh Rajendran
Author URI: http://www.loveyourcodes.com/
License: GPL2
*/
?>

<?php
class wp_post_slider extends WP_Widget {
	// constructor
	function wp_post_slider() {
		parent::WP_Widget(
			'wp_post_slider', // Base ID
			__('Post Slider', 'text_domain'), // Name
			array( 'description' => __( 'A simple plugin that can slide post based on its type', 'text_domain' ), ));
			add_action('init',array(&$this,'loadScript'));   
	}	
	function loadScript()
	{
		wp_register_style('cp_style.css', plugins_url('/css/style.css', __FILE__));
			wp_enqueue_style('cp_style.css' );		
			wp_enqueue_script('wp_cp_js_min',plugins_url('/js/jquery.min.1.11.js', __FILE__), array('jquery'));
			wp_enqueue_script('wp_cp_js_chili',plugins_url('/js//chili.1.7.js', __FILE__), array('jquery'));
			wp_enqueue_script('wp_cp_js_cycle',plugins_url('/js/jquery.cycle.js', __FILE__), array('jquery'));
	}
	// widget form creation
	function form($instance) 
	{	
			// Check values
		if( $instance) {
			 $title = esc_attr($instance['title']);
			 $post_type = esc_attr($instance['post_type']);
			 $post_count = esc_attr($instance['post_count']);
			 $show_thumbnail = esc_attr($instance['show_thumbnail']);
			 $display_count = esc_attr($instance['display_count']);
			 $custom_meta = esc_attr($instance['custom_meta']);
			 $effect_browser = esc_attr($instance['effect_browser']);
			 $effect_speed = esc_attr($instance['effect_speed']);
			 $show_date = esc_attr($instance['show_date']);
		} else {
			 $title = '';
			 $post_type = '';
			 $post_count = '';
			 $show_thumbnail = '';	
			 $display_count = '';	
			 $custom_meta = '';	
			 $effect_browser = '';
			 $effect_speed = '';
			 $show_date = '';
		}
		$effects = array( 0=> 'blindX' ,1=> 'blindY' ,2=> 'blindZ' ,3=> 'cover' ,4=> 'curtainX' ,5=> 'curtainY' ,6=> 'fade' ,7=> 'fadeZoom' ,8=> 'growX' ,9=> 'growY' ,10=> 'none' ,11=> 'scrollUp' ,12=> 'scrollDown' ,13=> 'scrollLeft' ,14=> 'scrollRight' ,15=> 'scrollHorz' ,16=> 'scrollVert' ,17=> 'shuffle' ,18=> 'slideX' ,19=> 'slideY' ,20=> 'toss' ,21=> 'turnUp' ,22=> 'turnDown' ,23=> 'turnLeft' ,24=> 'turnRight' ,25=> 'uncover' ,26=> 'wipe' ,27=> 'zoom' );
		?>

        <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'wp_post_slider'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        
        <p>
         <label for="<?php echo $this->get_field_id('post_type'); ?>"><?php _e('Post Type:', 'wp_post_slider'); ?></label>
       <select id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>" class="widefat" style="width:100%;">
    <?php foreach(get_post_types('','names') as $post_type) { ?>
        <option <?php selected( $instance['post_type'], $post_type ); ?> value="<?php echo $post_type; ?>"><?php echo $post_type; ?></option>
    <?php } ?>      
</select>
        </p>
        
        <p>
        <label for="<?php echo $this->get_field_id('post_count'); ?>"><?php _e('Post Count:', 'wp_post_slider'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('post_count'); ?>" name="<?php echo $this->get_field_name('post_count'); ?>" type="number" value="<?php echo $post_count; ?>" />
        </p>
        
         <p>
        <label for="<?php echo $this->get_field_id('display_count'); ?>"><?php _e('Dispaly Count:', 'wp_post_slider'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('display_count'); ?>" name="<?php echo $this->get_field_name('display_count'); ?>" type="number" value="<?php echo $display_count; ?>" />
        </p>
         <p>
         <label for="<?php echo $this->get_field_id('effect_browser'); ?>"><?php _e('Browse Effect :', 'wp_post_slider'); ?></label>
       <select id="<?php echo $this->get_field_id('effect_browser'); ?>" name="<?php echo $this->get_field_name('effect_browser'); ?>" class="widefat" style="width:100%;">
    <?php foreach($effects as $effect) { ?>
        <option <?php selected( $instance['effect_browser'], $effect ); ?> value="<?php echo $effect; ?>"><?php echo $effect; ?></option>
    <?php } ?>      
</select>
        </p>  
         <p>
        <label for="<?php echo $this->get_field_id('effect_speed'); ?>"><?php _e('Effect Speed:', 'wp_post_slider'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('effect_speed'); ?>" name="<?php echo $this->get_field_name('effect_speed'); ?>" type="number" value="<?php echo $effect_speed; ?>" step="100" min="100" />
        </p> 
         <p>
        <label for="<?php echo $this->get_field_id('custom_meta'); ?>"><?php _e('Custom Post Meta ( split meta by using (,) ex: meta1,meta2,.. )', 'custom_meta'); ?></label>
        <textarea class="widefat" id="<?php echo $this->get_field_id('custom_meta'); ?>" name="<?php echo $this->get_field_name('custom_meta'); ?>"><?php echo $custom_meta; ?></textarea>
        </p>         
         <p>
        <label for="<?php echo $this->get_field_id('show_thumbnail'); ?>"><?php _e('Show Thumbnail:', 'wp_post_slider'); ?></label>
       <input id="<?php echo $this->get_field_id('show_thumbnail'); ?>" name="<?php echo $this->get_field_name('show_thumbnail'); ?>" type="checkbox" value="1" <?php checked( '1', $show_thumbnail ); ?> />
        </p>     
         <p>
        <label for="<?php echo $this->get_field_id('show_date'); ?>"><?php _e('Show Date & Author:', 'wp_post_slider'); ?></label>
       <input id="<?php echo $this->get_field_id('show_date'); ?>" name="<?php echo $this->get_field_name('show_date'); ?>" type="checkbox" value="1" <?php checked( '1', $show_date ); ?> />
        </p>     
         
        <?php
	}

	// widget update
	function update($new_instance, $old_instance) {
		 $instance = $old_instance;
		  // Fields		 
		  
		   $instance['title'] = strip_tags($new_instance['title']);
		   $instance['post_type'] = strip_tags($new_instance['post_type']);
		   $instance['post_count'] = strip_tags($new_instance['post_count']);
		   $instance['show_thumbnail'] = strip_tags($new_instance['show_thumbnail']);
	       $instance['display_count'] = strip_tags($new_instance['display_count']);
	       $instance['custom_meta'] = strip_tags($new_instance['custom_meta']);
		   $instance['effect_browser'] = strip_tags($new_instance['effect_browser']);
		   $instance['effect_speed'] = strip_tags($new_instance['effect_speed']);
		   $instance['show_date'] = strip_tags($new_instance['show_date']);
		   
		 return $instance;
	}

	// widget display
	function widget($args, $instance) {
		
		extract( $args );
	   // these are the widget options
	   $title = apply_filters('widget_title', $instance['title']);
  	   $post_type = $instance['post_type'];
	   $post_count = $instance['post_count'];
	   $show_thumbnail = $instance['show_thumbnail'];	
	   $display_count = $instance['display_count'];		
	   $custom_meta = $instance['custom_meta'];	
	   $effect_browser = $instance['effect_browser'];		
	   $effect_speed = $instance['effect_speed'];
	   $show_date = $instance['show_date'];		
	   $effect = ($effect_browser !='')?$effect_browser:'scrollHorz';
	   $speed = ($effect_speed !='')?$effect_speed:600;	  
	   
	   
		

?>

<script type="text/javascript">
(function(){
jQuery.fn.cycle.defaults.timeout = 6000;
	jQuery('#<?php echo $this->id; ?> #s2').cycle({
    fx:     '<?php echo $effect; ?>',
    speed:  <?php echo $speed; ?>,
    timeout: 0,
    next:   '#<?php echo $this->id; ?> .prev',
    prev:   '#<?php echo $this->id; ?> .next',
});
}());
</script>

<?php
	   echo $before_widget;
	   // Display the widget
	   echo '<div class="cp_slider">';
	
	   // Check if title is set
	   if ( $title ) {
		  echo $before_title . $title.'<a class="prev" href="#"></a> <a class="next" href="#"></a>' . $after_title;
	   }
	   $cs_meta = explode(',',$custom_meta);
	   $post_details = $this->post_slider($post_type,$post_count, $show_thumbnail, $display_count, $cs_meta, $show_date);
	   		
	   echo '</div>';
	   echo $after_widget;		
	}
	function post_slider($type,$count,$thumb,$dcount,$meta_keys=0,$show_date)
	{
		$args = array( 
		'numberposts' => $count, 'orderby' => 'post_date', 'order' => 'DESC', 'post_type' => $type, 'post_status' => 'publish', 'suppress_filters' => true 
		);		
		
		$post_details = wp_get_recent_posts( $args, ARRAY_A ); //post list		
		$post_details = array_chunk($post_details, $dcount); //spliting array by display count
		$post_count = count($post_details)-1;
		echo "<div id='s2'>";		
		for($i=0; $i<=$post_count; $i++)
		{
			echo "<div class='sfirst".$i."'>";
			foreach($post_details[$i] as $post_detail)
			{
				
				$t_nail = '<span class="thumb">'.get_the_post_thumbnail($post_detail['ID'], array(64,64) ).'</span>'; //getting featured image
				$thumbnail = ($thumb == 1)?$t_nail:'';
				$author = 'by '.get_the_author_meta('display_name',$post_detail['post_author']);
		
				echo "<div style='border-bottom:1px dotted red; ".$padding."'><a href='".get_permalink($post_detail['ID'])."'>";
				echo $thumbnail;
				echo '<span id="title">'.substr($post_detail['post_title'], 0, 25).' ...</span>';
				
				if($type != 'events')
				{
					if($show_date == 1)
					echo '<span id="date">'.mysql2date('F j, Y',$post_detail['post_date']).' '.$author.'</span>';
				}
				else
				{
					$location = get_post_meta($post_detail['ID'],'location');		
					echo '<span id="date">'.$this->eventdate($post_detail,'eventstart').' - '.$this->eventdate($post_detail,'eventend').' '.$location[0].'</span>';
				}
				if($meta_keys != 0)
				{
					foreach($meta_keys as $key)
					{
						$loc = get_post_meta($post_detail['ID'],$key);					
						echo '<span class="meta-'.$key.'">'.$loc[0].'</span>';
					}
				}

					
				echo "</a></div>";	
			}
			echo "</div>";			
		}		
		echo "</div>";	
	}	

	function eventdate($event,$date)
	{
		$event_date = get_post_meta($event['ID'],$date);
		if($event_date[0] == '')			
		return '';
		else				
		return date('m/d',strtotime($event_date[0]));;				
	}
	
	
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("wp_post_slider");'));
?>
