$(document).ready(function(){
    $('#btn_submit').click(function(){
        // собираем данные с формы
        var data = new FormData();
        for (var i = 0; i < $("#files").get(0).files.length; i++) {
            var file = $("#files").get(0).files[i];
            if(file!=undefined){
                data.append("file"+i, file);
            }
        }
        data.append('action', 'add_property');
        data.append('property_address',$('#property_address').val());
        data.append('property_square',$('#property_square').val());
        data.append('property_living',$('#property_living').val());
        data.append('property_cost',$('#property_cost').val());
        data.append('property_type',$('#property_type').val());
        data.append('property_floor',$('#property_floor').val());
        data.append('property_text',$('#property_text').val());
        data.append('property_city',$('#property_city').val());

        // отправляем данные
        $.ajax({
            url: "/wp-admin/admin-ajax.php",
            method: 'post',
            dataType: "json",
            processData: false,
            contentType: false,
            data: data,

            // после получения ответа сервера
            success: function(data){
                $('.messages').html(data.result); // выводим ответ сервера
                $('form[name=add_property]').trigger('reset');
            }
        });
    });
});
