<?php

// Include Aj class.
require_once "lib/Aj.php";




function Aj_form($input)
{
  parse_str($input, $formData);
  $text ='<p>'.$formData['name'].'</p>
          <p>'.$formData['email'].'</p>';
  // Можно тестить результат в консоле js
  Aj::addResponse()->window->console->log('my some result');
  // use methods jq or js
  Aj::addResponse()->jQuery("#output1")->css('display','block')->addClass('forOutputBox');
  Aj::addResponse()->document->getElementById("output1")->innerHTML = $text;
}


function Aj_link($input)
{
  parse_str($input, $formData);

  // use methods jq or js
  Aj::addResponse()->jQuery("#output2")->css('display','block')->addClass('forOutputBox');
  Aj::addResponse()->document->getElementById("output2")->innerHTML = '<p>'. ucfirst($formData['v1']) .' '.ucfirst($formData['v2']).'</p>';
}


function Aj_block($input)
{
  parse_str($input, $formData);
  $text ='<p>'. ucfirst($formData['v1']) .' '.ucfirst($formData['v2']).'</p>';
  
  // use methods jq or js
  Aj::addResponse()->jQuery("#output3")->css('display','block')->addClass('forOutputBox');
  Aj::addResponse()->document->getElementById("output3")->innerHTML = $text;
}


function Aj_formfull($input)
{
  parse_str($input, $formData);

  $text ='<p>'. ucfirst($formData['my_country']) .'<br>'.
  ucfirst($formData['my_city']).'<br>'.
  ucfirst($formData['my_ch_01']).'<br>'.
  ucfirst($formData['my_ch_02']).'<br>'.
  ucfirst($formData['my_ch_03']).'<br>'.
  ucfirst($formData['my_ch_04']).'</p>';
  
  // use methods jq or js
  Aj::addResponse()->jQuery("#output4")->css('display','block')->addClass('forOutputBox');
  Aj::addResponse()->document->getElementById("output4")->innerHTML = $text;
}

// Традиционный прием и отдача результат в js функцию
function Aj_successResult($input){
	parse_str($input, $formData); 	// v1=box&v2=request
	echo json_encode($formData); 	  // {"v1":"box","v2":"request"}
}


// 
function Aj_closFoo($input){
	echo $input;
}

?><!DOCTYPE html>
<html>
<head>
    <title>Aj Demo</title>
    <meta charset="utf-8">


    <!-- Необходимое подключения jQuery библиотеки, и вывода скрипта обработчика -->
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <?php Aj::outputJs(0); ?>

  <style>
    html,body{margin: 0;padding: 0;}
    .page{width:625px; border: 4px solid #002185; padding: 10px; margin: 0 auto;}
    .box{border-top:  4px solid #002185; padding: 10px 0;}
    .forOutputBox{ width: 600px; padding: 10px; border: 2px dashed #002185; }
  </style>

  <script>
function js_success(data){
	alert('success!');
}
function js_error(data){
	alert('ERROR!');
	console.log(data);
}

function js_succesResult(data){
	var dataText = JSON.parse(data); // необходимо переобразовать строку в json обект
	jQuery('#output5').text(dataText.v1);
	jQuery('#output6').text(dataText.v2);
	console.log(dataText);
}
  </script>
</head>
<body>

<!-- прмер кликера

onclick="aj('form', $('#myForm').serialize(), 'sync', true, {success:js_success, error:js_error} );"

1 arg - функция php которая обрабатывает успешний запрос к сереру и отдает ответ внутреними методами jq переобразованых в зрз 
по умолчанию функция имеет префикс Aj_ ("myFoo"=>Aj_myFoo)
2 arg - значения запроса, напромер "name=My name Vasia&email=user@user.com" или средствами jq
3 arg - 'async' или 'sync' асинхронный запорс или синхронный. По умолчанию асинхронный
4 arg - url скрипта куда отправляеться запрос, По умолчанию активный скрипт (в котором опрелена функция вызова)
5 arg - обект определяющий дополнительные дейстивия {success:js_success}, js_success - функция js:
стандартные аргументы $.ajax beforeSend, error, success, complete
после описания функции js например js_success аргументы попадают в нее стандартно - автоматически, но еслм передается строка необходимо 
парсить в формат JSON (JSON.parse(data);)
-->

<div class="page">

  <h1>Aj sender</h1>
  <h4>simple ajax request</h4>

  <!-- example with form -->
  <div class="box">
    <div id="output1" style="display: none"></div>
    <form name="myForm" id="myForm">
      <input name="name" value="You Name" />
      <input name="email" value="You Email" />
      <input type="button" value="Aj Send"
             onclick="aj('form', $('#myForm').serialize(), 'sync', true, {error:js_error,success:js_success} );" />
    </form>
  </div>


  <!-- example with links -->
  <div class="box">
    <div id="output2" style="display: none"></div>
    <a href="jopa.php"
       onclick="aj('link', 'v1=hello&v2=world', 'async'); return false;">Hello World</a>
  </div>


  <!-- example with html element -->
  <div class="box">
    <div id="output3" style="display: none"></div>
    <div onclick="aj('block', 'v1=box&v2=request', 'async');">Send me!</div>
  </div>


  <!-- example with links -->
  <div class="box">
    <div id="output4" style="display: block"></div>
    <form name="myFormFull" id="myFormFull">
		<select name="my_country">
		    <option disabled>Выберите героя</option>
		    <option value="Ukraine">Ukraine</option>
		    <option value="Rossia" selected >Rossia</option>
		    <option value="Englend">Englend</option>
		    <option value="Tumba-umba">Tumba-umba</option>
		</select>
		<br><br>
		<input name="my_city" type="radio" value="Kiev" > Kiev<br>
		<input name="my_city" type="radio" value="Moscow" > Moscow<br>
		<input name="my_city" type="radio" value="London" > London<br>
		<input name="my_city" type="radio" value="Tumba-umba" > Tumba-umba<br>
		<br>
		<input name="my_ch_01" type="checkbox" checked value="num1"> номер 1<br>
		<input name="my_ch_02" type="checkbox" value="num2"> номер 2<br>
		<input name="my_ch_03" type="checkbox" value="num3"> номер 3<br>
		<input name="my_ch_04" type="checkbox" value="num4"> номер 4<br>
		<input type="button" value="Aj Send" onclick="aj('formfull', $('#myFormFull').serialize(), 'async');" />
    </form>
  </div>

  
  <!-- example with success result -->
  <div class="box">
    <div id="output5"></div>
    <div id="output6"></div>
    <div onclick="aj('successResult', 'v1=box&v2=request', 'async', true, {success:js_succesResult});">Send Success Result!</div>
  </div>
  
  <!-- example with success result -->
  <div class="box">
    <div id="output7"></div>
    <div onclick="aj('closFoo', 'complete', 'async', true, {success:function(data){
																    	alert('request is : '+data);
																    	jQuery('#output7').text(data);
																    }
															});">Send Result!</div>
  </div>
  
  
</div>
</body>
</html>