<?php get_header(); $a=get_query_var('cat' );?>
<?php $term = get_queried_object(); ?>
<main id="main">
    <?php get_template_part('breadcrums'); ?>
    <div class="page-body">
        <div class="container">
            <?php
            $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
            ?>
            <h1 class="page-title"><?php echo $curauth->nickname; ?></h1>
            <div class="archive-content">
                <div class="content-post clearfix">
                    <?php echo $curauth->user_description; ?>
                </div>
            </div>
            <div class="row row-margin">
                <div class="col-lg-9 col-md-12">
                    <div class="list-news">
                        <div class="row row-margin">
                            <?php if(have_posts()){ while(have_posts()):the_post();$format=get_post_format();setPostViews($post->ID); ?>
                            <div class="col-lg-4 col-md-6 col-12 col-item">
                                <?php get_template_part('loop'); ?>
                            </div>
                            <?php endwhile;wp_reset_postdata(); ?>
                            <?php } ?>
                        </div>
                    </div>
                    <?php get_template_part( 'pagination' ); ?>
                </div>
                <div class="col-lg-3 col-md-12">
                    <div class="page-sidebar">
                        <?php get_template_part('sidebar'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>