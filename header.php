<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Potencio el fuego que hay en ti y en tu marca">
	<meta name="author" content="Lizeth Alvam">
	<meta name="keywords" content="Branding, Diseño web, Marketing, Fotografia video, UGC">
	<?php wp_head(); ?>
	
	<!-- <link rel="icon" type="image/x-icon" href="http://lizethalvam.com/wp-content/uploads/2024/04/L1-1.png">
	
	<meta property="og:title" content="lizethalvam">
	<meta property="og:description" content="Potencio el fuego que hay en ti y en tu marca">
	<meta property="og:image" content="http://lizethalvam.com/wp-content/uploads/2024/03/L2.png">
	<meta property="og:url" content="https://lizethalvam.com/"> -->
	
	

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<link rel="stylesheet" href="<?= get_template_directory_uri() ?>/style.css">

	<!--  -->
	<script>
		let URL_BASE = `<?= get_site_url() ?>`
		const IP_CLIENT = `<?= $_SERVER['REMOTE_ADDR'] ?>`
		const URL_DIRECTORY = `<?= get_template_directory_uri()  ?>`
	</script>

</head>

<body <?php body_class(); ?>>
	<?php 
	
// 	if(isset($_GET["test"])){
		
// 		$test = $_GET["test"];
// 	}
	
	wp_body_open(); 
		
	?>

<!-- 	<header id="header" style="display:<?= !isset($test) ? 'none' : 'flex' ?>" > -->
<header class="aylluweb__header">
    <div class="contenedor aylluweb__header-contenedor">
        
        <div class="aylluweb__header-logo">
            <a href="<?= esc_url(home_url('/')); ?>">
                <img src="<?= get_template_directory_uri() ?>/assets/logo_ayllu.png" alt="Ayllu Eventos y Catering" class="aylluweb__header-logo-img aylluweb__header-logo-img--normal">
                <img src="<?= get_template_directory_uri() ?>/assets/logo_ayllu.png" alt="Ayllu Eventos y Catering" class="aylluweb__header-logo-img aylluweb__header-logo-img--scroll">
            </a>
        </div>

        <input type="checkbox" id="aylluweb__menu-checkbox" class="aylluweb__header-checkbox" onchange="handleChangeInputCheckbox(event)">
        <label for="aylluweb__menu-checkbox" class="aylluweb__header-hamburger">
            <i class="fa fa-bars" aria-hidden="true"></i>
        </label>

        <nav class="aylluweb__header-nav">
            <?php
            // wp_nav_menu(array(
            //     'theme_location' => 'principal',
            //     'container'      => false,
            //     'menu_class'     => 'aylluweb__header-menu-list',
            //     'fallback_cb'    => '__return_false'
            // ));
							wp_nav_menu(
				array(
					'menu'  => 'principal',
					'items_wrap'      => '<ul id="primary-menu-list" class="%2$s">%3$s</ul>',
					'fallback_cb'     => false,
					'menu_class'     => 'aylluweb__header-menu-list',
				)
			);
            ?>
        </nav>

    </div>
</header>