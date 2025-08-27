<?php require APP_ROOT . '/templates/partials/header.php'; ?>

<div class="row">
    <!-- Main Ticket Info -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3><?php echo htmlspecialchars($data['ticket']->subject); ?></h3>
                <a href="<?php echo URL_ROOT; ?>/tickets" class="btn btn-light"><i class="bi bi-arrow-left"></i> Back to All Tickets</a>
            </div>
            <div class="card-body">
                <p>
                    <strong>Ticket ID:</strong> <?php echo htmlspecialchars($data['ticket']->ticket_id); ?>
                </p>
                <hr>
                <p>
                    <?php echo nl2br(htmlspecialchars($data['ticket']->description)); ?>
                </p>
                <?php if (!empty($data['ticket']->attachment_path)) : ?>
                    <hr>
                    <p>
                        <strong>Attachment:</strong>
                        <a href="<?php echo URL_ROOT . '/' . htmlspecialchars($data['ticket']->attachment_path); ?>" target="_blank">View Attachment</a>
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Ticket Updates/History (Future) -->
        <div class="card mt-4">
            <div class="card-header">
                Ticket History / Comments
            </div>
            <div class="card-body">
                <p class="text-muted">Comment and update history will be shown here.</p>
            </div>
        </div>
    </div>

    <!-- Sidebar with Details -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Ticket Details</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Status:</strong> <span class="badge bg-primary"><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $data['ticket']->status))); ?></span></li>
                    <li class="list-group-item"><strong>Priority:</strong> <?php echo htmlspecialchars(ucwords($data['ticket']->priority)); ?></li>
                    <li class="list-group-item"><strong>Requester:</strong> <?php echo htmlspecialchars($data['ticket']->requester_name); ?></li>
                    <li class="list-group-item"><strong>Department:</strong> <?php echo htmlspecialchars($data['ticket']->department_name); ?></li>
                    <li class="list-group-item"><strong>Submitted:</strong> <?php echo date('Y-m-d H:i', strtotime($data['ticket']->created_at)); ?></li>
                    <li class="list-group-item"><strong>Assigned To:</strong> <?php echo htmlspecialchars($data['ticket']->assigned_to_name ?? 'Unassigned'); ?></li>
                </ul>
            </div>
        </div>

        <!-- Actions (Assign, Change Status) -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Manage Ticket</h5>
                <form action="<?php echo URL_ROOT; ?>/tickets/update/<?php echo $data['ticket']->id; ?>" method="post">

                    <!-- Status -->
                    <div class="form-group mb-3">
                        <label for="status">Status:</label>
                        <select name="status" class="form-control">
                            <option value="open" <?php if ($data['ticket']->status == 'open') echo 'selected'; ?>>Open</option>
                            <option value="in_progress" <?php if ($data['ticket']->status == 'in_progress') echo 'selected'; ?>>In Progress</option>
                            <option value="awaiting_approval" <?php if ($data['ticket']->status == 'awaiting_approval') echo 'selected'; ?>>Awaiting Approval</option>
                            <option value="awaiting_parts" <?php if ($data['ticket']->status == 'awaiting_parts') echo 'selected'; ?>>Awaiting Parts</option>
                            <option value="resolved" <?php if ($data['ticket']->status == 'resolved') echo 'selected'; ?>>Resolved</option>
                            <option value="closed" <?php if ($data['ticket']->status == 'closed') echo 'selected'; ?>>Closed</option>
                        </select>
                    </div>

                    <!-- Assign Technician -->
                    <div class="form-group mb-3">
                        <label for="assigned_to">Assign To:</label>
                        <select name="assigned_to" class="form-control">
                            <option value="0">Unassigned</option>
                            <?php foreach($data['technicians'] as $technician): ?>
                                <option value="<?php echo $technician->id; ?>" <?php if ($data['ticket']->assigned_to == $technician->id) echo 'selected'; ?>>
                                    <?php echo $technician->full_name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php require APP_ROOT . '/templates/partials/footer.php'; ?>
