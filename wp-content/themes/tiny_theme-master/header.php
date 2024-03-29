<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
    <title><?php wp_title(' - ', true, 'left'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="author" content="<?php bloginfo('name'); ?>">
	
    <!-- styles -->
    <link href="<?php echo get_template_directory_uri() ?>/stylesheet/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri() ?>/stylesheet/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri() ?>/stylesheet/fonts/MyFontsWebfontsKit.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/stylesheet/custom.css" />
   
    <?php //load theme style if it's not default
    $style = get_option('tiny_style');
    if($style != 'default'): ?>
    <link href="<?php echo get_template_directory_uri() ?>/stylesheet/colors/<?php echo $style ?>.css" rel="stylesheet">
    <?php endif; ?>
     
    <link href='http://fonts.googleapis.com/css?family=Noto+Sans:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
    <!--[if IE 7]>
		<link href="<?php echo get_template_directory_uri() ?>/stylesheet/font-awesome-ie7.min.css" rel="stylesheet">
	<![endif]-->
	
    <script src="<?php echo get_template_directory_uri() ?>/javascript/jquery-1.9.1.min.js"></script>
    <script src="<?php echo get_template_directory_uri() ?>/javascript/bootstrap.min.js"></script>
	<script src="<?php echo get_template_directory_uri() ?>/javascript/jquery.validate.min.js"></script>
    <script src="<?php echo get_template_directory_uri() ?>/javascript/mobile.detect.js"></script>
    <script src="<?php echo get_template_directory_uri() ?>/javascript/custom.js"></script>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<?php //comments_popup_script(); // off by default ?>

    <?php  wp_head() ?>
</head>
<body <?php body_class($class); ?>>
	<div id="top">
		<div class="container-fluid">
			<?php $logo_url = esc_url(get_option('logo')); ?>
			<a href="<?php echo home_url() ?>" class="logo">
				<?php if(!$logo_url): ?>
				<?php bloginfo('name'); ?>
				<?php else: ?>
				<img src="<?php echo $logo_url ?>" />
				<?php endif; ?>
			</a>
			<a href="#" class="menu-btn" data-placement="left" title="Main Menu">
				<i class="icon-reorder"></i>
			</a>
			<a href="http://app.wisdom.is/wiseboard" class="login-btn" >
				Login
			</a>
		</div>
	</div>
	<nav id="main-menu">
		<div class="container">
			 <?php echo wp_nav_menu( array( 'theme_location' => 'main-menu') ); ?>
			 <?php get_sidebar() ?>
		</div>
		
	</nav>
	<section id="content">