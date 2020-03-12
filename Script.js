$('#ok_button').hide();
$('#send_button').click(function(){
    $.post(
        './php/Handle.php', // адрес обработчика
         $("#my_form").serialize(), // отправляемые данные          
        function(msg) { // получен ответ сервера 
        // стираем ошибки 
        	console.log(msg);
        	$('#errName').html('');
        	$('#errSurname').html('');
            $('#errEmail').html('');
            $('#errStreet').html('');
            $('#errHouse').html('');
            $('#errPhone').html('');
            $('#errNum').html('');
            $('#errDate').html('');
            // проверяем ответ от сервера
        	if (msg.includes("Заявка")){
        		$('#my_form').hide('slow');
            	$('#answer').html(msg);
            	$('#ok_button').show();
        	}
            else {
            	var err = $.parseJSON(msg)
            	// пишем ошибки
            	$('#errSurname').html(err.surname);
            	$('#errEmail').html(err.email);
            	$('#errName').html(err.name);
            	$('#errStreet').html(err.street);
            	$('#errHouse').html(err.house);
            	$('#errPhone').html(err.phone);
            	$('#errNum').html(err.num);
            	$('#errDate').html(err.date);
            }
            
        }
    );
});
// кнопка возврата в форму
$('#ok_button').click(function(){
  $('#my_form').show('slow');
  $('#answer').html('');
  $('#ok_button').hide();
});
// функция быстрого выбора улиц
$( function() {
    $("#street").autocomplete({
      source: './php/streets.php',
      minLength: 3
    });
  } );