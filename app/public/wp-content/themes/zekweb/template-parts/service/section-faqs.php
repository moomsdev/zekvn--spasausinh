<?php
$faqsTitle = $args['faqs_title'];
$faqs = $args['faqs'];

if ($faqs) : ?>
?>
<div class="faq-card p-0 p-lg-4">
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
<?php endif; ?>