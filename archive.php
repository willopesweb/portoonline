<?php
get_header();

global $wp_query;

// Banners exibidos entre o conteudo da página no Mobile
$banners = array();

$banner_query = new WP_Query(array(
	'post_type' => 'banners',
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'meta_query' => array(
		'relation' => 'AND', // Garante que ambas as condições sejam atendidas
		array(
			'key' => 'obituario',
			'value' => (strpos($_SERVER['REQUEST_URI'], 'obituario') !== false) ? '1' : '0',
			'compare' => '='
		),
		array(
			'key' => 'eventos',
			'value' => (strpos($_SERVER['REQUEST_URI'], 'eventos') !== false) ? '1' : '0',
			'compare' => '='
		),
		array(
			'key' => 'ativo',
			'value' => '1',
			'compare' => '='
		)
	)
));

if ($banner_query->have_posts()) {
	while ($banner_query->have_posts()) {
		$banner_query->the_post();
		$custom = array(
			'titulo' => get_the_title(),
			'imagem' => get_field("imagem"),
			'imagem_mobile' => get_field("imagem_mobile"),
			'link' => get_field("link"),
		);
		array_push($banners, $custom);
	}
	wp_reset_postdata(); // Restaurar os dados originais do post global do WordPress
}
?>

<div class="l-page" id='content'>
	<header class="l-page__content" style="padding-top:40px">
		<div class="l-posts__header">
			<h1 class="l-posts__title"><?= str_replace('Categoria: ', '', get_the_archive_title()) ?></h1>
		</div>
	</header>

	<?php
	// Slide com Banners
	if (strpos($_SERVER['REQUEST_URI'], 'obituario') !== false) {
		$banner_query = new WP_Query(array(
			'post_type' => 'banners_obituario',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'orderby' => 'rand',
			'meta_key' => 'ativo',     // Adiciona a chave do campo personalizado
			'meta_value' => '0',           // Define o valor para buscar (true)
			'meta_compare' => '!=',
		));

		if ($banner_query->have_posts()) {
			echo '<div class="l-page__content c-carousel js-main-carousel splide">';
			echo '<div class="splide__track"><ul class="splide__list">';
			while ($banner_query->have_posts()) {
				$banner_query->the_post();
				$custom = array(
					'titulo' => get_the_title(),
					'imagem' => get_field("imagem"),
					'imagem_mobile' => get_field("imagem_mobile"),
					'link' => get_field("link"),
				);
				echo theme_slides_template($custom);
			}
			echo '</ul></div>';
			echo '</div>';
			wp_reset_postdata(); // Restaurar os dados originais do post global do WordPress
		}
	} else if (strpos($_SERVER['REQUEST_URI'], 'eventos') !== false) {
		$banner_query = new WP_Query(array(
			'post_type' => 'banners_eventos',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'orderby' => 'rand',
			'meta_key' => 'ativo',     // Adiciona a chave do campo personalizado
			'meta_value' => '0',           // Define o valor para buscar (true)
			'meta_compare' => '!=',
		));

		if ($banner_query->have_posts()) {
			echo '<div class="l-page__content c-carousel js-main-carousel splide">';
			echo '<div class="splide__track"><ul class="splide__list">';
			while ($banner_query->have_posts()) {
				$banner_query->the_post();
				$custom = array(
					'titulo' => get_the_title(),
					'imagem' => get_field("imagem"),
					'imagem_mobile' => get_field("imagem_mobile"),
					'link' => get_field("link"),
				);
				echo theme_slides_template($custom);
			}
			echo '</ul></div>';
			echo '</div>';
			wp_reset_postdata(); // Restaurar os dados originais do post global do WordPress
		}
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
					'titulo' => adicionar_elipse(get_the_title(), 80),
					'imagem' => get_the_post_thumbnail_url(),
					'data' => get_the_date(),
					'descricao' => get_the_excerpt(),
					'categoria' => array(get_cat_name($category_id), get_category_link($category_id)),
					'categoria_pai' => isset($parent_category_id) ? get_cat_name($parent_category_id) : "",
					'categoria_pai_link' => isset($parent_category_id) ? get_category_link($parent_category_id) : "",
					'link' => get_permalink(),
					'comentarios' => get_comments_number()
				);
				echo theme_post_template($post);

				if ($post_counter % 2 == 0) {
					// Exibir o post do tipo "Banner" aqui
					if (isset($banners[$banner_counter])) {
						echo banners_html($banners[$banner_counter]);
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
