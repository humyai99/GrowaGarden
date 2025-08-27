<!-- This is a partial form, it expects to be included by create.php or edit.php -->
<!-- It expects $data to be set with user info and errors -->

<div class="form-group mb-3">
    <label for="full_name">Full Name: <sup>*</sup></label>
    <input type="text" name="full_name" class="form-control <?php echo (!empty($data['errors']['full_name'])) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($data['full_name']); ?>">
    <span class="invalid-feedback"><?php echo $data['errors']['full_name'] ?? ''; ?></span>
</div>

<div class="form-group mb-3">
    <label for="email">Email: <sup>*</sup></label>
    <input type="email" name="email" class="form-control <?php echo (!empty($data['errors']['email'])) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($data['email']); ?>">
    <span class="invalid-feedback"><?php echo $data['errors']['email'] ?? ''; ?></span>
</div>

<div class="form-group mb-3">
    <label for="username">Username: <sup>*</sup></label>
    <input type="text" name="username" class="form-control <?php echo (!empty($data['errors']['username'])) ? 'is-invalid' : ''; ?>" value="<?php echo htmlspecialchars($data['username']); ?>" <?php if(isset($data['id'])) echo 'disabled'; ?>>
    <span class="invalid-feedback"><?php echo $data['errors']['username'] ?? ''; ?></span>
    <?php if(isset($data['id'])): ?><small class="form-text text-muted">Username cannot be changed.</small><?php endif; ?>
</div>

<div class="form-group mb-3">
    <label for="password">Password:</label>
    <input type="password" name="password" class="form-control <?php echo (!empty($data['errors']['password'])) ? 'is-invalid' : ''; ?>">
    <span class="invalid-feedback"><?php echo $data['errors']['password'] ?? ''; ?></span>
    <?php if(isset($data['id'])): ?><small class="form-text text-muted">Leave blank to keep the current password.</small><?php endif; ?>
</div>

<div class="form-group mb-3">
    <label for="role">Role:</label>
    <select name="role" class="form-control">
        <option value="user" <?php if ($data['role'] == 'user') echo 'selected'; ?>>User</option>
        <option value="technician" <?php if ($data['role'] == 'technician') echo 'selected'; ?>>Technician</option>
        <option value="admin" <?php if ($data['role'] == 'admin') echo 'selected'; ?>>Admin</option>
    </select>
</div>

<div class="form-group mb-3">
    <label for="department_id">Department (Optional):</label>
    <input type="text" name="department_id" class="form-control" value="<?php echo htmlspecialchars($data['department_id'] ?? ''); ?>">
    <small class="form-text text-muted">Note: For now, this is a text input for the department ID. A dropdown would be better in a future version.</small>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-success">Save User</button>
    <a href="<?php echo URL_ROOT; ?>/admin/users" class="btn btn-secondary">Cancel</a>
</div>
