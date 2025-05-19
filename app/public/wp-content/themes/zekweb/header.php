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

	<!-- Nhúng CSS -->
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/dist/main.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/dist/style.css?v=<?php echo time(); ?>">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style.css?v=<?php echo time(); ?>">
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

	<!-- Nhúng JS -->
	<?php
	$jsFiles = glob(get_template_directory() . '/dist/assets/main-*.js');
	if ($jsFiles) {
		$jsFile = str_replace(get_template_directory(), get_template_directory_uri(), $jsFiles[0]);
		echo '<script type="module" src="' . $jsFile . '?v=' . time() . '" defer></script>';
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

		<!-- <header id="header" class="is-fixed"> -->
		<header id="header" class="<?php echo is_home() || is_front_page() ? 'is-fixed' : ''; ?>">
			<div class="container">
				<?php
				if (is_home() || is_front_page()) :
					echo '<h1 class="site-name" style="display: none;">' . get_bloginfo('name') . '</h1>';
				endif;
				?>

				<div class="header-inner">
					<!-- Navbar -->
					<nav class="d-none d-lg-block pc-menu">
						<?php wp_nav_menu(array('container' => '', 'theme_location' => 'main', 'menu_class' => 'menu')); ?>
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
									<img src="<?php bloginfo('template_url'); ?>/assets/images/search.png" alt="Search">
								</button>
							</div>
							
							<div class="cart">
								<!-- Cart -->
								<a href="<?php echo wc_get_cart_url(); ?>" class="cart-btn">
									<i class="fa-solid fa-cart-shopping"></i>
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
									<img src="<?php bloginfo('template_url'); ?>/assets/images/search.png" alt="Search">
								</button>
								<input type="hidden" name="post_type" value="producdivt" />
							</form>

              <!-- <form role="search" autocomplete="off" action="<?php echo home_url('/'); ?>" method="get">
                <input type="text" name="s" class="search-input" placeholder="Tìm từ khóa bạn mong muốn ...">
                <button type="submit" class="submit-input">
                  <img src="<?php bloginfo('template_url'); ?>/images/icon_search.png" alt="icon">
                </button>
              </form> -->
						</div>
					</div>
				</div>
			</div>
		</div>