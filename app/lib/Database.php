<?php
    /*
     * PDO DB class
     * Connect to DB
     * Create prepared statements
     * Bind values
     * Return rows and results
     */
//require_once '../config/config.php';
    class Database {
        private $host   = DB_HOST;
        private $user   = DB_USER;
        private $pass   = DB_PASS;
        private $dbname = DB_NAME;

        private $dbh;
        private $stmt;
        private $error;

        function __construct() {
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            try {
                $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }
        // Prepare statement with query, первая часть PDO, подготовка запроса
        function query ($sql) {
            $this->stmt = $this->dbh->prepare($sql);
        }

        // Bind values, с помощью метода bindValue в PDO https://www.php.net/manual/ru/pdostatement.bindvalue.php
        public function bind($param, $value, $type = null) {
            if (is_null($type)) {
                switch (true) {
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                }
            }
            $this->stmt->bindValue($param, $value, $type);
        }
        // Execute the prepared statement Выполняем запрос к БД
        function execute() {
            return $this->stmt->execute();
        }

        // Get result set as array of obj. Метод возвращает все записи из БД как массив объектов
        function resultSet() {
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }

        // Get single record as obj
        function single() {
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

        // Get row count, Встроенный метод PDO, возвращает количество строк в последнем запросе https://www.php.net/manual/ru/pdostatement.rowcount.php
        function rowCount () {
            return $this->stmt->rowCount();
        }
   }
//   $some_var = new Database();