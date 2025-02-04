<?php
$show_related = succulents_qodef_options()->getOptionValue('blog_single_related_posts') == 'yes' ? true : false;
$related_post_number = succulents_qodef_sidebar_layout() === 'no-sidebar' ? 4 : 3;
$related_posts_options = array(
    'posts_per_page' => $related_post_number
);
$related_posts = succulents_qodef_get_blog_related_post_type(get_the_ID(), $related_posts_options);
$related_posts_image_size = isset($related_posts_image_size) ? $related_posts_image_size : 'full';
?>
<?php if($show_related) { ?>
    <div class="qodef-related-posts-holder clearfix">
        <div class="qodef-related-posts-holder-inner">
            <?php if ( $related_posts && $related_posts->have_posts() ) : ?>
                <div class="qodef-related-posts-title">
                    <h4><?php esc_html_e('Related posts', 'succulents' ); ?></h4>
                </div>
                <div class="qodef-related-posts-inner clearfix">
                    <?php while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
                        <div class="qodef-related-post">
                            <div class="qodef-related-post-inner">
			                    <?php if (has_post_thumbnail()) { ?>
                                <div class="qodef-related-post-image">
                                    <a itemprop="url" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                         <?php the_post_thumbnail($related_posts_image_size); ?>
                                    </a>
                                </div>
			                    <?php }	?>
                                <h4 itemprop="name" class="entry-title qodef-post-title"><a itemprop="url" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
                                <div class="qodef-post-info">
                                    <?php succulents_qodef_get_module_template_part('templates/parts/post-info/date', 'blog', '', $params); ?>
                                    <?php succulents_qodef_get_module_template_part('templates/parts/post-info/author', 'blog', '', $params); ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif;
            wp_reset_postdata();
            ?>
        </div>
    </div>
<?php } ?>