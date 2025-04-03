<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Edit Task</h4>
                <a href="<?php echo BASE_URL; ?>/tasks" class="btn btn-sm btn-secondary">Back to Tasks</a>
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

                <form action="<?php echo BASE_URL; ?>/tasks/update" method="post">
                    <input type="hidden" name="id" value="<?php echo $task['id']; ?>">

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="<?php echo isset($_SESSION['form_data']['title']) ? $_SESSION['form_data']['title'] : htmlspecialchars($task['title']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4"><?php echo isset($_SESSION['form_data']['description']) ? $_SESSION['form_data']['description'] : htmlspecialchars($task['description']); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="TODO" <?php echo (isset($_SESSION['form_data']['status']) && $_SESSION['form_data']['status'] === 'TODO') || (!isset($_SESSION['form_data']['status']) && $task['status'] === 'TODO') ? 'selected' : ''; ?>>TODO</option>
                            <option value="DOING" <?php echo (isset($_SESSION['form_data']['status']) && $_SESSION['form_data']['status'] === 'DOING') || (!isset($_SESSION['form_data']['status']) && $task['status'] === 'DOING') ? 'selected' : ''; ?>>DOING</option>
                            <option value="REVIEW" <?php echo (isset($_SESSION['form_data']['status']) && $_SESSION['form_data']['status'] === 'REVIEW') || (!isset($_SESSION['form_data']['status']) && $task['status'] === 'REVIEW') ? 'selected' : ''; ?>>REVIEW</option>
                            <option value="DONE" <?php echo (isset($_SESSION['form_data']['status']) && $_SESSION['form_data']['status'] === 'DONE') || (!isset($_SESSION['form_data']['status']) && $task['status'] === 'DONE') ? 'selected' : ''; ?>>DONE</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update Task</button>
                        <a href="<?php echo BASE_URL; ?>/tasks" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>

                <?php unset($_SESSION['form_data']); ?>

                <!-- Subtasks Section -->
                <hr>
                <h5>Subtasks</h5>

                <div class="mb-3">
                    <a href="<?php echo BASE_URL; ?>/subtasks/create?task_id=<?php echo $task['id']; ?>" class="btn btn-sm btn-outline-primary">Add Subtask</a>
                </div>

                <?php if (empty($subtasks)): ?>
                    <div class="alert alert-info">No subtasks yet. Add your first subtask!</div>
                <?php else: ?>
                    <div class="list-group">
                        <?php foreach ($subtasks as $subtask): ?>
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <div>
                                        <form action="<?php echo BASE_URL; ?>/subtasks/update" method="post" class="d-flex align-items-center">
                                            <input type="hidden" name="id" value="<?php echo $subtask['id']; ?>">
                                            <div class="form-check me-2">
                                                <input class="form-check-input" type="checkbox" name="completed" id="subtask<?php echo $subtask['id']; ?>" <?php echo $subtask['completed'] ? 'checked' : ''; ?> onchange="this.form.submit()">
                                            </div>
                                            <input type="text" name="title" class="form-control form-control-sm" value="<?php echo htmlspecialchars($subtask['title']); ?>" required>
                                            <button type="submit" class="btn btn-sm btn-outline-secondary ms-2">Update</button>
                                        </form>
                                    </div>
                                    <div>
                                        <a href="<?php echo BASE_URL; ?>/subtasks/delete?id=<?php echo $subtask['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this subtask?')">
                                            Delete
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>