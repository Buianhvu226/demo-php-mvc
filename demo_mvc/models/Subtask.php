<?php
class Subtask
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getAllByTaskId($taskId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM subtasks 
            WHERE task_id = :task_id 
            ORDER BY created_at ASC
        ");

        $stmt->bindParam(':task_id', $taskId);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM subtasks 
            WHERE id = :id
        ");

        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function getByTaskId($taskId)
    {
        $stmt = $this->db->prepare("SELECT * FROM subtasks WHERE task_id = :task_id ORDER BY created_at ASC");
        $stmt->bindParam(':task_id', $taskId);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function create($taskId, $title, $description = '')
    {
        $stmt = $this->db->prepare("
            INSERT INTO subtasks (task_id, title, description) 
            VALUES (:task_id, :title, :description)
        ");

        $stmt->bindParam(':task_id', $taskId);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);

        return $stmt->execute() ? $this->db->lastInsertId() : false;
    }

    public function update($id, $title, $description, $completed)
    {
        $stmt = $this->db->prepare("
            UPDATE subtasks 
            SET title = :title, description = :description, completed = :completed, updated_at = CURRENT_TIMESTAMP
            WHERE id = :id
        ");

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':completed', $completed, PDO::PARAM_BOOL);

        return $stmt->execute();
    }

    public function toggleComplete($id)
    {
        $subtask = $this->getById($id);
        if (!$subtask) return false;

        $completed = !$subtask['completed'];

        $stmt = $this->db->prepare("
            UPDATE subtasks 
            SET completed = :completed 
            WHERE id = :id
        ");

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':completed', $completed, PDO::PARAM_BOOL);

        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("
            DELETE FROM subtasks 
            WHERE id = :id
        ");

        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}
