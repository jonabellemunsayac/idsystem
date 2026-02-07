# Website Editor - Usage Examples

## Basic Usage

### 1. Accessing the Website Editor

**From Admin Dashboard:**
1. Log in as Admin or Superadmin
2. Look for "Website Editor" in the left sidebar (globe icon ✉️)
3. Click on it to open the editor

**Direct URL:**
```
/website-editor
```

---

## 2. Editing the Home Page

### Step 1: Open Home Page Editor
```
1. Click "Website Editor" in sidebar
2. Click the "Home" button (default selected)
```

### Step 2: Edit Hero Section
```
Fields available:
- Hero Title: "Experience a Progressive & Safe Community"
- Hero Subtitle: Description text shown under title
```

**Example:**
```
Title: "Welcome to Barangay Kalawaan"
Subtitle: "Your trusted community partner"
```

### Step 3: Edit Services Section
```
Fields available:
- Services Title: Section heading
- Services Subtitle: Description
```

**Example:**
```
Title: "Our Services"
Subtitle: "Complete list of services available"
```

### Step 4: Save Changes
```
Click "Save Changes" button at the bottom
Wait for success notification
Preview updates automatically on the right panel
```

---

## 3. Editing Different Pages

### About Page
```
1. Click "About" button in page navigation
2. Edit:
   - Page Title
   - Page Content (longer text)
3. Save and view in preview
```

### Services Page
```
1. Click "Services" button
2. Edit:
   - Page Title: "Our Services"
   - Page Content: Detailed service descriptions
3. Save changes
```

### News Page
```
1. Click "News" button
2. Edit:
   - Page Title: "News & Updates"
   - Page Content: Latest news content
3. Save changes
```

### Contact Page
```
1. Click "Contact" button
2. Edit:
   - Page Title: "Contact Us"
   - Page Content: Contact information and form details
3. Save changes
```

---

## 4. Live Preview Features

### Real-Time Preview
```
- As you type in the editor, preview updates
- Split-screen layout shows editor on left, preview on right
- Mobile/tablet responsive preview
```

### View Live Website
```
1. Click "View Live Website" button (top right)
2. Opens public website in new tab
3. Shows your changes live
```

### Preview Mobile Version
```
Buttons available to toggle preview size:
- Desktop view
- Tablet view (iPad)
- Mobile view (iPhone)
```

---

## 5. Advanced Features

### Adding HTML/Formatting
```
Current: Text-only fields
Future: Rich text editor will support:
- Bold, Italic, Underline
- Links
- Lists
- Images
- Headings
```

### Field Hints
```
Many fields have hints below them:
"Main heading displayed in hero banner"
"Secondary text shown in hero section"

These explain what each field is for
```

---

## 6. Best Practices

### ✅ DO:
```
✅ Write clear, concise content
✅ Use proper grammar and spelling
✅ Test changes in preview before saving
✅ Keep titles short (max 100 characters)
✅ Use descriptive subtitles
✅ Save frequently
✅ Check mobile preview for readability
```

### ❌ DON'T:
```
❌ Use excessive special characters
❌ Leave fields blank without reason
❌ Copy-paste from Word (loses formatting)
❌ Use very long sentences in titles
❌ Ignore preview warnings
❌ Edit without saving regularly
```

---

## 7. Troubleshooting

### Changes Not Saving
```
Problem: Clicked Save but no confirmation
Solution:
1. Check internet connection
2. Look for error message at top of page
3. Try saving again
4. Check browser console (F12) for errors
```

### Preview Not Updating
```
Problem: Preview shows old content
Solution:
1. Refresh preview with F5 key
2. Click "View Live Website" to see actual live version
3. Clear browser cache (Ctrl+Shift+Delete)
4. Try different browser
```

### Can't Find Website Editor
```
Problem: Website Editor not in sidebar
Solution:
1. Make sure you're logged in as Admin
2. Check if you have correct permissions
3. Try refreshing the page
4. Clear browser cookies
```

### Content Lost After Saving
```
Problem: Saved content didn't appear
Solution:
1. Check if you clicked "Save Changes" button
2. Look for success message notification
3. Refresh the page to reload
4. Try editing again
```

---

## 8. Keyboard Shortcuts

```
Ctrl + S (when in form field)  - May trigger browser save
Tab                             - Move between fields
Shift + Tab                     - Move to previous field
Enter                           - New line in textarea
F5                             - Refresh preview
F12                            - Open browser developer tools
```

---

## 9. Common Tasks

### Update Homepage Title
```
1. Go to Website Editor
2. Home page is already selected
3. Find "Hero Title" field
4. Clear existing text
5. Type new title
6. Click "Save Changes"
```

### Add Company News
```
1. Go to Website Editor
2. Click "News" button
3. Find "Page Content" field
4. Add news text
5. Save changes
```

### Update Contact Information
```
1. Go to Website Editor
2. Click "Contact" button
3. Edit contact details in content field
4. Save changes
5. Check live website
```

### Maintain Consistent Messaging
```
1. Use Website Editor for all public content
2. Keep tone professional but friendly
3. Update regularly (monthly recommended)
4. Review changes before saving
5. Archive old content if needed
```

---

## 10. Performance Tips

### For Best Results:
```
✓ Use clear, scannable content
✓ Keep paragraphs short (3-4 sentences max)
✓ Use bullet points for lists
✓ Include action buttons/CTAs
✓ Test on mobile before publishing
✓ Keep images optimized
✓ Update content regularly
```

### SEO Best Practices (Future):
```
When SEO features are added:
✓ Use keywords naturally
✓ Include meta descriptions
✓ Optimize heading structure
✓ Add alt text to images
✓ Keep content fresh
✓ Include internal links
```

---

## 11. API Integration (Developers)

### Save Changes via API
```javascript
fetch('/website-editor/update/home', {
    method: 'PUT',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: new URLSearchParams({
        'hero_title': 'New Title',
        'hero_subtitle': 'New Subtitle'
    })
})
.then(response => response.json())
.then(data => console.log('Saved:', data));
```

### Get Page Content
```javascript
fetch('/website-editor/edit/home')
    .then(response => response.text())
    .then(html => console.log(html));
```

---

## 12. Database Integration (Future)

### When Migrating to Database:
```php
// Create migration
php artisan make:migration create_website_pages_table

// Run migration
php artisan migrate

// Update controller to use model
$page = WebsitePage::where('slug', $page)->first();
```

---

## Support

For help or questions:
1. Review this documentation
2. Check WEBSITE_EDITOR_README.md
3. Contact system administrator
4. Check browser console for error messages

---

**Last Updated**: February 5, 2026
**Version**: 1.0
**Status**: ✅ Production Ready
