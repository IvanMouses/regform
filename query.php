<?php
require 'class.phpmailer.php';
require 'class.smtp.php';
require 'vendor/autoload.php';
require_once 'PHPExcel/Classes/PHPExcel.php';
require_once 'PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';
require_once 'PHPExcel/Classes/PHPExcel/IOFactory.php';
$xls = PHPExcel_IOFactory::load('data.xlsx');
$counter=False;

header('Content-Type: text/html; charset=utf-8');
mb_internal_encoding("windows-1251");
$lastName = $_POST["lastName"];
$pName = $_POST["pName"];
$othName = $_POST["othName"];
$vContact = $_POST["vContact"];
$vContact = trim($vContact);
$vPhone = $_POST["phone"];
$pSex = $_POST["pSex"];
$fioCh = $_POST["fioCh"];
$passNo = $_POST["passNo"];
$passSerial = $_POST["passSerial"];
$passDate = $_POST["passDate"];
$passGave = $_POST["passGave"];
$birthNo = $_POST["birthNo"];
$birthSerial = $_POST["birthSerial"];
$birthDate = $_POST["birthDate"];
$birthGave = $_POST["birthGave"];
$obienin = $_POST["associationArr"]; //массив с желаемыми объединениями 
$count = count ($obienin); //сколько всего заявлений
$vDate = $_POST["vDate"];
$snils = $_POST['snils'];
$dopInfo = $_POST['dopInfo'];
//доп инфа

$cityAcc = $_POST["cityAcc"];
$streetAcc = $_POST["streetAcc"];
$homeAcc = $_POST["homeAcc"];
$corAcc = $_POST["corAcc"];
$appAcc = $_POST["appAcc"];
$passportValue = $_POST["passportValue"];
$doNumber = $_POST["doNumber"];
$schoolNumber = $_POST["schoolNumber"];
$classNumber = $_POST ["classNumber"];
$familyComp = $_POST ["familyComp"];
$socStat = $_POST ["socStat"];






//Прописываем в заявление данные
for($i = 0; $i < $count; $i++)
{
$PHPWord = new \PhpOffice\PhpWord\PhpWord();
$document = $PHPWord->loadTemplate('Template.docx');
$document->setValue('lastName', $lastName); //Фамилия 
$document->setValue('pName', $pName); //Имя
$document->setValue('othName', $othName); //Отчество
$document->setValue('vContact', $vContact);// Контактные данные
$document->setValue('vPhone', $vPhone);// Телефон
$document->setValue('pSex', $pSex);// Пол ребёнка
$document->setValue('fioCh', $fioCh);// ФИО ребёнка
$document->setValue('obienin', $obienin[$i]);// Объединение
$document->setValue('vDate', $vDate);// Объединение
$document->setValue('passNo', $passNo);// 
$document->setValue('passSerial', $passSerial);//
$document->setValue('passDate', $passDate);//  
$document->setValue('passGave', $passGave);//
$document->setValue('birthNo', $birthNo);// 
$document->setValue('birthSerial', $birthSerial);//
$document->setValue('birthDate', $birthDate);//  
$document->setValue('birthGave', $birthGave);//

if($cityAcc) {
	$document->setValue('cityAcc', $cityAcc); //Город 
}
else {
	$document->setValue('cityAcc', ''); 
}	

if($streetAcc) {
	$document->setValue('streetAcc', $streetAcc); //Улица 
}
else {
	$document->setValue('streetAcc', ''); 
}

if($homeAcc) {
	$document->setValue('homeAcc', $homeAcc); //Дом 
}
else {
	$document->setValue('homeAcc', ''); 
}	

if($corAcc) {
	$document->setValue('corAcc', $corAcc); //Корпус
}
else {
	$document->setValue('corAcc', ''); 
}

if($appAcc) {
	$document->setValue('appAcc', $appAcc); //Квартира 
}
else {
	$document->setValue('appAcc', ''); 
}

if($passportValue) {
	$document->setValue('passportValue', $passportValue); //Паспортные данные 
}
else {
	$document->setValue('passportValue', '_________________________________');
	
}

if($snils) {
	$document->setValue('snils', $snils); //снилс
}
else {
	$document->setValue('snils', ' ');
	
}

if($doNumber) {
	$document->setValue('doNumber', $doNumber); //Учреждение ДО 
}
else {
	$document->setValue('doNumber', '________________________________________'); 
}

if($schoolNumber) {
	$document->setValue('schoolNumber', $schoolNumber); //Школа 
}
else {
	$document->setValue('schoolNumber', '_________'); 
}

if($classNumber) {
	$document->setValue('classNumber', $classNumber); //Класс 
}
else {
	$document->setValue('classNumber', '_____'); 
}

if($familyComp) {
	$document->setValue('familyComp', $familyComp); //Состав семьи
}
else {
	$document->setValue('familyComp', 'полная / неполная / многодетная (нужное подчеркнуть)'); 
}

if($socStat) {
	$document->setValue('socStat', $socStat); //Соц статус 
}
else {
	$document->setValue('socStat', 'сирота / под опекой / под попечительством / инвалид детства (нужное подчеркнуть)'); 
}	

if($dopInfo==true&&$dopInfo!= ' ') {
	$document->setValue('dopInfo', $dopInfo); //Доп информация 
}
else {
	$document->setValue('dopInfo', '___________________________________________________'); 
}

$document->saveAs('Attachment'.$i.'.docx'); //имя заполненного шаблона 
}

//Отправка письма

// Настройки
$mail = new PHPMailer;
$mail->CharSet = "UTF-8";
//$mail->isSMTP(); 
$mail->Host = 'smtp.yandex.ru'; 
$mail->SMTPAuth = true; 
$mail->Username = 'zddut2007forma'; // Ваш логин в Яндексе. Именно логин, без @yandex.ru
$mail->Password = 'ndjhxtcndj123'; // Ваш пароль
$mail->SMTPSecure = 'tls';
$mail->Port = 587; 
$mail->setFrom("zddut2007forma@yandex.ru", "zddut2007forma@yandex.ru"); // Ваш Email
$mail->addAddress("ZDDUT2007@yandex.ru", "Получатель"); // Email получателя
$mail->addAddress($vContact, "Получатель"); // Email получателя
$mail->AddAttachment($_FILES['upload']['tmp_name'], $_FILES['upload']['name']);
$mail->AddAttachment($_FILES['upload2']['tmp_name'], $_FILES['upload']['name']);		
//Приложения
for($i = 0; $i < $count; $i++)
{
$mail->AddAttachment('Attachment'.$i.'.docx', $obienin[$i].'.docx');	
}                                 

// Письмо
$mail->isHTML(true); 
$mail->Subject = "Заявление о приёме ".$fioCh." в объединения ЗДДТ"; // Заголовок письма
$mail->Body    = "Это письмо сформировано автоматически. Не нужно на него отвечать"; // Текст письма

//запись в excel всех данных
$i=1;
for($j=0; $j < $count; $j++)
{
	$counter=False;
	while($counter!=True)
	{	//устанавливаем счётчик
		$temp=$xls->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		//если нашли пустую строку, производим запись новых данных в неё
		if($temp=='')
		{
			$counter=True; //отключение цикла while
			$xls->setActiveSheetIndex(0);
			$xls->getActiveSheet()->setCellValueExplicit("A".$i, $lastName); //Фамилия
			$xls->getActiveSheet()->setCellValueExplicit("B".$i, $pName); //Имя
			$xls->getActiveSheet()->setCellValueExplicit("C".$i, $othName); //Отчество
			$xls->getActiveSheet()->setCellValueExplicit("D".$i, $vContact);// Контактные данные
			$xls->getActiveSheet()->setCellValueExplicit("E".$i, $vPhone);// Телефон
			$xls->getActiveSheet()->setCellValueExplicit("F".$i, $pSex);// Пол ребёнка
			$xls->getActiveSheet()->setCellValueExplicit("G".$i, $snils);// СНИЛС
			$xls->getActiveSheet()->setCellValueExplicit("H".$i, $fioCh);// ФИО ребёнка
			$xls->getActiveSheet()->setCellValueExplicit("I".$i, $obienin[$j]);// Объединение ?????????????????????????
			$xls->getActiveSheet()->setCellValueExplicit("J".$i, $cityAcc); //Город 
			$xls->getActiveSheet()->setCellValueExplicit("K".$i, $streetAcc); //Улица 
			$xls->getActiveSheet()->setCellValueExplicit("L".$i, $homeAcc); //Дом 
			$xls->getActiveSheet()->setCellValueExplicit("M".$i, $corAcc); //Корпус
			$xls->getActiveSheet()->setCellValueExplicit("N".$i, $appAcc); //Квартира 
			$xls->getActiveSheet()->setCellValueExplicit("O".$i, $doNumber); //Учреждение ДО 
			$xls->getActiveSheet()->setCellValueExplicit("P".$i, $schoolNumber); //Школа 
			$xls->getActiveSheet()->setCellValueExplicit("Q".$i, $classNumber); //Класс 
			$xls->getActiveSheet()->setCellValueExplicit("R".$i, $familyComp); //Состав семьи
			$xls->getActiveSheet()->setCellValueExplicit("S".$i, $socStat); //Соц статус 
			$xls->getActiveSheet()->setCellValueExplicit("T".$i, $dopInfo); //Доп информация 
			$xls->getActiveSheet()->setCellValueExplicit("U".$i, date('Y.m.d H:i:s')); //Дата записи
			
			$objWriter = new PHPExcel_Writer_Excel2007($xls);
			$objWriter->save('data.xlsx');
		}
		//если не нашли, переходим на следующую строку
		$i++;
	}
}


if($mail->send()) {
	echo '<h3 align = "center"> Заявление сформировано. В ближайшее время мы свяжемся с Вами касательно статуса рассмотрения Вашего заявления<br><br><br>
	<a href = "https://зддт.рф/">Вернуться на сайт </a><br>
	<i></i></h3>';
	
	
	
}
?>
