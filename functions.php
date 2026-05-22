<?php
// añadir imagen destacada en nuestros pots
add_theme_support('post-thumbnails');
add_theme_support('menus');
add_theme_support('title-tag');


// formulario de envios
function register_routes()
{

	// register_rest_route('st/v1/', 'registrar-contacto', array(
	// 	'methods'  => 'POST',
	// 	'callback' => 'registrar_contacto',
	// ));

	// register_rest_route('st/v1/', 'registrar-contacto-home', array(
	// 	'methods'  => 'POST',
	// 	'callback' => 'registrar_contacto_home',
	// ));
}


add_action('rest_api_init', 'register_routes');


// activamos la paginacion de paginas categorias
function paginated_category($query)
{
	if (!is_admin() && $query->is_main_query()) {
		if ($query->is_category()) {
			$query->set('posts_per_page', 6);
		}
	}
}
add_action('pre_get_posts', 'paginated_category');