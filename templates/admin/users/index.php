<?php require APP_ROOT . '/templates/partials/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><?php echo $data['title']; ?></h2>
    <a href="<?php echo URL_ROOT; ?>/admin/users/create" class="btn btn-success">
        <i class="bi bi-plus-lg"></i> Create New User
    </a>
</div>

<div class="card">
    <div class="card-body">
        <?php if (!empty($data['users'])) : ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Department</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['users'] as $user) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user->full_name); ?></td>
                                <td><?php echo htmlspecialchars($user->username); ?></td>
                                <td><?php echo htmlspecialchars($user->email); ?></td>
                                <td><span class="badge bg-secondary"><?php echo htmlspecialchars(ucfirst($user->role)); ?></span></td>
                                <td><?php echo htmlspecialchars($user->department_name ?? 'N/A'); ?></td>
                                <td>
                                    <a href="<?php echo URL_ROOT; ?>/admin/users/edit/<?php echo $user->id; ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <!-- Delete button would typically be a form to prevent CSRF -->
                                    <form action="<?php echo URL_ROOT; ?>/admin/users/delete/<?php echo $user->id; ?>" method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <p class="text-center">No users found.</p>
        <?php endif; ?>
    </div>
</div>

<?php require APP_ROOT . '/templates/partials/footer.php'; ?>
