<?php

if (post_password_required())
	return;
?>

<section class="l-comments">
	<?php if (have_comments()) : ?>
		<header class="l-comments__header">
			<h1 class="l-comments__title">
				<?php
				printf(
					_nx('Um comentário em "%2$s"', '%1$s comentários em "%2$s"', get_comments_number(), 'comments title'),
					number_format_i18n(get_comments_number()),
					'<span>' . get_the_title() . '</span>'
				);
				?>
			</h1>
		</header>


		<?php
		echo '<ul class="l-comments__list" id="commentsList">';
		foreach ($comments as $comment) {
			if ($comment->comment_parent === "0") {
		?>
				<li class="l-comments__list-item">
			<?php
				theme_custom_comment(
					$comment->comment_ID,
					get_avatar($comment->comment_author_email, 74, '', 'Avatar do Comentário', array('loading' => 'lazy')),
					get_comment_date('d \d\e F \d\e Y \à\s H:i', $comment),
					$comment->comment_author,
					$comment->comment_content
				);

				// Verifica se existem respostas para este comentário
				$args_reply = array(
					'post_id' => get_the_ID(),
					'status' => 'approve',
					'parent' => $comment->comment_ID,
				);
				$replies = get_comments($args_reply);
				if ($replies) {
					echo '<ul class="children">';
					foreach ($replies as $reply) {
						echo '<li class="l-comments__list-item">';
						theme_custom_comment(
							$reply->comment_ID,
							get_avatar($reply->comment_author_email, 74, '', 'Avatar do Comentário', array('loading' => 'lazy')),
							get_comment_date('d \d\e F \d\e Y \à\s H:i', $reply),
							$reply->comment_author,
							$reply->comment_content,
							false
						);
						echo "</li>";
					}
					echo '</ul>';
				}
				echo '</li>';
			}
		}
		echo '</ul>';
			?>
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

		<div class="l-comments__form js-comment-form">
			<header class="l-comments__header">
				<h3 class="l-comments__title">Deixe um comentário</h3>
				<span class="l-comments__cancel-reply js-cancel-reply">Cancelar resposta?</span>
			</header>
			<form action="" method="post" class="c-form js-form" aria-label="Formulário de comentário" id="comment">
				<input type="hidden" name="PostId" value="<?= get_the_ID() ?>" />
				<input type="hidden" name="ParentId" value="0" />
				<?php if (is_user_logged_in()) :
					$current_user = wp_get_current_user();
				?>
					<input type="hidden" name="UserId" value="<?= get_current_user_id() ?>">
					<input type="hidden" name="Nome" value="<?= esc_html($current_user->display_name) ?>">
				<?php else : ?>
					<input type="hidden" name="UserId" value="0">
					<label class="c-form__label">
						<span>Nome</span>
						<input required aria-required="true" aria-invalid="false" value="" type="text" name="Nome"></span>
					</label>
				<?php endif; ?>
				<label class="c-form__label">
					<span>Comentário</span>
					<textarea required cols="40" rows="10" aria-invalid="false" name="Comentario"></textarea>
				</label>
				<label class="c-form__label c-form__captcha">
					<span>Digite os caracteres da imagem abaixo</span>
					<?php $random =  rand(1, 13) ?>
					<input required aria-required="true" aria-invalid="false" value="" type="text" name="Captcha">
					<input type="hidden" name="CaptchaCode" value="<?= $random ?>" />
					<img loading="lazy" width="200" height="50" src="<?= get_template_directory_uri() . '/' . ASSETS_DIR . '/img/captchas/' . $random . '.png' ?>" alt="">
				</label>
				<div class="c-form__actions">
					<input class="c-button" type="submit" value="Enviar">
					<?= theme_custom_loading() ?>
				</div>
			</form>
		</div>


</section>