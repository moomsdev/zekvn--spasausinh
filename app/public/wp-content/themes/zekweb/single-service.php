<?php
get_header();
wp_reset_query();
$format = get_post_format();

while (have_posts()) : the_post();
$block_service = get_field('block_service');
$faqsTitle = get_field(selector: 'faqs_title');
$faqs = get_field('faqs');
?>
<main id="main">
    <div class="page-body">
        <!-- <div class="service-banner">
            <figure class="icon-image">
                <img src="" alt="">
            </figure>
        </div> -->
        <?php
        // Slider hero
        get_template_part('template-parts/section', 'slider_hero');

        foreach ($block_service as $block) {
            $title = $block['title'];
            $short_description = $block['short_desc'];
            $content_media = $block['content_media'];
            $content_only = $block['content_only'];
            $video = $block['video'];

            switch($block['blocks']):
                case 'content_media':
                    get_template_part('template-parts/service/section', 'content_media', ['title' => $title, 'short_description' => $short_description, 'content_media' => $content_media]);
                    break;
                case 'content':
                    get_template_part('template-parts/service/section', 'content', ['title' => $title, 'short_description' => $short_description, 'content_only' => $content_only]);
                    break;
                case 'video':
                    get_template_part('template-parts/service/section', 'video', ['title' => $title, 'video' => $video]);
                    break;
            endswitch;
        }

        get_template_part('template-parts/section', 'contact');

        get_template_part('template-parts/service/section', 'faqs', ['faqs_title' => $faqsTitle, 'faqs' => $faqs]);
        ?>
    </div>
</main>
<?php
endwhile;
get_footer(); ?>
