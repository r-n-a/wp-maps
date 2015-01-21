<?php

class Get_maps extends WP_Widget {
	
	public $name = 'WP maps';
	public $widget_desc = 'Get maps';
	public $control_options = array();
	
	static function register_this_widget()
	{
		register_widget(__CLASS__);
	}
    
    public static function head() {
			$search_handler_url = plugins_url('dynamic_javascript.php',dirname( __FILE__) );
			include('dynamic_javascript.php');
	}

	public static function initialize() {
			//wp_enqueue_script('jquery');
	} 
    
	function __construct() {
        $widget_options = array(
			'classname' => __CLASS__,
			'description' => $this->widget_desc,
			);
		parent::__construct( __CLASS__, $this->name, $widget_options, $this->control_options);
    } 
 
    function widget($args, $instance) {
		$title = apply_filters( 'widget_title', $instance['title'] );
        echo $args['before_widget'];
        if ( ! empty( $title ) )
       echo $args['before_title'] . $title . $args['after_title'];
	    
		if(!get_option('get_zoom'))
        add_option('get_zoom', 8);
		if(!get_option('get_v'))
        add_option('get_v', -34.397);
		if(!get_option('get_g'))
        add_option('get_g', 100.644);
		if(!get_option('get_w'))
        add_option('get_w', 250);
		if(!get_option('get_h'))
        add_option('get_h', 240);
		if(!get_option('get_marker_name'))
        add_option('get_marker_name', 'Point A');
		if(!get_option('get_map_type'))
        add_option('get_map_type', 'ROADMAP');
        echo '<p><div class="wrap"><div id="mapCanvas"></p>';
  		echo $args['after_widget']; 
    }
 
    function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
 
    function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'wpb_widget_domain' );
        }

        ?>
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php 
	   }
       
    static function admin_this_widget() {
       add_options_page('Get maps', 'Get maps', 'edit_pages', basename(__FILE__), 'get_maps_form');
    }

}

	function get_maps_form() {
        ?>
        <div class="wrap">
        <h2>Get map</h2>
		<div id="mapCanvas"></div>
	   <div id="data"></div>
	   <div id="infoPanel">
		<b>Marker status:</b>
		<div id="markerStatus"><i>Click and drag the marker.</i></div>
		<b>Current position:</b>
		<div id="info"></div>
		<b>Closest matching address:</b>
		<div id="address"></div>
	    </div>
		<div id="myform">
        <form method="post" action="">
        <h3>Введите обозначение маркера</h3>
		<textarea name="get_marker_name" rows="5" cols="32" ><?php echo get_option('get_marker_name') ?>
	   </textarea>
		<br/><br/>
		<h3>Выберите тип карты</h3>
        <select size="3" multiple name="get_map_type">
		    <option selected disabled>Тип карты</option>
			<option  value="ROADMAP">ROADMAP</option>
			<option  value="SATELLITE">SATELLITE</option>
			<option value="HYBRID">HYBRID</option>
			<option value="TERRAIN">TERRAIN</option>
		</select><br/><br/>
		<h3>Ширина карты</h3>
        <input type="text" name="get_w" value="<?php echo get_option('get_w') ?>" /><br/><br/>
		<h3>Высота карты</h3>
        <input type="text" name="get_h" value="<?php echo get_option('get_h') ?>" /><br/><br/>
		<input type="hidden" id="get_zoom" name="get_zoom" value="" />
		<input type="hidden" id="get_v" name="get_v" value="" />
		<input type="hidden" id="get_g" name="get_g" value="" /><br/>
	    <input type="submit" name="update" value="Сохранить" />
        </form>
        </div>  
<?php 
		if(isset($_POST['update'])) {
			if(isset($_POST['get_marker_name']))  
			{
				update_option('get_marker_name', $_POST['get_marker_name']);
			}
			if(isset($_POST['get_map_type']))  
			{
				update_option('get_map_type', $_POST['get_map_type']);
			}
			if(isset($_POST['get_w']))  
			{
				update_option('get_w', $_POST['get_w']);
			}
			if(isset($_POST['get_h']))  
			{
				update_option('get_h', $_POST['get_h']);
			}
			if(isset($_POST['get_zoom']))  
			{
				update_option('get_zoom', $_POST['get_zoom']);
			}
			if(isset($_POST['get_v']))  
			{
				update_option('get_v', $_POST['get_v']);
			}
			if(isset($_POST['get_g']))  
			{
				update_option('get_g', $_POST['get_g']);
			}
		}
    }

