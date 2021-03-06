<?php
/**
 * Класс для работы с AJAX запросами. AjPHP
 * Преимущества: 
 * - простое, быстрое создания кликеров и обработчика запросов и вывода результатов
 * - доступ к метода JS прямо из PHP кода
 */


// Start
Aj::execRequest();

/**
 * Class Aj
 */
class Aj
{
	
  /** @var string Префикс функций */
  private static $prefix = "Aj_";

  private static $_obj = null;
  private static $_responseCount = -1;
  private static $_responses = array();


  /**
   * Основное назначение волшебного метода обращение к матодам js и подключенным библиотекам
   * таким как jquery.js, moontool.js и другие. Смотри пример в комментариях метода __call()
   *
   * @param $name
   * @return $this
   */
  function __get($name)
  {
    Aj::$_responses[Aj::$_responseCount][] = $name;
    return $this;
  }

  /**
   * Основное назначение волшебного метода обращение к матодам js и подключенным библиотекам
   * таким как jquery.js, moontool.js и другие. Смотри пример в комментариях метода __call()
   *
   * @param $name
   * @param $value
   */
  function __set($name, $value)
  {
    $value = json_encode($value);
    Aj::$_responses[Aj::$_responseCount][] = $name . "=" . $value;
  }


  /**
   * Основное назначение волшебного метода обращение к матодам js и подключенным библиотекам
   * таким как jquery.js, moontool.js и другие. Вызов производится только после инициализации обекта класса статическим
   * методом addResponse()
   *
   * Например:
   * <pre>
   *  Aj::addResponse()->document->getElementById("output")->innerHTML = print_r($someData, true);
   *  // или
   *  Aj::addResponse()->jQuery("#output")->addClass("my_class")->html($someData);
   * </pre>
   *
   * @param $name
   * @param $arguments
   * @return $this
   */
  function __call($name, $arguments)
  {
    foreach ($arguments as $argumentNumber => $argument) {
      $arguments[$argumentNumber] = json_encode($argument);
    }
    Aj::$_responses[Aj::$_responseCount][] = $name . "(" . implode(",", $arguments) . ")";
    return $this;
  }


  /**
   * Дебагер, выводит переданные данные в JS консоль браузера,
   * если установить второй аргумент true вернет форматированую строку
   *
   * @param      $data
   * @param bool $formatted
   */
  public static function dumpConsole($data, $formatted=false)
  {
    if($formatted)
      $data = "<pre>".print_r($data,true)."</pre>";
      self::addResponse()->window->console->log($data);
  }

  /**
   * Инициилизирует обект класса, реализует паттерн одиночка
   * Возвращает экземпляр обекта. Через этот метод необходимо обращаться к динамическим свойствам и етодам JS
   * Смотри пример в комментариях метода __call()
   *
   * @return null|object
   */
  public static function addResponse()
  {
    Aj::$_responseCount++;
    Aj::$_responses[Aj::$_responseCount] = array();
    if (is_a(Aj::$_obj, "Aj")) {
      return Aj::$_obj;
    } else {
      Aj::$_obj = new Aj();
      return Aj::$_obj;
    }
  }


  /**
   * Отображает js скрипт в слушателя
   * Метод необходимо инициализировать между тегами head на странице в которой установлены слушатели
   * вызывающие оброботчик
   * Принимает один аргумент, дебагер
   *
   * @param int $ajaxDebugLevel
   */
  public static function outputJs($ajaxDebugLevel = 0)
  {
    echo PHP_EOL . '<script>
  function aj(args){
    var _func = (args.func==undefined) ? false : args.func;
    var _data = (args.data==undefined) ? false : args.data;
    var _url = (args.url==undefined || args.url===true) ? "'.$_SERVER["REQUEST_URI"].'" : args.url;
    var _async = (args.async==undefined || args.async===true) ? "async" : "sync";
    var _type = (args.async!=undefined && args.type.toLowerCase()=="get") ? "GET" : "POST";
    var _beforeSend = (typeof args.beforeSend == "function") ? args.beforeSend : false;
    var _error = (typeof args.error == "function") ? args.error : false;
    var _success = (typeof args.success == "function") ? args.success : false;
    var _complete = (typeof args.complete == "function") ? args.complete : false;
    if(_func===false || _data===false){
    '.($ajaxDebugLevel>0?'alert("\n\n empty args.func or args.data\n");':'').'
      return false;}
    if(args.output!=undefined){
      _success = function(data){
        $(args.output).html(data);
      };
    }
    $.ajax({
      async:_async,
      type:_type,
      url:_url,
      data:{ajaxRequest:true,arguments:JSON.stringify([_func, _data])},
      beforeSend: _beforeSend,
      error: _error,
      success: _success,
      complete: _complete
      }).done( function(response){
	      '.($ajaxDebugLevel>1?'alert("Response is:\n"+'.'response.replace(/(<([^>]+)>)/ig,""));':'').'
	      try{ eval(response); }catch(e){'.($ajaxDebugLevel>0?'alert(e+"\n\nResponse was:\n"+response);':'').' }
	  });
    }
    </script>' . PHP_EOL;
  }


  /**
   * Обрабатывает вызвание функции средствами AJAX
   */
  public static function execRequest()
  {
    if (isset($_POST["ajaxRequest"])) {
      $requestArguments = json_decode($_POST["arguments"], true);
      $functionName = self::$prefix . array_shift($requestArguments);
      if (function_exists($functionName))
        call_user_func_array($functionName, $requestArguments);
      else
        Aj::addResponse()->alert("PHP function \"$functionName\" not found error.");
      $responseJs = "";
      foreach (Aj::$_responses as $responseNumber => $responsePieces) {
        $responseJs .= implode(".", $responsePieces) . ";" . PHP_EOL;
      }
      echo($responseJs);
      die();
    }
  }

}


