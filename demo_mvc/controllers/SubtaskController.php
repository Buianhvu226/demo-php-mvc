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
            header("Location: " . BASE_URL . "/login");
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
            $title = $_POST['title'] ?? '';

            // Validate input
            $errors = [];

            if (empty($title)) {
                $errors[] = "Title is required";
            }

            // Check if task exists and belongs to user
            $task = $this->taskModel->getTaskById($taskId);
            if (!$task || $task['user_id'] != $_SESSION['user_id']) {
                $_SESSION['message'] = "Task not found or access denied";
                $_SESSION['message_type'] = "danger";
                header("Location: " . BASE_URL . "/tasks");
                exit;
            }

            if (empty($errors)) {
                if ($this->subtaskModel->create($taskId, $title)) {
                    $_SESSION['message'] = "Subtask created successfully!";
                    $_SESSION['message_type'] = "success";
                    header("Location: " . BASE_URL . "/tasks/edit?id=$taskId");
                    exit;
                } else {
                    $errors[] = "Failed to create subtask. Please try again.";
                }
            }

            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            header("Location: " . BASE_URL . "/subtasks/create?task_id=$taskId");
            exit;
        }

        header("Location: " . BASE_URL . "/tasks");
        exit;
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $title = $_POST['title'] ?? '';
            $completed = isset($_POST['completed']) ? 1 : 0;

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

            // Validate input
            $errors = [];

            if (empty($title)) {
                $errors[] = "Title is required";
            }

            if (empty($errors)) {
                if ($this->subtaskModel->update($id, $title, $completed)) {
                    $_SESSION['message'] = "Subtask updated successfully!";
                    $_SESSION['message_type'] = "success";
                } else {
                    $_SESSION['message'] = "Failed to update subtask";
                    $_SESSION['message_type'] = "danger";
                }
            } else {
                $_SESSION['errors'] = $errors;
                $_SESSION['message'] = "Please fix the errors";
                $_SESSION['message_type'] = "danger";
            }

            header("Location: " . BASE_URL . "/tasks/edit?id=" . $task['id']);
            exit;
        }

        header("Location: " . BASE_URL . "/tasks");
        exit;
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
}
