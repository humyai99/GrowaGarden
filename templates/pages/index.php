<?php require APP_ROOT . '/templates/partials/header.php'; ?>

<div class="p-5 mb-4 bg-light rounded-3">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold"><?php echo $title; ?></h1>
        <p class="col-md-8 fs-4"><?php echo $description; ?></p>
        <a href="<?php echo URL_ROOT; ?>/tickets/create" class="btn btn-primary btn-lg">แจ้งปัญหา (Report an Issue)</a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <h2><i class="bi bi-megaphone-fill"></i> ข่าวประกาศจาก IT (Announcements)</h2>
        <hr>
        <?php if (!empty($announcements)) : ?>
            <?php foreach ($announcements as $announcement) : ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($announcement->title); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($announcement->content); ?></p>
                        <p class="card-text"><small class="text-muted">Posted on <?php echo date('F j, Y', strtotime($announcement->created_at)); ?></small></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No active announcements at the moment.</p>
        <?php endif; ?>
    </div>
    <div class="col-md-4">
        <h2><i class="bi bi-hdd-stack-fill"></i> สถานะระบบ (System Status)</h2>
        <hr>
        <?php if (!empty($statuses)) : ?>
            <ul class="list-group">
                <?php foreach ($statuses as $status) :
                    $badge_class = 'bg-success'; // Default: operational
                    if ($status->status == 'degraded_performance') {
                        $badge_class = 'bg-warning text-dark';
                    } elseif ($status->status == 'partial_outage') {
                        $badge_class = 'bg-warning text-dark';
                    } elseif ($status->status == 'major_outage') {
                        $badge_class = 'bg-danger';
                    }
                ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?php echo htmlspecialchars($status->system_name); ?>
                        <span class="badge <?php echo $badge_class; ?> rounded-pill"><?php echo ucwords(str_replace('_', ' ', $status->status)); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>System status is not available.</p>
        <?php endif; ?>
    </div>
</div>


<?php require APP_ROOT . '/templates/partials/footer.php'; ?>
