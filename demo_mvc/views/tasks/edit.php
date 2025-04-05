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
                <div class="mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5>Subtasks</h5>
                        <a href="<?php echo BASE_URL; ?>/subtasks/create?task_id=<?php echo $task['id']; ?>" class="btn btn-sm btn-success">
                            <i class="bi bi-plus"></i> Add Subtask
                        </a>
                    </div>

                    <?php if (empty($task['subtasks'])): ?>
                        <div class="alert alert-info">
                            No subtasks yet. Add your first subtask!
                        </div>
                    <?php else: ?>
                        <ul class="list-group">
                            <?php foreach ($task['subtasks'] as $subtask): ?>
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <input type="checkbox" class="form-check-input me-2" 
                                                <?php echo $subtask['completed'] ? 'checked' : ''; ?>
                                                onchange="location.href='<?php echo BASE_URL; ?>/subtasks/toggle-complete?id=<?php echo $subtask['id']; ?>&task_id=<?php echo $task['id']; ?>'">
                                            <span class="<?php echo $subtask['completed'] ? 'text-decoration-line-through' : ''; ?>">
                                                <?php echo htmlspecialchars($subtask['title']); ?>
                                            </span>
                                        </div>
                                        <div>
                                            <a href="<?php echo BASE_URL; ?>/subtasks/edit?id=<?php echo $subtask['id']; ?>" class="btn btn-sm btn-primary me-1">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <a href="<?php echo BASE_URL; ?>/subtasks/delete?id=<?php echo $subtask['id']; ?>&task_id=<?php echo $task['id']; ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('Are you sure you want to delete this subtask?')">
                                                <i class="bi bi-trash"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                    <?php if (!empty($subtask['description'])): ?>
                                        <div class="mt-2 ps-4">
                                            <small class="text-muted"><?php echo nl2br(htmlspecialchars($subtask['description'])); ?></small>
                                        </div>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>