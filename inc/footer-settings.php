<?php
/**
 * Footer Settings Management
 * Handles all footer content that can be edited from WordPress admin
 */

// Add footer settings to WordPress admin
function victoria_style_footer_settings() {
    add_options_page(
        'Footer Settings',
        'Footer Settings',
        'manage_options',
        'footer-settings',
        'victoria_style_footer_settings_page'
    );
}
add_action('admin_menu', 'victoria_style_footer_settings');

// Register footer settings
function victoria_style_footer_settings_init() {
    register_setting('footer_settings', 'footer_content_settings');
    
    add_settings_section(
        'footer_section',
        'Footer Content Management',
        'victoria_style_footer_section_callback',
        'footer_settings'
    );
    
    add_settings_field(
        'footer_content',
        'Footer Content Fields',
        'victoria_style_footer_content_callback',
        'footer_settings',
        'footer_section'
    );
}
add_action('admin_init', 'victoria_style_footer_settings_init');

// Section callback
function victoria_style_footer_section_callback() {
    echo '<p>Manage your footer content here. Remember to use the multilingual format: &lt;ru_&gt;Russian text&lt;ru_&gt;&lt;ka_&gt;Georgian text&lt;ka_&gt;&lt;eng_&gt;English text&lt;eng_&gt;</p>';
}

// Footer content callback
function victoria_style_footer_content_callback() {
    $footer_content = get_option('footer_content_settings', victoria_style_get_default_footer_content());
    
    ?>
    <div id="footer-content-container">
        <!-- Column 1: Company Info -->
        <div class="footer-column" style="border: 1px solid #ddd; padding: 20px; margin: 20px 0; background: #f9f9f9;">
            <h3>Column 1: Company Information</h3>
            
            <p><label><strong>Company Name:</strong><br>
            <?php victoria_style_multilang_input_field('footer_content_settings[company_name]', 
                $footer_content['company_name'], 
                '<ru_>Швейные машины. Brother- Центр<ru_><ka_>საკერავი მანქანები. Brother- ცენტრი<ka_><eng_>Sewing Machines. Brother- Center<eng_>'); ?>
            </label></p>
            
            <p><label><strong>Working Hours Label:</strong><br>
            <?php victoria_style_multilang_input_field('footer_content_settings[working_hours_label]', 
                $footer_content['working_hours_label'], 
                '<ru_>Режим работы:<ru_><ka_>სამუშაო რეჟიმი:<ka_><eng_>Working Hours:<eng_>'); ?>
            </label></p>
            
            <p><label><strong>Working Hours:</strong><br>
            <?php victoria_style_multilang_input_field('footer_content_settings[working_hours]', 
                $footer_content['working_hours'], 
                '<ru_>Понедельник - Суббота с 10:00-19:00<ru_><ka_>ორშაბათი - შაბათი 10:00-19:00<ka_><eng_>Monday - Saturday 10:00-19:00<eng_>'); ?>
            </label></p>
            
            <p><label><strong>Address Label:</strong><br>
            <?php victoria_style_multilang_input_field('footer_content_settings[address_label]', 
                $footer_content['address_label'], 
                '<ru_>Адрес:<ru_><ka_>მისამართი:<ka_><eng_>Address:<eng_>'); ?>
            </label></p>
            
            <p><label><strong>Address:</strong><br>
            <?php victoria_style_multilang_input_field('footer_content_settings[address]', 
                $footer_content['address'], 
                '<ru_>Грузия. Тбилиси 0171. Пр. Пекина №2<ru_><ka_>საქართველო. თბილისი 0171. პეკინის გამზირი №2<ka_><eng_>Georgia. Tbilisi 0171. Beijing Avenue #2<eng_>'); ?>
            </label></p>
        </div>
        
        <!-- Column 2: Contact Information -->
        <div class="footer-column" style="border: 1px solid #ddd; padding: 20px; margin: 20px 0; background: #f9f9f9;">
            <h3>Column 2: Contact Information</h3>
            
            <p><label><strong>Contact Info Title:</strong><br>
            <?php victoria_style_multilang_input_field('footer_content_settings[contact_info_title]', 
                $footer_content['contact_info_title'], 
                '<ru_>Контактная информация<ru_><ka_>საკონტაქტო ინფორმაცია<ka_><eng_>Contact Information<eng_>'); ?>
            </label></p>
            
            <p><label><strong>Contact Person Label:</strong><br>
            <?php victoria_style_multilang_input_field('footer_content_settings[contact_person_label]', 
                $footer_content['contact_person_label'], 
                '<ru_>Контактное лицо:<ru_><ka_>საკონტაქტო პირი:<ka_><eng_>Contact Person:<eng_>'); ?>
            </label></p>
            
            <p><label><strong>Contact Person Name:</strong><br>
            <input type="text" name="footer_content_settings[contact_person_name]" 
                value="<?php echo esc_attr($footer_content['contact_person_name']); ?>" 
                style="width: 100%;" 
                placeholder="Мартин Чарухчян / Martin Charukhchyan" />
            </label></p>
            
            <p><label><strong>Phone/Fax Label:</strong><br>
            <?php victoria_style_multilang_input_field('footer_content_settings[phone_fax_label]', 
                $footer_content['phone_fax_label'], 
                '<ru_>Телефон/Факс:<ru_><ka_>ტელ/ფაქსი:<ka_><eng_>Tel/Fax:<eng_>'); ?>
            </label></p>
            
            <p><label><strong>Phone/Fax Number:</strong><br>
            <input type="tel" name="footer_content_settings[phone_fax]" 
                value="<?php echo esc_attr($footer_content['phone_fax']); ?>" 
                style="width: 100%;" 
                placeholder="+995 322 365322" />
            </label></p>
            
            <p><label><strong>Phone Label:</strong><br>
            <?php victoria_style_multilang_input_field('footer_content_settings[phone_label]', 
                $footer_content['phone_label'], 
                '<ru_>Телефон:<ru_><ka_>ტელეფონი:<ka_><eng_>Telephone:<eng_>'); ?>
            </label></p>
            
            <p><label><strong>Phone Number:</strong><br>
            <input type="tel" name="footer_content_settings[phone]" 
                value="<?php echo esc_attr($footer_content['phone']); ?>" 
                style="width: 100%;" 
                placeholder="+995 322 183225" />
            </label></p>
            
            <p><label><strong>Mobile Label:</strong><br>
            <?php victoria_style_multilang_input_field('footer_content_settings[mobile_label]', 
                $footer_content['mobile_label'], 
                '<ru_>Мобильный:<ru_><ka_>მობილური:<ka_><eng_>Mobile:<eng_>'); ?>
            </label></p>
            
            <p><label><strong>Mobile Number:</strong><br>
            <input type="tel" name="footer_content_settings[mobile]" 
                value="<?php echo esc_attr($footer_content['mobile']); ?>" 
                style="width: 100%;" 
                placeholder="+995 77 75 39 29" />
            </label></p>
            
            <p><label><strong>Email Address:</strong><br>
            <input type="email" name="footer_content_settings[email]" 
                value="<?php echo esc_attr($footer_content['email']); ?>" 
                style="width: 100%;" 
                placeholder="victorias_style@yahoo.co.uk" />
            </label></p>
        </div>
        
        <!-- Column 3: About Company -->
        <div class="footer-column" style="border: 1px solid #ddd; padding: 20px; margin: 20px 0; background: #f9f9f9;">
            <h3>Column 3: About Company</h3>
            
            <p><label><strong>About Company Title:</strong><br>
            <?php victoria_style_multilang_input_field('footer_content_settings[about_company_title]', 
                $footer_content['about_company_title'], 
                '<ru_>О компании<ru_><ka_>კომპანიის შესახებ<ka_><eng_>About Company<eng_>'); ?>
            </label></p>
            
            <p><label><strong>Company Description Line 1:</strong><br>
            <?php victoria_style_multilang_input_field('footer_content_settings[company_description_1]', 
                $footer_content['company_description_1'], 
                '<ru_>Наша компания "Victoria\'s Style" Victoria\'s Style LTD образована в 2007 году.<ru_><ka_>ჩვენი კომპანია "Victoria\'s Style" Victoria\'s Style LTD დაარსდა 2007 წელს.<ka_><eng_>Our company "Victoria\'s Style" Victoria\'s Style LTD was founded in 2007.<eng_>', 
                'textarea'); ?>
            </label></p>
            
            <p><label><strong>Company Description Line 2:</strong><br>
            <?php victoria_style_multilang_input_field('footer_content_settings[company_description_2]', 
                $footer_content['company_description_2'], 
                '<ru_>Выполняет весь комплекс работ по поставке оборудования для швейного производства.<ru_><ka_>ასრულებს სამუშაოების მთელ კომპლექსს საკერავი წარმოებისთვის აღჭურვილობის მიწოდებაზე.<ka_><eng_>Performs a full range of work on the supply of equipment for sewing production.<eng_>', 
                'textarea'); ?>
            </label></p>
            
            <p><label><strong>Company Description Line 3:</strong><br>
            <?php victoria_style_multilang_input_field('footer_content_settings[company_description_3]', 
                $footer_content['company_description_3'], 
                '<ru_>Мы можем подготовить проект организации и реконструкции современного швейного производства, выполняет весь комплекс работ по поставке различных типов оборудования для швейного производства, а также по проектированию швейных предприятий.<ru_><ka_>ჩვენ შეგვიძლია მოვამზადოთ თანამედროვე საკერავი წარმოების ორგანიზაციისა და რეკონსტრუქციის პროექტი, ასრულებს სამუშაოების მთელ კომპლექსს საკერავი წარმოებისთვის სხვადასხვა ტიპის აღჭურვილობის მიწოდებაზე, ასევე საკერავი საწარმოების პროექტირებაზე.<ka_><eng_>We can prepare a project for the organization and reconstruction of modern sewing production, perform a full range of work on the supply of various types of equipment for sewing production, as well as on the design of sewing enterprises.<eng_>', 
                'textarea'); ?>
            </label></p>
        </div>
        
        <!-- Footer Bottom -->
        <div class="footer-column" style="border: 1px solid #ddd; padding: 20px; margin: 20px 0; background: #f9f9f9;">
            <h3>Footer Bottom</h3>
            
            <p><label><strong>Copyright Text:</strong><br>
            <?php victoria_style_multilang_input_field('footer_content_settings[copyright_text]', 
                $footer_content['copyright_text'], 
                '<ru_>Все права защищены.<ru_><ka_>ყველა უფლება დაცულია.<ka_><eng_>All rights reserved.<eng_>'); ?>
            </label></p>
        </div>
    </div>
    <?php
}

// Settings page
function victoria_style_footer_settings_page() {
    ?>
    <div class="wrap">
        <h1>Footer Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('footer_settings');
            do_settings_sections('footer_settings');
            submit_button();
            ?>
        </form>
    </div>
    
    <style>
    .footer-column {
        border-radius: 5px;
    }
    .multilang-input-container {
        margin-bottom: 10px;
    }
    </style>
    <?php
}

// Process and sanitize footer data before saving
function victoria_style_process_footer_settings($input) {
    $processed = array();
    
    if (is_array($input)) {
        // Process multilingual fields
        $multilang_fields = array(
            'company_name', 'working_hours_label', 'working_hours', 'address_label', 'address',
            'contact_info_title', 'contact_person_label', 'phone_fax_label', 'phone_label',
            'mobile_label', 'about_company_title', 'company_description_1', 'company_description_2',
            'company_description_3', 'copyright_text'
        );
        
        foreach ($multilang_fields as $field) {
            if (isset($input[$field])) {
                $processed[$field] = victoria_style_sanitize_multilang_text($input[$field]);
            }
        }
        
        // Process regular fields
        $regular_fields = array(
            'contact_person_name' => 'sanitize_text_field',
            'phone_fax' => 'sanitize_text_field',
            'phone' => 'sanitize_text_field',
            'mobile' => 'sanitize_text_field',
            'email' => 'sanitize_email'
        );
        
        foreach ($regular_fields as $field => $sanitize_function) {
            if (isset($input[$field])) {
                $processed[$field] = call_user_func($sanitize_function, $input[$field]);
            }
        }
    }
    
    return $processed;
}

// Hook to process footer settings before saving
add_filter('pre_update_option_footer_content_settings', 'victoria_style_process_footer_settings');

// Get default footer content
function victoria_style_get_default_footer_content() {
    return array(
        'company_name' => '<ru_>Швейные машины. Brother- Центр<ru_><ka_>საკერავი მანქანები. Brother- ცენტრი<ka_><eng_>Sewing Machines. Brother- Center<eng_>',
        'working_hours_label' => '<ru_>Режим работы:<ru_><ka_>სამუშაო რეჟიმი:<ka_><eng_>Working Hours:<eng_>',
        'working_hours' => '<ru_>Понедельник - Суббота с 10:00-19:00<ru_><ka_>ორშაბათი - შაბათი 10:00-19:00<ka_><eng_>Monday - Saturday 10:00-19:00<eng_>',
        'address_label' => '<ru_>Адрес:<ru_><ka_>მისამართი:<ka_><eng_>Address:<eng_>',
        'address' => '<ru_>Грузия. Тбилиси 0171. Пр. Пекина №2<ru_><ka_>საქართველო. თბილისი 0171. პეკინის გამზირი №2<ka_><eng_>Georgia. Tbilisi 0171. Beijing Avenue #2<eng_>',
        'contact_info_title' => '<ru_>Контактная информация<ru_><ka_>საკონტაქტო ინფორმაცია<ka_><eng_>Contact Information<eng_>',
        'contact_person_label' => '<ru_>Контактное лицо:<ru_><ka_>საკონტაქტო პირი:<ka_><eng_>Contact Person:<eng_>',
        'contact_person_name' => 'Мартин Чарухчян / Martin Charukhchyan',
        'phone_fax_label' => '<ru_>Телефон/Факс:<ru_><ka_>ტელ/ფაქსი:<ka_><eng_>Tel/Fax:<eng_>',
        'phone_fax' => '+995 322 365322',
        'phone_label' => '<ru_>Телефон:<ru_><ka_>ტელეფონი:<ka_><eng_>Telephone:<eng_>',
        'phone' => '+995 322 183225',
        'mobile_label' => '<ru_>Мобильный:<ru_><ka_>მობილური:<ka_><eng_>Mobile:<eng_>',
        'mobile' => '+995 77 75 39 29',
        'email' => 'victorias_style@yahoo.co.uk',
        'about_company_title' => '<ru_>О компании<ru_><ka_>კომპანიის შესახებ<ka_><eng_>About Company<eng_>',
        'company_description_1' => '<ru_>Наша компания "Victoria\'s Style" Victoria\'s Style LTD образована в 2007 году.<ru_><ka_>ჩვენი კომპანია "Victoria\'s Style" Victoria\'s Style LTD დაარსდა 2007 წელს.<ka_><eng_>Our company "Victoria\'s Style" Victoria\'s Style LTD was founded in 2007.<eng_>',
        'company_description_2' => '<ru_>Выполняет весь комплекс работ по поставке оборудования для швейного производства.<ru_><ka_>ასრულებს სამუშაოების მთელ კომპლექსს საკერავი წარმოებისთვის აღჭურვილობის მიწოდებაზე.<ka_><eng_>Performs a full range of work on the supply of equipment for sewing production.<eng_>',
        'company_description_3' => '<ru_>Мы можем подготовить проект организации и реконструкции современного швейного производства, выполняет весь комплекс работ по поставке различных типов оборудования для швейного производства, а также по проектированию швейных предприятий.<ru_><ka_>ჩვენ შეგვიძლია მოვამზადოთ თანამედროვე საკერავი წარმოების ორგანიზაციისა და რეკონსტრუქციის პროექტი, ასრულებს სამუშაოების მთელ კომპლექსს საკერავი წარმოებისთვის სხვადასხვა ტიპის აღჭურვილობის მიწოდებაზე, ასევე საკერავი საწარმოების პროექტირებაზე.<ka_><eng_>We can prepare a project for the organization and reconstruction of modern sewing production, perform a full range of work on the supply of various types of equipment for sewing production, as well as on the design of sewing enterprises.<eng_>',
        'copyright_text' => '<ru_>Все права защищены.<ru_><ka_>ყველა უფლება დაცულია.<ka_><eng_>All rights reserved.<eng_>'
    );
}