<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @package WordPress
 * @subpackage New_Theme
 * @since New_Theme 1.0
 */
?>

  <footer class="footer">
    <div class="container">
      <p>Footer</p>
    </div>
  </footer>

  <div id="to-top" class="to-top hidden-mobile">
    <div class="circle">
      <div class="up"></div>
    </div>
  </div>

  <div id="cookie_note" class="we-use-cookie">
    <div class="we-use-cookie-wrapper">
      <div class="we-use-cookie-text">Мы используем файлы cookie и сервисы веб-аналитики (Яндекс.Метрика, Wordpress) для анализа производительности сайта, улучшения пользовательского опыта и обеспечения безопасности. Нажимая «Принять» вы соглашаетесь с нашей <a href="/politika-obrabotki-personalnyh-dannyh/">Политикой конфиденциальности</a>.</div>
      <div class="we-use-cookie-buttons">
        <button id="cookie_accept" class="we-use-cookie-close we-use-cookie-close-accept">Принять</button>
        <button id="cookie_dont_accept" class="we-use-cookie-close we-use-cookie-close-dont-accept">Отклонить</button>
      </div>
    </div>
  </div>

  <!-- mobile menu -->
  <div class="mobile-menu hidden-desktop">
    <div class="close"></div>
    <div class="logo">
      <img src="/wp-content/themes/new_theme/assets/images/footer-logo.svg" alt="">
    </div>
    <div class="menu">
      <ul id="mobile-nav-ul" class="navbar top-menu">
        <li id="menu-item-23" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-23">
          <a href="/#directions" aria-current="page">Направления</a>
        </li>
        <li id="menu-item-24" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-24">
          <a href="/#doctors" aria-current="page">Врачи</a>
        </li>
        <li id="menu-item-25" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-25">
          <a href="/#contacts" aria-current="page">Контакты</a>
        </li>
        <li id="menu-item-25" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-25">
          <a href="/documents" aria-current="page">Документы</a>
        </li>
      </ul>
    </div>
    <div class="horizontal-line"></div>
    <div class="address-item">
      <div class="text">Адрес и график работы</div>
    </div>
    <div class="address-item">
      <p>г. Миасс,</p>
      <p><?php get_template_part( 'template-parts/address' ); ?></p>
    </div>
    <div class="address-item">
      <p>Будни: 8:00–19:00</p>
      <p>Выходные: 8:00–15:00</p>
    </div>
  </div>

  <!-- Окно Добавить отзыв -->
  <div id="add-review-modal" class="add-review-modal modal">
    <div class="modal-wrapper">
      <div class="modal-area">
        <div class="modal-close">
          <div class="close"></div>
        </div>
        <div class="content">
          <?php
          $comments_args = array(
            'label_submit' => 'Отправить',
            'title_reply' => 'Спасибо за ваш отзыв',
            'title_reply_before' => '<div id="reply-title" class="comment-reply-title">',
            'title_reply_after' => '</div>',
            'comment_notes_after' => '',
            'comment_notes_before' => '',
            'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><br /><textarea id="comment" name="comment" minlength="10" maxlength="400" required="required"></textarea></p>',
              
          );

          comment_form( $comments_args, 7 );
          ?>
          
        </div>
        <script>
          let email = document.getElementById('email');
          if (email) {
            email.value = 'mmc.disk@yandex.ru';
          }
        </script>
      </div>
    </div>
  </div>

  <?php wp_footer(); ?>

  </body>
</html>