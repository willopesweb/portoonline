<sidebar class="l-sidebar">
  <?php
  if (
    is_single()
    && !has_category('obituario-porto-ferreira')
    && !has_category('vagas-de-empregos')
    && !has_category('eventos')
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
        theme_get_posts($args);
        ?>
      </div>
    </div>
  <?php } ?>
  <div class="l-sidebar__banners">
    <?php
    if (has_category('vagas-de-empregos')) {
      echo banners_vagas_shortcode();
    } else if ((strpos($_SERVER['REQUEST_URI'], 'obituario') !== false) || (is_single() && has_category('obituario-porto-ferreira'))) {
      echo banners_shortcode(true, false);
    } else if ((strpos($_SERVER['REQUEST_URI'], 'eventos') !== false) || (is_single() && has_category('eventos'))) {
      echo banners_shortcode(false, true);
    } else {
      echo banners_shortcode(false, false);
    }
    ?>
  </div>
</sidebar>