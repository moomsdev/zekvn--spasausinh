<?php
$title = get_field('sec11_title', 'option');
$image = get_field('sec11_img', 'option');
$image_mb = get_field('sec11_img_mb', 'option');
$branchList = get_field('sec11_branch', 'option');
?>

<section class="section-branch">
    <?php get_template_part('loop_template/loop', 'heading_section', ['title' => $title]) ?>

    <div class="container">
        <div class="branch-inner">
            <figure class="d-none d-md-block">
                <img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" loading="lazy">
            </figure>
            <figure class="d-block d-md-none">
                <?php if ($image_mb): ?>
                    <img src="<?php echo $image_mb; ?>" alt="<?php echo $title; ?>" loading="lazy">
                <?php else: ?>
                    <img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" loading="lazy">
                <?php endif; ?>
            </figure>
            <div class="branch-list">
                <select name="" id="">
                    <?php foreach ($branchList as $branch) : ?>
                        <option value="<?php echo $branch['branch_address']; ?>"><?php echo $branch['branch_address']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
</section>