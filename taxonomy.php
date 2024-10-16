<?php
$qodef_blog_type = succulents_qodef_get_archive_blog_list_layout();
succulents_qodef_include_blog_helper_functions( 'lists', $qodef_blog_type );
$qodef_holder_params = succulents_qodef_get_holder_params_blog();
get_header();
succulents_qodef_get_title();
$taxonomy = get_queried_object();
do_action('succulents_qodef_before_main_content');
?>
    <div class="<?php echo esc_attr( $qodef_holder_params['holder'] ); ?>">
        <?php do_action( 'succulents_qodef_after_container_open' ); ?>
        <div class="<?php echo esc_attr( $qodef_holder_params['inner'] ); ?>">
            <div class="qodef-section-title-holder  qodef-st-standard qodef-st-title-left qodef-st-normal-space " style="text-align: center">
                <div class="qodef-st-inner">
                    <h2 class="qodef-st-title">
                        <?php echo ucfirst($taxonomy->taxonomy) ?> / <?php echo $taxonomy->name ?>
                    </h2>
                </div>
            </div>
            <h5 style="text-align: center"><?php echo $taxonomy->description ?></h5>
            <div class="vc_empty_space" style="height: 35px"><span class="vc_empty_space_inner"></span></div>
            <?php succulents_qodef_get_taxonomy( $qodef_blog_type ); ?>
        </div>

        <?php do_action( 'succulents_qodef_before_container_close' ); ?>
    </div>

<?php do_action( 'succulents_qodef_blog_list_additional_tags' ); ?>
<?php get_footer(); ?>