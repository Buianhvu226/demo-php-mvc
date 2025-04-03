<div class="jumbotron">
    <h1 class="display-4">Welcome to Task Management App</h1>
    <p class="lead">A simple PHP MVC application to manage your tasks efficiently.</p>
    <hr class="my-4">
    <p>Organize your tasks, create subtasks, and track progress with different status options.</p>

    <?php if (!isset($_SESSION['user_id'])): ?>
        <div class="mt-4">
            <a href="<?php echo BASE_URL; ?>/auth/login" class="btn btn-primary me-2">Login</a>
            <a href="<?php echo BASE_URL; ?>auth/register" class="btn btn-outline-primary">Register</a>
        </div>
    <?php else: ?>
        <div class="mt-4">
            <a href="<?php echo BASE_URL; ?>/tasks" class="btn btn-primary">View My Tasks</a>
        </div>
    <?php endif; ?>
</div>

<div class="row mt-5">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Task Management</h5>
                <p class="card-text">Create, edit, and delete tasks with ease. Assign different statuses to track progress.</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Subtasks Support</h5>
                <p class="card-text">Break down complex tasks into smaller, manageable subtasks.</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Status Tracking</h5>
                <p class="card-text">Track task progress with different statuses: TODO, DOING, REVIEW, and DONE.</p>
            </div>
        </div>
    </div>
</div>