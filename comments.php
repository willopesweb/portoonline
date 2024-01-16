<?php

/**
 * The template for displaying Comments.
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if (post_password_required())
	return;
?>

<section id="comments" class="l-comments">

	<?php if (have_comments()) : ?>
		<header class="l-comments__header">
			<h1 class="l-comments__title">
				<?php
				printf(
					_nx('Um comentário em "%2$s"', '%1$s comentários em "%2$s"', get_comments_number(), 'comments title', 'twentythirteen'),
					number_format_i18n(get_comments_number()),
					'<span>' . get_the_title() . '</span>'
				);
				?>
			</h1>
		</header>

		<ol class="l-comments__list">
			<?php
			wp_list_comments(array(
				'style'       => 'ul',
				'short_ping'  => true,
				'avatar_size' => 74,
			));
			?>
		</ol>
		<?php

		// Are there comments to navigate through?
		if (get_comment_pages_count() > 1 && get_option('page_comments')) :
		?>
			<nav class="navigation comment-navigation" role="navigation">
				<h1 class="screen-reader-text section-heading"><?php _e('Comment navigation', 'twentythirteen'); ?></h1>
				<div class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments', 'twentythirteen')); ?></div>
				<div class="nav-next"><?php next_comments_link(__('Newer Comments &rarr;', 'twentythirteen')); ?></div>
			</nav><!-- .comment-navigation -->
		<?php endif; // Check for comment navigation 
		?>

		<?php if (!comments_open() && get_comments_number()) : ?>
			<p class="no-comments"><?php _e('Comments are closed.', 'twentythirteen'); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() 
	?>

	<?php

	// Remove campo Site do Fomulário
	function remove_website_field($fields)
	{
		unset($fields['url']);
		return $fields;
	}
	// Fiiltro para alterar os campos do formulário
	add_filter('comment_form_default_fields', 'remove_website_field');

	// Carrega o Formulário
	$args = [
		'class_container' => 'l-comments__form',
		'class_submit' => 'c-button',
		'class_form' => 'c-form',
		'label_submit' => 'Enviar',
		'title_reply' => 'Deixe um comentário'
	];
	comment_form($args);
	?>


</section>