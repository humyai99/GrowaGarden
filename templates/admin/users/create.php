<?php require APP_ROOT . '/templates/partials/header.php'; ?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card card-body bg-light mt-5">
            <h2><?php echo $data['title']; ?></h2>
            <p>Create a new user account.</p>
            <form action="<?php echo URL_ROOT; ?>/admin/users/store" method="post">
                <?php require '_form.php'; ?>
            </form>
        </div>
    </div>
</div>

<?php require APP_ROOT . '/templates/partials/footer.php'; ?>
