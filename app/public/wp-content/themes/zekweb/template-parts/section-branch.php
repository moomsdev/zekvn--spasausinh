<?php
$title = get_field('sec11_title', 'option');
$title_mb = get_field('sec11_title_mb', 'option');
$image = get_field('sec11_img', 'option');
$image_mb = get_field('sec11_img_mb', 'option');
$branchList = get_field('sec11_branch', 'option');
?>

<section class="section-branch">
    <?php get_template_part('loop_template/loop', 'heading_section', ['title' => $title, 'title_mb' => $title_mb]) ?>

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
                <select name="branch-select" id="branch-select">
                    <option value="">Chọn chi nhánh</option>
                    <?php
                    if ($branchList) :
                        foreach ($branchList as $branch) :
                            $branch_address = $branch['branch_address'];
                            $branch_url = $branch['url'];
                            
                    ?>
                        <option value="<?php echo $branch_url; ?>"><?php echo $branch_address; ?></option>
                    <?php 
                        endforeach; 
                    endif;
                    ?>
                </select>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const branchSelect = document.getElementById('branch-select');
    
    branchSelect.addEventListener('change', function() {
        const selectedUrl = this.value;
        
        if (selectedUrl) {
            window.location.href = selectedUrl;
        }
    });
});
</script>