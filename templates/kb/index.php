<?php require APP_ROOT . '/templates/partials/header.php'; ?>

<div class="row">
    <div class="col-md-10 mx-auto">
        <h2 class="mb-4"><?php echo $data['title']; ?></h2>
        <p>Find answers to common IT questions and learn how to solve problems yourself.</p>

        <?php
        // Group articles by category
        $grouped_articles = [];
        foreach ($data['articles'] as $article) {
            $grouped_articles[$article->category][] = $article;
        }
        ?>

        <?php if (!empty($grouped_articles)) : ?>
            <div class="accordion" id="kbAccordion">
                <?php $i = 0; foreach ($grouped_articles as $category => $articles) : $i++; ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading<?php echo $i; ?>">
                            <button class="accordion-button <?php if ($i > 1) echo 'collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $i; ?>" aria-expanded="<?php echo $i == 1 ? 'true' : 'false'; ?>" aria-controls="collapse<?php echo $i; ?>">
                                <?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $category))); ?>
                            </button>
                        </h2>
                        <div id="collapse<?php echo $i; ?>" class="accordion-collapse collapse <?php if ($i == 1) echo 'show'; ?>" aria-labelledby="heading<?php echo $i; ?>" data-bs-parent="#kbAccordion">
                            <div class="accordion-body">
                                <div class="list-group">
                                    <?php foreach ($articles as $article) : ?>
                                        <a href="<?php echo URL_ROOT; ?>/knowledgebase/show/<?php echo $article->id; ?>" class="list-group-item list-group-item-action">
                                            <?php echo htmlspecialchars($article->title); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p class="text-center">No knowledge base articles found.</p>
        <?php endif; ?>

    </div>
</div>

<?php require APP_ROOT . '/templates/partials/footer.php'; ?>
