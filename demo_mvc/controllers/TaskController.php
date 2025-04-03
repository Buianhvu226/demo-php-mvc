<?php
class TaskController
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

    public function index()
    {
        $userId = $_SESSION['user_id'];
        $tasks = $this->taskModel->getTasksWithSubtasks($userId);

        $pageTitle = 'My Tasks';
        $contentView = 'views/tasks/index.php';

        include 'views/application.php';
    }

    public function create()
    {
        $pageTitle = 'Create Task';
        $contentView = 'views/tasks/create.php';

        include 'views/application.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_id'];
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $status = $_POST['status'] ?? 'TODO';

            // Validate input
            $errors = [];

            if (empty($title)) {
                $errors[] = "Title is required";
            }

            if (empty($errors)) {
                if ($taskId = $this->taskModel->create($userId, $title, $description, $status)) {
                    $_SESSION['message'] = "Task created successfully!";
                    $_SESSION['message_type'] = "success";
                    header("Location: " . BASE_URL . "/tasks");
                    exit;
                } else {
                    $errors[] = "Failed to create task. Please try again.";
                }
            }

            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            header("Location: " . BASE_URL . "/tasks/create");
            exit;
        }

        header("Location: " . BASE_URL . "/tasks/create");
        exit;
    }

    public function edit()
    {
        $id = $_GET['id'] ?? 0;
        $task = $this->taskModel->getTaskById($id);

        if (!$task || $task['user_id'] != $_SESSION['user_id']) {
            $_SESSION['message'] = "Task not found or access denied";
            $_SESSION['message_type'] = "danger";
            header("Location: " . BASE_URL . "/tasks");
            exit;
        }

        $subtasks = $this->subtaskModel->getAllByTaskId($id);

        $pageTitle = 'Edit Task';
        $contentView = 'views/tasks/edit.php';

        include 'views/application.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $status = $_POST['status'] ?? 'TODO';

            // Validate input
            $errors = [];

            if (empty($title)) {
                $errors[] = "Title is required";
            }

            // Check if task exists and belongs to user
            $task = $this->taskModel->getTaskById($id);
            if (!$task || $task['user_id'] != $_SESSION['user_id']) {
                $_SESSION['message'] = "Task not found or access denied";
                $_SESSION['message_type'] = "danger";
                header("Location: " . BASE_URL . "/tasks");
                exit;
            }

            if (empty($errors)) {
                if ($this->taskModel->update($id, $title, $description, $status)) {
                    $_SESSION['message'] = "Task updated successfully!";
                    $_SESSION['message_type'] = "success";
                    header("Location: " . BASE_URL . "/tasks");
                    exit;
                } else {
                    $errors[] = "Failed to update task. Please try again.";
                }
            }

            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $_POST;
            header("Location: " . BASE_URL . "/tasks/edit?id=$id");
            exit;
        }

        header("Location: " . BASE_URL . "/tasks");
        exit;
    }

    public function delete()
    {
        $id = $_GET['id'] ?? 0;

        // Check if task exists and belongs to user
        $task = $this->taskModel->getTaskById($id);
        if (!$task || $task['user_id'] != $_SESSION['user_id']) {
            $_SESSION['message'] = "Task not found or access denied";
            $_SESSION['message_type'] = "danger";
            header("Location: " . BASE_URL . "/tasks");
            exit;
        }

        if ($this->taskModel->delete($id)) {
            $_SESSION['message'] = "Task deleted successfully!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Failed to delete task";
            $_SESSION['message_type'] = "danger";
        }

        header("Location: " . BASE_URL . "/tasks");
        exit;
    }

    public function changeStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $status = $_POST['status'] ?? '';

            // Validate status
            $validStatuses = ['TODO', 'DOING', 'REVIEW', 'DONE'];
            if (!in_array($status, $validStatuses)) {
                $_SESSION['message'] = "Invalid status";
                $_SESSION['message_type'] = "danger";
                header("Location: " . BASE_URL . "/tasks");
                exit;
            }

            // Check if task exists and belongs to user
            $task = $this->taskModel->getTaskById($id);
            if (!$task || $task['user_id'] != $_SESSION['user_id']) {
                $_SESSION['message'] = "Task not found or access denied";
                $_SESSION['message_type'] = "danger";
                header("Location: " . BASE_URL . "/tasks");
                exit;
            }

            if ($this->taskModel->changeStatus($id, $status)) {
                $_SESSION['message'] = "Task status updated successfully!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Failed to update task status";
                $_SESSION['message_type'] = "danger";
            }
        }

        header("Location: " . BASE_URL . "/tasks");
        exit;
    }
}
