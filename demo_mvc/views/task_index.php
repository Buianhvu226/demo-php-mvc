<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>My Tasks</h2>
    <a href="<?php echo BASE_URL; ?>/tasks/create" class="btn btn-primary">Create New Task</a>
</div>

<?php if (empty($tasks)): ?>
    <div class="alert alert-info">
        No tasks found. Create your first task now!
    </div>
<?php else: ?>
    <!-- Status filters -->
    <div class="mb-4">
        <div class="btn-group" role="group">
            <a href="<?php echo BASE_URL; ?>/tasks" class="btn btn-outline-secondary active">All</a>
            <a href="<?php echo BASE_URL; ?>/tasks?status=TODO" class="btn btn-outline-warning">TODO</a>
            <a href="<?php echo BASE_URL; ?>/tasks?status=DOING" class="btn btn-outline-primary">DOING</a>
            <a href="<?php echo BASE_URL; ?>/tasks?status=REVIEW" class="btn btn-outline-info">REVIEW</a>
            <a href="<?php echo BASE_URL; ?>/tasks?status=DONE" class="btn btn-outline-success">DONE</a>
        </div>
    </div>

    <?php
    // Filter tasks by status if specified
    $status = $_GET['status'] ?? '';
    if (!empty($status)) {
        $filteredTasks = array_filter($tasks, function ($task) use ($status) {
            return $task['status'] === $status;
        });
    } else {
        $filteredTasks = $tasks;
    }
    ?>

    <?php if (empty($filteredTasks)): ?>
        <div class="alert alert-info">No tasks found with the selected filter.</div>
    <?php else: ?>
        <?php foreach ($filteredTasks as $task): ?>
            <div class="card mb-3 task-card task-<?php echo strtolower($task['status']); ?>">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title"><?php echo htmlspecialchars($task['title']); ?></h5>
                        <span class="badge bg-<?php
                                                echo $task['status'] === 'TODO' ? 'warning' : ($task['status'] === 'DOING' ? 'primary' : ($task['status'] === 'REVIEW' ? 'info' : 'success'));
                                                ?>"><?php echo $task['status']; ?></span>
                    </div>

                    <p class="card-text"><?php echo nl2br(htmlspecialchars($task['description'])); ?></p>

                    <?php if (!empty($task['subtasks'])): ?>
                        <div class="subtask-list mt-3">
                            <h6>Subtasks:</h6>
                            <ul class="list-group">
                                <?php foreach ($task['subtasks'] as $subtask): ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <?php if ($subtask['completed']): ?>
                                                <span class="text-decoration-line-through"><?php echo htmlspecialchars($subtask['title']); ?></span>
                                            <?php else: ?>
                                                <?php echo htmlspecialchars($subtask['title']); ?>
                                            <?php endif; ?>
                                        </div>
                                        <span class="badge bg-<?php echo $subtask['completed'] ? 'success' : 'secondary'; ?> rounded-pill">
                                            <?php echo $subtask['completed'] ? 'Completed' : 'Pending'; ?>
                                        </span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="mt-3 d-flex justify-content-between">
                        <div>
                            <a href="<?php echo BASE_URL; ?>/tasks/edit?id=<?php echo $task['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="<?php echo BASE_URL; ?>/tasks/delete?id=<?php echo $task['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this task?')">Delete</a>
                        </div>

                        <!-- Status change dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton<?php echo $task['id']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                Change Status
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $task['id']; ?>">
                                <li>
                                    <form action="<?php echo BASE_URL; ?>/tasks/change-status" method="post" class="px-2 py-1">
                                        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                                        <input type="hidden" name="status" value="TODO">
                                        <button type="submit" class="dropdown-item <?php echo $task['status'] === 'TODO' ? 'active' : ''; ?>">
                                            <span class="text-warning">■</span> TODO
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <form action="<?php echo BASE_URL; ?>/tasks/change-status" method="post" class="px-2 py-1">
                                        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                                        <input type="hidden" name="status" value="DOING">
                                        <button type="submit" class="dropdown-item <?php echo $task['status'] === 'DOING' ? 'active' : ''; ?>">
                                            <span class="text-primary">■</span> DOING
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <form action="<?php echo BASE_URL; ?>/tasks/change-status" method="post" class="px-2 py-1">
                                        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                                        <input type="hidden" name="status" value="REVIEW">
                                        <button type="submit" class="dropdown-item <?php echo $task['status'] === 'REVIEW' ? 'active' : ''; ?>">
                                            <span class="text-info">■</span> REVIEW
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <form action="<?php echo BASE_URL; ?>/tasks/change-status" method="post" class="px-2 py-1">
                                        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                                        <input type="hidden" name="status" value="DONE">
                                        <button type="submit" class="dropdown-item <?php echo $task['status'] === 'DONE' ? 'active' : ''; ?>">
                                            <span class="text-success">■</span> DONE
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-2 text-muted small">
                        <div>Created: <?php echo date('M j, Y g:i A', strtotime($task['created_at'])); ?></div>
                        <div>Updated: <?php echo date('M j, Y g:i A', strtotime($task['updated_at'])); ?></div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>