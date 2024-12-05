<?php
get_header();


function check_gallery_shortcode($content)
{
	// Verifica se o shortcode [rl_gallery] está presente no conteúdo
	if (has_shortcode($content, 'rl_gallery')) {
		// Usa expressão regular para capturar o ID do shortcode
		if (preg_match('/\[rl_gallery id="(\d+)"\]/', $content, $matches)) {
			$gallery_id = $matches[1]; // Salva o valor do ID
			return $gallery_id; // Retorna o ID do gallery
		}
	}
	return null;
}

$post_id = get_the_ID();
$content = get_the_content();
$gallery_shortcode_id = check_gallery_shortcode($content);
$gallery_id = $gallery_shortcode_id ? $gallery_shortcode_id : get_field("galeria_id");
?>

<script defer src="<?= get_stylesheet_directory_uri() . '/' . ASSETS_DIR ?>/js/gallery.js"></script>
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
				'categoria' => array(get_cat_name($category_id), get_category_link($category_id)),
				'categoria_pai' => isset($parent_category_id) ? get_cat_name($parent_category_id) : "",
				'categoria_pai_link' => isset($parent_category_id) ? get_category_link($parent_category_id) : "",
				'link' => get_permalink(),
				'comentarios' => get_comments_number(),
				'video' => get_field("video_youtube")
			);

			$html = "";
			$html .= '<div class="c-post">';

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

			if ($post_info["video"]) {
				$html .= '<div style="padding:10px" class="c-post__video js-lazy-iframe-video" data-video-id="' . $post_info['video'] . '"></div>';
			} else if ($post_info['imagem']) {
				$html .= '<div class="c-post__image" style="padding:10px">';
				$html .= '<img class="lazy" width="600" height="590" data-src="' . $post_info['imagem'] . '" alt="' . $post_info['titulo'] . '" />';
				$html .= '</div>';
			};

			$html .= '</div>';

			echo $html;

			echo '<div class="l-page__single-content"/>';
			echo the_content();
			if ($gallery_id) {
				theme_custom_gallery($gallery_id);
			}
			echo '</div>';

			?>

			<div class="l-page__share">
				<?php
				//Foi necessário remover a última / do link para que a foto do post aparecesse corretamente no Facebook
				$permalink = get_permalink();
				$permalink = rtrim($permalink, '/')
				?>
				<a class="icon-facebook" href="#" onclick="shareOnSocial('https://www.facebook.com/sharer.php?t=<?= get_the_title() ?>&amp;u=<?= $permalink ?>', 'Compartilhar no Facebook'); return false;"></a>
				<a class="icon-linkedin" href="#" onclick="shareOnSocial('https://www.linkedin.com/shareArticle?url=<?= $permalink ?>&amp;title=<?= get_the_title() ?>', 'Compartilhar no LinkedIn'); return false;"></a>
				<a class="icon-whatsapp" href="whatsapp://send?text=<?= get_the_title() ?> - <?= get_permalink() ?>" target="_blank"></a>
			</div>
		</article>

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