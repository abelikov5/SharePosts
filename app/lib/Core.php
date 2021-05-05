<?php
    /*
     * App Core Class
     * Creates URL & loads core controller
     * URL FORMAT - /controller/method/params
     */
    class Core {
        protected $curController    = 'Pages';
        protected $curMethod        = 'index';
        protected $params           = [];

        function __construct() {
            $url = $this->getUrl();
            // делаем проверку, есть ли такой контроллер, в папке app/controllers, и присваиваем переменной $curController
            if (isset($url[0]) && file_exists('../app/controllers/'.ucwords($url[0]).'.php')) {
                $this->curController = $url[0];
                unset($url[0]);
            }

            // инициализируем экземпляр класса который хранится в $curController, предварительно подключив его
            require_once '../app/controllers/' . $this->curController . '.php';
            $this->curController = new $this->curController;

            // проверяем вторую часть URL, если существует и есть такой метод в контроллере, используем его
            if (isset($url[1]) && method_exists($this->curController, $url[1])) {
                $this->curMethod = $url[1];
                unset($url[1]);
            }

            // проверяем наличие параметров
            if (isset($url)) {
                $this->params = array_values($url);
            }
            // вызываем метод из переменной $curMethod, с параметрами $params;
            $tmp  = $this->curController;
            $tmp2 = $this->curMethod;
            $tmp->$tmp2($this->params);
//            call_user_func_array([$this->curController, $this->curMethod], $this->params);
        }
        function getUrl() {
            if (isset($_GET['url'])) {
                $url = $_GET['url'];
                $url = rtrim($url, '/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url);
                // возращаем массив из URL
                return $url;
            }

        }
    }