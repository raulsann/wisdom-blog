<?php
/**
 * Defining constants
 *
 * @since 1.0.0
 */
$bavotasan_theme_data = wp_get_theme();
define( 'BAVOTASAN_THEME_URL', get_template_directory_uri() );
define( 'BAVOTASAN_THEME_TEMPLATE', get_template_directory() );
define( 'BAVOTASAN_THEME_VERSION', trim( $bavotasan_theme_data->Version ) );
define( 'BAVOTASAN_THEME_NAME', $bavotasan_theme_data->Name );
define( 'BAVOTASAN_THEME_FILE', get_option( 'template' ) );

/**
 * Includes
 *
 * @since 1.0.0
 */
require( BAVOTASAN_THEME_TEMPLATE . '/library/theme-options.php' ); // Functions for theme options page
require( BAVOTASAN_THEME_TEMPLATE . '/library/preview-pro.php' ); // Functions for preview pro page

/**
 * Prepare the content width
 *
 * @since 1.0.0
 */
$bavotasan_theme_options = bavotasan_theme_options();
$array_width = array( '' => 1200, 'w960' => 960, 'w640' => 640, 'w320' => 320, 'wfull' => 1200 );
$array_content = array( 'c2' => .17, 'c3' => .25, 'c4' => .34, 'c5' => .42, 'c6' => .5, 'c7' => .58, 'c8' => .66, 'c9' => .75, 'c10' => .83, 'c12' => 1 );
$bavotasan_main_content =  $array_content[$bavotasan_theme_options['primary']] * $array_width[$bavotasan_theme_options['width']] - 40;

if ( ! isset( $content_width ) )
	$content_width = $bavotasan_main_content;

add_action( 'after_setup_theme', 'bavotasan_setup' );
if ( ! function_exists( 'bavotasan_setup' ) ) :
/**
 * Initial setup
 *
 * This function is attached to the 'after_setup_theme' action hook.
 *
 * @uses	load_theme_textdomain()
 * @uses	get_locale()
 * @uses	BAVOTASAN_THEME_TEMPLATE
 * @uses	add_theme_support()
 * @uses	add_editor_style()
 * @uses	add_custom_background()
 * @uses	add_custom_image_header()
 * @uses	register_default_headers()
 *
 * @since 1.0.0
 */
function bavotasan_setup() {
	load_theme_textdomain( 'tonic', BAVOTASAN_THEME_TEMPLATE . '/library/languages' );

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'tonic' ) );

	// Add support for a variety of post formats
	add_theme_support( 'post-formats', array( 'gallery', 'image', 'video', 'audio', 'quote', 'link', 'status', 'aside' ) );

	// This theme uses Featured Images (also known as post thumbnails) for archive pages
	add_theme_support( 'post-thumbnails' );

	// Add a filter to bavotasan_header_image_width and bavotasan_header_image_height to change the width and height of your custom header.
	add_theme_support( 'custom-header', array(
		'default-text-color' => 'fff',
		'flex-height' => true,
		'flex-width' => true,
		'random-default' => true,
		'width' => apply_filters( 'bavotasan_header_image_width', 1500 ),
		'height' => apply_filters( 'bavotasan_header_image_height', 550 ),
		'admin-head-callback' => 'bavotasan_admin_header_style',
		'admin-preview-callback' => 'bavotasan_admin_header_image'
	) );

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'header01' => array(
			'url' => '%s/library/images/header01.jpg',
			'thumbnail_url' => '%s/library/images/header01-thumbnail.jpg',
			'description' => __( 'Default Header 1', 'tonic' )
		),
	) );

	// Add support for custom backgrounds
	add_theme_support( 'custom-background' );
}
endif; // bavotasan_setup

add_action( 'wp_head', 'bavotasan_styles' );
/**
 * Add a style block to the theme for the current link color.
 *
 * This function is attached to the 'wp_head' action hook.
 *
 * @since 1.0.0
 */
function bavotasan_styles() {
	$bavotasan_theme_options = bavotasan_theme_options();
	$text_color = get_header_textcolor();
	$styles = ( 'blank' == $text_color ) ? 'position:absolute !important;clip:rect(1px 1px 1px 1px);clip:rect(1px, 1px, 1px, 1px)' : 'color:#' . $text_color . ' !important';
	?>
<style>
#header-wrap { background: url(<?php echo get_header_image(); ?>) no-repeat; background-size: cover; }
#site-title a,#site-description{<?php echo $styles; ?>}
</style>
	<?php
}

add_action( 'admin_bar_menu', 'bavotasan_admin_bar_menu', 999 );
/**
 * Add menu item to toolbar
 *
 * This function is attached to the 'admin_bar_menu' action hook.
 *
 * @param	array $wp_admin_bar
 *
 * @since 2.0.4
 */
function bavotasan_admin_bar_menu( $wp_admin_bar ) {
    if ( current_user_can( 'edit_theme_options' ) && is_admin_bar_showing() )
    	$wp_admin_bar->add_node( array( 'id' => 'bavotasan_toolbar', 'title' => BAVOTASAN_THEME_NAME, 'href' => admin_url( 'customize.php' ) ) );
}

if ( ! function_exists( 'bavotasan_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in bavotasan_setup().
 *
 * @since 1.0.0
 */
function bavotasan_admin_header_style() {
	$text_color = get_header_textcolor();
	$styles = ( 'blank' == $text_color ) ? 'display:none' : 'color:#' . $text_color . ' !important';
	?>
<style>
.appearance_page_custom-header #headimg {
	border: none;
	}

#site-title {
	margin: 0;
	font-family: Georgia, sans-serif;
	font-size: 50px;
	line-height: 1.2;
	}

#site-description {
	font-family: Arial, sans-serif;
	margin: 0 0 30px;
	font-size: 20px;
	line-height: 1.2;
	font-weight: normal;
	padding: 0;
	}

#headimg img {
	max-width: 1500px;
	height: auto;
	width: 100%;
	}

#site-title,#site-description{<?php echo $styles; ?>}
</style>
	<?php
}
endif; // bavotasan_admin_header_style

if ( ! function_exists( 'bavotasan_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in bavotasan_setup().
 *
 * @uses	bloginfo()
 * @uses	get_header_image()
 *
 * @since 1.0.0
 */
function bavotasan_admin_header_image() {
	?>
	<div id="headimg">
		<h1 id="site-title"><?php bloginfo( 'name' ); ?></h1>
		<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
		<?php if ( $header_image = get_header_image() ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
		<?php endif; ?>
	</div>
	<?php
}
endif; // bavotasan_admin_header_image

add_action( 'pre_get_posts', 'bavotasan_home_query' );
if ( ! function_exists( 'bavotasan_home_query' ) ) :
/**
 * Remove sticky posts from home page query
 *
 * This function is attached to the 'pre_get_posts' action hook.
 *
 * @param	array $query
 *
 * @since 1.0.0
 */
function bavotasan_home_query( $query = '' ) {
	$bavotasan_theme_options = bavotasan_theme_options();
	if ( ! is_home() || ! is_a( $query, 'WP_Query' ) || ! $query->is_main_query() )
		return;

	$query->set( 'posts_per_page', (int) $bavotasan_theme_options['number_posts'] );
}
endif;

add_action( 'wp_enqueue_scripts', 'bavotasan_add_js' );
if ( ! function_exists( 'bavotasan_add_js' ) ) :
/**
 * Load all JavaScript to header
 *
 * This function is attached to the 'wp_enqueue_scripts' action hook.
 *
 * @uses	is_admin()
 * @uses	is_singular()
 * @uses	get_option()
 * @uses	wp_enqueue_script()
 * @uses	BAVOTASAN_THEME_URL
 *
 * @since 1.0.0
 */
function bavotasan_add_js() {
	if ( is_singular() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );

	wp_enqueue_script( 'harvey', BAVOTASAN_THEME_URL .'/library/js/harvey.min.js', '', '', true );
	wp_enqueue_script( 'bootstrap', BAVOTASAN_THEME_URL .'/library/js/bootstrap.min.js', array( 'jquery' ), '2.2.2', true );
	wp_enqueue_script( 'theme_js', BAVOTASAN_THEME_URL .'/library/js/theme.js', array( 'bootstrap' ), '', true );

	wp_enqueue_style( 'theme_stylesheet', get_stylesheet_uri() );
	wp_enqueue_style( 'google_fonts', 'http://fonts.googleapis.com/css?family=PT+Sans|Lato:300,400|Lobster|Quicksand', false, null, 'all' );
	wp_enqueue_style( 'font_awesome', 'http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css', false, null, 'all' );
}
endif; // bavotasan_add_js

add_action( 'widgets_init', 'bavotasan_widgets_init' );
if ( ! function_exists( 'bavotasan_widgets_init' ) ) :
/**
 * Creating the two sidebars
 *
 * This function is attached to the 'widgets_init' action hook.
 *
 * @uses	register_sidebar()
 *
 * @since 1.0.0
 */
function bavotasan_widgets_init() {
	$bavotasan_theme_options = bavotasan_theme_options();
	require( BAVOTASAN_THEME_TEMPLATE . '/library/widgets/widget-image-icon.php' ); // Custom Image/Icon Text widget

	register_sidebar( array(
		'name' => __( 'First Sidebar', 'tonic' ),
		'id' => 'sidebar',
		'description' => __( 'This is the first sidebar widgetized area. All defaults widgets work great here.', 'tonic' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Second Sidebar', 'tonic' ),
		'id' => 'second-sidebar',
		'description' => __( 'This is the second sidebar widgetized area. All defaults widgets work great here.', 'tonic' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Home Page Top Area', 'tonic' ),
		'id' => 'home-page-top-area',
		'description' => __( 'Widgetized area on the home page directly below the navigation menu. Specifically designed for 3 text widgets. Must be turned on in the Layout options on the Theme Options admin page.', 'tonic' ),
		'before_widget' => '<aside id="%1$s" class="home-widget c3 %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="home-widget-title">',
		'after_title' => '</h3>',
	) );
}
endif; // bavotasan_widgets_init

if ( !function_exists( 'bavotasan_pagination' ) ) :
/**
 * Add pagination
 *
 * @uses	paginate_links()
 * @uses	add_query_arg()
 *
 * @since 1.0.0
 */
function bavotasan_pagination() {
	global $wp_query;

	$current = max( 1, get_query_var('paged') );
	$big = 999999999; // need an unlikely integer

	$pagination_return = paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => $current,
		'total' => $wp_query->max_num_pages,
		'next_text' => '&raquo;',
		'prev_text' => '&laquo;'
	) );

	if ( ! empty( $pagination_return ) ) {
		echo '<div id="pagination">';
		echo '<div class="total-pages btn special">';
		printf( __( 'Page %1$s of %2$s', 'tonic' ), $current, $wp_query->max_num_pages );
		echo '</div><div class="btn-group">';
		echo str_replace( array( 'page-numbers', 'current' ), array( 'page-numbers btn', 'disabled' ), $pagination_return );
		echo '</div></div>';
	}
}
endif; // bavotasan_pagination

add_filter( 'wp_title', 'bavotasan_filter_wp_title', 10, 2 );
if ( !function_exists( 'bavotasan_filter_wp_title' ) ) :
/**
 * Filters the page title appropriately depending on the current page
 *
 * @uses	get_bloginfo()
 * @uses	is_home()
 * @uses	is_front_page()
 *
 * @since 1.0.0
 */
function bavotasan_filter_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'tonic' ), max( $paged, $page ) );

	return $title;
}
endif; // bavotasan_filter_wp_title

if ( ! function_exists( 'bavotasan_comment' ) ) :
/**
 * Callback function for comments
 *
 * Referenced via wp_list_comments() in comments.php.
 *
 * @uses	get_avatar()
 * @uses	get_comment_author_link()
 * @uses	get_comment_date()
 * @uses	get_comment_time()
 * @uses	edit_comment_link()
 * @uses	comment_text()
 * @uses	comments_open()
 * @uses	comment_reply_link()
 *
 * @since 1.0.0
 */
function bavotasan_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	switch ( $comment->comment_type ) :
		case '' :
		?>
		<li <?php comment_class(); ?>>
			<div id="comment-<?php comment_ID(); ?>" class="comment-body">
				<div class="comment-avatar">
					<?php echo get_avatar( $comment, 60 ); ?>
				</div>
				<div class="comment-content">
					<div class="comment-author">
						<?php echo get_comment_author_link() . ' '; ?>
					</div>
					<div class="comment-meta">
						<?php
						printf( __( '%1$s at %2$s', 'tonic' ), get_comment_date(), get_comment_time() );
						edit_comment_link( __( '(edit)', 'tonic' ), '  ', '' );
						?>
					</div>
					<div class="comment-text">
						<?php if ( '0' == $comment->comment_approved ) { echo '<em>' . __( 'Your comment is awaiting moderation.', 'tonic' ) . '</em>'; } ?>
						<?php comment_text() ?>
					</div>
					<?php if ( $args['max_depth'] != $depth && comments_open() && 'pingback' != $comment->comment_type ) { ?>
					<div class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</div>
					<?php } ?>
				</div>
			</div>
			<?php
			break;

		case 'pingback'  :
		case 'trackback' :
		?>
		<li id="comment-<?php comment_ID(); ?>" class="pingback">
			<div class="comment-body">
				<?php _e( 'Pingback:', 'tonic' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(edit)', 'tonic' ), ' ' ); ?>
			</div>
			<?php
			break;
	endswitch;
}
endif; // bavotasan_comment

add_filter( 'comment_form_default_fields', 'bavotasan_html5_fields' );
if ( ! function_exists( 'bavotasan_html5_fields' ) ) :
/**
 * Adds HTML5 fields to comment form
 *
 * This function is attached to the 'comment_form_default_fields' filter hook.
 *
 * @param	array $fields
 *
 * @return	Modified comment form fields
 *
 * @since 1.0.0
 */
function bavotasan_html5_fields( $fields ) {
	$fields['author'] = '<p class="comment-form-author"><input id="author" name="author" type="text" required size="30" placeholder="' . __( 'Name', 'tonic' ) . ' *" aria-required="true" /></p>';
	$fields['email'] = '<p class="comment-form-email"><input id="email" name="email" type="email" required size="30" placeholder="' . __( 'Email', 'tonic' ) . ' *" aria-required="true" /></p>';
	$fields['url'] = '<p class="comment-form-url"><input id="url" name="url" type="url" size="30" placeholder="' . __( 'Website', 'tonic' ) . '" /></p>';

	return $fields;
}
endif; // bavotasan_html5_fields

add_filter( 'get_search_form', 'bavotasan_html5_search_form' );
if ( ! function_exists( 'bavotasan_html5_search_form' ) ) :
/**
 * Update default WordPress search form to HTML5 search form
 *
 * This function is attached to the 'get_search_form' filter hook.
 *
 * @param	$form
 *
 * @return	Modified search form
 *
 * @since 1.0.0
 */
function bavotasan_html5_search_form( $form ) {
    return '<form role="search" method="get" id="searchform" class="slide" action="' . home_url( '/' ) . '" >
    <label class="assistive-text" for="site-search">' . __('Search for:', 'tonic') . '</label>
    <input type="search" placeholder="' . __( 'Search&hellip;', 'tonic' ) . '" value="' . get_search_query() . '" name="s" id="site-search" />
    </form>';
}
endif; // bavotasan_html5_search_form

add_filter( 'excerpt_more', 'bavotasan_excerpt' );
if ( ! function_exists( 'bavotasan_excerpt' ) ) :
/**
 * Adds a ellipse to excerpts
 *
 * This function is attached to the 'excerpt_more' filter hook.
 *
 * @param	int $more
 *
 * @return	Custom excerpt ending
 *
 * @since 3.0.0
 */
function bavotasan_excerpt( $more ) {
	return '&hellip;';
}
endif; // bavotasan_excerpt

add_filter( 'wp_trim_excerpt', 'bavotasan_excerpt_more' );
if ( ! function_exists( 'bavotasan_excerpt_more' ) ) :
/**
 * Adds a read more link to all excerpts
 *
 * This function is attached to the 'wp_trim_excerpt' filter hook.
 *
 * @param	string $text
 *
 * @return	Custom read more link
 *
 * @since 3.0.0
 */
function bavotasan_excerpt_more( $text ) {
	$bavotasan_theme_options = bavotasan_theme_options();
	return $text . '<p class="more-link-p"><a class="btn btn-primary" href="' . get_permalink( get_the_ID() ) . '">' . __( 'Read more &rarr;' , 'tonic' ) . '</a></p>';
}
endif; // bavotasan_excerpt_more

add_filter( 'the_content_more_link', 'bavotasan_content_more_link', 10, 2 );
if ( ! function_exists( 'bavotasan_content_more_link' ) ) :
/**
 * Customize read more link for content
 *
 * This function is attached to the 'the_content_more_link' filter hook.
 *
 * @param	string $link
 * @param	string $text
 *
 * @return	Custom read more link
 *
 * @since 3.0.0
 */
function bavotasan_content_more_link( $link, $text ) {
	return '<p class="more-link-p"><a class="btn btn-primary" href="' . get_permalink( get_the_ID() ) . '">' . $text . '</a></p>';
}
endif; // bavotasan_content_more_link

add_filter( 'excerpt_length', 'bavotasan_excerpt_length', 999 );
if ( ! function_exists( 'bavotasan_excerpt_length' ) ) :
/**
 * Custom excerpt length
 *
 * This function is attached to the 'excerpt_length' filter hook.
 *
 * @param	int $length
 *
 * @return	Custom excerpt length
 *
 * @since 3.0.0
 */
function bavotasan_excerpt_length( $length ) {
	return 40;
}
endif; // bavotasan_excerpt_length

/*
 * Remove default gallery styles
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Create the required attributes for the #primary container
 *
 * @since 1.0.0
 */
function bavotasan_primary_attr() {
	$bavotasan_theme_options = bavotasan_theme_options();

	$layout = $bavotasan_theme_options['layout'];
	$column = ( is_bavotasan_full_width() ) ? $bavotasan_theme_options['primary'] : 'c12';
	$class = ( 6 == $layout ) ? $column . ' centered' : $column;
	$style = ( 1 == $layout || 3 == $layout ) ? ' style="float: right;"' : '';

	echo 'class="' . $class . '"' . $style;
}

/**
 * Create the required classes for the #secondary sidebar container
 *
 * @since 1.0.0
 */
function bavotasan_sidebar_class() {
	$bavotasan_theme_options = bavotasan_theme_options();

	$layout = $bavotasan_theme_options['layout'];
	if ( 1 == $layout || 2 == $layout || 6 == $layout ) {
		$end = ( 2 == $layout ) ? ' end' : '';
		$class = str_replace( 'c', '', $bavotasan_theme_options['primary'] );
		$class = 'c' . ( 12 - $class ) . $end;
	} else {
		$class = $bavotasan_theme_options['secondary'];
	}

	echo 'class="' . $class . '"';
}

/**
 * Create the required classes for the #tertiary sidebar container
 *
 * @since 1.0.0
 */
function bavotasan_second_sidebar_class() {
	$bavotasan_theme_options = bavotasan_theme_options();

	$layout = $bavotasan_theme_options['layout'];
	$end = ( 4 == $layout || 5 == $layout ) ? ' end' : '';
	$primary = str_replace( 'c', '', $bavotasan_theme_options['primary'] );
	$secondary = str_replace( 'c', '', $bavotasan_theme_options['secondary'] );
	$class = 'c' . ( 12 - $primary - $secondary ) . $end;

	echo 'class="' . $class . '"';
}

add_filter( 'body_class','bavotasan_custom_body_class' );
/**
 * Adds class if first sidebar located on left side
 *
 * @since Gridiculous Pro 1.0.7
 */
function bavotasan_custom_body_class( $classes ) {
	$bavotasan_theme_options = bavotasan_theme_options();
	$arr = array( 1, 3, 5 );
	if ( in_array( $bavotasan_theme_options['layout'], $arr ) )
		$classes[] = 'left-sidebar';

	return $classes;
}

/**
 * Full width conditional check
 *
 * @since 1.0.0
 *
 * @return	boolean
 */
function is_bavotasan_full_width() {
	$bavotasan_theme_options = bavotasan_theme_options();
	if ( ( $bavotasan_theme_options['home_posts'] && is_front_page() ) || ! is_front_page() ) {
		$single_layout = ( is_singular() ) ? get_post_meta( get_the_ID(), 'bavotasan_single_layout', true ) : '';
		if ( 'on' != $single_layout )
			return true;
	}
}

/**
 * Default menu
 *
 * Referenced via wp_nav_menu() in header.php.
 *
 * @since 1.0.0
 */
function bavotasan_default_menu( $args ) {
	extract( $args );

	$output = wp_list_categories( array(
		'title_li' => '',
		'echo' => 0,
		'number' => 5,
		'depth' => 0,
	) );
	echo "<$container class='$container_class'><ul class='nav'>$output</ul></$container>";
}

/**
 * Add bootstrap classes to menu items
 *
 * @since 1.0.0
 */
class Bavotasan_Page_Navigation_Walker extends Walker_Nav_Menu {
	function check_current( $classes ) {
		return preg_match( '/(current[-_])|active|dropdown/', $classes );
	}

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= "\n<ul class=\"dropdown-menu\">\n";
	}

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$item_html = '';
		parent::start_el( $item_html, $item, $depth, $args );

		if ( $item->is_dropdown && ( $depth === 0 ) ) {
			$item_html = str_replace( '<a', '<a class="dropdown-toggle" data-toggle="dropdown" data-target="#"', $item_html );
			$item_html = str_replace( '</a>', ' <b class="caret"></b></a>', $item_html );
		} elseif ( stristr( $item_html, 'li class="divider' ) ) {
			$item_html = preg_replace( '/<a[^>]*>.*?<\/a>/iU', '', $item_html );
		} elseif ( stristr( $item_html, 'li class="nav-header' ) ) {
			$item_html = preg_replace( '/<a[^>]*>(.*)<\/a>/iU', '$1', $item_html );
		}

		$output .= $item_html;
	}

	function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
		$element->is_dropdown = !empty( $children_elements[$element->ID] );

		if ( $element->is_dropdown ) {
			if ( $depth === 0 ) {
				$element->classes[] = 'dropdown';
			} elseif ( $depth > 0 ) {
				$element->classes[] = 'dropdown-submenu';
			}
		}

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
}

add_filter( 'wp_nav_menu_args', 'bavotasan_nav_menu_args' );
/**
 * Set our new walker only if a menu is assigned and a child theme hasn't modified it to one level deep
 *
 * This function is attached to the 'wp_nav_menu_args' filter hook.
 *
 * @author Kirk Wight <http://kwight.ca/adding-a-sub-menu-indicator-to-parent-menu-items/>
 * @since 1.0.0
 */
function bavotasan_nav_menu_args( $args ) {
    if ( 1 !== $args[ 'depth' ] && has_nav_menu( 'primary' ) )
        $args[ 'walker' ] = new Bavotasan_Page_Navigation_Walker;

    return $args;
}

function bavotasan_bootstrap_carousel() {
	$bavotasan_theme_options = bavotasan_theme_options();
	?>
	<div id="myCarousel" class="c12 carousel slide" data-interval="7500">
		<div class="carousel-inner">
		<div class="item active">
		  <div class="container">
		    <div class="carousel-caption grid <?php echo $bavotasan_theme_options['width']; ?>">
		      <h1>Example headline.</h1>
		      <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
		      <a class="btn btn-large btn-primary" href="#">Sign up today</a>
		    </div>
		  </div>
		</div>
		<div class="item">
		  <div class="container">
		    <div class="carousel-caption grid <?php echo $bavotasan_theme_options['width']; ?>">
		      <h1>Another example headline.</h1>
		      <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
		      <a class="btn btn-large btn-primary" href="#">Learn more</a>
		    </div>
		  </div>
		</div>
		<div class="item">
		  <div class="container">
		    <div class="carousel-caption grid <?php echo $bavotasan_theme_options['width']; ?>">
		      <h1>One more for good measure.</h1>
		      <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
		      <a class="btn btn-large btn-primary" href="#">Browse gallery</a>
		    </div>
		  </div>
		</div>
		</div>
		<a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
		<a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
	</div><!-- /.carousel -->
	<?php
}

/**
 * Create the default widgets that are displayed in the home page top area
 *
 * @since 1.0.0
 */
function bavotasan_home_page_default_widgets() {
	global $paged;
	$bavotasan_theme_options = bavotasan_theme_options();
	if ( $bavotasan_theme_options['home_widget'] && is_front_page() && 2 > $paged ) {
		?>
	<div id="home-page-widgets" class="c12">
		<div class="row">
			<?php if ( ! dynamic_sidebar( 'home-page-top-area' ) ) : ?>

				<?php if ( current_user_can( 'edit_theme_options' ) ) { ?>
					<div class="c12">
						<div class="alert top"><?php printf( __( 'The three boxes below are text widgets that have been added to the <em>Home Page Top Area</em>. Add your own widgets by going to the %sWidgets admin page%s or remove this section completely under the <em>Layout panel</em> on the %sTheme Options page%s.', 'tonic' ), '<a href="' . admin_url( 'widgets.php' ) . '">', '</a>', '<a href="' . admin_url( 'customize.php' ) . '">', '</a>' ); ?></div>
					</div>
				<?php } ?>

				<aside class="home-widget c3 bavotasan_custom_text_widget">
					<img src="<?php echo BAVOTASAN_THEME_URL; ?>/library/images/ex01.jpg" alt="" class="img-circle aligncenter" />
					<h3 class="home-widget-title">Responsive Design</h3>
					<div class="textwidget">
						<p>Resize your browser to see how <strong>Tonic</strong> will adjust for desktops, tablets and handheld devices.</p>
					</div>
				</aside>

				<aside class="home-widget c3 bavotasan_custom_text_widget">
					<img src="<?php echo BAVOTASAN_THEME_URL; ?>/library/images/ex02.jpg" alt="" class="img-circle aligncenter" />
					<h3 class="home-widget-title">Fully Customizable</h3>
					<div class="textwidget">
						<p>Take advantage of the new Theme Options customizer to preview your changes before putting them live.</p>
					</div>
				</aside>

				<aside class="home-widget c3 bavotasan_custom_text_widget">
					<img src="<?php echo BAVOTASAN_THEME_URL; ?>/library/images/ex03.jpg" alt="" class="img-circle aligncenter" />
					<h3 class="home-widget-title">Twitter Bootstrap</h3>
					<div class="textwidget">
						<p>Bootstrap already has tons of great design elements. That's why we included a bunch of them in <strong>Tonic</strong>.</p>
					</div>
				</aside>

				<aside class="home-widget c3 bavotasan_custom_text_widget">
					<img src="<?php echo BAVOTASAN_THEME_URL; ?>/library/images/ex04.jpg" alt="" class="img-circle aligncenter" />
					<h3 class="home-widget-title">Bold Typography</h3>
					<div class="textwidget">
						<p>Readability is key with all sites. Good thing <strong>Tonic</strong> uses some of Google's most popular fonts.</p>
					</div>
				</aside>
			<?php endif; ?>
		</div>
	</div>
	<?php
	}
}

/**
 * Create the jumbo headline section on the home page
 *
 * @since 1.0.0
 */
function bavotasan_jumbotron() {
	$bavotasan_theme_options = bavotasan_theme_options();
	if ( ! empty( $bavotasan_theme_options['jumbo_headline_title'] ) ) {
	?>
	<div class="grid <?php echo $bavotasan_theme_options['width']; ?> row">
		<div class="jumbotron c10 s1">
			<h1><?php echo $bavotasan_theme_options['jumbo_headline_title']; ?></h1>
			<p class="lead"><?php echo $bavotasan_theme_options['jumbo_headline_text']; ?></p>
			<?php if ( ! empty( $bavotasan_theme_options['jumbo_headline_button_text'] ) ) { ?>
			<a class="btn btn-large btn-primary" href="<?php echo $bavotasan_theme_options['jumbo_headline_button_link']; ?>"><?php echo $bavotasan_theme_options['jumbo_headline_button_text']; ?></a>
			<?php } ?>
		</div>
	</div>
	<?php
	}
}