<?php
get_header();
?>

<div class="l-page__main" style="padding-top:40px">
	<main id="content">
		<article class="l-page__single">
			<?php
			$categories = get_the_category();
			$parent_category_id = null;
			if (empty($categories[1])) {
				$category_id = $categories[0]->term_id;
			} else {
				$category_id = $categories[1]->term_id;
				$parent_category_id = $categories[0]->term_id;
			}
			$post_info = array(
				'titulo' => get_the_title(),
				'imagem' => get_the_post_thumbnail_url(),
				'data' => get_the_date(),
				//'descricao' => get_the_excerpt(),
				'categoria' => array(get_cat_name($category_id), get_category_link($category_id)),
				'categoria_pai' => isset($parent_category_id) ? get_cat_name($parent_category_id) : "",
				'categoria_pai_link' => isset($parent_category_id) ? get_category_link($parent_category_id) : "",
				'link' => get_permalink(),
				'comentarios' => get_comments_number()
			);

			$html = "";
			$html .= '<div class="c-post">';
			if ($post_info['imagem']) {
				$html .= '<div class="c-post__image">';
				$html .= '<img class="lazy" width="600" height="590" data-src="' . $post_info['imagem'] . '" alt="' . $post_info['titulo'] . '" />';
				$html .= '</div>';
			};
			$html .= '<header class="c-post__header">';
			$html .= '<ul class="c-post__categories">';
			if ($post_info['categoria']) {
				$html .= '<li class="c-post__category"><a href="' . $post_info['categoria'][1] . '" title="' . $post_info['categoria'][0] . '">' . $post_info['categoria'][0] . '</a></li>';
			}
			if ($post_info['categoria_pai'] !== "" && $post_info['categoria_pai_link'] !== "") {
				$html .= '<li class="c-post__category"><a href="' . $post_info['categoria_pai_link'] . '" title="' . $post_info['categoria_pai'] . '">' . $post_info['categoria_pai'] . '</a></li>';
			}
			$html .= '</ul>';
			$html .= '<h1 class="c-post__title">' . $post_info['titulo'] . '</h1>';
			$html .= '<div class="c-post__info">';
			if ($post_info['data']) {
				$html .= '<p class="c-post__data">' . $post_info['data'] . '</p>';
			}
			if (isset($post_info['comentarios'])) {
				$html .= '<a href="' . $post_info['link'] . '#respond" title="Ver comentários" class="c-post__comentarios">' . $post_info['comentarios'] . " " . ($post_info['comentarios'] === 1 ? "Comentário" : "Comentários") . '</a>';
			}
			$html .= "</div>";
			$html .= '</header>';
			/* if ($post_info['descricao']) {
				$html .= '<div class="c-post__descricao">' . $post_info['descricao'] . '</div>';
			} */
			$html .= '</div>';

			echo $html;
			echo '<div class="l-page__single-content"/>';
			echo the_content();
			echo '</div>';

			?>

			<div class="l-page__share">
				<?php
				//Foi necessário remover a última / do link para que a foto do post aparecesse corretamente no Facebook
				$permalink = get_permalink();
				$permalink = rtrim($permalink, '/')
				?>
				<a class="icon-facebook" href="#" onclick="shareOnSocial('https://www.facebook.com/sharer.php?t=<?= get_the_title() ?>&amp;u=<?= $permalink ?>', 'Compartilhar no Facebook'); return false;"></a>
				<a class="icon-twitter" data-show-count="false" href="https://twitter.com/share?ref_src=<?php echo urlencode(get_permalink()); ?>&amp;text=<?php echo urlencode(get_the_title()); ?>&amp;url=<?php echo urlencode(get_permalink()); ?>" onclick="shareOnSocial(this.href, 'Compartilhar no Twitter'); return false;"></a>
				<!-- <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> -->
				<a class="icon-linkedin" href="#" onclick="shareOnSocial('https://www.linkedin.com/shareArticle?url=<?= $permalink ?>&amp;title=<?= get_the_title() ?>', 'Compartilhar no LinkedIn'); return false;"></a>
				<a class="icon-whatsapp" href="whatsapp://send?text=<?= get_the_title() ?> - <?= get_permalink() ?>" target="_blank"></a>
			</div>
		</article>
		<!-- Ad Single Post -->
		<!-- 		<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7379900084732959" crossorigin="anonymous"></script>
		
		<ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-7379900084732959" data-ad-slot="2738902532" data-ad-format="auto" data-full-width-responsive="true"></ins>
		<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
		</script> -->
		<div class="l-page__comments">
			<?php
			if (comments_open()) {
				comments_template();
			}
			?>
		</div>
	</main>
	<?php include "template-parts/sidebar.php"; ?>
</div>

<script async>
	function shareOnSocial(url, title) {
		const popupWidth = 600; // Largura da janela pop-up
		const popupHeight = 400; // Altura da janela pop-up

		// Calcula as coordenadas X e Y para centralizar a janela na tela
		const left = (window.innerWidth - popupWidth) / 2;
		const top = (window.innerHeight - popupHeight) / 2;

		// Abre a janela pop-up centralizada
		const popup = window.open(url, title, `width=${popupWidth},height=${popupHeight},left=${left},top=${top}`);

		// Verifica se a janela foi bloqueada pelo navegador (popup === null)
		if (!popup) {
			// Se a janela foi bloqueada, abra-a em uma nova aba
			window.location.href = url;
		}
	}
</script>

<?php
get_footer();
?>