<?php

class HomeController
{
    public function index()
    {
        // Check if user is logged in
        if (isset($_SESSION['user_id'])) {
            // Redirect to tasks page
            header('Location: ' . BASE_URL . '/tasks');
            exit;
        }

        // Set page title
        $pageTitle = 'Welcome to Task Management';

        // Include view
        $contentView = 'views/home.php';
        include 'views/application.php';
    }
}
