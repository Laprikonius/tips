<?php
require_once 'DatabaseObject.php';

class Employer extends DatabaseObject {
    private $position;
    private $salary;
    private $company_id;

    // Конструктор класса
    public function __construct($dbConnection) {
        parent::__construct($dbConnection);
    }

    // Метод валидации для полей сотрудника
    public function validate($data) {
        if (empty($data['position'])) {
            $this->errors['position'] = "Должность не должна быть пуста.";
        }
        if (empty($data['salary']) || $data['salary'] <= 0) {
            $this->errors['salary'] = "Зарплата не должна быть пуста.";
        }
        if (empty($data['company_id']) || !$this->companyExists($data['company_id'])) {
            $this->errors['company_id'] = "Компания не существует.";
        }
        return empty($this->errors);
    }

    // Проверка существования компании по ID
    private function companyExists($companyId) {
        $stmt = $this->connection->prepare("SELECT id FROM companies WHERE id = ?");
        $stmt->bind_param("i", $companyId);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    // Метод создания сотрудника
    public function create($data) {
        if (!$this->validate($data)) {
            return false;
        }

        // Подготовка SQL-запроса для вставки сотрудника
        $stmt = $this->connection->prepare("INSERT INTO employers (name, position, salary, company_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdi", $data['name'], $data['position'], $data['salary'], $data['company_id']); // Привязка параметров
        $stmt->execute();
        return $stmt->insert_id;
    }

    // Метод чтения сотрудника
    public function read($id) {
        $stmt = $this->connection->prepare("SELECT * FROM employers WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Метод обновления сотрудника
    public function update($id, $data) {
        if (!$this->validate($data)) {
            return false;
        }

        $stmt = $this->connection->prepare("UPDATE employers SET name = ?, position = ?, salary = ?, company_id = ? WHERE id = ?");
        $stmt->bind_param("ssdii", $data['name'], $data['position'], $data['salary'], $data['company_id'], $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    // Метод удаления сотрудника
    public function delete($id) {
        $stmt = $this->connection->prepare("DELETE FROM employers WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
?>
