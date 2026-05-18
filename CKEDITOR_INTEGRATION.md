# CKEditor Integration Guide

## Overview
This application now includes CKEditor 5 integration for rich text editing in the admin panel. The system provides:
- **Safe HTML editing** with WYSIWYG capabilities (Bold, Italic, Underline, Headings, Lists, Links, Blockquotes, Text Alignment)
- **Strict HTML sanitization** to prevent XSS attacks
- **Word count validation** to enforce content limits
- **Safe HTML rendering** on the frontend

## What's New

### Admin Panel Fields with CKEditor
The following fields now use CKEditor for rich text editing:

1. **Services** - Description (max 500 words)
2. **About** - Content (max 1000 words)
3. **Features** - Description (max 300 words)
4. **Projects** - Description (max 400 words) *(new field)*
5. **FAQs** - Answer (max 300 words)
6. **Testimonials** - Quote (max 200 words)
7. **Banners** - Subtitle (max 100 words)
8. **Company Details** - Address (max 200 words)

### Allowed HTML Tags
The sanitization system only allows these safe tags:
- Text formatting: `<strong>`, `<em>`, `<i>`, `<b>`, `<u>`
- Headings: `<h1>` - `<h6>`
- Lists: `<ul>`, `<ol>`, `<li>`
- Other: `<p>`, `<blockquote>`, `<a>`, `<br>`

### CKEditor Features Available

#### Text Formatting
- **Bold** - Make text bold (Ctrl+B)
- **Italic** - Italicize text (Ctrl+I)
- **Underline** - Underline text (Ctrl+U)

#### Structural
- **Headings** - Use H1-H6 for different heading levels
- **Bullet List** - Create unordered lists
- **Numbered List** - Create ordered lists
- **Block Quote** - Highlight important quotes

#### Links
- **Insert Link** - Add hyperlinks (only HTTP/HTTPS protocols allowed)
- Links open in new tabs with `rel="noopener noreferrer"` for security

#### Text Alignment
- Align text left, center, right, or justify

## Security Features

### HTML Sanitization
The `HtmlHelper` class sanitizes all HTML content:
- Strips all dangerous tags
- Removes onclick, onerror, and other event attributes
- Prevents JavaScript execution (blocks `javascript:`, `data:` URLs)
- Allows only specified safe tags

### Validation Rules
Each field has word-count validation:
- Prevents excessively long content
- Applies appropriate limits based on field type
- Shows clear error messages to users

### Frontend Security
- HTML is escaped by default in Blade templates
- Content from CKEditor uses `{!! !!}` syntax only after backend sanitization
- All external links have `target="_blank"` and `rel="noopener noreferrer"`

## Usage in Admin Panel

### Editing Content
1. Navigate to any admin resource (e.g., Services, FAQ, About)
2. Click "Create" or "Edit"
3. Find the CKEditor field (marked with the editor toolbar)
4. Use the toolbar to format your content
5. The editor shows real-time formatting
6. Click "Save" or "Update"

### Content Limits
Each field displays its validation rules in the admin panel. The system will reject:
- Content exceeding word limits
- Invalid HTML (automatically cleaned)
- Malicious links or scripts

## Technical Implementation

### Files Modified/Created

1. **app/Helpers/HtmlHelper.php** (NEW)
   - Main sanitization and validation class
   - Methods: `sanitize()`, `wordCount()`, `truncate()`, `stripTags()`

2. **resources/views/admin/crud/form.blade.php**
   - Added CKEditor field type support
   - Loads CKEditor library from CDN
   - Initializes editor on page load

3. **app/Http/Controllers/Admin/BaseCrudController.php**
   - Added `sanitizeHtmlFields()` method
   - Sanitizes content before saving

4. **app/Http/Controllers/Admin/*.php**
   - All controllers updated with CKEditor field types
   - Added custom validation rules for word counts

5. **resources/views/home.blade.php**
   - Updated to use `{!! !!}` for HTML rendering
   - Safe display of rich text content

6. **app/Models/Project.php**
   - Added 'description' to $fillable array

7. **database/migrations/2026_05_18_083625_add_description_to_projects_table.php** (NEW)
   - Adds description column to projects table

## Database Migration

To apply the new migration and add the description column to projects:

```bash
php artisan migrate
```

## Frontend Display Styling

Add custom CSS to style the rendered HTML content in `public/css/main.css`:

```css
.service-description,
.feature-description {
    line-height: 1.6;
    color: #333;
}

.service-description p,
.feature-description p {
    margin-bottom: 0.5rem;
}

.service-description h1,
.feature-description h1,
.service-description h2,
.feature-description h2,
.service-description h3,
.feature-description h3 {
    margin-top: 1rem;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.service-description ul,
.feature-description ul,
.service-description ol,
.feature-description ol {
    margin-left: 1.5rem;
    margin-bottom: 0.5rem;
}

.service-description li,
.feature-description li {
    margin-bottom: 0.3rem;
}

.service-description blockquote,
.feature-description blockquote {
    border-left: 4px solid #007bff;
    padding-left: 1rem;
    margin-left: 0;
    color: #666;
    font-style: italic;
}

.service-description a,
.feature-description a {
    color: #007bff;
    text-decoration: none;
}

.service-description a:hover,
.feature-description a:hover {
    text-decoration: underline;
}

.item-desc {
    line-height: 1.6;
}

.footer-contact li {
    line-height: 1.8;
}
```

## Best Practices

### For Content Creators
1. **Keep it concise** - Follow word limits
2. **Use appropriate headings** - H1 for main titles, H2-H3 for subsections
3. **Format lists properly** - Use bullet or numbered lists for readability
4. **Add links wisely** - Link to relevant internal or external resources
5. **Preview before saving** - Check formatting before submission

### For Developers
1. **Always sanitize** - Never bypass the sanitization process
2. **Test content** - Verify HTML renders correctly on frontend
3. **Maintain limits** - Adjust word counts only if necessary
4. **Monitor XSS** - Keep the sanitization helper updated for new threats
5. **Document changes** - Update this guide if adding new fields

## Troubleshooting

### CKEditor Not Loading
- Check browser console for errors
- Verify CDN is accessible
- Clear browser cache and reload

### Content Not Saving
- Check validation rules - content might exceed word limits
- Verify field name matches in controller and form
- Check browser console for JavaScript errors

### HTML Tags Not Rendering
- Ensure backend sanitization isn't stripping needed tags
- Check `HtmlHelper::$allowed_tags` for the tag list
- Verify frontend uses `{!! !!}` syntax

### Links Not Working
- Only HTTP/HTTPS protocols are allowed
- Verify URL format in editor
- Check browser console for security warnings

## Support

For issues or enhancements:
1. Check the validation rules in individual controllers
2. Review `HtmlHelper.php` for sanitization logic
3. Test content sanitization with the helper methods
4. Verify database field types are `longText` or `text`

## References

- [CKEditor 5 Documentation](https://ckeditor.com/docs/ckeditor5/latest/)
- [OWASP HTML Sanitizer](https://owasp.org/www-community/attacks/xss/)
- [Laravel Security Best Practices](https://laravel.com/docs/security)
