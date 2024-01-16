<?php
get_header();
?>

<div class="l-page__content">
	<main id="content">
		<article class="l-page__single">
			<?php
			$post_info = array(
				'titulo' => get_the_title(),
			);

			echo '<header class="l-page__header">';
			echo '<h1 class="l-page__title">' . $post_info['titulo'] . '</h1>';
			echo '</header>';

			echo '<div class="l-page__single-content"/>';
			echo the_content();
			echo '</div>';

			?>

		</article>
		<div class="l-page__comments">
			<?php
			if (comments_open()) {
				comments_template();
			}
			?>
		</div>
	</main>
</div>

<?php
get_footer();
?>