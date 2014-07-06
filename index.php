<?php
include 'source/Aj.php';

function Aj_form($input){

    parse_str($input, $formData);

    $result = '<p>'. ucfirst($formData['name']) .' '.ucfirst($formData['email']).'</p>';
    Aj::addResponse()->jQuery(".output")->css('display','block')->html($result);

    // use methods jq or js
    //Aj::addResponse()->document->getElementById("output")->innerHTML = $result;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Aj Demo</title>
    <meta charset="utf-8">

    <!-- Необходимое подключения jQuery библиотеки, и вывода скрипта обработчика -->
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>

    <!-- Инициализация метода вывода скрипта js функции отбаботчика запросов -->
    <?php Aj::outputJs(0); ?>

    <style>
        body{margin: 0;padding: 0; background: #0055aa; color: #0055aa; }
        .page{width:960px; background: #d9d9d9; border: 4px solid #002185; padding: 10px; margin: 0 auto; font-family: Verdana, Arial; font-size: 12px; box-shadow: 0 0 20px #000085;}
        .box{border-top:  4px solid #002185; padding: 10px 0; box-shadow: 0 0 10px #002185; padding: 5px;}
        .output{ width: 600px; padding: 10px; border: 2px dashed #002185; }
        .content{}
        .content pre{
            color: darkorange;
            display: block;
            background: #002185;
            padding: 5px;
            font-family: Consolas, Monaco, "Courier New", Courier, monospace;
            font-size: 12px;
        }
    </style>

</head>
<body>
    <div class="page">

        <h2>Aj PHP Example</h2>

        <!-- example with form -->
        <div class="box">
            <form>
                <input name="name" value="You Name" placeholder="You Name" />
                <input name="email" value="You Email" placeholder="You Email" />
                <input type="button" value="Aj Send" placeholder="Send"
                       onclick="aj({
                       func: 'form',
                       data: 'name='+$('[name=name]').val()+'&email='+$('[name=email]').val()
                       });" />
            </form>
            <div class="output" style="display: none">output</div>
        </div>

        <div class="content">
            <h3>Простой пример использования:</h3>
            <p>Передача данных формы с последующим ответов в заданый блок</p>


            <br/>
            <h3>CODE</h3>
            <pre>
&lt;?php
include 'source/Aj.php';

function Aj_form($input){
    parse_str($input, $formData);
    $result = '&lt;p&gt;'. ucfirst($formData['name']) .' '.ucfirst($formData['email']).'&lt;/p&gt;';
    Aj::addResponse()->jQuery(".output")->css('display','block')->html($result);
}

?&gt;
&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
    &lt;title&gt;&lt;/title&gt;
    &lt;script src="http://code.jquery.com/jquery-1.9.1.min.js"&gt;&lt;/script&gt;
    &lt;?php Aj::outputJs(0); ?&gt;
&lt;/head&gt;
&lt;body&gt;

    &lt;div class="box"&gt;
        &lt;form&gt;
            &lt;input name="name" /&gt;
            &lt;input name="email" /&gt;
            &lt;input type="button"
                   onclick="aj({
                           func: 'form',
                           data: 'name='+$('[name=name]').val()+'&email='+$('[name=email]').val()
                           });" /&gt;
        &lt;/form&gt;
        &lt;div class="output" style="display: none"&gt;output&lt;/div&gt;
    &lt;/div&gt;

&lt;/body&gt;
&lt;/html&gt;</pre>



            <br/>
            <h3>Установка:</h3>
            <div>
            <p>1. Заинклюдить файл Aj.php.</p>
            <p>2. Подключить библиотеку jQuery.</p>
            <p>3. Инициализировать метод Aj::outputJs(0) в зазметке между head.</p>
            <p>4. Написать скрипт для передачи данных. Вызывать функцию JS aj(obj) принимает обект. Опции описаны ниже.</p>
            <p>5. Написать функцию для приему данных. По умолчаю имя функции начинается с префикса Aj_названиеФункции. Функция принимает 1 аргумент в виде переданных данных.</p>
            </div>


            <br/>
            <h3>Опции функции JS:</h3>
            <div>
                <p>Обезательные первые два параметра "func" и "data"</p>
<pre>
onclick="aj({
    func:'string',          //Имя вызываемой функции php. ОБИЗАТЕЛЕН!
    data:'url string',      //(стандарт jq $.ajax) данные дял передачи "value=Name&value2=name@a.com&...". ОБИЗАТЕЛЕН!
    url:'string',           //(стандарт jq $.ajax) URL путь к файлу. По умолчанию current script file.
    async:'string',         //(стандарт jq $.ajax) асинхронный "async" или синхронный "sync". По умолчанию "async".
    type:'string',          //(стандарт jq $.ajax) POST или GET. По умолчанию POST/
    beforeSend:function,    //(стандарт jq $.ajax) beforeSend,complete,error,success
    complete:function,      //        работают одинаково.
    error:function,         //        принимать могут имя функции javascript или анонимную функцию
    success:function,       //        аргументы залитают автоматически. По умолчанию false.
    output:'#output'        //селектор вывода результата, заменяет "success", выводит данные определенные функцией PHP "func"
                            //        методом .html(). По умолчанию false.
});"</pre>

            </div>

        </div>

    </div>
</body>
</html>