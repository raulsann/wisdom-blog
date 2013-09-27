<?php
class Bavotasan_Preview_Pro {
	public function __construct() {
		add_action( 'admin_bar_menu', array( $this, 'admin_bar_menu' ), 1000 );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	/**
	 * Add a 'Preview Pro' menu item to the admin bar
	 *
	 * This function is attached to the 'admin_bar_menu' action hook.
	 *
	 * @since 1.0.0
	 */
	public function admin_bar_menu( $wp_admin_bar ) {
	    if ( current_user_can( 'edit_theme_options' ) && is_admin_bar_showing() )
	    	$wp_admin_bar->add_node( array( 'parent' => 'bavotasan_toolbar', 'id' => 'preview_pro', 'title' => sprintf( __( 'Preview %s Pro', 'tonic' ), BAVOTASAN_THEME_NAME ), 'href' => admin_url( 'themes.php?page=bavotasan_preview_pro' ) ) );
	}

	/**
	 * Add a 'Preview Pro' menu item to the Appearance panel
	 *
	 * This function is attached to the 'admin_menu' action hook.
	 *
	 * @since 1.0.0
	 */
	public function admin_menu() {
		add_theme_page( sprintf( __( 'Preview %s Pro', 'tonic' ), BAVOTASAN_THEME_NAME ), sprintf( __( 'Preview %s Pro', 'tonic' ), BAVOTASAN_THEME_NAME ), 'edit_theme_options', 'bavotasan_preview_pro', array( $this, 'bavotasan_preview_pro' ) );
	}

	public function bavotasan_preview_pro() {
		?>
		<div class="wrap" id="custom-background">
			<div id="icon-themes" class="icon32"></div>
			<h2><?php echo get_admin_page_title(); ?></h2>
			<p><iframe width="853" height="480" src="//www.youtube.com/embed/aMS7GsGzXnQ?rel=0" frameborder="0" allowfullscreen></iframe></p>

			<p><?php printf( __( '%s can help you take your website to the next level. Here\'s a list of some of the advanced features.', 'tonic' ), '<strong>Tonic Pro</strong>' ); ?></p>
			<ul style="padding-left: 20px; list-style: disc; margin-bottom: 20px;">
				<li>Featured Slider</li>
				<li>Logo Uploader</li>
				<li>Multiple Sidebar Layout</li>
				<li>Full Width Posts/Pages</li>
				<li>Twitter Bootstrap Shortcodes</li>
				<li>Font Selector, with 20 Google Fonts</li>
				<li>Custom CSS Editor</li>
				<li>Advanced Color Picker</li>
				<li>And a whole lot more...</li>
			</ul>
			<p><a href="https://themes.bavotasan.com/2013/tonic-pro/" class="button button-large"><?php printf( __( 'Buy %s Now &rarr;', 'tonic' ), '<strong>Tonic Pro</strong>' ); ?></a></p>
		</div>
		<?php
	}
}
$bavotasan_preview_pro = new Bavotasan_Preview_Pro;