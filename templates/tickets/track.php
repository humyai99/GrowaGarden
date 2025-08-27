<?php require APP_ROOT . '/templates/partials/header.php'; ?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2><?php echo $data['title']; ?></h2>
            <p>Enter your Ticket ID below to see its current status.</p>
            <form action="<?php echo URL_ROOT; ?>/tickets/track" method="post">
                <div class="input-group mb-3">
                    <input type="text" name="ticket_id" class="form-control form-control-lg" placeholder="e.g., TICKET-20240807-ABCDE" value="<?php echo htmlspecialchars($data['ticket_id']); ?>">
                    <button class="btn btn-success" type="submit">Track</button>
                </div>
            </form>
        </div>

        <?php if (!empty($data['error'])) : ?>
            <div class="alert alert-danger mt-4"><?php echo $data['error']; ?></div>
        <?php endif; ?>

        <?php if (!empty($data['ticket'])) : ?>
            <div class="card mt-4">
                <div class="card-header bg-dark text-white">
                    Ticket Details: <?php echo htmlspecialchars($data['ticket']->ticket_id); ?>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($data['ticket']->subject); ?></h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Status:</strong> <span class="badge bg-primary"><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $data['ticket']->status))); ?></span></li>
                        <li class="list-group-item"><strong>Requester:</strong> <?php echo htmlspecialchars($data['ticket']->requester_name); ?></li>
                        <li class="list-group-item"><strong>Department:</strong> <?php echo htmlspecialchars($data['ticket']->department_name); ?></li>
                        <li class="list-group-item"><strong>Issue Type:</strong> <?php echo htmlspecialchars(ucwords($data['ticket']->issue_type)); ?></li>
                        <li class="list-group-item"><strong>Priority:</strong> <?php echo htmlspecialchars(ucwords($data['ticket']->priority)); ?></li>
                        <li class="list-group-item"><strong>Assigned To:</strong> <?php echo htmlspecialchars($data['ticket']->assigned_to_name ?? 'Not yet assigned'); ?></li>
                        <li class="list-group-item"><strong>Date Submitted:</strong> <?php echo date('F j, Y, g:i a', strtotime($data['ticket']->created_at)); ?></li>
                    </ul>
                    <div class="mt-3">
                        <h6>Description</h6>
                        <p><?php echo nl2br(htmlspecialchars($data['ticket']->description)); ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>


<?php require APP_ROOT . '/templates/partials/footer.php'; ?>
