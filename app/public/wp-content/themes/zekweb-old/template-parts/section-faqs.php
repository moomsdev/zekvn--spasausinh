<?php
$title = get_field('sec14_title', 'option');
$faqs = get_field('sec14_faqs', 'option');
?>
<div class="faq-card p-4">
  <div class="container">
    <h3 class="mb-4 fw-bold"><?php echo $title; ?></h3>

    <?php foreach ($faqs as $faq) : ?>
      <div class="faq-item mb-3">
        <h6 class="faq-question fw-bold mb-1"><?php echo $faq['question']; ?></h6>
        <p class="faq-answer mb-0"><?php echo $faq['answers']; ?></p>
      </div>
    <?php endforeach; ?>

  </div>
</div>
