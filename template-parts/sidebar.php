<sidebar class="l-sidebar">
  <?php
  if (
    is_single()
    && !has_category('obituario-porto-ferreira')
    && !has_category('pat-vagas-de-empregos')
    && !has_category('eventos')
    && !has_category('etv')
    && !has_category('saude')
  ) { ?>
    <div class="l-posts">
      <header class="l-posts__header">
        <h2 class="l-posts__title">Acontece na Região</h2>
      </header>
      <div class="l-posts__content l-posts__content">
        <?php
        $args = array(
          'post_type' => 'post',
          'post_status' => 'publish',
          'posts_per_page' => 4,
          'order' => 'DESC',
          'category_name' => "regiao"
        );
        $postsSidebar =  theme_get_posts($args);

        if (!empty($postsSidebar)) {
          foreach ($postsSidebar as $post) {
            theme_post_template($post);
          }
        }
        ?>
      </div>
    </div>
  <?php } ?>
  <div class="l-sidebar__banners">
    <?php
    if ((strpos($_SERVER['REQUEST_URI'], 'empregos') !== false) || (is_single() && has_category('pat-vagas-de-empregos'))) {
      echo theme_get_banners("banners_vagas");
    } else if ((strpos($_SERVER['REQUEST_URI'], 'etv') !== false) || (is_single() && has_category('etv'))) {
      echo theme_get_banners("banners_etv");
    } else if ((strpos($_SERVER['REQUEST_URI'], 'obituario') !== false) || (is_single() && has_category('obituario-porto-ferreira'))) {
      echo theme_get_banners("banners_obituario");
    } else if ((strpos($_SERVER['REQUEST_URI'], 'eventos') !== false) || (is_single() && has_category('eventos'))) {
      echo theme_get_banners("banners_eventos");
    } else if ((strpos($_SERVER['REQUEST_URI'], 'saude') !== false) || (is_single() && has_category('saude'))) {
      echo theme_get_banners("banners_saude");
    } else {
      echo theme_get_banners("banners");
    }
    ?>
  </div>
</sidebar>