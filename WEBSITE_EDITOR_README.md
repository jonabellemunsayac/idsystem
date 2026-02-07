# Website Editor Feature

## Overview
The Website Editor is a built-in content management system (CMS) that allows administrators to edit the public website content without touching code, similar to WordPress.

## Features

### 1. **Live Preview**
- Split-screen editor with live preview
- See changes in real-time as you edit
- Preview functionality on mobile, tablet, and desktop views

### 2. **Multi-Page Editing**
- Edit multiple pages: Home, About, Services, News, Contact
- Switch between pages easily
- Each page has its own content sections

### 3. **WordPress-like Interface**
- Intuitive drag-and-drop editor (expandable in future)
- Visual editing with field hints
- Organized by sections within each page
- WYSIWYG content editor

### 4. **Content Management**
- Edit hero sections, titles, subtitles
- Manage service descriptions
- Update news headlines
- Edit about page content
- Modify contact information

## How to Use

### Accessing the Website Editor

1. Log in to the admin dashboard
2. In the sidebar menu, click **"Website Editor"** (globe icon)
3. You'll see the editor with two panels:
   - **Left Panel**: Content editor with all fields
   - **Right Panel**: Live preview of your website

### Editing Content

1. **Select a Page**: Click on one of the page buttons at the top:
   - Home
   - About
   - Services
   - News
   - Contact

2. **Edit Fields**: Fill in the text fields with your content:
   - **Titles**: Main headings
   - **Subtitles**: Secondary text
   - **Content**: Body text and descriptions

3. **Save Changes**: Click the "Save Changes" button to update the website

### Viewing Live Website

1. Click the **"View Live Website"** button in the top right
2. Opens the public website in a new tab
3. See your changes reflected immediately

## File Locations

- **Controller**: `app/Http/Controllers/WebsiteEditorController.php`
- **Views**: `resources/views/website-editor/`
  - `index.blade.php` - Main editor interface
  - `edit.blade.php` - Individual page editor
- **Routes**: `routes/web.php` (prefixed with `/website-editor`)

## Future Enhancements

### Potential Features to Add:

1. **Rich Text Editor**
   - Add CKEDITOR or TinyMCE for advanced formatting
   - Support for bold, italic, links, lists
   - Image embedding

2. **Database Storage**
   - Create `website_pages` table
   - Store all page content in database
   - Version history/revisions

3. **Media Manager**
   - Upload custom images for each page
   - Image gallery management
   - Drag-and-drop file upload

4. **Template Builder**
   - Drag-and-drop page builder
   - Pre-built sections (hero, features, testimonials, CTA)
   - Custom layouts

5. **SEO Settings**
   - Meta titles and descriptions
   - Meta keywords
   - Open Graph tags

6. **Publishing Schedule**
   - Schedule content to go live at specific times
   - Draft/publish workflow

7. **User Permissions**
   - Different access levels
   - Editor role for content creators
   - Admin role for full control

## Technical Implementation

### Current Setup (Basic)
- Uses `public.home`, `public.about`, etc. Blade views
- Default content hardcoded in controller
- Form submission with PUT request
- Session-based updates

### Recommended Database Implementation

```sql
CREATE TABLE website_pages (
    id BIGINT UNSIGNED PRIMARY KEY,
    page_slug VARCHAR(255) UNIQUE,
    page_title VARCHAR(255),
    content LONGTEXT,
    meta_title VARCHAR(255),
    meta_description TEXT,
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE website_sections (
    id BIGINT UNSIGNED PRIMARY KEY,
    page_id BIGINT UNSIGNED,
    section_name VARCHAR(255),
    section_content LONGTEXT,
    section_order INT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### API Endpoints

- `GET /website-editor` - Main editor interface
- `GET /website-editor/edit/{page}` - Edit specific page
- `PUT /website-editor/update/{page}` - Save page changes
- `GET /website-editor/preview` - Preview website

## Security Notes

- All editor routes are protected with `auth` middleware
- Admin role required (can be extended to specific roles)
- CSRF protection on all forms
- Content validation recommended

## Troubleshooting

### Changes not showing
1. Clear browser cache (Ctrl+F5)
2. Check if form submission was successful (look for success message)
3. Verify the routes are configured correctly

### Preview not loading
1. Check if website has errors
2. Try refreshing the preview with F5
3. Check browser console for errors

## Support

For issues or feature requests, contact the development team.
