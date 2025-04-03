<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Create New Subtask</h4>
                <a href="<?php echo BASE_URL; ?>/tasks/edit?id=<?php echo $taskId; ?>" class="btn btn-sm btn-secondary">Back to Task</a>
            </div>
            <div class="card-body">
                <?php if (isset($_SESSION['errors'])): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($_SESSION['errors'] as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php unset($_SESSION['errors']); ?>
                <?php endif; ?>

                <form action="<?php echo BASE_URL; ?>/subtasks/store" method="post">
                    <input type="hidden" name="task_id" value="<?php echo $taskId; ?>">

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="<?php echo isset($_SESSION['form_data']['title']) ? $_SESSION['form_data']['title'] : ''; ?>" required>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Create Subtask</button>
                        <a href="<?php echo BASE_URL; ?>/tasks/edit?id=<?php echo $taskId; ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>

                <?php unset($_SESSION['form_data']); ?>
            </div // filepath: c:\PHP_Training\demo_mvc\views\subtasks\create.php
                <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Create New Subtask</h4>
                        <a href="<?php echo BASE_URL; ?>/tasks/edit?id=<?php echo $taskId; ?>" class="btn btn-sm btn-secondary">Back to Task</a>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['errors'])): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach ($_SESSION['errors'] as $error): ?>
                                        <li><?php echo $error; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php unset($_SESSION['errors']); ?>
                        <?php endif; ?>

                        <form action="<?php echo BASE_URL; ?>/subtasks/store" method="post">
                            <input type="hidden" name="task_id" value="<?php echo $taskId; ?>">

                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="<?php echo isset($_SESSION['form_data']['title']) ? $_SESSION['form_data']['title'] : ''; ?>" required>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Create Subtask</button>
                                <a href="<?php echo BASE_URL; ?>/tasks/edit?id=<?php echo $taskId; ?>" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>

                        <?php unset($_SESSION['form_data']); ?>
                    </div