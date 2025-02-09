<?php
get_header();

global $wp_query;

// Banners exibidos entre o conteudo da página no Mobile
$banners = array();

if (has_category('vagas-de-empregos')) {
	$post_type = "banners_vagas";
} else if ((strpos($_SERVER['REQUEST_URI'], 'obituario') !== false) || (is_single() && has_category('obituario-porto-ferreira'))) {
	$post_type = "banners_obituario";
} else if ((strpos($_SERVER['REQUEST_URI'], 'eventos') !== false) || (is_single() && has_category('eventos'))) {
	$post_type = "banners_eventos";
} else if ((strpos($_SERVER['REQUEST_URI'], 'saude') !== false) || (is_single() && has_category('saude'))) {
	$post_type = "banners_saude";
} else {
	$post_type = "banners";
}

$banner_query = new WP_Query(array(
	'post_type' => $post_type,
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'meta_key' => 'ativo',
	'meta_value' => '0',
	'meta_compare' => '!=',
));

if ($banner_query->have_posts()) {
	while ($banner_query->have_posts()) {
		$banner_query->the_post();
		$custom = array(
			'titulo' => get_the_title(),
			'imagem' => get_field("imagem"),
			'link' => get_field("link"),
			'exibir_ate' => get_field("exibir_ate"),
		);

		if (!$custom["exibir_ate"]) {
			array_push($banners, $custom);
		}

		$custom_date_string = $custom["exibir_ate"];
		$custom_date = DateTime::createFromFormat('d/m/Y', $custom_date_string);

		if ($custom_date && $custom_date >= new DateTime()) {
			array_push($banners, $custom);
		}
	}
	wp_reset_postdata();
}
?>

<div class="l-page" id='content'>
	<header class="l-page__content" style="padding-top:40px">
		<div class="l-posts__header">
			<h1 class="l-posts__title"><?= str_replace('Categoria: ', '', get_the_archive_title()) ?></h1>
		</div>
	</header>

	<?php

	// Slides (Banners Rotativos)
	if (strpos($_SERVER['REQUEST_URI'], 'obituario') !== false) {
		echo slides_obituario_shortcode();
	} else if (strpos($_SERVER['REQUEST_URI'], 'eventos') !== false) {
		echo slides_eventos_shortcode();
	} else if (strpos($_SERVER['REQUEST_URI'], 'saude') !== false) {
		echo slides_saude_shortcode();
	}
	?>
</div>

<div class="l-page__main">
	<main class="l-page__posts l-page__archive">
		<h2 class="screen-readers-only">Todas as notícias</h2>
		<?php
		$paged = get_query_var('paged', 1);
		$post_counter = 1;
		$banner_counter = 0;

		if (have_posts()) :
			while (have_posts()) :
				the_post();
				$categories = get_the_category();
				$parent_category_id = null;
				if (empty($categories[1])) {
					$category_id = $categories[0]->term_id;
				} else {
					$category_id = $categories[1]->term_id;
					$parent_category_id = $categories[0]->term_id;
				}
				$post = array(
					'titulo' => resume_text(get_the_title(), 80),
					'imagem' => get_the_post_thumbnail_url(),
					'video' => get_field('video_youtube'),
					'data' => get_the_date(),
					'descricao' => has_category('obituario-porto-ferreira') ? apply_filters('the_content', get_the_content()) : get_the_excerpt(),
					'categoria' => array(get_cat_name($category_id), get_category_link($category_id)),
					'categoria_pai' => isset($parent_category_id) ? get_cat_name($parent_category_id) : "",
					'categoria_pai_link' => isset($parent_category_id) ? get_category_link($parent_category_id) : "",
					'link' => get_permalink(),
					'comentarios' => get_comments_number()
				);
				echo theme_post_template($post);

				if ($post_counter % 2 == 0) {
					if (isset($banners[$banner_counter])) {
						echo theme_banner_template($banners[$banner_counter]);
						$banner_counter++;
					}
				}
				$post_counter++;

			endwhile;
		?>
			<div class="c-pagination">
				<?php
				theme_custom_pagination();
				?>
			</div>

		<?php
		else : ?>
			<div class="c-trigger">
				<p>Desculpe, nenhum post foi encontrado.</p>
			</div>
		<?php endif; ?>
	</main>
	<?php include "template-parts/sidebar.php" ?>
</div>

</div>

<?php
get_footer();
