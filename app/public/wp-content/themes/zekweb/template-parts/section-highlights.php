<?php
$title = get_field('title', 'option');
$image = get_field('image', 'option');
?>

<section class="section-highlights">
    <div class="container">
        <?php get_template_part('loop_template/loop', 'heading_section') ?>
        <div class="row g-4 justify-content-center">
            <?php for ($i = 0; $i < 4; $i++): ?>
                <?php get_template_part('loop_template/loop', 'item_highlights', ['aos_delay' => $i * 250]); ?>
            <?php endfor; ?>
        </div>
    </div>
</section>
