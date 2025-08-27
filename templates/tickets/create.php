<?php require APP_ROOT . '/templates/partials/header.php'; ?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card card-body bg-light mt-3 mb-5">
            <h2><?php echo $data['title']; ?></h2>
            <p>Please fill out this form to submit a new ticket.</p>
            <form action="<?php echo URL_ROOT; ?>/tickets/store" method="post" enctype="multipart/form-data">

                <!-- Issue Type -->
                <div class="form-group mb-3">
                    <label for="issue_type">Issue Type: <sup>*</sup></label>
                    <select name="issue_type" class="form-control form-control-lg">
                        <option value="computer">Computer / Notebook</option>
                        <option value="printer">Printer</option>
                        <option value="internet">Internet / Network</option>
                        <option value="email">Email</option>
                        <option value="software">Software / Application</option>
                        <option value="ups">UPS</option>
                        <option value="cctv">CCTV</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <!-- Subject -->
                <div class="form-group mb-3">
                    <label for="subject">Subject: <sup>*</sup></label>
                    <input type="text" name="subject" class="form-control form-control-lg <?php echo (!empty($data['subject_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['subject']; ?>">
                    <span class="invalid-feedback"><?php echo $data['subject_err']; ?></span>
                </div>

                <!-- Description -->
                <div class="form-group mb-3">
                    <label for="description">Description: <sup>*</sup></label>
                    <textarea name="description" class="form-control form-control-lg <?php echo (!empty($data['description_err'])) ? 'is-invalid' : ''; ?>"><?php echo $data['description']; ?></textarea>
                    <span class="invalid-feedback"><?php echo $data['description_err']; ?></span>
                </div>

                <!-- Priority -->
                <div class="form-group mb-3">
                    <label for="priority">Priority: <sup>*</sup></label>
                    <select name="priority" class="form-control form-control-lg">
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </div>

                <!-- Attachment -->
                <div class="form-group mb-3">
                    <label for="attachment">Attachment (Optional):</label>
                    <input type="file" name="attachment" class="form-control">
                </div>

                <div class="mt-4">
                    <input type="submit" value="Submit Ticket" class="btn btn-success">
                    <a href="<?php echo URL_ROOT; ?>" class="btn btn-secondary">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>

<?php require APP_ROOT . '/templates/partials/footer.php'; ?>
