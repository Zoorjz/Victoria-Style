# Victoria Style WordPress Theme

A bright and elegant WordPress theme with golden accents and multilingual support, built with Bootstrap 5.

## Theme Information

- **Theme Name:** Victoria Style
- **Author:** Your Name
- **Version:** 1.0
- **Description:** A bright and elegant WordPress theme with golden accents using Bootstrap 5
- **License:** GNU General Public License v2 or later
- **Text Domain:** victoria-style

## Features

### Design & Layout
- Clean, modern design with golden accents (#C79A1B)
- Bootstrap 5 framework integration
- Responsive design for all device sizes
- Poppins font family with Google Fonts integration
- Custom logo support
- Elegant carousel functionality for homepage
- Category sidebar with mega panel navigation

### Multilingual Support
- Built-in multilingual system supporting Russian, Georgian, and English
- Language switcher in header navigation
- Custom multilingual text format: `<ru_>Russian text<ru_><ka_>Georgian text<ka_><eng_>English text<eng_>`
- JavaScript-powered dynamic content translation
- Cookie-based language preference storage
- **NEW: Full Content Translation** - Use multilingual format directly in WordPress editor for posts, pages, and widgets
- Real-time content switching without page reload
- WordPress KSES-safe content processing

### Admin Management Features
- **Carousel Management:** Admin interface to manage homepage carousel slides (up to 5 slides)
- **Category Management:** Custom admin panel for managing homepage categories and subcategories
- **Navigation Management:** Admin interface for managing secondary navigation menu items
- All content supports multilingual format

### Technical Features
- WordPress 5.0+ compatible
- Custom post thumbnails support
- Widget-ready areas (sidebar + 3 footer columns)
- oEmbed support with YouTube embed fixes
- Custom image sizes
- SEO-friendly structure
- Bootstrap 5 Nav Walker integration

## File Structure

```
Victoria_Style/
├── assets/
│   └── images/
│       ├── img1.png
│       └── img2.png
├── inc/
│   ├── class-bootstrap-5-nav-walker.php
│   ├── custom-functions.php
│   └── template-tags.php
├── js/
│   └── custom.js
├── languages/
├── footer.php
├── front-page.php
├── functions.php
├── header.php
├── index.php
├── page.php
├── sidebar.php
└── style.css
```

## Installation

1. Download and extract the theme files
2. Upload the `Victoria_Style` folder to `/wp-content/themes/`
3. Activate the theme in WordPress Admin → Appearance → Themes
4. Configure theme settings in the admin panels

## Configuration

### Carousel Settings
Navigate to **Settings → Carousel Settings** to:
- Add/edit carousel slides (maximum 5 slides)
- Set slide titles, descriptions, links, and images
- Support multilingual content for each slide

### Category Management
Navigate to **Settings → Category Management** to:
- Configure homepage categories with icons and links
- Set up subcategories with items and URLs
- Manage mega panel content

### Navigation Management
Navigate to **Settings → Navigation Management** to:
- Customize secondary navigation menu items
- Set URLs and link targets
- Configure multilingual menu labels

### Content Translation
**NEW FEATURE:** You can now use multilingual content directly in the WordPress editor:

1. **In Posts/Pages:** Use the multilingual format in the content editor:
   ```
   <ru_>Это русский текст о швейных машинах<ru_><ka_>ეს არის ქართული ტექსტი საკერავი მანქანების შესახებ<ka_><eng_>This is English text about sewing machines<eng_>
   ```

2. **Real-time Translation:** Content automatically changes when users switch languages using the header language switcher

3. **Supported Content Areas:**
   - Post content
   - Page content
   - Widget text
   - Post excerpts

4. **Admin Notice:** When editing posts/pages, you'll see a helpful notice about the multilingual format

5. **Content Processing:** The system safely preserves multilingual tags during WordPress content processing

### Multilingual Content Format

Use this format for multilingual text throughout the theme:
```
<ru_>Русский текст<ru_><ka_>ქართული ტექსტი<ka_><eng_>English text<eng_>
```

## Color Scheme

- **Primary Color:** #ffffff (White)
- **Secondary Color:** #f8f9fa (Light Gray)
- **Accent Color:** #C79A1B (Golden)
- **Text Color:** #333333 (Dark Gray)
- **Link Color:** #C79A1B (Golden)
- **Link Hover:** #b38f2e (Darker Golden)

## Widget Areas

- **Sidebar:** Main sidebar for posts/pages
- **Footer 1-3:** Three footer widget columns

## Browser Support

- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 79+
- Internet Explorer 11+

## Dependencies

- WordPress 5.0+
- Bootstrap 5.3.0 (loaded from CDN)
- jQuery (included with WordPress)
- Google Fonts (Poppins, Playfair Display)

## Development

The theme includes:
- Minified and development CSS/JS files
- WordPress coding standards compliance
- Proper sanitization and escaping
- Translation-ready strings
- Custom admin interfaces

## Support

For theme support and customization:
- Check WordPress documentation
- Review theme files for customization examples
- Use WordPress hooks and filters for modifications

## Changelog

### Version 1.0
- Initial release
- Bootstrap 5 integration
- Multilingual support system
- Admin management panels
- Carousel and mega panel functionality

## License

This theme is licensed under the GNU General Public License v2 or later.