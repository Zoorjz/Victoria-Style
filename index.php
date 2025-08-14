<?php get_header(); ?>

<main id="primary" class="site-main">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8">
                <?php
                if (have_posts()) :
                    while (have_posts()) :
                        the_post();
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('mb-5'); ?>>
                            <header class="entry-header">
                                <?php
                                if (is_singular()) :
                                    the_title('<h1 class="entry-title">', '</h1>');
                                else :
                                    the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                                endif;
                                ?>
                                <div class="entry-meta text-muted mb-3">
                                    <?php
                                    echo sprintf(
                                        esc_html__('Posted on %s by %s', 'victoria-style'),
                                        get_the_date(),
                                        get_the_author()
                                    );
                                    ?>
                                </div>
                            </header>

                            <?php if (has_post_thumbnail()) : ?>
                                <div class="entry-thumbnail mb-4">
                                    <?php the_post_thumbnail('large', array('class' => 'img-fluid rounded')); ?>
                                </div>
                            <?php endif; ?>

                            <div class="entry-content">
                                <?php
                                if (is_singular()) :
                                    the_content();
                                else :
                                    the_excerpt();
                                    ?>
                                    <a href="<?php the_permalink(); ?>" class="btn btn-primary mt-3">
                                        <?php esc_html_e('Read More', 'victoria-style'); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </article>
                        <?php
                    endwhile;

                    the_posts_pagination(array(
                        'prev_text' => '<span class="btn btn-outline-primary">' . esc_html__('Previous', 'victoria-style') . '</span>',
                        'next_text' => '<span class="btn btn-outline-primary">' . esc_html__('Next', 'victoria-style') . '</span>',
                        'class' => 'pagination justify-content-center'
                    ));

                else :
                    ?>
                    <p><?php esc_html_e('No posts found.', 'victoria-style'); ?></p>
                    <?php
                endif;
                ?>
            </div>

            <div class="col-lg-4">
                <div class="sidebar">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?> 