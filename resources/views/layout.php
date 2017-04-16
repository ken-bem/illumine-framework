<?php
if ( !defined('ABSPATH') ){ die(); }


global $avia_config;
get_header();
if( get_post_meta(get_the_ID(), 'header', true) != 'no') echo avia_title(array(
    'title' 		=> 'custom page',
    //'subtitle' 		=> "subtitle",
    'link'			=> '/asd',
    'breadcrumb'	=> false,
));
do_action( 'ava_after_main_title' );
?>
    <div class="container_wrap container_wrap_first main_color <?php avia_layout_class('main') ?>">

        <div class="container">

            <main class="template-page <?php avia_layout_class('content') ?> units" <?php avia_markup_helper(['context' => 'content','post_type'=>'page']) ?>>

                <article class="post-entry post-entry-type-page <?php avia_markup_helper(array('context' => 'entry')); ?>">

                    <div class="entry-content-wrapper clearfix">

                        <header class="entry-content-header av-special-heading av-special-heading-h1 blockquote modern-quote">
                            <h1 class="av-special-heading-tag">
                                Custom Page
                            </h1>
                            <div class="av-subheading av-subheading_below" style="font-size:15px;">
                                <p>Custom Page SubHeading</p>
                            </div>
                        </header>

                        <p>
                            Execution: <?php
                            $time = microtime(true) - WWP_TIME;
                            echo(number_format($time,2));
                            ?> sec.<br/>
                            WpQueries:
                        </p>
                      </div>

                    </article>

                </main><!--end content-->


            <?php
            $avia_config['currently_viewing'] = 'page';
            get_sidebar();
            ?>
        </div><!--end container-->

    </div><!-- close default .container_wrap element -->
<?php get_footer(); ?>