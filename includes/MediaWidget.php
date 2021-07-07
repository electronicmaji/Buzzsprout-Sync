<?php
/**
 * @package BuzzsproutSync
 */


class MediaWidget extends WP_Widget{

public $widget_ID;

public $widget_name;

public $widget_options = array();

public $control_options = array();

public function __construct(){

    $this->widget_ID = 'buzz_sync_widget';
    $this->widget_name ='Buzzsprout Sync Widget';

    $this->widget_options = array(
        'classname' => $this->widget_ID, 
        'description' => $this->widget_name,
        'customize_selective_refresh' => true,
    );

    $this->control_options = array( 
        'width' => 400,
        'height' => 400,
    );
}

public function register_widget(){ 
    parent::__construct( $this->widget_ID, $this->widget_name, 
    $this->widget_options, );

    add_action('widgets_init', array( $this, 'widgetInit') );
}

public function widgetInit(){
    register_widget( $this );
}

public function widget( $args, $instance ) {
    echo $args['before_widget'];
    if ( ! empty( $instance['title'] ) ) {
        echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
    }
    echo $args['after_widget'];
}

public function form( $instance ) {
    $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Custom Text', 'awps' );
    ?>
    <p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'awps' ); ?></label> 
    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>
    <?php 
}

public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = sanitize_text_field( $new_instance['title'] );

    return $instance;
}


}


$media_widget = new MediaWidget();
$media_widget->register_widget();