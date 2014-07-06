<?php

// Include Aj class.
require_once "lib/AjPhp.php";


function Aj_link($input)
{
  parse_str($input, $formData);

  // use methods jq or js
  Aj::addResponse()->jQuery("#output")->css('display','block')->addClass('forOutputBox');
  Aj::addResponse()->document->getElementById("output")->innerHTML = '<p>'. ucfirst($formData['v1']) .' '.ucfirst($formData['v2']).'</p>';
}


function Aj_toOutput($input)
{
  parse_str($input, $formData);
  echo '<p>'. ucfirst($formData['v1']) .' '.ucfirst($formData['v2']).'</p>';
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

</head>
<body>

<div class="page">

  <h1>Aj sender</h1>
  <h4>simple ajax request</h4>

  <!-- OPTIONS
Обезательные первые два параметра "func" и "data"
onclick="aj({
    func:'string',          Имя вызываемой функции php. ОБИЗАТЕЛЕН!
    data:'url string',      (стандарт jq $.ajax) данные дял передачи "value=User Name&...". ОБИЗАТЕЛЕН!
    url:'string',           (стандарт jq $.ajax) URL путь к файлу. По умолчанию current script file.
    async:'string',         (стандарт jq $.ajax) асинхронный "async" или синхронные "sync". По умолчанию "async".
    type:'string',          (стандарт jq $.ajax) POST или GET. По умолчанию POST/
    beforeSend:function,    (стандарт jq $.ajax) beforeSend,complete,error,success
    complete:function,              работают одинаково.
    error:function,                 принимать могут имя функции javascript или анонимную функцию
    success:function,               аргументы залитают автоматически. По умолчанию false.
    output:'#output'        селектор вывода результата, заменяет "success", выводит данные определенные функцией PHP "func" методом .html(). По умолчанию false.
});"
-->


  <!-- example with links -->
  <div class="box">
    <div id="output" style="display: none"></div>
    <div class="out"></div>
    <a href="file.php" onclick="aj({
                        func:'toOutput',
                        data:'v1=user&v2=request',
                        output:'.out'
                        }); return false;">request</a>
  </div>


</div>
</body>
</html>