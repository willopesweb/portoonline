<script src="<?= get_stylesheet_directory_uri() . '/' . ASSETS_DIR ?>/js/main.js"></script>
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7379900084732959" crossorigin="anonymous"></script>
<!-- PFO -->
<ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-7379900084732959" data-ad-slot="3674901331" data-ad-format="auto" data-full-width-responsive="true"></ins>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({});
</script>

<?php
if (!defined('ABSPATH')) {
  exit;
}

?>
<div class="l-page l-page__cta" style="background-image: url(<?= get_stylesheet_directory_uri() . '/' . ASSETS_DIR ?>/img/bg-call-to-ads.jpg)">
  <div class="l-page__content">
    <h2 class="l-page__title">Tem uma empresa em Porto Ferreira?</h2>
    <p class="l-page__subtitle">Seja encontrado pelos milhares de usuários que acessam o nosso guia todos os dias.</p>
    <a href="<?= get_site_url() ?>/anuncie-no-porto-ferreira-online/" class="c-button">Cadastre sua empresa</a>
  </div>
</div>
<footer class="l-footer">
  <div class="l-footer__content">
    <div class="l-footer__about">
      <h5 class="l-footer__title">Sobre Nós</h5>
      <p>O portal mais completo sobre Porto Ferreira com empresas e notícias. Fale conosco e saiba como anunciar sua empresa.</p>
    </div>
    <div>
      <h5 class="l-footer__title">Institucional</h5>
      <?php
      wp_nav_menu([
        'menu' => 'Institucional',
        'container' => 'ul',
        'menu_class' => 'l-footer__menu',
        'container_aria_label' => 'navigation'
      ]);
      ?>
    </div>

    <div>
      <h5 class="l-footer__title">Categorias</h5>
      <?php
      wp_nav_menu([
        'menu' => 'Topo',
        'container' => 'ul',
        'menu_class' => 'l-footer__menu',
        'container_aria_label' => 'navigation'
      ]);
      ?>
    </div>

    <div class="l-footer__social">
      <h5 class="l-footer__title">Redes Sociais</h5>
      <?= theme_social_networks(); ?>
    </div>
    <p class="l-footer__copy">PortoFerreiraOnline.com.br - © <?= date("Y"); ?> - Todos os direitos reservados</p>
  </div>
</footer>

<?php
wp_footer();
?>
</body>

</html>