<?php

/**
 * Предоставляет интерфейс-singleton к базе данных
 */
class DB {
    /**
     * @var null|PDO
     */
    private $engine = null;
    /**
     * @var bool
     */
    private static $instance = false;

	/**
	 * Возвращает объект класса DB
	 * @return DB
	 */
	public static function getInstance () {
		if (self::$instance === false) {
			self::$instance = new DB;
		}
		return self::$instance;
	}

    /**
     * Инициализация PDO
     */
    private function __construct () {
        try {
            $this->engine = new PDO(DB_CONNECT_STRING, DB_USER, DB_PASSWORD);
            $this->engine->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        }
        catch(PDOException $e) {
            print $e->getMessage();
        }
    }

    /**
     * Отключить PDO
     */
    public function __destruct() {
        $this->engine = null;
    }

    /**
	 * Выполнить запрос к базе данных
	 * @param string $sQuery prepared строка с запросом
     * @param array $data ассоциативный массив с данными для запроса
	 * @return PDOStatement
     */
	public function query ($sQuery, $data = array()) {
        try {
            $result = $this->engine->prepare ($sQuery);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result->execute($data);
        }
        catch(PDOException $e) {
            print $e->getMessage();
        }

        return $result;
	}

    /**
     * Получить id последнего вставленного элемента
     * @return string
     */
    public function lastInsertId(){
        return $this->engine->lastInsertId();
    }
}