<?php
$msg_box = "";
$errors = array();
// Дополнить проверки корректности полей
if($_POST['property_address'] == "")   $errors[] = "Поле 'Адрес' не заполнено!";
if($_POST['property_square'] +1 < 0) $errors[] = "Поле 'Общая Площадь' не заполнено!";
if($_POST['property_living'] +1 < 0) $errors[] = "Поле 'Жилая Площадь' не заполнено!";
if($_POST['property_cost'] +1< 0) $errors[] = "Поле 'Стоимость' не заполнено!";
if($_POST['property_floor'] +1 < 0) $errors[] = "Поле 'Этаж' не заполнено!";
if($_POST['property_type'] == "Выберите категорию") $errors[] = "Поле 'Категория' не заполнено!";
if($_POST['property_city'] == "Выберите город") $errors[] = "Поле 'Категория' не заполнено!";
if($_POST['property_text'] == "") $errors[] = "Поле 'Описание' не заполнено!";


if(empty($errors)) {
        $postarr=array(
            'post_content' => $_POST['property_text'],
            'post_title' => $_POST['property_address'],
            'post_status' => 'pending',
            'post_type' => 'the_property'
        );
        $attachment_id=0;
        $postid = wp_insert_post($postarr, $wp_error = false);
        if( ! empty( $_FILES ) ) {
           foreach ($_FILES as $file) {
                if (is_array($file)) {
                    $attachment_id = save_upload_files($file,$postid);
                }
           }
        }
        set_post_thumbnail( $postid, $attachment_id ); //последний файл как миниатюра

        if($postid > 1 &&
        add_post_meta( $postid, 'address', $_POST['property_address']) &&
        add_post_meta( $postid, 'square', $_POST['property_square'])   &&
        add_post_meta( $postid, 'living_space', $_POST['property_living']) &&
        add_post_meta( $postid, 'cost', $_POST['property_cost'])       &&
        add_post_meta( $postid, 'floor', $_POST['property_floor']) &&
        add_post_meta( $postid, 'the_city', $_POST['property_city']) &&
        wp_set_post_terms( $postid, $_POST['property_type'], 'property_type')
        )

            {  $msg_box = "<span style='color: green;'>Добавлено успешно!</span>"; }
        else {$msg_box = "<span style='color: red;'>Неизвестная ошибка!</span>";}


}else{
    $msg_box = "";
    foreach($errors as $one_error){
        $msg_box .= "<span style='color: red;'>$one_error</span><br/>";
    }
}

// делаем ответ на клиентскую часть в формате JSON
echo json_encode(array(
    'result' => $msg_box
));wp_die ();

?>