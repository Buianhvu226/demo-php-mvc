<?php
class SubtaskController
{
    private $taskModel;
    private $subtaskModel;

    public function __construct()
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['message'] = "Please log in first";
            $_SESSION['message_type'] = "danger";
            header("Location: " . BASE_URL . "/auth/login");
            exit;
        }

        $this->taskModel = new Task();
        $this->subtaskModel = new Subtask();
    }

    public function create()
    {
        $taskId = $_GET['task_id'] ?? 0;

        // Check if task exists and belongs to user
        $task = $this->taskModel->getTaskById($taskId);
        if (!$task || $task['user_id'] != $_SESSION['user_id']) {
            $_SESSION['message'] = "Task not found or access denied";
            $_SESSION['message_type'] = "danger";
            header("Location: " . BASE_URL . "/tasks");
            exit;
        }

        $pageTitle = 'Create Subtask';
        $contentView = 'views/subtasks/create.php';

        include 'views/application.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $taskId = $_POST['task_id'] ?? 0;
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');

            // Validate input
            $errors = [];
            if (empty($title)) {
                $errors[] = "Title is required";
            }

            if (empty($taskId)) {
                $errors[] = "Task ID is required";
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['form_data'] = $_POST;
                header("Location: " . BASE_URL . "/subtasks/create?task_id=" . $taskId);
                exit;
            }

            // Create subtask
            $subtaskId = $this->subtaskModel->create($taskId, $title, $description);

            if ($subtaskId) {
                $_SESSION['message'] = "Subtask created successfully";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Failed to create subtask";
                $_SESSION['message_type'] = "danger";
            }

            header("Location: " . BASE_URL . "/tasks/edit?id=" . $taskId);
            exit;
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $taskId = $_POST['task_id'] ?? 0;
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $completed = isset($_POST['completed']) ? true : false;

            // Validate input
            $errors = [];
            if (empty($title)) {
                $errors[] = "Title is required";
            }

            if (empty($id)) {
                $errors[] = "Subtask ID is required";
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['form_data'] = $_POST;
                header("Location: " . BASE_URL . "/subtasks/edit?id=" . $id);
                exit;
            }

            // Update subtask
            $success = $this->subtaskModel->update($id, $title, $description, $completed);

            if ($success) {
                $_SESSION['message'] = "Subtask updated successfully";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Failed to update subtask";
                $_SESSION['message_type'] = "danger";
            }

            header("Location: " . BASE_URL . "/tasks/edit?id=" . $taskId);
            exit;
        }
    }

    public function edit()
    {
        $id = $_GET['id'] ?? 0;
    
        if (empty($id)) {
            $_SESSION['message'] = "Invalid subtask ID";
            $_SESSION['message_type'] = "danger";
            header("Location: " . BASE_URL . "/tasks");
            exit;
        }
    
        $subtask = $this->subtaskModel->getById($id);
    
        if (!$subtask) {
            $_SESSION['message'] = "Subtask not found";
            $_SESSION['message_type'] = "danger";
            header("Location: " . BASE_URL . "/tasks");
            exit;
        }
    
        // Check if the subtask belongs to a task owned by the current user
        $task = $this->taskModel->getTaskById($subtask['task_id']);
    
        if (!$task || $task['user_id'] != $_SESSION['user_id']) {
            $_SESSION['message'] = "You don't have permission to edit this subtask";
            $_SESSION['message_type'] = "danger";
            header("Location: " . BASE_URL . "/tasks");
            exit;
        }
    
        $pageTitle = 'Edit Subtask';
        $contentView = 'views/subtasks/edit.php';
        include 'views/application.php';
    }

    public function delete()
    {
        $id = $_GET['id'] ?? 0;

        // Get subtask to check parent task ownership
        $subtask = $this->subtaskModel->getById($id);
        if (!$subtask) {
            $_SESSION['message'] = "Subtask not found";
            $_SESSION['message_type'] = "danger";
            header("Location: " . BASE_URL . "/tasks");
            exit;
        }

        // Check if parent task belongs to user
        $task = $this->taskModel->getTaskById($subtask['task_id']);
        if (!$task || $task['user_id'] != $_SESSION['user_id']) {
            $_SESSION['message'] = "Access denied";
            $_SESSION['message_type'] = "danger";
            header("Location: " . BASE_URL . "/tasks");
            exit;
        }

        if ($this->subtaskModel->delete($id)) {
            $_SESSION['message'] = "Subtask deleted successfully!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Failed to delete subtask";
            $_SESSION['message_type'] = "danger";
        }

        header("Location: " . BASE_URL . "/tasks/edit?id=" . $task['id']);
        exit;
    }

    public function toggleComplete()
    {
        $id = $_GET['id'] ?? 0;
        $taskId = $_GET['task_id'] ?? 0;
        
        if (empty($id)) {
            $_SESSION['message'] = "Invalid subtask ID";
            $_SESSION['message_type'] = "danger";
            header("Location: " . BASE_URL . "/tasks");
            exit;
        }
        
        // Get subtask to check parent task ownership
        $subtask = $this->subtaskModel->getById($id);
        if (!$subtask) {
            $_SESSION['message'] = "Subtask not found";
            $_SESSION['message_type'] = "danger";
            header("Location: " . BASE_URL . "/tasks");
            exit;
        }
        
        // Check if parent task belongs to user
        $task = $this->taskModel->getTaskById($subtask['task_id']);
        if (!$task || $task['user_id'] != $_SESSION['user_id']) {
            $_SESSION['message'] = "Access denied";
            $_SESSION['message_type'] = "danger";
            header("Location: " . BASE_URL . "/tasks");
            exit;
        }
        
        if ($this->subtaskModel->toggleComplete($id)) {
            $_SESSION['message'] = "Subtask status updated successfully!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Failed to update subtask status";
            $_SESSION['message_type'] = "danger";
        }
        
        // Redirect back to task edit page
        header("Location: " . BASE_URL . "/tasks/edit?id=" . $subtask['task_id']);
        exit;
    }
}
