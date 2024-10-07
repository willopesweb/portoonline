<?php

get_header();


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

//Posts recentes
$recents = theme_get_posts(array(
	'post_type' => 'post',
	'post_status' => 'publish',
	'posts_per_page' => 4,
	'order' => 'DESC',
));

if (!empty($recents)) {
	foreach ($recents as $post) {
		echo '<link rel="prefetch" href="' . $post['link'] . '">';
	}
}

?>
<section class="l-page">
	<div class="l-page-home__posts">
		<div class="l-page-home__slides js-news-carousel splide">
			<div class="splide__track">
				<ul class="splide__list">
					<?php
					if (!empty($recents)) {
						foreach ($recents as $post) {
							echo '<li class="splide__slide"><article class="c-post">';
							echo '<a class="c-post__image" href="' . $post['link'] . '" title="' . $post['titulo'] . '">';
							echo '<img class="lazy" width="530" height="300" data-src="' . $post['imagem'] . '" alt="' . $post['titulo'] . '" />';
							echo '</a>';
							echo '<header class="c-post__header">';
							echo '<ul class="c-post__categories">';
							if ($post['categoria']) {
								echo '<li class="c-post__category"><a href="' . $post['categoria'][1] . '" title="' . $post['categoria'][0] . '">' . $post['categoria'][0] . '</a></li>';
							}
							if ($post['categoria_pai'] !== "" && $post['categoria_pai_link'] !== "") {
								echo '<li class="c-post__category"><a href="' . $post['categoria_pai_link'] . '" title="' . $post['categoria_pai'] . '">' . $post['categoria_pai'] . '</a></li>';
							}
							echo '</ul>';
							echo '<h2 class="c-post__title"><a href="' . $post['link'] . '" title="' . $post['titulo'] . '">' . $post['titulo'] . '</a></h2>';
							echo '<div class="c-post__info">';
							if ($post['data']) {
								echo '<p class="c-post__data">' . $post['data'] . '</p>';
							}
							if (isset($post['comentarios'])) {
								echo '<a href="' . $post['link'] . '#respond" title="Ver comentários" class="c-post__comentarios">' . $post['comentarios'] . " " . ($post['comentarios'] === 1 ? "Comentário" : "Comentários") . '</a>';
							}
							echo "</div>";
							echo '</header>';
							echo '</article></li>';
						}
					}
					?>
				</ul>
			</div>
		</div>
		<div class="l-page-home__recents">
			<?php


			if (!empty($recents)) {
				foreach ($recents as $post) {
					theme_post_template($post);
				}
			}
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

				$events = theme_get_posts(array(
					'post_type' => 'post',
					'post_status' => 'publish',
					'posts_per_page' => 4,
					'order' => 'DESC',
					'category_name' => "eventos"
				));


				if (!empty($events)) {
					foreach ($events as $post) {
						theme_post_template($post);
					}
				}
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

				$obituarioPosts = theme_get_posts(array(
					'post_type' => 'post',
					'post_status' => 'publish',
					'posts_per_page' => 4,
					'order' => 'DESC',
					'category_name' => "obituario-porto-ferreira"
				));


				if (!empty($obituarioPosts)) {
					foreach ($obituarioPosts as $post) {
						theme_post_template($post);
					}
				}
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
				$policialPosts = theme_get_posts(array(
					'post_type' => 'post',
					'post_status' => 'publish',
					'posts_per_page' => 4,
					'order' => 'DESC',
					'category_name' => "policial"
				));


				if (!empty($policialPosts)) {
					foreach ($policialPosts as $post) {
						theme_post_template($post);
					}
				}
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

				$portoPosts = theme_get_posts(array(
					'post_type' => 'post',
					'post_status' => 'publish',
					'posts_per_page' => 4,
					'order' => 'DESC',
					'category_name' => "porto-ferreira",
					'category__not_in' => array(get_category_by_slug('policial')->term_id)
				));


				if (!empty($portoPosts)) {
					foreach ($portoPosts as $post) {
						theme_post_template($post);
					}
				}
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

		<script defer src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7379900084732959" crossorigin="anonymous"></script>
		<!-- Home -->
		<ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-7379900084732959" data-ad-slot="2445057361" data-ad-format="auto" data-full-width-responsive="true"></ins>
		<script defer>
			(adsbygoogle = window.adsbygoogle || []).push({});
		</script>

		<div class="l-page-home__posts-two-columns">
			<div class="l-posts">
				<header class="l-posts__header">
					<h2 class="l-posts__title">Saúde</h2>
				</header>
				<div class="l-posts__content">
					<?php

					$saudePosts = theme_get_posts(array(
						'post_type' => 'post',
						'post_status' => 'publish',
						'posts_per_page' => 4,
						'order' => 'DESC',
						'category_name' => "saude"
					));


					if (!empty($saudePosts)) {
						foreach ($saudePosts as $post) {
							theme_post_template($post);
						}
					}
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
					$lazerPosts = theme_get_posts(array(
						'post_type' => 'post',
						'post_status' => 'publish',
						'posts_per_page' => 4,
						'order' => 'DESC',
						'category_name' => "lazer-cultura"
					));


					if (!empty($lazerPosts)) {
						foreach ($lazerPosts as $post) {
							theme_post_template($post);
						}
					}
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
				$regiaoPosts = theme_get_posts(array(
					'post_type' => 'post',
					'post_status' => 'publish',
					'posts_per_page' => 4,
					'order' => 'DESC',
					'category_name' => "regiao"
				));


				if (!empty($regiaoPosts)) {
					foreach ($regiaoPosts as $post) {
						theme_post_template($post);
					}
				}
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
