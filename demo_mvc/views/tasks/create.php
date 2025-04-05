<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4>Create New Task</h4>
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

                <form action="<?php echo BASE_URL; ?>/tasks/store" method="post">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title"
                            value="<?php echo isset($_SESSION['form_data']['title']) ? $_SESSION['form_data']['title'] : ''; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4"><?php echo isset($_SESSION['form_data']['description']) ? $_SESSION['form_data']['description'] : ''; ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="TODO" <?php echo (isset($_SESSION['form_data']['status']) && $_SESSION['form_data']['status'] === 'TODO') ? 'selected' : ''; ?>>TODO</option>
                            <option value="DOING" <?php echo (isset($_SESSION['form_data']['status']) && $_SESSION['form_data']['status'] === 'DOING') ? 'selected' : ''; ?>>DOING</option>
                            <option value="REVIEW" <?php echo (isset($_SESSION['form_data']['status']) && $_SESSION['form_data']['status'] === 'REVIEW') ? 'selected' : ''; ?>>REVIEW</option>
                            <option value="DONE" <?php echo (isset($_SESSION['form_data']['status']) && $_SESSION['form_data']['status'] === 'DONE') ? 'selected' : ''; ?>>DONE</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Create Task</button>
                        <a href="<?php echo BASE_URL; ?>/tasks" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>

                <?php unset($_SESSION['form_data']); ?>
            </div>
        </div>
    </div>
</div>