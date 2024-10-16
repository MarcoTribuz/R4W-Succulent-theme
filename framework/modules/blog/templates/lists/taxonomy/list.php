<div class="qodef-blog-list-holder qodef-bl-standard qodef-bl-five-columns qodef-large-space qodef-bl-pag-no-pagination">
    <div class="qodef-bl-wrapper qodef-outer-space">
        <ul class="qodef-blog-list">
            <?php
            if ( $blog_query->have_posts() ):
                while ( $blog_query->have_posts() ) : $blog_query->the_post();
                    succulents_qodef_get_post_taxonomy_format_html( $blog_type );
                endwhile;
            else:
                succulents_qodef_get_module_template_part( 'templates/parts/no-posts', 'blog', '', $params );
            endif;

            wp_reset_postdata();
            ?>
        </ul>
    </div>
    <?php succulents_qodef_get_module_template_part( 'templates/parts/pagination/' . $params['pagination_type'], 'blog', '', $params ); ?>
</div>