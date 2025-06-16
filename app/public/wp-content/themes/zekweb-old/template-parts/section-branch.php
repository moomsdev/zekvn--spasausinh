<?php
$title = get_field('sec11_title', 'option');
$image = get_field('sec11_img', 'option');
$branchList = get_field('sec11_branch', 'option');
?>

<section class="section-branch">
    <?php get_template_part('loop_template/loop', 'heading_section', ['title' => $title]) ?>

    <div class="container">
        <div class="branch-inner">
            <figure>
                <img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" loading="lazy">
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