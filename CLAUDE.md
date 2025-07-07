# Victoria Style Theme - Claude Documentation

This file contains technical information about the Victoria Style WordPress theme for Claude AI assistant.

## Project Overview

**Victoria Style** is a WordPress theme for a sewing and textile business website. It features multilingual support (Russian, Georgian, English) with a golden color scheme and Bootstrap 5 framework.

## Key Technical Components

### 1. Multilingual System
- **Location:** Implemented throughout all template files and admin panels
- **Format:** `<ru_>Russian<ru_><ka_>Georgian<ka_><eng_>English<eng_>`
- **Functions:** 
  - `victoria_style_parse_multilang_text()` in functions.php:808
  - `victoria_style_display_multilang()` in functions.php:848
  - JavaScript parsing in js/custom.js:31-60
- **Language switching:** Cookie-based storage with real-time content updates via JavaScript

### 2. Admin Management Panels

#### Carousel Management (functions.php:83-270)
- Admin page: Settings → Carousel Settings
- Manages up to 5 homepage carousel slides
- Fields: title, description, link, image (all multilingual)
- Media uploader integration

#### Category Management (functions.php:272-546)
- Admin page: Settings → Category Management  
- Manages homepage categories with icons and mega panel content
- Supports subcategories with items and URLs
- Multilingual content for all fields

#### Navigation Management (functions.php:612-805)
- Admin page: Settings → Navigation Management
- Manages secondary navigation menu items
- Fields: title, URL, target (multilingual titles)

### 3. Frontend Features

#### Homepage Layout (front-page.php)
- Category sidebar (col-auto) with hover mega panels
- Main carousel area with dynamic slides
- Mega panel system for category subcategories
- Ultimate Product Catalog plugin integration area

#### Language Switcher (header.php:51-118)
- Three-button switcher: RUS/GEO/ENG
- JavaScript event handling for real-time switching
- Cookie persistence across page loads

#### Mega Panel System (front-page.php:104-205, js/custom.js:166-210)
- Shows on category hover with timeout delays
- Dynamic content based on category data
- Responsive behavior for mobile devices

### 4. Styling System

#### CSS Variables (style.css:13-20)
```css
--primary-color: #ffffff
--secondary-color: #f8f9fa  
--accent-color: #C79A1B (Golden)
--text-color: #333333
--link-color: #C79A1B
--link-hover-color: #b38f2e
```

#### Key Layout Classes
- `.category-sidebar` - Left navigation panel (240px width)
- `.mega-panel` - Dropdown content area
- `.carousel-caption` - Slide text with shadows
- `.language-switcher` - Header language buttons

### 5. JavaScript Functionality (js/custom.js)

#### Core Functions
- `parseMultilangText(text, lang)` - Extracts language-specific text
- `updateMultilangContent(selectedLang)` - Updates all page content
- Language switcher event handlers (lines 124-164)
- Mega panel hover behavior (lines 166-210)

### 6. WordPress Integration

#### Theme Support
- Custom logo, post thumbnails, HTML5, responsive embeds
- Navigation menus: primary, footer
- Widget areas: sidebar, footer-1, footer-2, footer-3

#### Custom Functions
- Bootstrap 5 Nav Walker integration
- oEmbed fixes for YouTube (functions.php:870-895)
- Custom image sizes and excerpt customization
- **Multilingual Content System** (functions.php:898-1128)

### 7. Multilingual Content System (NEW)

#### Content Translation Functions (functions.php:898-1128)
- `victoria_style_sanitize_multilang_content()` - Protects multilang tags from WordPress KSES
- `victoria_style_restore_multilang_content()` - Restores tags after KSES processing
- `victoria_style_filter_multilang_content()` - Displays appropriate language on frontend
- `victoria_style_multilang_content_script()` - JavaScript for real-time content switching

#### Content Processing Pipeline
1. **Save Phase:** Content with `<ru_>text<ru_>` format is saved
2. **Pre-KSES:** Tags converted to placeholders (priority 9)
3. **Post-KSES:** Placeholders restored to tags (priority 11)
4. **Display Phase:** Shows only current language content (priority 5)
5. **JavaScript:** Real-time switching without page reload

#### Usage in WordPress Editor
```html
<ru_>Это русский текст<ru_><ka_>ეს არის ქართული ტექსტი<ka_><eng_>This is English text<eng_>
```

#### Frontend Display
- Shows only current language content
- Empty content for other languages is hidden
- Works with posts, pages, widgets, and excerpts
- Real-time switching via JavaScript

## Database Storage

### Theme Options
- `carousel_slides` - Array of carousel slide data
- `homepage_categories` - Category structure with subcategories  
- `custom_secondary_navigation_items` - Navigation menu items
- `site_language` - Cookie for user language preference

## Security Features
- Proper input sanitization with `victoria_style_sanitize_multilang_text()`
- Escaped output throughout templates
- Nonce verification in admin forms
- WordPress coding standards compliance

## Plugin Compatibility
- Ultimate Product Catalog - Special CSS handling in style.css:367-401
- WordPress native widgets and customizer
- Standard WordPress hooks and filters

## Development Notes

### When Modifying This Theme:
1. **Multilingual content:** Always use the multilingual format for user-facing text
2. **Admin panels:** Follow the established pattern for option processing and sanitization
3. **JavaScript:** Ensure language switching functionality remains intact
4. **CSS:** Maintain the golden accent color scheme throughout
5. **Responsive:** Test mega panel behavior on mobile devices

### Common Tasks:
- **Adding new categories:** Use Category Management admin panel
- **Modifying carousel:** Use Carousel Settings admin panel  
- **Changing navigation:** Use Navigation Management admin panel
- **Adding translations:** Update multilingual strings in admin panels
- **Styling changes:** Modify CSS variables in style.css

### File Modification Priority:
1. **functions.php** - Core functionality and admin panels
2. **style.css** - Design and layout
3. **js/custom.js** - Interactive functionality
4. **Template files** - Structure and content display

## Testing Checklist
- [ ] Language switching works on all content
- [ ] Mega panels display correctly on hover
- [ ] Carousel slides show proper content
- [ ] Mobile responsiveness maintained
- [ ] Admin panels save/load correctly
- [ ] WordPress standards compliance

## Known Limitations
- Maximum 5 carousel slides
- Language format requires specific syntax
- Mega panels only show for categories with subcategories
- Requires JavaScript for optimal functionality