<?php get_header(); ?>

<main id="primary" class="site-main">
    <div class="container py-5">
        <?php
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header mb-4">
                    <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="entry-thumbnail mb-4">
                        <?php the_post_thumbnail('large', array('class' => 'img-fluid rounded')); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content">
                    <?php
                    // Use custom content function that ensures multilingual filtering
                    victoria_style_the_content_filtered();

                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'victoria-style'),
                        'after'  => '</div>',
                    ));
                    ?>
                </div>
            </article>
            <?php
        endwhile;
        ?>
    </div>
</main>

<?php get_footer(); ?>