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
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/swiper-bundle.min.css">
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/select2.min.css">
  <!-- <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/aos.css"> -->
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/fancybox.css">
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/dist/style.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css?v=<?php echo time(); ?>">
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
			<div class="container">
				<?php
				if (is_home() || is_front_page()) :
					echo '<h1 class="site-name" style="display: none;">' . get_bloginfo('name') . '</h1>';
				endif;
				?>

				<div class="header-inner">
					<!-- Navbar -->
					<nav class="d-none d-lg-block pc-menu">
            <?php 
						wp_nav_menu(array(
							'container' => '', 
							'theme_location' => 'main', 
							'menu_class' => 'menu',
							'walker' => new Menu_Middle_Logo()
						)); 
						?>
					</nav>

					<!-- Menu mobile -->
					<div class="menu-mobile">
						<div id="touch-menu" class="touch-menu d-block d-lg-none"></div>
					</div>

					<!-- Logo mobile -->
					<a href="<?php echo home_url(); ?>" class="d-lg-none menu-logo menu-logo-mobile">
						<img src="<?php echo get_field('logo', 'option'); ?>" alt="<?php echo get_bloginfo('name'); ?>">
					</a>

					<!-- Ext menu -->
					<div class="ext-menu">
						<div class="ext-menu-inner">
							<div class="search">
								<button data-bs-toggle="modal" data-bs-target="#search-modal">
									<img src="<?php bloginfo('template_url'); ?>/images/search.png" alt="Search">
								</button>
							</div>
							
							<div class="cart">
								<!-- Cart -->
								<a href="<?php echo wc_get_cart_url(); ?>" class="cart-btn">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/></svg>
									<span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>

		<!-- Menu mobile -->
		<div id="menu-mobile">
			<div class="close" id="close-menu"></div>
			<?php wp_nav_menu(array('container' => '', 'theme_location' => 'main', 'menu_class' => 'menu')); ?>
		</div>

		<!-- Search modal -->
		<div class="modal fade" id="search-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="search-form">
						<div class="input-search">
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							<form role="search" method="get" autocomplete="off" class="woocommerce-product-search" action="<?php echo esc_url(home_url('/')); ?>">
								<label class="screen-reader-text" for="woocommerce-product-search-field-<?php echo isset($index) ? absint($index) : 0; ?>"><?php esc_html_e('Search for:', 'woocommerce'); ?></label>
								<input type="search" id="woocommerce-product-search-field-<?php echo isset($index) ? absint($index) : 0; ?>" class="search-input" placeholder="<?php echo esc_attr__('Nhập tìm kiếm&hellip;', 'woocommerce'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
								<button type="submit" value="<?php echo esc_attr_x('Search', 'submit button', 'woocommerce'); ?>" class="search-submit">
									<img src="<?php bloginfo('template_url'); ?>/images/search.png" alt="Search">
								</button>
								<input type="hidden" name="post_type" value="producdivt" />
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>