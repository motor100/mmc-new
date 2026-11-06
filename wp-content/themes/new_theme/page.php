<?php
/**
 * The template for displaying all page
 *
 * @package WordPress
 * @subpackage New_Theme
 * @since New_Theme 1.0
 */

get_header(); ?>

<div class="page-default section">
  <div class="container">
    <h1 class="page-title"><?php the_title(); ?></h1>
    <div class="page-content">
      <div class="page-text"><?php the_content(); ?></div>
    </div>
  </div>
</div>

<?php get_footer(); ?>