<?php
class Task
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getAllTasksByUser($userId)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM tasks 
            WHERE user_id = :user_id 
            ORDER BY created_at DESC
        ");

        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getTaskById($id)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM tasks 
            WHERE id = :id
        ");

        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function create($userId, $title, $description, $status)
    {
        $stmt = $this->db->prepare("
            INSERT INTO tasks (user_id, title, description, status) 
            VALUES (:user_id, :title, :description, :status)
        ");

        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':status', $status);

        return $stmt->execute() ? $this->db->lastInsertId() : false;
    }

    public function update($id, $title, $description, $status)
    {
        $stmt = $this->db->prepare("
            UPDATE tasks 
            SET title = :title, description = :description, status = :status 
            WHERE id = :id
        ");

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':status', $status);

        return $stmt->execute();
    }

    public function changeStatus($id, $status)
    {
        $stmt = $this->db->prepare("
            UPDATE tasks 
            SET status = :status 
            WHERE id = :id
        ");

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);

        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("
            DELETE FROM tasks 
            WHERE id = :id
        ");

        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function getTasksWithSubtasks($userId)
    {
        $tasks = $this->getAllTasksByUser($userId);
        $subtask = new Subtask();

        foreach ($tasks as &$task) {
            $task['subtasks'] = $subtask->getAllByTaskId($task['id']);
        }

        return $tasks;
    }
}
