<?php get_header(); ?>

<main id="primary" class="site-main">
    <div class="container-lg">
        <div class="row position-relative">
            <!-- Sidebar with Categories -->
            <div class="col-auto">
                <div class="category-sidebar">
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action category-item" data-category="sewing-machines">
                            <i class="fas fa-sewing-machine me-2"></i>Sewing Machines
                        </a>
                        <a href="#" class="list-group-item list-group-item-action category-item" data-category="fabrics">
                            <i class="fas fa-tshirt me-2"></i>Fabrics
                        </a>
                        <a href="#" class="list-group-item list-group-item-action category-item" data-category="accessories">
                            <i class="fas fa-tools me-2"></i>Accessories
                        </a>
                        <a href="#" class="list-group-item list-group-item-action category-item" data-category="patterns">
                            <i class="fas fa-cut me-2"></i>Patterns
                        </a>
                        <a href="#" class="list-group-item list-group-item-action category-item" data-category="notions">
                            <i class="fas fa-th me-2"></i>Notions
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content Area with Carousel -->
            <div class="col">
                <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
                        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
                        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <a href="https://example.com/sewing-machines">
                                <img src="<?php echo content_url(); ?>/uploads/2025/06/Brother_F440-.jpg" class="d-block w-100" alt="Sewing Machines">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Sewing Machines</h5>
                                    <p>Discover our range of sewing machines for all skill levels.</p>
                                </div>
                            </a>
                        </div>
                        <div class="carousel-item">
                            <a href="https://example.com/fabrics">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/img2.png" class="d-block w-100" alt="Fabrics">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Fabrics</h5>
                                    <p>Explore a variety of fabrics for your next project.</p>
                                </div>
                            </a>
                        </div>
                        <div class="carousel-item">
                            <a href="https://example.com/accessories">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/slide3.jpg" class="d-block w-100" alt="Accessories">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Accessories</h5>
                                    <p>Find the perfect accessories to complement your sewing.</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>

            <!-- Mega Panel (Hidden by default) -->
            <div class="mega-panel">
                <div class="container-lg">
                    <div class="mega-panel-content">
                        <!-- Sewing Machines Panel -->
                        <div class="mega-panel-section" data-category="sewing-machines">
                            <div class="row">
                                <div class="col-md-4">
                                    <h4>Domestic Machines</h4>
                                    <ul class="list-unstyled">
                                        <li><a href="#">Basic Sewing Machines</a></li>
                                        <li><a href="#">Computerized Machines</a></li>
                                        <li><a href="#">Embroidery Machines</a></li>
                                        <li><a href="#">Quilting Machines</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <h4>Industrial Machines</h4>
                                    <ul class="list-unstyled">
                                        <li><a href="#">Heavy Duty Machines</a></li>
                                        <li><a href="#">Overlock Machines</a></li>
                                        <li><a href="#">Cover Stitch Machines</a></li>
                                        <li><a href="#">Specialty Machines</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <h4>Accessories</h4>
                                    <ul class="list-unstyled">
                                        <li><a href="#">Presser Feet</a></li>
                                        <li><a href="#">Needles</a></li>
                                        <li><a href="#">Maintenance Kits</a></li>
                                        <li><a href="#">Machine Parts</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Fabrics Panel -->
                        <div class="mega-panel-section" data-category="fabrics">
                            <div class="row">
                                <div class="col-md-4">
                                    <h4>Natural Fabrics</h4>
                                    <ul class="list-unstyled">
                                        <li><a href="#">Cotton</a></li>
                                        <li><a href="#">Linen</a></li>
                                        <li><a href="#">Wool</a></li>
                                        <li><a href="#">Silk</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-4">
                                    <h4>Synthetic Fabrics</h4>
                                    <ul class="list-unstyled">
                                        <li><a href="#">Polyester</a></li>
                                        <li><a href="#">Nylon</a></li>
                                        <li><a href="#">Rayon</a></li>
                                        <li><a href="#">Spandex</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
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