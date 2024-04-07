<?php

get_header();


// Evita que categorias de produtos e serviços apareçam como notícias
/* $exclude_categories = array();
$produtos_category = get_category_by_slug('produtos-servicos');
if ($produtos_category) {
	$exclude_categories[] = $produtos_category->term_id;


	$subcategories = get_categories(array('parent' => $produtos_category->term_id));
	foreach ($subcategories as $subcategory) {
		$exclude_categories[] = $subcategory->name;
	}
} */

// Banners exibidos entre o conteudo da página no Mobile
$banners = array();
$banner_query = new WP_Query(array(
	'post_type' => 'banners',
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
<section class="l-page">
	<div class="l-page-home__posts">
		<div class="l-page-home__slides js-news-carousel splide">
			<div class="splide__track">
				<ul class="splide__list">
					<?php
					$args = array(
						'post_type' => 'post',
						'post_status' => 'publish',
						'posts_per_page' => 4,
						//'category__not_in' => $exclude_categories,
						'order' => 'DESC',
					);
					$html = '';
					$query = new WP_Query($args);
					if ($query->have_posts()) {
						$i = 1;
						while ($query->have_posts()) {
							$query->the_post();
							$categories = get_the_category();
							$parent_category_id = null;
							$parent_category = array('', '');
							if (!empty($categories)) {
								$category_ancestors = get_ancestors($categories[0]->term_id, 'category');
								if (!empty($category_ancestors)) {
									$parent_category_id = $category_ancestors[count($category_ancestors) - 1];
								}
							}
							$post = array(
								'titulo' => get_the_title(),
								'imagem' => get_the_post_thumbnail_url(),
								'data' => get_the_date(),
								'categoria' => array(get_the_category()[0]->name, get_category_link(get_the_category()[0]->term_id)),
								'categoria_pai' => isset($parent_category_id) ? get_cat_name($parent_category_id) : "",
								'categoria_pai_link' => isset($parent_category_id) ? get_category_link($parent_category_id) : "",
								'link' => get_permalink(),
								'comentarios' => get_comments_number()
							);

							$html = "";

							$html .= '<li class="splide__slide"><article class="c-post">';
							$html .= '<a class="c-post__image" href="' . $post['link'] . '" title="' . $post['titulo'] . '">';
							$html .= '<img loading="lazy" width="530" height="300" src="' . $post['imagem'] . '" alt="' . $post['titulo'] . '" />';
							$html .= '</a>';
							$html .= '<header class="c-post__header">';
							$html .= '<ul class="c-post__categories">';
							if ($post['categoria']) {
								$html .= '<li class="c-post__category"><a href="' . $post['categoria'][1] . '" title="' . $post['categoria'][0] . '">' . $post['categoria'][0] . '</a></li>';
							}
							if ($post['categoria_pai'] !== "" && $post['categoria_pai_link'] !== "") {
								$html .= '<li class="c-post__category"><a href="' . $post['categoria_pai_link'] . '" title="' . $post['categoria_pai'] . '">' . $post['categoria_pai'] . '</a></li>';
							}
							$html .= '</ul>';
							$html .= '<h2 class="c-post__title"><a href="' . $post['link'] . '" title="' . $post['titulo'] . '">' . $post['titulo'] . '</a></h2>';
							$html .= '<div class="c-post__info">';
							if ($post['data']) {
								$html .= '<p class="c-post__data">' . $post['data'] . '</p>';
							}
							if (isset($post['comentarios'])) {
								$html .= '<a href="' . $post['link'] . '#respond" title="Ver comentários" class="c-post__comentarios">' . $post['comentarios'] . " " . ($post['comentarios'] === 1 ? "Comentário" : "Comentários") . '</a>';
							}
							$html .= "</div>";
							$html .= '</header>';
							$html .= '</article></li>';

							echo $html;
						}
					}
					wp_reset_postdata();

					?>
				</ul>
			</div>
		</div>
		<div class="l-page-home__recents">
			<?php

			$args = array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'posts_per_page' => 4,
				'order' => 'DESC',
				//'category__not_in' => $exclude_categories,
			);
			theme_get_posts($args);
			?>
		</div>
	</div>
</section>
<div class="l-page__main-home ">
	<main id="content" class="l-page__posts">
		<section class="l-posts">
			<header class="l-posts__header">
				<h2 class="l-posts__title">Fotos de Eventos</h2>
			</header>
			<div class="l-posts__content l-posts__content--two-columns">
				<?php
				$args = array(
					'post_type' => 'post',
					'post_status' => 'publish',
					'posts_per_page' => 4,
					'order' => 'DESC',
					'category_name' => "eventos"
				);
				theme_get_posts($args);
				?>
			</div>
			<footer class="l-posts__footer">
				<a href="<?= get_site_url() ?>/categoria/eventos/" class="c-button">Ver Mais</a>
			</footer>
		</section>

		<?php
		//Banners mobile
		if (count($banners) > 0) {
			echo '<div class="l-page-home__banners-mobile">';
			echo theme_banner_template($banners[0]);
			echo theme_banner_template($banners[1]);
			echo "</div>";
		}
		?>

		<?php
		$args = array(
			'post_type' => 'banners_home',
			'post_status' => 'publish',
			'posts_per_page' => 1,
			'order' => 'DESC',
		);
		$html = '';
		$query = new WP_Query($args);
		if ($query->have_posts()) {
			$i = 1;
			while ($query->have_posts()) {
				$query->the_post();
				$custom = array(
					'titulo' => get_the_title(),
					'imagem' => get_field("imagem"),
					'link' => get_field("link"),
				);

				if ($custom["link"]) {
					$html .= '<a target="_blank" rel="nofollow" href="' . $custom['link'] . '" title="' . $custom['titulo'] . '" class="l-page-home__banner">';
				} else {
					$html .= '<article class="l-page-home__banner">';
					$html .= '<h3 class="screen-readers-only">' . $custom['titulo'] . '</h3>';
				}

				$html .= '<img loading="lazy" width="1000" height="100" src="' . $custom['imagem'] . '" alt="' . $custom['titulo'] . '"/>';

				if ($custom["link"]) {
					$html .= '</a>';
				} else {
					$html .= '</article>';
				}
			}
		}
		wp_reset_postdata();
		echo $html;
		?>

		<section class="l-posts">
			<header class="l-posts__header">
				<h2 class="l-posts__title">Obituário Ferreirense</h2>
			</header>
			<div class="l-posts__content l-posts__content--two-columns">
				<?php
				$args = array(
					'post_type' => 'post',
					'post_status' => 'publish',
					'posts_per_page' => 4,
					'order' => 'DESC',
					'category_name' => "obituario-porto-ferreira"
				);
				theme_get_posts($args);
				?>
			</div>
			<footer class="l-posts__footer">
				<a href="<?= get_site_url() ?>/categoria/obituario-porto-ferreira/" class="c-button">Ver Mais</a>
			</footer>
		</section>

		<?php
		//Banners mobile
		if (count($banners) > 0) {
			echo '<div class="l-page-home__banners-mobile">';
			echo theme_banner_template($banners[2]);
			echo theme_banner_template($banners[3]);
			echo "</div>";
		}
		?>

		<?php
		$args = array(
			'post_type' => 'banners_home',
			'post_status' => 'publish',
			'posts_per_page' => 1,
			'offset' => 2,
			'order' => 'DESC',
		);
		$html = '';
		$query = new WP_Query($args);
		if ($query->have_posts()) {
			$i = 1;
			while ($query->have_posts()) {
				$query->the_post();
				$custom = array(
					'titulo' => get_the_title(),
					'imagem' => get_field("imagem"),
					'link' => get_field("link"),
				);

				if ($custom["link"]) {
					$html .= '<a target="_blank" rel="nofollow" href="' . $custom['link'] . '" title="' . $custom['titulo'] . '" class="l-page-home__banner">';
				} else {
					$html .= '<article class="l-page-home__banner">';
					$html .= '<h3 class="screen-readers-only">' . $custom['titulo'] . '</h3>';
				}

				$html .= '<img loading="lazy" width="1000" height="100" src="' . $custom['imagem'] . '" alt="' . $custom['titulo'] . '"/>';

				if ($custom["link"]) {
					$html .= '</a>';
				} else {
					$html .= '</article>';
				}
			}
		}
		wp_reset_postdata();
		echo $html;
		?>

		<section class="l-posts">
			<header class="l-posts__header">
				<h2 class="l-posts__title">Policial</h2>
			</header>
			<div class="l-posts__content l-posts__content--two-columns">
				<?php
				$args = array(
					'post_type' => 'post',
					'post_status' => 'publish',
					'posts_per_page' => 4,
					'order' => 'DESC',
					'category_name' => "policial"
				);
				theme_get_posts($args);
				?>
			</div>

			<footer class="l-posts__footer">
				<a href="<?= get_site_url() ?>/categoria/noticias/policial/" class="c-button">Ver Mais</a>
			</footer>
		</section>

		<?php
		//Banners mobile
		if (count($banners) > 0) {
			echo '<div class="l-page-home__banners-mobile">';
			echo theme_banner_template($banners[4]);
			echo theme_banner_template($banners[5]);
			echo "</div>";
		}
		?>

		<section class="l-posts">
			<header class="l-posts__header">
				<h2 class="l-posts__title">Porto Ferreira</h2>
			</header>
			<div class="l-posts__content l-posts__content--two-columns">
				<?php
				$args = array(
					'post_type' => 'post',
					'post_status' => 'publish',
					'posts_per_page' => 4,
					'order' => 'DESC',
					'category_name' => "porto-ferreira",
					'category__not_in' => array(get_category_by_slug('policial')->term_id)
				);
				theme_get_posts($args);
				?>
			</div>
			<footer class="l-posts__footer">
				<a href="<?= get_site_url() ?>/categoria/noticias/porto-ferreira/" class="c-button">Ver Mais</a>
			</footer>
		</section>

		<?php
		//Banners mobile
		if (count($banners) > 0) {
			echo '<div class="l-page-home__banners-mobile">';
			echo theme_banner_template($banners[6]);
			echo theme_banner_template($banners[7]);
			echo "</div>";
			echo '<div class="l-page-home__banners-mobile">';
			echo theme_banner_template($banners[8]);
			echo theme_banner_template($banners[9]);
			echo "</div>";
		}
		?>

		<?php
		$args = array(
			'post_type' => 'banners_home',
			'post_status' => 'publish',
			'posts_per_page' => 1,
			'offset' => 3,
			'order' => 'DESC',
		);
		$html = '';
		$query = new WP_Query($args);
		if ($query->have_posts()) {
			$i = 1;
			while ($query->have_posts()) {
				$query->the_post();
				$custom = array(
					'titulo' => get_the_title(),
					'imagem' => get_field("imagem"),
					'link' => get_field("link"),
				);

				if ($custom["link"]) {
					$html .= '<a target="_blank" rel="nofollow" href="' . $custom['link'] . '" title="' . $custom['titulo'] . '" class="l-page-home__banner">';
				} else {
					$html .= '<article class="l-page-home__banner">';
					$html .= '<h3 class="screen-readers-only">' . $custom['titulo'] . '</h3>';
				}

				$html .= '<img loading="lazy" width="1000" height="100" src="' . $custom['imagem'] . '" alt="' . $custom['titulo'] . '"/>';

				if ($custom["link"]) {
					$html .= '</a>';
				} else {
					$html .= '</article>';
				}
			}
		}
		wp_reset_postdata();
		echo $html;
		?>

		<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7379900084732959" crossorigin="anonymous"></script>
		<!-- Home -->
		<ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-7379900084732959" data-ad-slot="2445057361" data-ad-format="auto" data-full-width-responsive="true"></ins>
		<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
		</script>


		<?php
		/* 		echo '<section class="l-page-home__posts-links">';
		echo '<h2 class="l-page-home__title">Geral</h2>';
		$args = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => 6,
			'order' => 'DESC',
			'category_name' => "geral"
		);
		$query = new WP_Query($args);
		if ($query->have_posts()) {
			$i = 1;
			while ($query->have_posts()) {
				$query->the_post();
				$post = array(
					'titulo' => get_the_title(),
					'link' => get_permalink(),
				);

				echo '<a href="' . $post["link"] . '" title="' . $post["titulo"] . '"><h3>' . $post["titulo"] . '</h3></a>';
			}
		}
		wp_reset_postdata();
		echo '</section>'; */
		?>


		<div class="l-page-home__posts-two-columns">
			<div class="l-posts">
				<header class="l-posts__header">
					<h2 class="l-posts__title">Saúde</h2>
				</header>
				<div class="l-posts__content">
					<?php
					$args = array(
						'post_type' => 'post',
						'post_status' => 'publish',
						'posts_per_page' => 4,
						'order' => 'DESC',
						'category_name' => "saude"
					);
					theme_get_posts($args);
					?>
				</div>
				<footer class="l-posts__footer">
					<a href="<?= get_site_url() ?>/categoria/noticias/saude/" class="c-button">Ver Mais</a>
				</footer>
			</div>

			<div class="l-posts">
				<header class="l-posts__header">
					<h2 class="l-posts__title">Lazer & Cultura</h2>
				</header>
				<div class="l-posts__content">
					<?php
					$args = array(
						'post_type' => 'post',
						'post_status' => 'publish',
						'posts_per_page' => 4,
						'order' => 'DESC',
						'category_name' => "lazer-cultura"
					);
					theme_get_posts($args);
					?>
				</div>
				<footer class="l-posts__footer">
					<a href="<?= get_site_url() ?>/categoria/lazer-cultura/" class="c-button">Ver Mais</a>
				</footer>
			</div>
		</div>

		<?php
		$args = array(
			'post_type' => 'banners_home',
			'post_status' => 'publish',
			'posts_per_page' => 1,
			'offset' => 4,
			'order' => 'DESC',
		);
		$html = '';
		$query = new WP_Query($args);
		if ($query->have_posts()) {
			$i = 1;
			while ($query->have_posts()) {
				$query->the_post();
				$custom = array(
					'titulo' => get_the_title(),
					'imagem' => get_field("imagem"),
					'link' => get_field("link"),
				);

				if ($custom["link"]) {
					$html .= '<a target="_blank" rel="nofollow" href="' . $custom['link'] . '" title="' . $custom['titulo'] . '" class="l-page-home__banner">';
				} else {
					$html .= '<article class="l-page-home__banner">';
					$html .= '<h3 class="screen-readers-only">' . $custom['titulo'] . '</h3>';
				}

				$html .= '<img loading="lazy" width="1000" height="100" src="' . $custom['imagem'] . '" alt="' . $custom['titulo'] . '"/>';

				if ($custom["link"]) {
					$html .= '</a>';
				} else {
					$html .= '</article>';
				}
			}
		}
		wp_reset_postdata();
		echo $html;
		?>

		<div class="l-posts">
			<header class="l-posts__header">
				<h2 class="l-posts__title">Acontece na Região</h2>
			</header>
			<div class="l-posts__content l-posts__content--two-columns">
				<?php
				$args = array(
					'post_type' => 'post',
					'post_status' => 'publish',
					'posts_per_page' => 4,
					'order' => 'DESC',
					'category_name' => "regiao"
				);
				theme_get_posts($args);
				?>
			</div>
			<footer class="l-posts__footer">
				<a href="<?= get_site_url() ?>/categoria/noticias/regiao/" class="c-button">Ver Mais</a>
			</footer>
		</div>

		<?= videos_shortcode() ?>

		<div class="l-page-home__banner">
			<img loading="lazy" width="1000" height="100" src="<?= get_stylesheet_directory_uri() . '/' . ASSETS_DIR ?>/img/banner-home.png" alt="Anuncie na Porto Ferreira Online" />
		</div>
	</main>
	<?php include "template-parts/sidebar.php" ?>
</div>

<?php

get_footer();
