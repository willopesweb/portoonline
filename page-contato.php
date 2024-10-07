<?php
//Template Name: Contato
get_header();
?>


<main id="content" style="padding-top:3page-anuncie.php0px">
	<article class="l-page__content">
		<header class="l-page__header">
			<h2 class="l-page__title"><?= the_title() ?></h2>
		</header>
		<div class="l-page__single-content">
			<?php echo the_content(); ?>
			<form id="anuncio" action="" method="post" class="c-form js-form" aria-label="Formulário de contato">
				<label class="c-form__label">
					<span>Seu nome</span>
					<input required aria-required="true" aria-invalid="false" value="" type="text" name="Nome">
				</label>
				<label class="c-form__label">
					<span>Seu e-mail preferido</span>
					<input required aria-required="true" aria-invalid="false" value="" type="email" name="Email">
				</label>
				<label class="c-form__label">
					<span>Telefone / Whatsapp com DDD</span>
					<input required aria-required="true" aria-invalid="false" value="" type="number" name="Telefone">
				</label>
				<label class="c-form__label">
					<span>Mensagem</span>
					<textarea required cols="40" rows="10" aria-invalid="false" name="Mensagem"></textarea>
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
	</article>
</main>

<?php
get_footer();
?>