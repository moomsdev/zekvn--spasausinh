<?php get_header(); $a=get_query_var('cat' );?>
<main id="main">
    <?php get_template_part('loop_template/breadcrums'); ?>
    <div class="page-body">
        <div class="container">
            <h1 class="page-title">Tìm kiếm: "<?php echo get_search_query(); ?>"</h1>
            <div class="row row-margin">
                <div class="col-lg-9 col-md-12">
                    <div class="list-news">
                        <div class="row row-margin">
                            <?php if(have_posts()){ while(have_posts()):the_post();$format=get_post_format();setPostViews($post->ID); ?>
                            <div class="col-lg-4 col-md-6 col-12 col-item">
                                <?php get_template_part('loop_template/loop'); ?>
                            </div>
                            <?php endwhile;wp_reset_postdata(); ?>
                            <?php }?>
                        </div>
                    </div>
                    <?php get_template_part( 'loop_template/pagination' ); ?>
                </div>
                <div class="col-lg-3 col-md-12">
                    <div class="page-sidebảe">
                        <?php get_template_part('sidebar'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>