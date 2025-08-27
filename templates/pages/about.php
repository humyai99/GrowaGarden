<?php require APP_ROOT . '/templates/partials/header.php'; ?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2><?php echo $title; ?> (ติดต่อ IT)</h2>
            <p><?php echo $description; ?></p>
            <hr>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <strong><i class="bi bi-telephone-fill"></i> เบอร์โทร (Phone):</strong> 02-123-4567 (ต่อ 888)
                </li>
                <li class="list-group-item">
                    <strong><i class="bi bi-line"></i> Line OA:</strong> @ithelpdesk
                </li>
                <li class="list-group-item">
                    <strong><i class="bi bi-envelope-fill"></i> Email:</strong> helpdesk@example.com
                </li>
                <li class="list-group-item">
                    <strong><i class="bi bi-clock-fill"></i> เวลาทำการ (Office Hours):</strong> จันทร์ - ศุกร์ (Mon - Fri), 08:30 - 17:30
                </li>
            </ul>
        </div>
    </div>
</div>


<?php require APP_ROOT . '/templates/partials/footer.php'; ?>
