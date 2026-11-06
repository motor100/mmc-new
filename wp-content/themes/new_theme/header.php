<?php
/**
 * The header.
 *
 * This is the template that displays all of the <head> section.
 *
 * @package WordPress
 * @subpackage New_Theme
 * @since New_Theme 1.0
 */
?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <header class="header">
    <div class="menu-wrapper">
      <div class="container">
        <ul id="top-nav-ul" class="navbar top-menu">
          <li id="menu-item-23" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-23">
            <a href="/#directions" aria-current="page">Направления</a>
          </li>
          <li id="menu-item-24" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-24">
            <a href="/#doctors" aria-current="page">Врачи</a>
          </li>
          <li id="menu-item-25" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-25">
            <a href="/#contacts" aria-current="page">Контакты</a>
          </li>
        </ul>
      </div>
    </div>
  </header>