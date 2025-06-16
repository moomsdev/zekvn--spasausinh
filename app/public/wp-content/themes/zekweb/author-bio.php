<?php get_header(); ?>
<main id="main">
    <?php get_template_part('breadcrums'); ?>
    <div id="content_pages">
        <div class="container">
            <div class="all_box">
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
                        ?>
                        <div class="box-author clearfix">
                            <div class="img"><?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'twentyeleven_author_bio_avatar_size', 300 ) ); ?></div>
                            <div class="info clearfix">
                                <h2 class="name"><?php echo $curauth->nickname; ?></h2>
                                <div class="depscription"><?php echo $curauth->user_description; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="list-news clearfix">
                            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                            <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php the_author();?></a>
                            <?php endwhile; else: ?>
                            <p><?php _e('Chưa có bài viết nào'); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="sidebar">
                            <?php get_template_part('sidebar'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php get_footer(); ?>