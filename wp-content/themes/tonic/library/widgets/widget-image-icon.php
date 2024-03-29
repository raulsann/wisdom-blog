<?php
/**
 * Custom Text widget class
 *
 * @since 1.0.0
 */
class Bavotasan_Custom_Text_Widget extends WP_Widget {
	function __construct() {
		$widget_ops = array( 'classname' => 'bavotasan_custom_text_widget', 'description' => __( 'Custom Text Widget with Image', 'tonic' ) );
		$control_ops = array('width' => 400, 'height' => 350);
		parent::__construct( 'bavotasan_custom_text_widget', __( 'Image Text Widget', 'tonic' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$image = esc_url( $instance['image'] );
		$text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
		$icon =  ( empty( $icon ) ) ? '' : '<i class="' . $icon. '"></i> ';

		echo $before_widget;

		if ( ! empty( $image ) )
			echo '<img src="' . $image. '" alt="" class="img-circle aligncenter" />';

		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;

		?>

		<div class="textwidget">
			<?php echo ( ! empty( $instance['filter'] ) ) ? wpautop( $text ) : $text; ?>
		</div>
		<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['image'] = esc_url( $new_instance['image'] );

		if ( current_user_can( 'unfiltered_html' ) )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text'] ) ) ); // wp_filter_post_kses() expects slashed

		$instance['filter'] = isset( $new_instance['filter'] );

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '', 'icon' => '', 'image' => '' ) );
		$title = strip_tags( $instance['title'] );
		$image = esc_url( $instance['image'] );
		$text = esc_textarea( $instance['text'] );
		?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'tonic' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'image' ); ?>"><?php _e( 'Image URL:', 'tonic' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" type="text" value="<?php echo esc_url( $image ); ?>" /></p>

		<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

		<p><input id="<?php echo $this->get_field_id('filter'); ?>" name="<?php echo $this->get_field_name('filter'); ?>" type="checkbox" <?php checked(isset($instance['filter']) ? $instance['filter'] : 0); ?> />&nbsp;<label for="<?php echo $this->get_field_id('filter'); ?>"><?php _e( 'Automatically add paragraphs', 'tonic' ); ?></label></p>
		<?php
	}
}
register_widget( 'Bavotasan_Custom_Text_Widget' );