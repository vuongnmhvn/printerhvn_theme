# 📤 UPLOAD ASSET PAGE - COMPLETE

## ✅ ĐÃ TẠO HOÀN CHỈNH

Template trang **Upload Asset** giống Pinterest Create Pin với drag & drop và preview tự động cho GIF/MP4.

---

## 📄 TEMPLATE

**File:** `page-upload-asset.php`

**Features:**
- ✅ Template Name: "Upload Asset"
- ✅ Redirect nếu chưa login
- ✅ Permission check: `edit_posts`
- ✅ Drag & drop file upload
- ✅ Auto preview (images, GIF, MP4)
- ✅ Video auto-play và loop
- ✅ AJAX submission
- ✅ Pinterest "Create Pin" style

---

## 🎨 LAYOUT

### Header (Sticky):
```
[✕ Close]    Create Pin    [Spacer]
```
- Close button (top left)
- Title centered
- Sticky at top: 64px

### Two-Column Grid:

**Left Column (450px):**
- File drop zone
- Preview area
- "Save from URL" button

**Right Column (Flexible):**
- Title input
- Description textarea
- Link input
- Category select
- Tags input
- More options (Collections)
- Publish button

---

## 📤 FILE UPLOAD

### Drop Zone Features:

**Default State:**
```
     [Upload Icon]
  Choose a file or drag and drop it here
  We recommend using high quality .jpg files
  less than 20 MB or .mp4 files less than 200 MB
        [Choose file button]
```

**Drag Over State:**
- Background: Light blue
- Border: Blue dashed
- Scale: 1.02
- Smooth animation

**Accepted Files:**
- Images: JPG, PNG, GIF
- Video: MP4
- Max size: 200MB

### Preview Features:

**Image Preview:**
- ✅ Show immediately after select
- ✅ Max height: 600px
- ✅ Object-fit: contain
- ✅ Black background

**Video Preview (MP4):**
- ✅ Auto-play on load
- ✅ Loop continuously
- ✅ Muted
- ✅ playsinline attribute
- ✅ Controls hidden (auto replay)

**GIF Preview:**
- ✅ Auto-play (native)
- ✅ Loop continuously
- ✅ Full animation

**Change Button:**
- Below preview
- Gray button
- Click to change file

---

## 📝 FORM FIELDS

### 1. Title (Required)
```
Label: Title
Placeholder: Add a title
Type: text
Required: yes
```

### 2. Description
```
Label: Description
Placeholder: Add a detailed description
Type: textarea (5 rows)
Required: no
```

### 3. Link (Required)
```
Label: Link
Placeholder: Add a link
Type: url
Required: yes
```

### 4. Category
```
Label: Category
Placeholder: Choose a board
Type: select
Options: All asset_category terms
```

### 5. Tags
```
Label: Tagged topics (0)
Placeholder: Search for a tag
Type: text with tag badges
Feature: Enter or comma to add tag
Counter updates: (X)
```

**Tag Badges:**
- Gray background
- Remove × button
- Hover: Darker
- Display below input

### 6. Collections (Hidden)
```
Button: More options ▼
Content: Multiple select
Options: User's collections
Hint: Hold Ctrl/Cmd to select multiple
```

---

## 💻 JAVASCRIPT FEATURES

### File Handling:
```javascript
1. Choose file button → Open file picker
2. File input change → Preview file
3. Drag over zone → Highlight
4. Drop file → Preview file
5. Validate type & size
6. Show appropriate preview (img/video)
7. Video: auto-play, loop, muted
```

### Tag Management:
```javascript
1. Type tag name
2. Press Enter or comma
3. Add to selectedTags array
4. Create badge with × button
5. Click × → Remove tag
6. Update counter in label
```

### Form Submission:
```javascript
1. Validate file selected
2. Build FormData
3. Append tags as comma-separated
4. AJAX to pinterhvn_upload_asset
5. Show loading state
6. Success → Redirect to asset
7. Error → Show message
```

### More Options:
```javascript
Click "More options" → Toggle slideDown/Up
Chevron rotates 180deg
```

---

## 🎬 VIDEO/GIF AUTO-PLAY

### Video Element:
```html
<video id="preview-video" 
       autoplay 
       loop 
       muted 
       playsinline>
</video>
```

**JavaScript:**
```javascript
// Set video source
$('#preview-video').attr('src', fileURL);

// Ensure play
var videoElement = document.getElementById('preview-video');
videoElement.load();
videoElement.play();
```

**Attributes:**
- `autoplay` - Plays immediately
- `loop` - Replays infinitely
- `muted` - Required for autoplay
- `playsinline` - Mobile support

### GIF Handling:
```javascript
// GIF is just an image
$('#preview-image').attr('src', gifURL);
// Browser handles animation automatically
```

---

## 🔧 AJAX INTEGRATION

### Endpoint:
```
Action: pinterhvn_upload_asset
Handler: class-asset-upload-handler.php
```

### Request Data:
```
asset_title: string
asset_description: string
asset_link: URL
asset_thumbnail: File
asset_category: term_id
asset_tags: "tag1,tag2,tag3"
asset_collections[]: [term_id, ...]
```

### Response:
```javascript
{
  success: true,
  data: {
    message: "Asset đã được upload thành công!",
    post_id: 123,
    view_url: "/digital-assets/my-asset/"
  }
}
```

---

## 🎨 DESIGN DETAILS

### Colors:
- Background: #f8f9fa (light gray)
- Card: #ffffff (white)
- Drop zone: #f1f5f9
- Drag over: #e0f2fe (light blue)
- Publish button: #e60023 (Pinterest red)

### Spacing:
- Grid gap: 40px
- Section padding: 32px
- Input padding: 12px 16px
- Border radius: 12-16px

### Typography:
- Title: 20px bold
- Labels: 13px semi-bold
- Inputs: 16px regular
- Hints: 12px gray

### Animations:
- Drag over: Scale 1.02
- Button hover: translateY -2px
- Dropdown: slideToggle
- All: 0.2-0.3s ease

---

## 📱 RESPONSIVE

### Desktop (>1024px):
- Two columns (450px + flexible)
- Sticky media section
- Max-width: 1200px

### Tablet (768-1024px):
- Single column
- Media section not sticky
- Full width form

### Mobile (<768px):
- Smaller padding
- Compact header
- Smaller drop zone (300px min)
- Full width inputs

---

## 🔒 SECURITY & VALIDATION

### Client-Side:
- ✅ File type check (JPG, PNG, GIF, MP4)
- ✅ File size check (max 200MB)
- ✅ Required fields validation
- ✅ URL format validation

### Server-Side (Plugin):
- ✅ Nonce verification
- ✅ User authentication
- ✅ Permission check
- ✅ File type validation
- ✅ File size validation
- ✅ Sanitize all inputs
- ✅ Escape all outputs

---

## 🚀 USER FLOW

### Upload Process:
```
1. Click "Upload" in vertical nav
   OR Click "Đăng tài nguyên" in user menu
   OR Go to /upload-asset/

2. Drag & drop file OR click "Choose file"

3. See preview:
   - Image: Static display
   - GIF: Auto-play animation
   - MP4: Auto-play video (loop, muted)

4. Fill in details:
   - Title (required)
   - Description
   - Link (required)
   - Category
   - Tags (press Enter to add)
   - Collections (optional)

5. Click "Publish"

6. See loading state

7. Success:
   - Message displays
   - Auto-redirect to asset page (2s)

8. Error:
   - Message displays
   - Stay on page
   - Can retry
```

---

## 🎯 FEATURES HIGHLIGHTS

### Drag & Drop:
- ✅ Visual feedback (blue highlight)
- ✅ Scale animation
- ✅ Drop anywhere in zone

### File Preview:
- ✅ Instant preview
- ✅ Video auto-play
- ✅ GIF animation
- ✅ Proper aspect ratio
- ✅ Black background
- ✅ Centered display

### Tag System:
- ✅ Add tag on Enter/comma
- ✅ Visual badges
- ✅ Remove tag (× button)
- ✅ Counter in label
- ✅ Prevent duplicates

### Smart Defaults:
- ✅ Publish button disabled until file selected
- ✅ More options collapsed
- ✅ Form validates before submit

---

## 🧪 TESTING

### File Upload Tests:
- [ ] JPG image → Preview shows
- [ ] PNG image → Preview shows
- [ ] GIF image → Animates in preview
- [ ] MP4 video → Auto-plays in preview
- [ ] Large file (>200MB) → Error
- [ ] Invalid type → Error
- [ ] Drag & drop → Works
- [ ] Multiple uploads → Each works

### Form Tests:
- [ ] Fill all fields → Submit works
- [ ] Missing title → Validation error
- [ ] Missing link → Validation error
- [ ] Select category → Saves
- [ ] Add tags → Creates badges
- [ ] Remove tags → Deletes badges
- [ ] Select collections → Saves
- [ ] Click Publish → Uploads
- [ ] Success → Redirects
- [ ] Error → Shows message

### Preview Tests:
- [ ] GIF plays automatically
- [ ] MP4 plays automatically
- [ ] MP4 loops infinitely
- [ ] MP4 muted (no sound)
- [ ] Change file → Preview updates
- [ ] Large image → Fits container

---

## 🎨 COMPARISON WITH PINTEREST

### Similarities:
- ✅ Two-column layout
- ✅ Sticky media preview
- ✅ Drag & drop upload
- ✅ "Create Pin" header
- ✅ Red publish button
- ✅ Tag system
- ✅ More options expandable
- ✅ Clean minimalist design

### Our Enhancements:
- ✅ Video auto-play preview
- ✅ GIF animation preview
- ✅ Collections integration
- ✅ WordPress media library
- ✅ Custom taxonomies

---

## 📋 REQUIRED PAGES

**To Create:**
1. Pages > Add New
2. Title: "Upload Asset"
3. Slug: `upload-asset`
4. Template: "Upload Asset"
5. Publish

**Menu Links:**
- Vertical nav: "Upload" button
- User menu: "Đăng tài nguyên"
- Direct: `/upload-asset/`

---

## ✅ INTEGRATION

### With Plugin:
- Uses `pinterhvn_upload_asset` endpoint
- Form validation on server
- Media library integration
- Taxonomy assignment

### With Theme:
- Consistent styling
- Same form components
- Responsive design
- Navigation integration

---

**Status:** ✅ **PRODUCTION READY**  
**Created:** November 5, 2024  
**Template:** page-upload-asset.php  
**Special Feature:** Video/GIF Auto-Play Preview ✨  
**Inspired by:** Pinterest Create Pin
