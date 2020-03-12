<?php 

//Данные для подключения к БД
include 'db_info.php';

if (!$_POST) exit('No direct script access allowed');
if (!isset($_POST['f'])) exit('No direct script access allowed');

// Класс заявка с публичными свойствами "Номер" и "Сумма" и публичным методом "Обработка"
class Order{

	private $surname = "";
	private $name = "";
	private $second_name = "";
	private $street = "";
	private $house = "";
	private $room = "";
	private $phone = "";
	private $email = "";
	private $doc = "";
	private $ser = "";
	private $num = "";
	private $date = "";
	private $inet_tariff = "";
	private $number_comp = "";
	private $phone_tariff = "";
	private $phone_number = "";
	private $wifiRouter = "";
	private $tvBox = "";
    private $errors = array(); // контейнер для ошибок

    public $summa = 0;
    public $number = Null; // номер заявки
    
    function __construct($arr){

        if (isset($arr['surname']) and $arr['surname'] != "" and
           (preg_match('/^[A-Za-zА-Яа-яЁё]+$/u',$arr['surname']))){
            $this->surname = $arr['surname'];
        }
        else{
    	    $this->errors['surname'] = 'Введите корректную фамилию';
        }

	    if (isset($arr['name']) and $arr['name'] != "" and
		   (preg_match('/^[A-Za-zА-Яа-яЁё]+$/u',$arr['name']))){
	        $this->name = $arr['name'];
	    }
	    else{
	    	$this->errors['name'] = 'Введите корректное имя';
	    }

	    if (isset($arr['second_name']) and $arr['second_name'] != "" and
		   (preg_match('/^[A-Za-zА-Яа-яЁё]+$/u',$arr['second_name']))){
	        $this->second_name = $arr['second_name'];
	    }

	    if (isset($arr['street']) and $arr['street'] != ""){
	        $this->street = $arr['street'];
	    }
	    else{
	    	$this->errors['street'] = 'Введите название улицы';
	    }

	    if (isset($arr['house']) and $arr['house'] != ""){
	        $this->house = $arr['house'];
	    }
	    else{
	    	$this->errors['house'] = 'Введите номер дома';
	    }

	    if (isset($arr['room']) and $arr['room'] != ""){
	        $this->room = $arr['room'];
	    }

	    if (isset($arr['phone']) and $arr['phone'] != "" and
		   (preg_match('/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/',$arr['phone']))){
	        $this->phone = $arr['phone'];
	    }
	    else{
	    	$this->errors['phone'] = 'Введите корректный номер телефона';
	    }

	    if (isset($arr['email']) and filter_var($arr['email'], FILTER_VALIDATE_EMAIL)){
	        $this->email = $arr['email'];
	    }
	    else {
	    	$this->errors['email'] = 'Введите корректный email';
	    }

	    if (isset($arr['doc']) and $arr['doc'] != ""){
	        $this->doc = $arr['doc'];
	    }

	    if (isset($arr['ser']) and $arr['ser'] != ""){
	        $this->ser = $arr['ser'];
	    }

	    if (isset($arr['num']) and $arr['num'] != ""){
	        $this->num = $arr['num'];
	    }
	    else {
	    	$this->errors['num'] = 'Введите номер документа';
	    }

	    if (isset($arr['date']) and $arr['date'] != ""){
	        $this->date = $arr['date'];
	    }
	    else {
	    	$this->errors['date'] = 'Введите дату документа';
	    }

	    if (isset($arr['inet_tariff']) and $arr['inet_tariff'] != "Тариф интернет"){
	        $this->inet_tariff = $arr['inet_tariff'];
	        if ($this->inet_tariff == "Марафон-50"){
	            $sum = 590;
	        }
	        elseif ($this->inet_tariff == "Марафон-80"){
	            $sum = 740;
	        }
	        elseif ($this->inet_tariff == "Марафон-100"){
	            $sum = 849;
	        }
	        elseif ($this->inet_tariff == "Эстафета-50"){
	            $sum = 440;
	        }
	        elseif ($this->inet_tariff == "Эстафета-70"){
	            $sum = 590;
	        }
	        elseif ($this->inet_tariff == "Эстафета-100"){
	            $sum = 740;
	        }
	        elseif ($this->inet_tariff == "Усадьба-30"){
	            $sum = 690;
	        }
	        elseif ($this->inet_tariff == "Усадьба-50"){
	            $sum = 990;
	        }
	        elseif ($this->inet_tariff == "Усадьба-100"){
	            $sum = 1290;
	        }
	        else{
	            echo "Ошибка тарифа";
	            $sum = 0;
	        }
	        $this->summ_count($sum);
	    }


	    if (isset($arr['number_comp']) and $arr['inet_tariff'] != "Тариф интернет"){
	        $this->number_comp = $arr['number_comp'];
	        $sum = ($arr['number_comp'] - 1) * 100;
	        $this->summ_count($sum);
	    }

	    if (isset($arr['phone_tariff']) and $arr['phone_tariff'] != "Тариф телефонии"){
	        $this->phone_tariff = $arr['phone_tariff'];
	        if ($this->phone_tariff == "Безлимитный"){
	            $sum = 404;
	        }
	        if ($this->phone_tariff == "Поминутный"){
	            $sum = 180;
	        }
	        $this->summ_count($sum);
	        $this->summ_count(4800); /*Стоимость установки городского телефона*/
	    }

	    if (isset($arr['phone_number']) and $arr['phone_number'] != "Не выбрано"){
	        $this->phone_number = $arr['phone_number'];
	    }

	    if (isset($arr['wifiRouter']) and $arr['wifiRouter'] == "on"){
	        $this->wifiRouter = $arr['wifiRouter'];
	        $this->summ_count(1300);
	    }
	    if (isset($arr['TVBox']) and $arr['TVBox'] == "on"){
	        $this->tvBox = $arr['TVBox'];
	        $this->summ_count(3800);
	    }
    }

    private function summ_count($sum){
    	$this->summa += $sum;
    }

    private function set_in_base(){

    	global $dbHost;
    	global $dbUsername;
    	global $dbPassword;
    	global $dbName;

    	$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName); 
		$db->set_charset("utf8");

		// Проверяем соединение
		if ($db->connect_error) { 
		    die("Connection failed: " . $db->connect_error); 
		} 
		
		//определяем номер заявки
		$query = $db->query("SELECT COUNT(*) FROM orders"); 
		$row = ($query->fetch_row());
		$count = (int)$row[0];
		if ($count > 0){
			$this->number = $count + 1;
		}
		else{
			$this->number = 1;
		}

		//добавляем заявку в базу
		$query = "INSERT INTO orders (surname, first_name, second_name, street, house, room, phone, email, doc, ser, num, doc_date, inet_tariff, number_comp, phone_tariff, phone_number, wifiRouter, tvBox, summa) VALUES ('$this->surname', '$this->name', '$this->second_name', '$this->street', '$this->house', '$this->room', '$this->phone', '$this->email', '$this->doc', '$this->ser', '$this->num', '$this->date', '$this->inet_tariff', '$this->number_comp', '$this->phone_tariff', '$this->phone_number', '$this->wifiRouter', '$this->tvBox', $this->summa)"; 

		if ($db->query($query) === TRUE) {
		   echo "Заявка № $this->number успешно сформирована.";
		} else {
		   echo "Ошибка: " . $query . "<br>" . $db->error;
		}
    }

    public function handle(){
        
    	// если форма без ошибок
        if(empty($this->errors)){   
            
            // пишем данные новой заявки в базу
            $this->set_in_base();
            
        }else{
            echo json_encode($this->errors); // делаем ответ на клиентскую часть в формате JSON с ошибками
        }
    }
}

//Создаём объект "Заявка"
$order = new Order($_POST['f']);
//Обрабатываем заявку
$order->handle();


    
 
    
   