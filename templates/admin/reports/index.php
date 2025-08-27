<?php require APP_ROOT . '/templates/partials/header.php'; ?>

<h2><?php echo $data['title']; ?></h2>
<p>Filter and view ticket history. You can also export the results.</p>

<!-- Filter Form -->
<div class="card card-body bg-light mb-4">
    <form action="<?php echo URL_ROOT; ?>/admin/reports/index" method="get" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select">
                <option value="all" <?php if ($data['filters']['status'] == 'all') echo 'selected'; ?>>All</option>
                <option value="open" <?php if ($data['filters']['status'] == 'open') echo 'selected'; ?>>Open</option>
                <option value="in_progress" <?php if ($data['filters']['status'] == 'in_progress') echo 'selected'; ?>>In Progress</option>
                <option value="resolved" <?php if ($data['filters']['status'] == 'resolved') echo 'selected'; ?>>Resolved</option>
                <option value="closed" <?php if ($data['filters']['status'] == 'closed') echo 'selected'; ?>>Closed</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="date_from" class="form-label">From</label>
            <input type="date" name="date_from" id="date_from" class="form-control" value="<?php echo htmlspecialchars($data['filters']['date_from']); ?>">
        </div>
        <div class="col-md-3">
            <label for="date_to" class="form-label">To</label>
            <input type="date" name="date_to" id="date_to" class="form-control" value="<?php echo htmlspecialchars($data['filters']['date_to']); ?>">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>
</div>

<!-- Results -->
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <span>Report Results</span>
        <?php if (!empty($data['tickets'])) : ?>
            <!-- The export link will pass the current filters -->
            <a href="<?php echo URL_ROOT; ?>/admin/reports/export_csv?<?php echo http_build_query($data['filters']); ?>" class="btn btn-sm btn-success">
                <i class="bi bi-file-earmark-spreadsheet"></i> Export as CSV
            </a>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <?php if (!empty($data['tickets'])) : ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Subject</th>
                            <th>Requester</th>
                            <th>Status</th>
                            <th>Assigned To</th>
                            <th>Date Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['tickets'] as $ticket) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($ticket->ticket_id); ?></td>
                                <td><?php echo htmlspecialchars($ticket->subject); ?></td>
                                <td><?php echo htmlspecialchars($ticket->requester_name); ?></td>
                                <td><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $ticket->status))); ?></td>
                                <td><?php echo htmlspecialchars($ticket->assigned_to_name ?? 'Unassigned'); ?></td>
                                <td><?php echo date('Y-m-d', strtotime($ticket->created_at)); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php elseif (!empty($_GET)) : ?>
            <p class="text-center">No tickets found matching your criteria.</p>
        <?php else: ?>
            <p class="text-center">Use the filters above to generate a report.</p>
        <?php endif; ?>
    </div>
</div>


<?php require APP_ROOT . '/templates/partials/footer.php'; ?>
