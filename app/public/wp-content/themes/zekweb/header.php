<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">

<head>
	<meta charset="UTF-8">
	<title><?php wp_title('|', true, 'right'); ?></title>
	<?php wp_head(); ?>

	<?php if (get_option('origin-favicon')) { ?>
		<link rel="shortcut icon" href="<?php echo get_option('origin-favicon'); ?>" type="image/x-icon">
	<?php } ?>

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">

	<!-- Nhúng CSS đã build từ Vite (tự động lấy file hash) -->
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/dist/main.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/dist/style.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css?v=<?php echo time(); ?>">

	<!-- Nhúng JS đã build từ Vite (tự động lấy file hash) -->
	<?php
	$jsFiles = glob(get_template_directory() . '/dist/assets/main-*.js');
	if ($jsFiles) {
		$jsFile = str_replace(get_template_directory(), get_template_directory_uri(), $jsFiles[0]);
		echo '<script src="' . $jsFile . '?v=' . time() . '" defer></script>';
	}
	?>

	<?php
	$value = get_field('code_header', 'option');
	echo $value;
	?>
</head>

<body <?php body_class(); ?>>
	<?php
	$value = get_field('code_body', 'option');
	echo $value;
	?>

	<div id="zek-web">
		<div class="line-dark"></div>

		<header id="header">
			<?php if (is_home() || is_front_page()) { ?>
				<h1 class="site-name" style="display: none;"><?php bloginfo('title'); ?></h1>
			<?php } ?>

			<!-- Navbar -->
			<nav>
				<div class="container">
					<div class="row align-items-center">
						<div class="col-lg-3 col-12">
							<a href="<?php echo esc_url(home_url()); ?>" title="<?php bloginfo('title'); ?>">
								<img src="<?php the_field('logo', 'option') ?>" alt="<?php bloginfo('title'); ?>"
									class="img-logo" />
							</a>
							<div class="bars-mobile d-lg-none">
								<i class="fal fa-bars"></i>
							</div>
						</div>
						<div class="col-lg-9 col-12 d-none d-md-block">
							<?php wp_nav_menu(array('container' => '', 'theme_location' => 'main', 'menu_class' => 'menu')); ?>
						</div>
					</div>
				</div>
			</nav>

			<!-- Banner -->
		</header>

		<!-- Menu mobile -->
		<?php wp_nav_menu(array('container' => '', 'theme_location' => 'main', 'menu_class' => 'menu')); ?>