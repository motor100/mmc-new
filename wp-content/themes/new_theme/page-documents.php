<?php
/**
 * Information page
 *
 * @package WordPress
 * @subpackage New_Theme
 * @since New_Theme 1.0
 */
?>

<?php get_header(); ?>

  <div class="documents-page section">
    <div class="container">
      <div class="page-title">Документы и лицензии</div>
      <div class="documents">

        <?php
        // Временно отключаю запрос
        $query = new WP_Query(array(

          /*
          // Правильные параметры
          'cat' => 7,
          'posts_per_page' => -1,
          'order' => 'ASC'
          */

          // Фейковые параметры
          'post__in' => array(0), // Заставляем искать пост с ID 0 (его не существует)
          'posts_per_page' => 1,  // Минимальный лимит, чтобы WP не перенапрягался
          'no_found_rows' => true // Отключаем лишний подсчет строк в БД
        ));
        ?>

        <?php if ( $query->have_posts() ) : ?>
          <?php while ($query->have_posts()) : ?>
            <?php $query->the_post(); ?>
            <div class="list-item">
              <?php
              $files = rwmb_meta( 'file_pdf' );
              $file = reset( $files );
              ?>
              <img class="icon" src="/wp-content/themes/new_theme/assets/images/pdf-icon.svg" alt="">
              <a class="name" href="<?php echo $file['url']; ?>" target="_blank"><?php echo the_title(); ?></a>
              <div class="clear-both"></div>
            </div>
          <?php endwhile; ?>
        <?php endif; ?>
      </div>

      <div class="control-link">

        <div class="list-item">
          <img class="icon" src="/wp-content/themes/new_theme/assets/images/html-icon.svg" alt="">
          <a class="name" href="http://foms74.ru/" target="_blank">ТФОМС Челябинской области</a>
        </div>
        <div class="list-item">
          <img class="icon" src="/wp-content/themes/new_theme/assets/images/html-icon.svg" alt="">
          <a class="name" href="http://74.rospotrebnadzor.ru/" target="_blank">Управление Роспотребнадзора по Челябинской области</a>
        </div>
        <div class="list-item">
          <img class="icon" src="/wp-content/themes/new_theme/assets/images/html-icon.svg" alt="">
          <a class="name" href="https://74reg.roszdravnadzor.gov.ru/" target="_blank">Управление Росздравнадзора по Челябинской области</a>
        </div>
        <div class="list-item">
          <img class="icon" src="/wp-content/themes/new_theme/assets/images/html-icon.svg" alt="">
          <a class="name" href="https://www.zdrav74.ru/" target="_blank">Министерство здравоохранения Челябинской области</a>
        </div>
        <div class="list-item">
          <img class="icon" src="/wp-content/themes/new_theme/assets/images/html-icon.svg" alt="">
          <a class="name" href="http://www.minzdravsoc.ru/" target="_blank">Агентство медицинской информации "Минздравсоц"</a>
        </div>
        <div class="list-item">
          <img class="icon" src="/wp-content/themes/new_theme/assets/images/html-icon.svg" alt="">
          <a class="name" href="https://www.nalog.gov.ru/rn74/" target="_blank">Федеральная налоговая служба</a>
        </div>        
        
        <div class="list-item">
          <img class="icon" src="/wp-content/themes/new_theme/assets/images/html-icon.svg" alt="">
          <a class="name" href="http://foms74.ru/page/territorialnaya_programma_oms" target="_blank">Территориальная программа государственных гарантий бесплатного оказания гражданам медицинской помощи в Челябинской области</a>
        </div>
        <div class="list-item">
          <img class="icon" src="/wp-content/themes/new_theme/assets/images/html-icon.svg" alt="">
          <a class="name" href="http://ips.pravo.gov.ru:8080/default.aspx?pn=0001202101040006" target="_blank">Программа государственных гарантий бесплатного оказания гражданам медицинской помощи  на 2021год и на плановый период 2022 и 2023 годов</a>
        </div>
        <div class="list-item">
          <img class="icon" src="/wp-content/themes/new_theme/assets/images/pdf-icon.svg" alt="">
          <a class="name" href="/wp-content/themes/new_theme/assets/pdf/o-programme-gosudarstvennyh-garantij-besplatnogo-okazaniya-grazhdanam-medicinskoj-pomoshchi-na-2026-god-i-na-planovyj-period-2027-i-2028-godov.pdf" target="_blank">О Программе государственных гарантий бесплатного оказания гражданам медицинской помощи на 2026 год и на плановый период 2027 и 2028 годов</a>
        </div>
        <div class="list-item">
          <img class="icon" src="/wp-content/themes/new_theme/assets/images/pdf-icon.svg" alt="">
          <a class="name" href="/wp-content/themes/new_theme/assets/pdf/ob-informacii-neobhodimoj-dlya-provedeniya-nezavisimoj-ocenki-kachestva.pdf" target="_blank">Об информации необходимой для проведения независимой оценки качества</a>
        </div>
        <div class="list-item">
          <img class="icon" src="/wp-content/themes/new_theme/assets/images/pdf-icon.svg" alt="">
          <a class="name" href="/wp-content/themes/new_theme/assets/pdf/o-pravakh-i-obyazannostyakh-grazhdan-v-sfere-okhrany-zdorovya.pdf" target="_blank">О правах и обязанностях граждан в сфере охраны здоровья</a>
        </div>
        <div class="list-item">
          <img class="icon" src="/wp-content/themes/new_theme/assets/images/pdf-icon.svg" alt="">
          <a class="name" href="/wp-content/themes/new_theme/assets/pdf/ob-utverzhdenii-pravil-predostavleniya-medicinskimi-organizaciyami-platnyh-medicinskih-uslug.pdf" target="_blank">Об утверждении Правил предоставления медицинскими организациями платных медицинских услуг</a>
        </div>
      </div>

      <div class="control-link">
        
        <div class="list-item">
          <img class="icon" src="/wp-content/themes/new_theme/assets/images/html-icon.svg" alt="">
          <a class="name" href="/politika-obrabotki-personalnyh-dannyh/" target="_blank">Политика обработки персональных данных</a>
        </div>
        <div class="list-item">
          <img class="icon" src="/wp-content/themes/new_theme/assets/images/html-icon.svg" alt="">
          <a class="name" href="/soglasie-posetitelya-sajta-na-obrabotku-personalnyh-dannyh/" target="_blank">Согласие на обработку персональных данных</a>
        </div>
        <div class="list-item">
          <img class="icon" src="/wp-content/themes/new_theme/assets/images/html-icon.svg" alt="">
          <a class="name" href="/soglasie-na-poluchenie-rassylki-reklamnogo-haraktera/" target="_blank">Согласие на получение рассылки рекламного характера</a>
        </div>

      </div>

      <div class="control-link">

        <div class="list-item">
          <img class="icon" src="/wp-content/themes/new_theme/assets/images/pdf-icon.svg" alt="">
          <a class="name" href="/wp-content/themes/new_theme/assets/pdf/L041-01024-74_00377345.pdf" target="_blank">Лицензия</a>
        </div>
        <div class="list-item">
          <img class="icon" src="/wp-content/themes/new_theme/assets/images/pdf-icon.svg" alt="">
          <a class="name" href="/wp-content/themes/new_theme/assets/pdf/informacionnaya-karta-ooo-miassmedcentr-uralsib.pdf" target="_blank">Карточка предприятия</a>
        </div>
        <div class="list-item">
          <img class="icon" src="/wp-content/themes/new_theme/assets/images/pdf-icon.svg" alt="">
          <a class="name" href="/wp-content/themes/new_theme/assets/pdf/dogovor-na-okazanie-medicinskih-uslug.pdf" target="_blank">Договор на оказание медицинских услуг</a>
        </div>

    </div>
  </div>

<?php get_footer(); ?>