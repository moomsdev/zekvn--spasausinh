<?php
$faqsTitle = isset($args['faqs_title']) ? $args['faqs_title'] : 'Tiêu đề mặc định';
$faqs = isset($args['faqs']) ? $args['faqs'] : '';
?>
<div class="faq-card p-4">
  <div class="container">
    <h3 class="mb-4 fw-bold"><?php echo $faqsTitle; ?></h3>

    <?php foreach ($faqs as $faq) : ?>
      <div class="faq-item mb-3">
        <h6 class="faq-question fw-bold mb-1"><?php echo $faq['question']; ?></h6>
        <p class="faq-answer mb-0"><?php echo $faq['answers']; ?></p>
      </div>
    <?php endforeach; ?>

  </div>
</div>
