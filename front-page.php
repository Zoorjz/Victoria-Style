<?php get_header(); ?>

<main id="primary" class="site-main">
    <div class="container-lg">
        <div class="row position-relative">
            <!-- Sidebar with Categories -->
            <div class="col-auto">
                <div class="category-sidebar">
                    <div class="list-group list-group-flush">
                        <?php
                        $homepage_categories = get_option('homepage_categories', array());
                        
                        // Default categories if none exist
                        if (empty($homepage_categories)) {
                            $homepage_categories = array(
                                array('name' => '<ru_>Швейные машины<ru_><ka_>საკერავი მანქანები<ka_><eng_>Sewing Machines<eng_>', 'icon' => 'fas fa-sewing-machine', 'slug' => 'sewing-machines', 'link' => '#?categories=13'),
                                array('name' => '<ru_>Ткани<ru_><ka_>ქსოვილები<ka_><eng_>Fabrics<eng_>', 'icon' => 'fas fa-tshirt', 'slug' => 'fabrics', 'link' => '#'),
                                array('name' => '<ru_>Аксессуары<ru_><ka_>აქსესუარები<ka_><eng_>Accessories<eng_>', 'icon' => 'fas fa-tools', 'slug' => 'accessories', 'link' => '#'),
                                array('name' => '<ru_>Выкройки<ru_><ka_>ნიმუშები<ka_><eng_>Patterns<eng_>', 'icon' => 'fas fa-cut', 'slug' => 'patterns', 'link' => '#')
                            );
                        }
                        
                        foreach ($homepage_categories as $category) :
                        ?>
                        <a href="<?php echo esc_url(!empty($category['link']) ? $category['link'] : '#'); ?>" class="list-group-item list-group-item-action category-item" data-category="<?php echo esc_attr($category['slug']); ?>" data-original-text="<?php echo esc_attr($category['name']); ?>">
                            <i class="<?php echo esc_attr($category['icon']); ?> me-2"></i><?php echo esc_html(victoria_style_display_multilang($category['name'])); ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Main Content Area with Carousel -->
            <div class="col">
<?php
                // Get carousel slides from settings
                $carousel_slides = get_option('carousel_slides', array());
                
                // Filter out empty slides
                $carousel_slides = array_filter($carousel_slides, function($slide) {
                    return !empty($slide['image']) && !empty($slide['title']);
                });
                
                // If no slides, show default content
                if (empty($carousel_slides)) {
                    $carousel_slides = array(
                        array(
                            'title' => '<ru_>Швейные машины<ru_><ka_>საკერავი მანქანები<ka_><eng_>Sewing Machines<eng_>',
                            'description' => '<ru_>Откройте наш ассортимент швейных машин для всех уровней навыков<ru_><ka_>აღმოაჩინეთ ჩვენი საკერავი მანქანების ასორტიმენტი ყველა უნარის დონისთვის<ka_><eng_>Discover our range of sewing machines for all skill levels<eng_>',
                            'link' => '#',
                            'image' => get_template_directory_uri() . '/assets/images/img1.png'
                        ),
                        array(
                            'title' => '<ru_>Ткани<ru_><ka_>ქსოვილები<ka_><eng_>Fabrics<eng_>',
                            'description' => '<ru_>Изучите разнообразие тканей для вашего следующего проекта<ru_><ka_>შეისწავლეთ ქსოვილების მრავალფეროვნება თქვენი შემდეგი პროექტისთვის<ka_><eng_>Explore a variety of fabrics for your next project<eng_>',
                            'link' => '#',
                            'image' => get_template_directory_uri() . '/assets/images/img2.png'
                        )
                    );
                }
                ?>
                <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
                    <?php if (count($carousel_slides) > 1) : ?>
                    <div class="carousel-indicators">
                        <?php foreach ($carousel_slides as $index => $slide) : ?>
                        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="<?php echo $index; ?>" <?php echo $index === 0 ? 'class="active"' : ''; ?>></button>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <div class="carousel-inner">
                        <?php foreach ($carousel_slides as $index => $slide) : ?>
                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                            <?php if (!empty($slide['link'])) : ?>
                            <a href="<?php echo esc_url($slide['link']); ?>">
                            <?php endif; ?>
                                <img src="<?php echo esc_url($slide['image']); ?>" class="d-block w-100" alt="<?php echo esc_attr($slide['title']); ?>">
                                <?php if (!empty($slide['title']) || !empty($slide['description'])) : ?>
                                <div class="carousel-caption d-none d-md-block">
                                    <?php if (!empty($slide['title'])) : ?>
                                    <h5 data-original-text="<?php echo esc_attr($slide['title']); ?>"><?php echo esc_html(victoria_style_display_multilang($slide['title'])); ?></h5>
                                    <?php endif; ?>
                                    <?php if (!empty($slide['description'])) : ?>
                                    <p data-original-text="<?php echo esc_attr($slide['description']); ?>"><?php echo esc_html(victoria_style_display_multilang($slide['description'])); ?></p>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            <?php if (!empty($slide['link'])) : ?>
                            </a>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (count($carousel_slides) > 1) : ?>
                    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Mega Panel (Hidden by default) -->
            <div class="mega-panel">
                <div class="container-lg">
                    <div class="mega-panel-content">
                        <?php
                        // Default mega panel data for fallback
                        $default_mega_panels = array(
                            'sewing-machines' => array(
                                array(
                                    'title' => 'Home Sewing Machines', 
                                    'title_link' => '#',
                                    'items' => array(
                                        array('name' => 'VERITAS', 'url' => '#'),
                                        array('name' => 'Brother', 'url' => '#'),
                                        array('name' => 'Janome', 'url' => '#'),
                                        array('name' => 'JAPSEW', 'url' => '#')
                                    )
                                ),
                                array(
                                    'title' => 'Industrial Machines', 
                                    'title_link' => '#',
                                    'items' => array(
                                        array('name' => 'Heavy Duty Machines', 'url' => '#'),
                                        array('name' => 'Overlock Machines', 'url' => '#'),
                                        array('name' => 'Cover Stitch Machines', 'url' => '#'),
                                        array('name' => 'Specialty Machines', 'url' => '#')
                                    )
                                ),
                                array(
                                    'title' => 'Accessories', 
                                    'title_link' => '#',
                                    'items' => array(
                                        array('name' => 'Presser Feet', 'url' => '#'),
                                        array('name' => 'Needles', 'url' => '#'),
                                        array('name' => 'Maintenance Kits', 'url' => '#'),
                                        array('name' => 'Machine Parts', 'url' => '#')
                                    )
                                )
                            ),
                            'fabrics' => array(
                                array(
                                    'title' => 'Natural Fabrics', 
                                    'title_link' => '#',
                                    'items' => array(
                                        array('name' => 'Cotton', 'url' => '#'),
                                        array('name' => 'Linen', 'url' => '#'),
                                        array('name' => 'Wool', 'url' => '#'),
                                        array('name' => 'Silk', 'url' => '#')
                                    )
                                ),
                                array(
                                    'title' => 'Synthetic Fabrics', 
                                    'title_link' => '#',
                                    'items' => array(
                                        array('name' => 'Polyester', 'url' => '#'),
                                        array('name' => 'Nylon', 'url' => '#'),
                                        array('name' => 'Rayon', 'url' => '#'),
                                        array('name' => 'Spandex', 'url' => '#')
                                    )
                                )
                            )
                        );
                        
                        // Generate mega panel sections dynamically
                        foreach ($homepage_categories as $category) :
                            $category_slug = $category['slug'];
                            $subcategories = !empty($category['subcategories']) ? $category['subcategories'] : 
                                            (isset($default_mega_panels[$category_slug]) ? $default_mega_panels[$category_slug] : array());
                            
                            if (!empty($subcategories)) :
                        ?>
                        <div class="mega-panel-section" data-category="<?php echo esc_attr($category_slug); ?>">
                            <div class="row">
                                <?php foreach ($subcategories as $subcategory) : ?>
                                <div class="col-md-4">
                                    <?php if (!empty($subcategory['title_link']) && $subcategory['title_link'] !== '#') : ?>
                                        <h4><a href="<?php echo esc_url($subcategory['title_link']); ?>" data-original-text="<?php echo esc_attr($subcategory['title']); ?>"><?php echo esc_html(victoria_style_display_multilang($subcategory['title'])); ?></a></h4>
                                    <?php else : ?>
                                        <h4 data-original-text="<?php echo esc_attr($subcategory['title']); ?>"><?php echo esc_html(victoria_style_display_multilang($subcategory['title'])); ?></h4>
                                    <?php endif; ?>
                                    <ul class="list-unstyled">
                                        <?php foreach ($subcategory['items'] as $item) : ?>
                                        <li>
                                            <?php if (is_array($item)) : ?>
                                                <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['name']); ?></a>
                                            <?php else : ?>
                                                <a href="#"><?php echo esc_html($item); ?></a>
                                            <?php endif; ?>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="frontpage-content py-5">
					<?php the_content(); ?>
				</div>
			<?php endwhile; ?>
		<?php endif; ?>
    </div>
</main>

<?php get_footer(); ?> 