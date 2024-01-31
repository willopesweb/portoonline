<?php

get_header();
?>
<section class="l-page">
	<header class="l-page__header">
		<h2 class="l-page__title">Desculpe, a página que você procura não existe.</h2>
	</header>

</section>
<div class="l-page__main">
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

				$html .= '<img src="' . $custom['imagem'] . '" alt="' . $custom['titulo'] . '"/>';

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

				$html .= '<img src="' . $custom['imagem'] . '" alt="' . $custom['titulo'] . '"/>';

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

				$html .= '<img src="' . $custom['imagem'] . '" alt="' . $custom['titulo'] . '"/>';

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

		<section class="l-page-home__posts-links">
			<h2 class="l-page-home__title">Geral</h2>
			<?php
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
			?>
		</section>

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

				$html .= '<img src="' . $custom['imagem'] . '" alt="' . $custom['titulo'] . '"/>';

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

		<?php
		$args = array(
			'post_type' => 'banners_home',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'offset' => 5,
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

				$html .= '<img src="' . $custom['imagem'] . '" alt="' . $custom['titulo'] . '"/>';

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

		<section class="l-page-home__video">
			<h2 class="l-page-home__title">Porto Ferreira Online TV</h2>
			<div class="l-page-home__video-content">
				<iframe src="https://www.youtube.com/embed/puuB5_LMQUE" title="Porto Ferreira Online TV" allowfullscreen></iframe>
			</div>
		</section>

		<div class="l-page-home__banner">
			<img loading="lazy" src="<?= get_stylesheet_directory_uri() . '/' . ASSETS_DIR ?>/img/banner-home.png" alt="Anuncie na Porto Ferreira Online" />
		</div>
	</main>
	<?php include "template-parts/sidebar.php" ?>
</div>

<?php

get_footer();
