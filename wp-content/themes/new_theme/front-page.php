<?php
/**
 * The front page template file
 *
 * @package WordPress
 * @subpackage New_Theme
 * @since New_Theme 1.0
 */
?>

<?php get_header(); ?>
  
<div class="main-section">
  <div class="main-slider-wrapper">
    <?php
    $query = new WP_Query(array(

      'cat' => 2, // Акции
      'posts_per_page' => 5,

    ));
    ?>

    <div class="main-slider swiper-container">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <div class="swiper-slide__img">
            <img src="/wp-content/themes/new_theme/assets/images/101.jpg" alt="">
          </div>
          <div class="swiper-slide__content">
            <div class="container">
              <div class="swiper-slide__title"><?php get_template_part( 'template-parts/company-title' ); ?></div>
            </div>
          </div>
          <div class="swiper-slide__bg">
            <img src="/wp-content/themes/new_theme/assets/images/main-slider-bg.png" alt="">
          </div>
        </div>
      </div>
    </div>

  </div>

</div>

<p>Секции</p>
  
<?php get_footer(); ?>