<?php
/**
 * Template Name: page bài viết
 */

get_header(); ?>

	<div id="content" class="site-content">

		<div id="content-inside" class="container right-sidebar">
			<section id="primary" class="content-area">
				<main id="main" class="site-main" role="main">
                <?php
                $args['status'] = 'publish';
                $args['post_type'] = 'post';
                $query = new WP_Query( $args );
                ?>
                <?php foreach ($query->posts as $list) :
                    ?>
                    <article id="post-<?=$list->ID?>" class="list-article clearfix post-<?=$list->ID ?> post type-post status-publish format-standard  " style="border-top: 1px solid #818181; padding-top: 20px" >

                        <div class="list-article-thumb col-md-6 pull-left" >
                            <a href="<?=$list->guid?>">
                                <?php if (!empty(get_the_post_thumbnail( $list->ID, 'thumbnail' ))): ?>
                                    <?=get_the_post_thumbnail( $list->ID, 'feature' )?>
                                <?php else :?>
                                    <img alt="" src="https://vaycaptoc.com/wp-content/themes/onepress/assets/images/placholder2.png">
                                <?php endif;?>
                            </a>
                        </div>

                        <div class="list-article-content col-md-6 pull-left">
                            <div class="list-article-meta" style="text-transform: uppercase">
                                <?php
                                foreach (get_the_category( $list->ID ) as $listCategory) :
                                    ?>
                                <h4>
                                    <a href="<?=WP_SITEURL.'/category/'.$listCategory->slug?>" rel="category tag"><?=$listCategory->name?></a>
                                </h4>
                                <?php endforeach;?>

                            </div>
                            <header class="entry-header">
                                <p class="lead"><a href="<?=$list->guid?>" rel="bookmark"><?=$list->post_title ?></a></p>		</header><!-- .entry-header -->
                            <div class="entry-excerpt">
                                <p><?php echo sprintf(substr( $list->post_content,0 ,200 ))?>...</p>
                            </div><!-- .entry-content -->
                        </div>

                    </article>
                <?php endforeach; ?>
				</main><!-- #main -->
			</section><!-- #primary -->

			<?php get_sidebar(); ?>

		</div><!--#content-inside -->
	</div><!-- #content -->

<?php get_footer(); ?>
