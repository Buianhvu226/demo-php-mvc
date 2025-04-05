<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Edit Subtask</h4>
                <a href="<?php echo BASE_URL; ?>/tasks/edit?id=<?php echo $subtask['task_id']; ?>" class="btn btn-sm btn-secondary">Back to Task</a>
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

                <form action="<?php echo BASE_URL; ?>/subtasks/update" method="post">
                    <input type="hidden" name="id" value="<?php echo $subtask['id']; ?>">
                    <input type="hidden" name="task_id" value="<?php echo $subtask['task_id']; ?>">

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="<?php echo isset($_SESSION['form_data']['title']) ? $_SESSION['form_data']['title'] : htmlspecialchars($subtask['title']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?php echo isset($_SESSION['form_data']['description']) ? $_SESSION['form_data']['description'] : htmlspecialchars($subtask['description'] ?? ''); ?></textarea>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="completed" name="completed" 
                            <?php echo (isset($_SESSION['form_data']['completed']) || (!isset($_SESSION['form_data']) && $subtask['completed'])) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="completed">Completed</label>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update Subtask</button>
                        <a href="<?php echo BASE_URL; ?>/tasks/edit?id=<?php echo $subtask['task_id']; ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>

                <?php unset($_SESSION['form_data']); ?>
            </div>
        </div>
    </div>
</div>