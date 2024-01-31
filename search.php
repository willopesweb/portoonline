<?php
get_header();
global $wp_query;
?>
<div class="l-page" id='content'>
	<header class="l-page__header">
		<?php
		if ($wp_query->found_posts == 0) {
			echo '<h1 class="l-page____title"> Nenhum resultado encontrado para "' . get_search_query() . '"</h1>';
			echo '<p class=s"l-page__subtitle">Tente refazer a pesquisa usando outros termos</p>';
		} else {
			echo '<div class="l-posts__header"><h1 class="l-posts__title">' . $wp_query->found_posts . ' resultados para "' . get_search_query() . '"</h1></div>';
		}
		?>
	</header>

	<div class="l-page__main">
		<main class="l-page__posts l-page__archive">
			<h2 class="screen-readers-only">Todas as notícias</h2>
			<?php
			$paged = get_query_var('paged', 1);
			$s = get_search_query();

			$args = array(
				's' => $s,
				'post_type' => 'post',
				'posts_per_page' => '10',
				'order' => 'DESC',
				'paged' => $paged,
				'orderby' => 'date',
			);

			$query = new WP_Query($args); //Create our new custom query

			if ($query->have_posts()) :
				while ($query->have_posts()) :
					$query->the_post();
					$content = get_the_content();
					$content = preg_replace('/<strong[^>]*>(.*?)<\/strong>/i', '$1', $content);
					$categories = get_the_category();
					$category_name = '';
					$category_link = '';
					$parent_category_id = null;
					$parent_category = array('', '');
					if (!empty($categories) && isset($categories[0]) && is_object($categories[0])) {
						$category_name = $categories[0]->name;
						$category_link = get_category_link($categories[0]->term_id);
						$category_ancestors = get_ancestors($categories[0]->term_id, 'category');
						if (!empty($category_ancestors)) {
							$parent_category_id = $category_ancestors[count($category_ancestors) - 1];
						}
					}
					$post = array(
						'titulo' => adicionar_elipse(get_the_title(), 80),
						'imagem' => get_the_post_thumbnail_url(),
						'data' => get_the_date(),
						'descricao' => get_the_excerpt(),
						'categoria' => array($category_name, $category_link),
						'categoria_pai' => isset($parent_category_id) ? get_cat_name($parent_category_id) : "",
						'categoria_pai_link' => isset($parent_category_id) ? get_category_link($parent_category_id) : "",
						'link' => get_permalink(),
						'comentarios' => get_comments_number()
					);
					echo theme_post_template($post);
				endwhile;

				// Adicionar verificação para redirecionamento quando há apenas um resultado
				if ($query->post_count == 1) {
					echo '<script>window.location.href = "' . get_permalink($query->posts[0]->ID) . '";</script>';
				}

			?>
				<div class="c-pagination">
					<?php
					theme_custom_pagination($query);
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
