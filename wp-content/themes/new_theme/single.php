<?php
/**
 * The template for displaying all single posts
 *
 * @package WordPress
 * @subpackage New_Theme
 * @since New_Theme 1.0
 */
?>

<?php get_header(); ?>

<div class="single-page">
	<div class="container">

		<?php
    $cat = get_the_category()[0]->cat_ID;
    $product_id = get_the_ID();
    $gallery = rwmb_meta( 'gallery', 'type=image&size=gallery-preview' );
    $counter = count($gallery);

    $query = new WP_Query(array(

      'cat' => $cat,
      'posts_per_page' => 1,
      'p' => $product_id,

    ));
    ?>

    <?php while ($query->have_posts()) : ?>
      <?php $query->the_post(); ?>

      <div class="single-img">
        <img src="<?php echo the_post_thumbnail_url('full'); ?>" alt="">
      </div>
      <div class="single-title"><?php the_title(); ?></div>
      <div class="single-text"><?php the_content(); ?></div>

    <?php endwhile; ?>

	</div>
</div>   

<?php get_footer(); ?>