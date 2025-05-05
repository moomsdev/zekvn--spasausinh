<?php
$title = get_field('sec9_title', 'option');
$highlights = get_field('sec9_highlight', 'option');
$i = 0;
?>

<section class="section-highlights">
    <div class="container">
        <?php get_template_part('loop_template/loop', 'heading_section', ['title' => $title]) ?>

        <div class="row g-4 justify-content-center">
            <?php
            foreach ($highlights as $article):
                get_template_part('loop_template/loop', 'item_highlights', ['aos_delay' => $i * 250, 'article' => $article]);
            endforeach; 
            ?>
        </div>
    </div>
</section>
