<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>My Tasks</h2>
        <a href="<?php echo BASE_URL; ?>/tasks/create" class="btn btn-primary">
            <i class="bi bi-plus"></i> Create New Task
        </a>
    </div>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['message_type']; ?> alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message']); ?>
        <?php unset($_SESSION['message_type']); ?>
    <?php endif; ?>

    <?php if (empty($tasks)): ?>
        <div class="alert alert-info">
            You don't have any tasks yet. Create your first task!
        </div>
    <?php else: ?>
        <div class="row">
            <?php foreach ($tasks as $task): ?>
                <div class="col-md-6 mb-4">
                    <div class="card task-card <?php echo 'task-' . strtolower($task['status']); ?>">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><?php echo htmlspecialchars($task['title']); ?></h5>
                            <span class="badge bg-<?php 
                                echo $task['status'] === 'TODO' ? 'warning' : 
                                    ($task['status'] === 'DOING' ? 'primary' : 
                                        ($task['status'] === 'REVIEW' ? 'info' : 'success')); 
                            ?>">
                                <?php echo $task['status']; ?>
                            </span>
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                <?php echo nl2br(htmlspecialchars($task['description'])); ?>
                            </p>
                            
                            <?php if (!empty($task['subtasks'])): ?>
                                <div class="subtask-list mt-3">
                                    <h6>Subtasks:</h6>
                                    <ul class="list-group">
                                        <?php foreach ($task['subtasks'] as $subtask): ?>
                                            <li class="list-group-item">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <input type="checkbox" class="form-check-input me-2" 
                                                            <?php echo $subtask['completed'] ? 'checked' : ''; ?>
                                                            onchange="location.href='<?php echo BASE_URL; ?>/subtasks/toggle-complete?id=<?php echo $subtask['id']; ?>'">
                                                        <span class="<?php echo $subtask['completed'] ? 'text-decoration-line-through' : ''; ?>">
                                                            <?php echo htmlspecialchars($subtask['title']); ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <?php if (!empty($subtask['description'])): ?>
                                                    <div class="mt-1 ps-4">
                                                        <small class="text-muted"><?php echo nl2br(htmlspecialchars($subtask['description'])); ?></small>
                                                    </div>
                                                <?php endif; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <div>
                                <a href="<?php echo BASE_URL; ?>/tasks/edit?id=<?php echo $task['id']; ?>" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <a href="<?php echo BASE_URL; ?>/subtasks/create?task_id=<?php echo $task['id']; ?>" class="btn btn-sm btn-success">
                                    <i class="bi bi-plus"></i> Add Subtask
                                </a>
                            </div>
                            <div>
                                <a href="<?php echo BASE_URL; ?>/tasks/delete?id=<?php echo $task['id']; ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Are you sure you want to delete this task and all its subtasks?')">
                                    <i class="bi bi-trash"></i> Delete
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>