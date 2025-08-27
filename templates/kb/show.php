<?php require APP_ROOT . '/templates/partials/header.php'; ?>

<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="card card-body mt-4 mb-5">
            <h1 class="mb-3"><?php echo htmlspecialchars($data['article']->title); ?></h1>
            <div class="text-muted mb-3">
                Category: <?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $data['article']->category))); ?> |
                Last Updated: <?php echo date('F j, Y', strtotime($data['article']->updated_at)); ?>
            </div>
            <hr>
            <div class="article-content">
                <?php
                    // A simple way to parse markdown-like text for basic formatting.
                    // In a real app, a library like Parsedown would be better.
                    $content = htmlspecialchars($data['article']->content);
                    $content = nl2br($content); // Convert newlines to <br>
                    echo $content;
                ?>
            </div>
            <hr>
            <a href="<?php echo URL_ROOT; ?>/knowledgebase" class="btn btn-secondary mt-3" style="width: fit-content;">
                <i class="bi bi-arrow-left"></i> Back to Knowledge Base
            </a>
        </div>
    </div>
</div>

<?php require APP_ROOT . '/templates/partials/footer.php'; ?>
