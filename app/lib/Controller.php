<?php
    /*
     * Base Controller
     * Loads models and views
     */
    class Controller {
        // Load model
        function model ($model) {
        // Require model file
            require_once '../app/models/' . $model . '.php';
        // возвращаем экземляр класса текущей модели
            return new $model;
        }

        function view($view, $data = []) {
        // проверяем наличие вьюхи
            if(file_exists('../app/views/' . $view . '.php')) {
                require_once '../app/views/' . $view . '.php';
            } else {
                die('View file is unavailable');
            }
        }
    }