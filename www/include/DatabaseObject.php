<?php
class DatabaseObject {
    protected $connection;
    protected $errors = [];

    // Конструктор класса
    public function __construct($dbConnection) {
        $this->connection = $dbConnection;
    }

    // Метод валидации
    protected function validate($data) {
        return true;
    }

    // Метод создания объекта
    public function create($data) {
        if (!$this->validate($data)) {
            return false;
        }
        //
    }

    // Метод чтения объекта
    public function read($id) {
        //
    }

    // Метод обновления объекта
    public function update($id, $data) {
        if (!$this->validate($data)) {
            return false;
        }
        //
    }

    // Метод удаления объекта
    public function delete($id) {
        //
    }

    // Метод для получения ошибок валидации
    public function getErrors() {
        return $this->errors;
    }
}
?>
