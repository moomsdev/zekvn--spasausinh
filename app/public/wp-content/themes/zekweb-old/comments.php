<?php

if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Vui lòng không tải trang này trực tiếp. Cảm ơn!');

	if ( post_password_required() ) { ?>
		<p class="nocomments">Bài đăng này được bảo vệ bằng mật khẩu. Nhập mật khẩu để xem bình luân.</p>
	<?php
		return;
	}
?>
<div id="comments" class="comments-area">

<?php if ( comments_open() ) : ?>
<div id="formcmmaxweb">

    <div class="cancel-comment-reply">
    	<small><?php cancel_comment_reply_link(); ?></small>
    </div>

    <?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
    <p><a href="<?php echo wp_login_url( get_permalink() ); ?>">Đăng nhập</a> để bình luận.</p>
    <?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

    <?php if ( is_user_logged_in() ) : ?>
		<p class="nameuser">Bình luận với tư cách: <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a></p>    
    <?php endif; ?>
     	<p>
        	<textarea name="comment" id="comment" cols="50" rows="4" tabindex="4" placeholder="Gửi bình luận của bạn"></textarea>
        </p>
    <?php if(!is_user_logged_in()):?>    
		<div class="name-email">
	      <p>
	      	<input placeholder="Họ tên" type="text" name="author" id="author" value="<?php echo esc_attr($comment_author);?>" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
	      </p>
	      <p>
	        <input placeholder="Email" type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
	      </p>
		</div>
    <?php endif;?>
        <p><input name="submit" type="submit" id="submit" tabindex="5" value="Bình luận" />
        <?php comment_id_fields(); ?>
        </p>
        <?php do_action('comment_form', $post->ID); ?>

    </form>

        <?php endif; // If registration required and not logged in ?>
       
    </div>
<?php endif; // if you delete this the sky will fall on your head ?>

<?php
	if ( ! comments_open() && get_comments_number() ) : ?>
	<p class="nocomments"><?php _e( 'Comment is closed.' , '' ); ?></p>
	<?php endif; ?>
	<?php // You can start editing here -- including this comment! ?>
	<?php if ( have_comments() ) : ?>
	<ol class="commentlist">
		<?php wp_list_comments('type=comment&callback=maxweb_comment'); ?>
	</ol><!-- .commentlist -->
	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
	<nav id="comment-nav-below" class="navigation" role="navigation">
		<h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', '' ); ?></h1>
		<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', '' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', '' ) ); ?></div>
	</nav>
	<?php endif; // check for comment navigation ?>
<?php endif; // have_comments() ?>


</div><!-- #comments .comments-area -->

<style>
ol.commentlist{display:block;overflow:visible;background:#fff;margin:20px 0;clear:both;border-top:1px solid #dadada;padding-top:20px}
ol.commentlist > li{display:block;overflow:visible;margin-bottom:15px;position:relative;padding-bottom:5px}
ol.commentlist > li .fn{overflow:visible;font-size:16px;display:inline-block;position:relative;font-style:normal;margin-bottom:0;cursor:default;text-transform:capitalize;font-weight:600}
.comment-respond{clear:both}
#formcmmaxweb textarea{display:block;overflow:hidden;width:100%;height:120px;margin-bottom: 20px; background:#fff;border:1px solid #dbdbdb;border-radius:10px;padding:15px 20px;font-size:14px;color:#BBBBBB;outline:none}
#formcmmaxweb input{display:block;padding:0 20px;width:100%;margin:0 0 20px;height:40px;line-height: 38px;outline: none; border:1px solid #dbdbdb;background:#fff;border-radius:5px;font-size:14px;box-sizing:border-box}
#formcmmaxweb input[type=submit]{display:block;width:auto;min-width: 160px;text-align: center; margin:0 auto 10px;padding:0 10px;height:40px;line-height: 38px; font-size:14px;color:#fff;text-transform:uppercase;border:1px solid #346DB2;border-radius:5px;background:#346DB2;cursor:pointer}
ol.commentlist > li > ul.children{display:block;position:relative;margin:10px 0 0;padding:10px 15px 0 12px;clear:both;font-size:14px;color:#333;line-height:22px;background:#f8f8f8;border:1px solid #dfdfdf}
.commentBody > p{display:inline-block}
.qtv{background:#f1c40f;border-radius:2px;display:none;padding:0 5px;line-height:normal;border:1px solid #f1c40f;font-size:11px;color:#333;font-weight:400;margin:5px 0 0 10px}
.comment-author-admin .qtv{display:inline-block}
.ngaythang{padding:5px 0;font-size:13px;color:#999;position:relative}
ol.commentlist > li > ul.children:before,ol.commentlist > li > ul.children:after{top:-20px;left:18px;border:solid transparent;content:" ";height:0;width:0;position:absolute;pointer-events:none}
ol.commentlist > li > ul.children:before{border-color:rgba(238,238,238,0);border-bottom-color:#f8f8f8;border-width:11px;margin-left:-11px;z-index:1}
ol.commentlist > li > ul.children:after{border-color:rgba(255,255,255,0);border-bottom-color:#dfdfdf;border-width:10px;margin-left:-10px}
ol.commentlist > li .comment-author{display: flex;align-items: center;}
ol.commentlist > li .comment-author img{width: 36px;height: 36px;border-radius: 50%;object-fit: cover;margin-right: 10px;}
ol.commentlist > li .text_cmt{padding-left: 46px;}
ol.commentlist > li .text_cmt p{margin-bottom: 5px;}

.reply a{padding:5px 10px 0 0;font-size:13px;color:#288ad9}
@media(max-width:768px) {
.comment-list,.children{list-style:none}
ul.children{list-style:none;padding-left:0;margin-left:0}
.comment-wrap{border-bottom:1px solid #ccc;padding-bottom:40px;margin-bottom:50px;position:relative}
.comment-wrap .comments-title{padding-top:60px}
.comment-wrap .comment-img{float:left;margin-right:20px;padding-bottom:25px}
.comment-author{text-align:left}
.comment-reply{position:absolute;top:0;right:0;font-style:italic;padding:5px;background:#f5f5f5}
.comment-author,.comment-author a{font-size:14px;text-transform:uppercase;letter-spacing:2px;margin-bottom:2px}
.comment-date{font-size:10px;text-transform:uppercase;letter-spacing:2px;font-style:italic;display:block;padding-bottom:7px}
.depth-2 .comment-wrap{padding-left:30px}
.depth-3 .comment-wrap{padding-left:60px}
.depth-4 .comment-wrap{padding-left:90px}
.depth-5 .comment-wrap{padding-left:120px}
.depth-6 .comment-wrap{padding-left:150px}
.depth-7 .comment-wrap{padding-left:180px}
.depth-8 .comment-wrap{padding-left:210px}
.depth-9 .comment-wrap{padding-left:240px}
.depth-10 .comment-wrap{padding-left:270px}
#commentform #comment,#commentform #author,#commentform #email,#commentform #url{display:block;width:100%}
#commentform input[type="submit"]{display:inline-block;border:1px solid #e4e4e4;font-size:12px;text-transform:uppercase;letter-spacing:3px;}
#commentform input[type="submit"]:hover{background:#e2fcff}
}
@media (max-width: 767px) {
.comment-list,.children{padding-left:0}
.comment-wrap .comment-img{float:none;margin:0;width:100%;padding-bottom:0}
.comment-img>img{display:block;margin:0 auto}
.comment-author,.comment-author a,.comment-date{text-align:center}
.depth-2 .comment-wrap,.depth-3 .comment-wrap,.depth-4 .comment-wrap,.depth-5 .comment-wrap,.depth-6 .comment-wrap,.depth-7 .comment-wrap,.depth-8 .comment-wrap,.depth-9 .comment-wrap,.depth-10 .comment-wrap{padding-left:0}
.comment-reply{position:relative;text-align:center;display:block;margin-top:25px}
}
</style>