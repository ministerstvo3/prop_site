<?php

//-------------------------------------------------------------------
//register new post type
add_action( 'init', 'register_new_post_type_init' );

function register_new_post_type_init() {
    $labels = array(
        'name' => 'Недвижимость',
        'singular_name' => 'Недвижимость',
        'add_new' => 'Добавить Недвижимость',
        'add_new_item' => 'Добавить новую Недвижимость',
        'edit_item' => 'Редактировать Недвижимость',
        'new_item' => 'Новая Недвижимость',
        'all_items' => 'Вся Недвижимость',
        'view_item' => 'Просмотр Недвижимости на сайте',
        'search_items' => 'Искать Недвижимость',
        'not_found' =>  'Недвижимость не найдена.',
        'not_found_in_trash' => 'В корзине нет Недвижимости.',
        'menu_name' => 'Недвижимость'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_ui' => true, //admin menu
        'has_archive' => true,
        'menu_position' => 15, // порядок в меню
        'supports' => array( 'title', 'editor', 'author', 'thumbnail','custom-fields' ),
        'taxonomies' => array( '' )
    );
    register_post_type('the_property', $args);
    $labels = array(
        'name' => 'Города',
        'singular_name' => 'Города',
        'add_new' => 'Добавить Город',
        'add_new_item' => 'Добавить новый Города',
        'edit_item' => 'Редактировать Город',
        'new_item' => 'Новый Города',
        'all_items' => 'Все Города',
        'view_item' => 'Просмотр Города на сайте',
        'search_items' => 'Искать Город',
        'not_found' =>  'Город не найдена.',
        'not_found_in_trash' => 'В корзине нет Города.',
        'menu_name' => 'Города'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_ui' => true, //admin menu
        'has_archive' => true,
        'menu_position' => 16, // порядок в меню
        'supports' => array( 'title', 'editor', 'thumbnail')
    );
    register_post_type('cities', $args);
}

//-------------------------------------------------------------------
//register new taxonomy
add_action( 'init', 'register_new_taxonomy_init' );
function register_new_taxonomy_init(){
    $args=array(
        'labels' => array(
            'name' => 'Тип недвижимости',
            'singular_name' => 'Тип недвижимости',
            'search_items' =>  'Найти Тип недвижимости',
            'popular_items' => 'Популярный Тип недвижимости',
            'all_items' => 'Все Типы недвижимости',
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => 'Редактировать Тип недвижимости',
            'update_item' => 'Обновить Тип недвижимости',
            'add_new_item' => 'Добавить новый Тип недвижимости',
            'new_item_name' => 'Название нового Типа недвижимости',
            'separate_items_with_commas' => 'Разделяйте Тип недвижимости запятыми',
            'add_or_remove_items' => 'Добавить или удалить Тип недвижимости',
            'choose_from_most_used' => 'Выбрать из наиболее часто используемых Тип недвижимости',
            'menu_name' => 'Тип недвижимости'
        ),
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array(
            'slug' => 'property_type',
            'hierarchical' => false
        ),
    );

    register_taxonomy('property_type', 'the_property', $args);
}

//------------------------------------------
//form for add property on main page
function mup_load_scripts() {

    wp_enqueue_script('ajax.googleapis.com', 'https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js');

    $data = array(
        'upload_url' => admin_url('async-upload.php'),
        'ajax_url'   => admin_url('admin-ajax.php'),
        'nonce'      => wp_create_nonce('media-form')
    );

    wp_localize_script( 'ajax.googleapis.com', 'mup_config', $data );
}
add_action('wp_enqueue_scripts', 'mup_load_scripts');

function get_form_for_add_property(){
    wp_enqueue_script('script_pfc' );
    ?>
    <div>
        <h2>Добавить недвижимость</h2>
        <div class="messages"></div>
        <br/>
        <form enctype="multipart/form-data" method="post" name="add_property">
            <div class="row">
                <label class="col-xs-12 col-sm-3">Адрес:</label>
                <input  class="col-xs-12 col-sm-9" type="text" id="property_address" value="" />
            </div>
            <br/>
            <div class="row">
                <label class="col-xs-12 col-sm-3">Общая площадь:</label>
                <input class="col-xs-12 col-sm-9" type="text" id="property_square" value="" />
            </div>
            <br/>
            <div class="row">
                <label class="col-xs-12 col-sm-3">Жилая площадь:</label>
                <input class="col-xs-12 col-sm-9" type="text" id="property_living" value="" />
            </div>
            <br/>
            <div class="row">
                <label class="col-xs-12 col-sm-3">Стоимость:</label>
                <input class="col-xs-12 col-sm-9" type="text" id="property_cost" value="" />
            </div>
            <br/>
            <div class="row">
                <label class="col-xs-12 col-sm-3">Тип недвижимости:</label>
                <select class="col-xs-12 col-sm-9" name="select" id="property_type">
                    <option value="Выберите категорию">Выберите категорию</option>
                        <?php
                        $terms2 = get_terms( array(
                                    'taxonomy' => 'property_type',
                                    'hide_empty' =>0
                                    ));
                        foreach( $terms2 as $term ){
                            echo '<option value="'.$term->name.'">'.$term->name.'</option>';
                        }
                        ?>
                </select>
            </div>
            <br/>
            <div class="row">
                <label class="col-xs-12 col-sm-3">Город:</label>
                <select class="col-xs-12 col-sm-9" name="select" id="property_city">
                    <option value="Выберите город">Выберите город</option>
                        <?php
                        $posts = get_posts( array(
                                        'numberposts' => -1,
                                        'orderby'     => 'title',
                                        'order'       => 'asc',
                                        'post_status'     => 'publish',
                                        'post_type'   => 'cities'
                                    ) );
                        foreach( $posts as $post ){
                                $post_title = get_the_title( $post );
                                echo '<option value="'.$post_title.'">'.$post_title.'</option>';
                        }
                        ?>
                </select>
            </div>
            <br/>
            <div class="row">
                <label class="col-xs-12 col-sm-3">Этаж:</label>
                <input class="col-xs-12 col-sm-9" type="text" id="property_floor" value="" />
            </div>
            <br/>
            <div class="row">
                <label class="col-xs-12 col-sm-3">Фотографии:</label>
                <input class="col-xs-12 col-sm-9" type="file"  id="files"  accept="image/jpeg" name="img[]" multiple="multiple">
            </div>
            <br/>
            <div class="row">
                <label class="col-xs-12 col-sm-3">Описание:</label>
                <textarea class="col-xs-12 col-sm-9" id="property_text"></textarea>
            </div>
            <br/>
            <input type="button" value="Отправить" id="btn_submit" />
        </form>
    </div>
    <?php
}

//-------------------------------------------------------------------------------------
//save property from main page
function add_property(){
   require_once plugin_dir_path(__FILE__) . 'action.php';
}
add_action('wp_ajax_nopriv_add_property', 'add_property' );
add_action('wp_ajax_add_property', 'add_property' );

function save_upload_files( $file = array(),$postid=0 ) {
        require_once( ABSPATH . 'wp-admin/includes/admin.php' );

        $file_return = wp_handle_upload( $file, array('test_form' => false ) );

        if( isset( $file_return['error'] ) || isset( $file_return['upload_error_handler'] ) ) {
          return false;
        } else {
          $filename = $file_return['file'];
          $attachment = array(
              'post_mime_type' => $file_return['type'],
              'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
              'post_content' => '',
              'post_status' => 'inherit',
              'post_parent' =>  $postid,
              'guid' => $file_return['url']
          );
          $attachment_id = wp_insert_attachment( $attachment, $file_return['url'] );
          require_once(ABSPATH . 'wp-admin/includes/image.php');
          $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );
          wp_update_attachment_metadata( $attachment_id, $attachment_data );
          if( 0 < intval( $attachment_id ) ) {
               return $attachment_id;
          }
      }
      return false;
}

//------------------------------------------------------------------------------
//get preview block

function get_item_block($post){
    ?>
    <div class="row item_block">
    <div class="col-xs-12 col-sm-12" >
        <div class="col-xs-12 col-sm-12">
            <h3 class=""><?php the_title(); ?></h3>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <img class="shomtek_post_image-list" src="<?php
                $tid=get_post_thumbnail_id($post);
                $thumb_url = wp_get_attachment_image_src($tid,'medium', true);
                echo $thumb_url[0]; ?>" />
            </div>
            <div class="col-xs-12 col-sm-8">
                <?php

                $posts = get_posts( array(
                    'post_type' => 'acf-field',
                    'numberposts' => -1,
                    'post_status'     => 'publish',
                    'post_parent'   => '19' //группа мета характеристик недвижимости
                ) );
                $text="";
                foreach( $posts as $p ){
                    if(get_post_meta( get_the_ID($p), strstr(get_the_excerpt($p), ' ', true), true )!=""){
                            $text=$text.get_the_title($p).": ".get_post_meta( get_the_ID($p), strstr(get_the_excerpt($p), ' ', true), true )."<br>";
                    }
                }
                if($text==""){ the_excerpt();}
                else{echo $text;}

                ?>
            </div>
        </div>

        <?php
        if($text!=""){ ?>
        <div class="col-xs-12 col-sm-12" style="display: inherit;">
            <a data-elementor-open-lightbox="default" class="a-list" href="<?php the_permalink() ?>" >Подробности.</a>
        </div>
        <?php
        } ?>
    </div>
    </div>
    <?php
}

//-----------------------------------------------------------------
//block with attach photo in admin

function images_box_func(){
    global $post;
    $arr= get_posts( array (
        'post_type' => 'attachment',
        'post_parent' => $post->ID
        ));

    echo '<div>';
    ?>
        <h1>Фотографии аттача</h1>
        <ul id="temp-files-page-slider-2" class="attachments-post">
            <?php foreach ($arr as $item){
                ?>

                <li class="" style="min-width: 200px;width:30%;display:inline-block;text-align:center;">
                    <div>
                        <img style="width: 100%;" src="<?php echo $item->guid; ?>">
                    </div>
                    <div id="rcl-field-post_title" class="rcl-field-input type-text-input">
                        <a class="" target="_blank" href="/wp-admin/post.php?post=<?php echo $item->ID; ?>&action=edit">В галерею</a>
                    </div>
                </li>
            <?php }   ?>
        </ul>
        <?php
    echo '</div>';

}
?>