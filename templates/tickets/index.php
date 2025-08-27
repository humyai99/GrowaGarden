<?php require APP_ROOT . '/templates/partials/header.php'; ?>

<h2><?php echo $title; ?></h2>
<p>Here is a list of all the support tickets in the system.</p>

<div class="card">
    <div class="card-body">
        <?php if (!empty($tickets)) : ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Subject</th>
                            <th>Requester</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Assigned To</th>
                            <th>Date Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tickets as $ticket) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($ticket->ticket_id); ?></td>
                                <td><?php echo htmlspecialchars($ticket->subject); ?></td>
                                <td><?php echo htmlspecialchars($ticket->requester_name); ?></td>
                                <td><?php echo htmlspecialchars($ticket->department_name); ?></td>
                                <td><span class="badge bg-info"><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $ticket->status))); ?></span></td>
                                <td><span class="badge bg-warning text-dark"><?php echo htmlspecialchars(ucwords($ticket->priority)); ?></span></td>
                                <td><?php echo htmlspecialchars($ticket->assigned_to_name ?? 'Unassigned'); ?></td>
                                <td><?php echo date('Y-m-d H:i', strtotime($ticket->created_at)); ?></td>
                                <td>
                                    <a href="<?php echo URL_ROOT; ?>/tickets/show/<?php echo $ticket->id; ?>" class="btn btn-sm btn-primary">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <p class="text-center">No tickets found.</p>
        <?php endif; ?>
    </div>
</div>


<?php require APP_ROOT . '/templates/partials/footer.php'; ?>
