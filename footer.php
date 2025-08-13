    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <?php 
        // Get footer content settings
        $footer_content = get_option('footer_content_settings', victoria_style_get_default_footer_content());
        ?>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="footer-content">
                        <h4 class="widget-title">
                            <?php echo victoria_style_filter_multilang_content($footer_content['company_name']); ?>
                        </h4>
                        <div class="contact-info">
                            <p><strong>
                                <?php echo victoria_style_filter_multilang_content($footer_content['working_hours_label']); ?>
                            </strong><br>
                            <?php echo victoria_style_filter_multilang_content($footer_content['working_hours']); ?>
                            </p>
                            
                            <p><strong>
                                <?php echo victoria_style_filter_multilang_content($footer_content['address_label']); ?>
                            </strong><br>
                            <?php echo victoria_style_filter_multilang_content($footer_content['address']); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="footer-content">
                        <h4 class="widget-title">
                            <?php echo victoria_style_filter_multilang_content($footer_content['contact_info_title']); ?>
                        </h4>
                        <div class="contact-info">
                            <p><strong>
                                <?php echo victoria_style_filter_multilang_content($footer_content['contact_person_label']); ?>
                            </strong><br>
                            <?php echo esc_html($footer_content['contact_person_name']); ?>
                            </p>
                            
                            <p><strong>
                                <?php echo victoria_style_filter_multilang_content($footer_content['phone_fax_label']); ?>
                            </strong><br>
                            <a href="tel:<?php echo esc_attr(str_replace(' ', '', $footer_content['phone_fax'])); ?>"><?php echo esc_html($footer_content['phone_fax']); ?></a>
                            </p>
                            
                            <p><strong>
                                <?php echo victoria_style_filter_multilang_content($footer_content['phone_label']); ?>
                            </strong><br>
                            <a href="tel:<?php echo esc_attr(str_replace(' ', '', $footer_content['phone'])); ?>"><?php echo esc_html($footer_content['phone']); ?></a>
                            </p>
                            
                            <p><strong>
                                <?php echo victoria_style_filter_multilang_content($footer_content['mobile_label']); ?>
                            </strong><br>
                            <a href="tel:<?php echo esc_attr(str_replace(' ', '', $footer_content['mobile'])); ?>"><?php echo esc_html($footer_content['mobile']); ?></a>
                            </p>
                            
                            <p><strong>Email:</strong><br>
                            <a href="mailto:<?php echo esc_attr($footer_content['email']); ?>"><?php echo esc_html($footer_content['email']); ?></a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="footer-content">
                        <h4 class="widget-title">
                            <?php echo victoria_style_filter_multilang_content($footer_content['about_company_title']); ?>
                        </h4>
                        <div class="company-info">
                            <p><?php echo victoria_style_filter_multilang_content($footer_content['company_description_1']); ?></p>
                            
                            <p><?php echo victoria_style_filter_multilang_content($footer_content['company_description_2']); ?></p>
                            
                            <p><?php echo victoria_style_filter_multilang_content($footer_content['company_description_3']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <p class="mb-0">&copy; <?php echo date('Y'); ?> Victoria's Style LTD. 
                    <?php echo victoria_style_filter_multilang_content($footer_content['copyright_text']); ?>
                    </p>
                </div>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>