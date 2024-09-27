<?php
require_once 'DatabaseObject.php';

class Company extends DatabaseObject {
    private $location;
    private $industry;

    // Конструктор класса
    public function __construct($dbConnection) {
        parent::__construct($dbConnection);
    }

    // Метод валидации для полей компании
    public function validate($data) {
        if (empty($data['location'])) {
            $this->errors['location'] = "Местоположение не может быть пустым.";
        }
        if (empty($data['industry'])) {
            $this->errors['industry'] = "Отрасль компании не может быть пуста.";
        }
        return empty($this->errors);
    }

    // Метод создания компании
    public function create($data) {
        if (!$this->validate($data)) {
            return false;
        }

        // Подготовка SQL-запроса для вставки компании
        $stmt = $this->connection->prepare("INSERT INTO companies (name, location, industry) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $data['name'], $data['location'], $data['industry']);
        $stmt->execute();
        return $stmt->insert_id;
    }

    // Метод чтения компании
    public function read($id) {
        $stmt = $this->connection->prepare("SELECT * FROM companies WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Метод обновления компании
    public function update($id, $data) {
        if (!$this->validate($data)) {
            return false;
        }

        $stmt = $this->connection->prepare("UPDATE companies SET name = ?, location = ?, industry = ? WHERE id = ?");
        $stmt->bind_param("sssi", $data['name'], $data['location'], $data['industry'], $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    // Метод удаления компании
    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM companies WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
?>
