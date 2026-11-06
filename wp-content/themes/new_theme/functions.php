<?php
/**
 * Functions and definitions
 *
 * @package WordPress
 * @subpackage New_Theme
 * @since New_Theme 1.0
 */

add_theme_support('title-tag'); // теперь тайтл управляется самим вп

add_theme_support('post-thumbnails'); // включаем поддержку миниатюр

// Отключение jquery-migrate
function remove_jq_migrate( $scripts ) { 
  if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
    $script = $scripts->registered['jquery'];
    if ( $script->deps ) {
      $script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
    }
  }
}
add_action( 'wp_default_scripts', 'remove_jq_migrate' );

// Добавление версии в css и js
/*
* $temp_debug = true добавляется версия на основе даты и времени
* $temp_debug = false добавляется версия wp
*/

$temp_debug = true;
if ($temp_debug) {
  $ver = date('dis');
} else {
  $ver = '';
}

add_action('wp_footer', 'add_scripts');
if (!function_exists('add_scripts')) {
  function add_scripts() {
    global $ver;
    if(is_admin()) return false;
    wp_deregister_script('jquery');
    wp_enqueue_script('pswp', get_template_directory_uri().'/assets/js/pswp.js','','',true);
    wp_enqueue_script('swiperjs', get_template_directory_uri().'/assets/js/swiper-bundle.min.js','','',true);
    wp_enqueue_script('main', get_template_directory_uri().'/assets/js/main.js','',$ver,true);
  }
}

/**
 * Enqueue classic editor styles.
 */
function classic_editor_styles() {
  $classic_editor_styles = array(
    '/assets/css/editor-style-classic.css',
  );
  add_editor_style( $classic_editor_styles );
}
add_action( 'init', 'classic_editor_styles' );

add_action('wp_print_styles', 'add_styles');
if (!function_exists('add_styles')) {
  function add_styles() {
    global $ver;
    wp_enqueue_style( 'bootstrap-grid', '/wp-content/themes/new_theme/assets/css/bootstrap-grid.min.css' );
    wp_enqueue_style( 'bootstrap-reboot', '/wp-content/themes/new_theme/assets/css/bootstrap-reboot.min.css' );
    wp_enqueue_style( 'swiper', '/wp-content/themes/new_theme/assets/css/swiper-bundle.min.css' );
    wp_enqueue_style( 'photoswipe', '/wp-content/themes/new_theme/assets/css/photoswipe.css' );
    wp_enqueue_style( 'defaultskin', '/wp-content/themes/new_theme/assets/css/default-skin/default-skin.css' );
    wp_enqueue_style( 'main', '/wp-content/themes/new_theme/assets/css/main.css','',$ver,'all');
  }
}

/* Оптимизация */
// удалить атрибут type у scripts
add_filter('script_loader_tag', 'clean_script_tag');
function clean_script_tag($src) {
  return str_replace("type='text/javascript'", '', $src);
}
// удалить атрибут type у style
add_filter('style_loader_tag', 'clean_css_tag', 10, 2);
function clean_css_tag($tag, $handle) {
  return preg_replace( "/type=['\"]text\/(css)['\"]/", '', $tag );
}

// Disable the emoji's
function disable_emojis() {
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'disable_emojis' );

function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
  if ( 'dns-prefetch' == $relation_type ) {
    /** This filter is documented in wp-includes/formatting.php */
    $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://w.org' );
    $urls = array_diff( $urls, array( $emoji_svg_url ) );
  }
  return $urls;
}

// Очистка wp_head от лишних мета-тегов и ссылок
add_action('init', function () {
    remove_action('wp_head', 'wp_generator');                 // Удаляет версию WordPress
    remove_action('wp_head', 'wlwmanifest_link');             // Ссылка для Windows Live Writer
    remove_action('wp_head', 'rsd_link');                     // Ссылка для сервисов XML-RPC (клиенты блогов)
    remove_action('wp_head', 'wp_shortlink_wp_head');         // Короткие ссылки для страниц/постов
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10); // Ссылки на соседние посты
    remove_action('wp_head', 'rest_output_link_wp_head', 10); // Ссылка на WP REST API
    remove_action('wp_head', 'wp_oembed_add_discovery_links', 10); // Ссылки oEmbed (встраивание контента)
});

// Отключение базовых стилей блоков (Gutenberg) и инлайн-стилей темы
add_action( 'wp_enqueue_scripts', function() {
    wp_dequeue_style( 'wp-block-library' );       // Стили блоков по умолчанию
    wp_dequeue_style( 'wp-block-library-theme' ); // Тема стилей блоков по умолчанию
    wp_dequeue_style( 'global-styles' );          // Инлайн-стили цветов и шрифтов WP
    wp_dequeue_style( 'classic-theme-styles' );   // Стили для обратной совместимости старых тем
}, 100 );

// Disables - редактор блоков для управления виджетами в плагине Gutenberg
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );

// Disables редактор блоков от управления виджетами
add_filter( 'use_widgets_block_editor', '__return_false' );

// Отключение wp-embed
function my_deregister_scripts(){
  wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'my_deregister_scripts' );

// Remove unwanted SVG filter injection WP
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
/* Оптимизация */



// Ограничение количества выводимых символов в заголовке новости на главной
function the_title_excerpt($maxchar = 100) {
  $title = get_the_title();
  //$maxchar = 55; //количество символов

  if (mb_strlen($title) > $maxchar ) {
    $cut_title = mb_substr( $title, 0, $maxchar );
    $cut_title = preg_replace( '~(.*)\s[^\s]*$~s', '\\1...', $cut_title );
  } else {
    $cut_title = $title;
  }

  echo $cut_title;
}

// Redirect to front-page if is post or archive
add_action( 'template_redirect', 'true_redirect' );
 
function true_redirect() {
 
  if ( is_singular('post') || is_archive() ) { // Проверка если это пост 
    wp_redirect( home_url(), 301 ); // Редирект
    exit;
  }
 
}


// Добавление кастомных полей
add_filter( 'rwmb_meta_boxes', 'register_meta_boxes' );
function register_meta_boxes( $meta_boxes ) {
  $meta_boxes = [
    array(
      'id'       => 'file_pdf',
      'title'    => 'Документы PDF',
      'post_type' => 'post',
      'context'  => 'normal',
      'priority' => 'high',
      'fields' => array(
        array(
          'name'  => 'pdf',
          'id'    => 'file_pdf',
          'type'  => 'file_advanced',
          'max_file_uploads' => 1,
          'mime_type' => 'application/pdf',
        )
      )
    ),
    array(
      'id'       => 'gallery',
      'title'    => 'Галерея',
      'pages'    => array('post'),
      'context'  => 'normal',
      'priority' => 'high',
      'fields' => array(
        array(
          'name'  => 'Галерея',
          'id'    => 'gallery',
          'type'  => 'image_advanced',
          'class' => 'custom-class',
          'clone' => false,
        )
      )
    ),
    array(
      'id'       => 'addon',
      'title'    => 'Дополнительно',
      'pages'    => array('post'),
      'context'  => 'normal',
      'priority' => 'high',
      'fields' => array(
        array(
          'name' => 'Специализация',
          'id' => 'specialization',
          'type' => 'text',
        ),
        array(
          'name' => 'Понедельник',
          'id' => 'monday',
          'type' => 'text',
        ),
        array(
          'name' => 'Вторник',
          'id' => 'tuesday',
          'type' => 'text',
        ),
        array(
          'name' => 'Среда',
          'id' => 'wednesday',
          'type' => 'text',
        ),
        array(
          'name' => 'Четверг',
          'id' => 'thursday',
          'type' => 'text',
        ),
        array(
          'name' => 'Пятница',
          'id' => 'friday',
          'type' => 'text',
        ),
        array(
          'name' => 'Суббота',
          'id' => 'saturday',
          'type' => 'text',
        ),
        array(
          'name' => 'Воскресенье',
          'id' => 'sunday',
          'type' => 'text',
        ),
      )
    )
  ];

  return $meta_boxes;

}

// Обрезка текста
function kama_excerpt( $args = '' ){
  global $post;

  if( is_string( $args ) ){
    parse_str( $args, $args );
  }

  $rg = (object) array_merge( [
    'maxchar'           => 350,
    'text'              => '',
    'autop'             => false, // Тег <p>
    'more_text'         => '...',
    'ignore_more'       => false,
    'save_tags'         => '<strong><b><a><em><i><var><code><span>',
    'sanitize_callback' => static function( string $text, object $rg ){
      return strip_tags( $text, $rg->save_tags );
    },
  ], $args );

  $rg = apply_filters( 'kama_excerpt_args', $rg );

  if( ! $rg->text ){
    $rg->text = $post->post_excerpt ?: $post->post_content;
  }

  $text = $rg->text;
  // strip content shortcodes: [foo]some data[/foo]. Consider markdown
  $text = preg_replace( '~\[([a-z0-9_-]+)[^\]]*\](?!\().*?\[/\1\]~is', '', $text );
  // strip others shortcodes: [singlepic id=3]. Consider markdown
  $text = preg_replace( '~\[/?[^\]]*\](?!\()~', '', $text );
  // strip direct URLs
  $text = preg_replace( '~(?<=\s)https?://.+\s~', '', $text );
  $text = trim( $text );

  // <!--more-->
  if( ! $rg->ignore_more && strpos( $text, '<!--more-->' ) ){

    preg_match( '/(.*)<!--more-->/s', $text, $mm );

    $text = trim( $mm[1] );

    $text_append = sprintf( ' <a href="%s#more-%d">%s</a>', get_permalink( $post ), $post->ID, $rg->more_text );
  }
  // text, excerpt, content
  else {

    $text = call_user_func( $rg->sanitize_callback, $text, $rg );
    $has_tags = false !== strpos( $text, '<' );

    // collect html tags
    if( $has_tags ){
      $tags_collection = [];
      $nn = 0;

      $text = preg_replace_callback( '/<[^>]+>/', static function( $match ) use ( & $tags_collection, & $nn ){
        $nn++;
        $holder = "~$nn";
        $tags_collection[ $holder ] = $match[0];

        return $holder;
      }, $text );
    }

    // cut text
    $cuted_text = mb_substr( $text, 0, $rg->maxchar );
    if( $text !== $cuted_text ){

      // del last word, it not complate in 99%
      $text = preg_replace( '/(.*)\s\S*$/s', '\\1...', trim( $cuted_text ) );
    }

    // bring html tags back
    if( $has_tags ){
      $text = strtr( $text, $tags_collection );
      $text = force_balance_tags( $text );
    }
  }

  // add <p> tags. Simple analog of wpautop()
  if( $rg->autop ){

    $text = preg_replace(
      [ "/\r/", "/\n{2,}/", "/\n/" ],
      [ '', '</p><p>', '<br />' ],
      "<p>$text</p>"
    );
  }

  $text = apply_filters( 'kama_excerpt', $text, $rg );

  if( isset( $text_append ) ){
    $text .= $text_append;
  }

  return $text;
}

// Отключение полей в комментариях
add_filter( 'comment_form_fields', 'custom_comment_field' );
function custom_comment_field( $fields ) {

    unset($fields['url']);

    unset($fields['cookies']);

    return $fields;
}

// Переопределение полей комментарии
add_filter('comment_form_fields', 'kama_reorder_comment_fields' );
function kama_reorder_comment_fields( $fields ){
  //die(print_r( $fields )); // посмотрим какие поля есть

  $new_fields = array(); // сюда соберем поля в новом порядке

  $myorder = array('author','comment'); // нужный порядок

  foreach( $myorder as $key ){
    $new_fields[ $key ] = $fields[ $key ];
    unset( $fields[ $key ] );
  }

  // если остались еще какие-то поля добавим их в конец
  if( $fields )
    foreach( $fields as $key => $val )
      $new_fields[ $key ] = $val;

  return $new_fields;
}


// Добавление соглашения в форме комментариев
add_filter('comment_form_submit_field', 'add_checkbox', 10, 2);
function add_checkbox($submit_field, $args) {
  return '<p class="comment-form-checkbox"><label>
  <input type="checkbox" name="checkbox_policy" value="1" required="required">
  Ознакомлен с <a href="/politika-obrabotki-personalnyh-dannyh/" target="_blank">политикой</a></label></p>
  <p class="comment-form-checkbox"><label>
  <input type="checkbox" name="checkbox_agreement" value="1" required="required">
  Согласен на <a href="/soglasie/" target="_blank">обработку персональных данных</a></label></p>' . $submit_field;
}

// Проверка чекбоксов на стороне сервера (Защита от спама и обхода)
add_filter( 'preprocess_comment', 'verify_comment_checkboxes' );
function verify_comment_checkboxes( $commentdata ) {
  if ( ! is_user_logged_in() ) { // Для админов можно отключить проверку
    if ( empty( $_POST['checkbox_policy'] ) || empty( $_POST['checkbox_agreement'] ) ) {
      wp_die( __( '<strong>Ошибка:</strong> Вы должны принять условия политики конфиденциальности.', 'new_theme' ) );
    }
  }
  return $commentdata;
}


// Вывод комментариев
function b_recent_comments( $args = array() ){
  global $wpdb;

  $def = array(
    'limit'      => 20, // сколько комментов выводить.
    'term'       => '', // id категорий/меток. Включить(5,12,35) или исключить(-5,-12,-35) категории. По дефолту - из всех категорий.
    'comm_type'  => 'comment', // название типа комментария
    'meta_query' => '', // WP_Meta_Query
    'meta_key'   => '', // WP_Meta_Query
    'meta_value' => '', // WP_Meta_Query
    'url_patt'   => '', // оптимизация ссылки на коммент. Пр: '%s?comments#comment-%d' плейсхолдеры будут заменены на $post->guid и $comment->comment_ID
  );

  $args = wp_parse_args( $args, $def );
  extract( $args );

  $AND = '';

  // ЗАПИСИ
  if( $term ){
    $cats = explode( ',', $term );
    $cats = array_map( 'intval', $cats );

    $CAT_IN = ( $cats[ key($cats) ] > 0 ); // из категорий или нет

    $cats = array_map( 'absint', $cats ); // уберем минусы
    $AND_term_id = 'AND term_id IN ('. implode(',', $cats) .')';

    $posts_sql = "SELECT object_id FROM $wpdb->term_relationships rel
    LEFT JOIN $wpdb->term_taxonomy tax ON (rel.term_taxonomy_id = tax.term_taxonomy_id) WHERE 1 $AND_term_id ";

    $AND .= ' AND comment_post_ID '. ($CAT_IN ? 'IN' : 'NOT IN') .' ('. $posts_sql .')';
  }

  // WP_Meta_Query
  $META_JOIN = '';
  if( $meta_query || $meta_key || $meta_value ){
    $mq = new WP_Meta_Query( $args );
    $mq->parse_query_vars( $args );
    if( $mq->queries ){
      $mq_sql = $mq->get_sql('comment', $wpdb->comments, 'comment_ID' );
      $META_JOIN = $mq_sql['join'];
      $AND .= $mq_sql['where'];
    }
  }

  $sql = $wpdb->prepare("SELECT * FROM $wpdb->comments LEFT JOIN $wpdb->posts ON (ID = comment_post_ID ) $META_JOIN
  WHERE comment_approved = '1' AND comment_type = %s $AND ORDER BY comment_date_gmt DESC LIMIT %d", $comm_type, $limit );

  //die( $sql );
  $results = $wpdb->get_results( $sql );

  $comments = [];

  if ( $results ) {

    foreach ( $results as $comm ){

      if ($comm->comment_parent == 0) { // Отзыв
        $comment_item = [];

        $comment_id = $comm->comment_ID;
        $comment_author = $comm->comment_author;
        $comment_date = mb_substr($comm->comment_date, 0, 10);
        $comment_content = mb_substr($comm->comment_content, 0, 400);
        $comment_answer = '';

        foreach ( $results as $ans ){
          if ($ans->comment_parent == $comment_id) {
            $comment_answer = mb_substr($ans->comment_content, 0, 200);
            break;
          }
        }

        $comment_item['comment_id'] = $comment_id;
        $comment_item['comment_author'] = $comment_author;
        $comment_item['comment_date'] = $comment_date;
        $comment_item['comment_content'] = $comment_content;
        $comment_item['comment_answer'] = $comment_answer;

        $comments[] = $comment_item;
        
      }

    }
  }

  return $comments;
}


// Логирование комментариев в отдельную таблицу для требований РКН
add_action( 'comment_post', 'log_comment_to_backup_comments_table', 10, 3 );
function log_comment_to_backup_comments_table( $comment_ID, $comment_approved, $commentdata ) {
  global $wpdb;
  $table_name = $wpdb->prefix . 'backup_comments';

  // Корректно получаем имя, даже если пользователь авторизован
  if ( ! empty( $commentdata['comment_author'] ) ) {
     $name = sanitize_text_field( $commentdata['comment_author'] );
  } else {
     $current_user = wp_get_current_user();
     $name = $current_user->exists() ? sanitize_text_field( $current_user->display_name ) : 'Аноним';
  }

  $text = isset( $commentdata['comment_content'] ) ? wp_kses_post( $commentdata['comment_content'] ) : '';

  $ip = '0.0.0.0';
  if ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
     $ip = sanitize_text_field( $_SERVER['REMOTE_ADDR'] );
  }
  $created_at = current_time( 'mysql' );

  $wpdb->insert(
     $table_name,
     array( 'name' => $name, 'text' => $text, 'ip' => $ip, 'created_at' => $created_at ),
     array( '%s', '%s', '%s', '%s' )
  );
}


// Отключаем шаблоны архивов и перенаправляем на 404
function disable_archive_pages() {
    if ( is_archive() ) {
        global $wp_query;
        $wp_query->set_404();
        status_header( 404 );
        nocache_headers();
        include( get_query_template( '404' ) );
        exit;
    }
}
add_action( 'template_redirect', 'disable_archive_pages' );


// Перенаправление страниц вложений (image.php / attachment.php) на главную или родительский пост
function redirect_attachment_to_parent() {
    if ( is_attachment() ) {
        global $post;
        if ( ! empty( $post->post_parent ) ) {
            wp_redirect( get_permalink( $post->post_parent ), 301 );
        } else {
            wp_redirect( home_url( '/' ), 301 );
        }
        exit;
    }
}
add_action( 'template_redirect', 'redirect_attachment_to_parent' );


/**
 * Полное ограничение доступа к REST API для гостей.
 */
function close_rest_api_routes( $result, $rest_server, $request ) {
    if ( ! is_null( $result ) ) {
        return $result;
    }

    // Доступ разрешен только администраторам
    if ( current_user_can( 'manage_options' ) ) {
        return $result;
    }

    return new WP_Error( 
        'rest_not_logged_in', 
        'Access to this REST API route is restricted.', 
        array( 'status' => 401 ) 
    );
}
add_filter( 'rest_pre_dispatch', 'close_rest_api_routes', 10, 3 );

// Disable authors archive
// Return a 404 page for author pages if accessed directly.
add_action( 'template_redirect', function () {
    if ( is_author() ) {
        global $wp_query;
        $wp_query->set_404();
        status_header( 404 );
        nocache_headers();
    }
} );

// Remove the author links.
add_filter( 'author_link', '__return_empty_string', 1000 );
add_filter( 'the_author_posts_link', 'get_the_author', 1000, 0 );

// Remove the author pages from the WP 5.5+ sitemap.
add_filter( 'wp_sitemaps_add_provider', function ( $provider, $name ) {
    if ( 'users' === $name ) {
        return false;
    }
    return $provider;
}, 10, 2 );

// Remove admin links in the list of users.
add_filter( 'user_row_actions', function ( $actions, $user ) {
    unset( $actions['view'] );
    unset( $actions['posts'] );
    return $actions;
}, 10, 2 );

// Удаление строки <style>img:is([sizes="auto" i], [sizes^="auto," i]) { contain-intrinsic-size: 3000px 1500px }</style>
add_filter('wp_img_tag_add_auto_sizes', '__return_false');

?>