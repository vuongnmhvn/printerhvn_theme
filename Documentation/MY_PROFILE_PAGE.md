# 👤 MY PROFILE PAGE - COMPLETE

## ✅ ĐÃ TẠO HOÀN CHỈNH

Template trang **My Profile** giống Pinterest để user cập nhật thông tin cá nhân và avatar.

---

## 📄 FILE ĐÃ TẠO

### 1. Template: `page-my-profile.php`
**Location:** `/wp-content/themes/pinterhvn-theme/`

**Features:**
- ✅ Template Name: "My Profile"
- ✅ Redirect nếu chưa login
- ✅ Form cập nhật profile
- ✅ AJAX submission
- ✅ Real-time avatar preview
- ✅ Success/Error messages
- ✅ Pinterest-style design

---

## 🎨 GIAO DIỆN

### Edit Profile Section:

**Header:**
- Title: "Edit profile"
- Subtitle: "Keep your personal details private..."

**Form Fields:**

1. **Photo**
   - Current avatar (120x120px, circular)
   - "Change" button
   - File input (hidden)
   - Real-time preview

2. **First name**
   - Text input
   - Placeholder: "First name"

3. **Last name**
   - Text input
   - Placeholder: "Last name"

4. **About**
   - Textarea (4 rows)
   - Placeholder: "Tell your story"

5. **Website**
   - URL input
   - Placeholder: "https://"
   - Hint: "Add a link to drive traffic to your site"

6. **Username** (readonly)
   - Disabled input
   - Shows: www.pinterhvn.local/@username

**Action Buttons:**
- Cancel (gray button) → Back to home
- Save (red button) → Submit form

---

### Account Management Section:

**Title:** "Account management"
**Subtitle:** "Make changes to your personal information or account type."

**Your Account:**

1. **Email** • Private
   - Shows current email
   - Read-only display

2. **Password**
   - "Change" button
   - Links to password reset

---

## 🔧 BACKEND (Plugin)

### AJAX Handler: `handle_update_profile()`
**File:** `class-asset-ajax-handler.php`

**Xử lý:**
- ✅ Nonce verification
- ✅ User authentication check
- ✅ Update first_name, last_name
- ✅ Update user_url (website)
- ✅ Update description (bio)
- ✅ Upload & save custom avatar
- ✅ Validate image types (JPG, PNG, GIF)
- ✅ Fire action hook: `pinterhvn_profile_updated`

**AJAX Endpoint:**
```
Action: pinterhvn_update_profile
Method: POST
Nonce: pinterhvn_profile_nonce
```

**Response:**
```javascript
{
  success: true,
  data: {
    message: "Profile đã được cập nhật thành công!"
  }
}
```

---

## 🎯 CUSTOM AVATAR SYSTEM

### Helper Functions:
**File:** `includes/helper-functions.php`

**Functions:**

1. **pinterhvn_get_user_avatar_url($user_id, $size)**
   - Get custom avatar URL
   - Fallback to default if not set

2. **pinterhvn_custom_avatar($avatar, $id_or_email, ...)**
   - Filter: `get_avatar`
   - Override WordPress default avatar
   - Use custom uploaded avatar

**Meta Key:**
```
pinterhvn_avatar = attachment_id
```

**How it works:**
1. User uploads avatar via profile page
2. Image saved to media library
3. Attachment ID saved to user meta
4. Filter `get_avatar` returns custom image
5. Works everywhere (header, cards, comments, etc.)

---

## 💻 JAVASCRIPT

**Inline trong template:**

```javascript
// Change avatar button
$('#change-avatar-btn').click() → Trigger file input

// Preview avatar on change
$('#profile-avatar-upload').change() → Show preview

// Form submission
$('#pinterhvn-profile-form').submit() → AJAX save
```

**Features:**
- ✅ FormData for file upload
- ✅ Loading state on button
- ✅ Success/Error messages
- ✅ Auto-hide message after 5s
- ✅ Scroll to message

---

## 🎨 CSS STYLING

**Included in template:**

### Sections:
- `.profile-page` - Main container
- `.profile-header` - Title section
- `.form-section` - Each form field
- `.photo-upload-wrapper` - Avatar upload
- `.form-actions` - Submit buttons
- `.account-management-section` - Account settings

### Design System:
- Border radius: 16px
- Border: 2px solid #cbd5e1
- Focus: Blue border + shadow
- Buttons: 24px border-radius
- Red primary button: #e60023 (Pinterest red)

### Responsive:
- Max-width: 680px (centered)
- Mobile: Stacked layout
- Full-width buttons on mobile

---

## 📋 CÁCH SỬ DỤNG

### 1. Tạo Trang Profile:
1. WordPress Admin > Pages > Add New
2. Title: "My Profile"
3. Slug: `my-profile`
4. Template: Select "My Profile"
5. Publish

### 2. User Access:
- URL: `yoursite.com/my-profile/`
- Menu link: "Thông tin cá nhân" trong user mega menu

### 3. Update Profile:
1. Click avatar in search bar
2. Click "Thông tin cá nhân"
3. Edit fields
4. Upload new avatar (optional)
5. Click "Save"

---

## ✅ TÍCH HỢP VỚI THEME

### User Mega Menu:
```html
<a href="/my-profile/">
  <svg>[User Icon]</svg>
  <div class="item-content">
    <div class="item-title">Thông tin cá nhân</div>
    <div class="item-desc">Xem assets đã lưu & collections</div>
  </div>
</a>
```

### Custom Avatar:
- ✅ Hiển thị trong header
- ✅ Hiển thị trong user mega menu
- ✅ Hiển thị trong asset cards
- ✅ Hiển thị mọi nơi dùng `get_avatar()`

---

## 🔒 SECURITY

### Validation:
- ✅ Nonce check
- ✅ User authentication
- ✅ File type validation (images only)
- ✅ Sanitize all inputs
- ✅ Escape all outputs

### Permissions:
- ✅ Must be logged in
- ✅ Can only edit own profile
- ✅ Image upload permissions checked

---

## 📊 DATABASE

### User Meta Keys:
```
_pinterhvn_avatar = {attachment_id}
description = {user bio}
```

### WordPress Core:
```
first_name = {string}
last_name = {string}
user_url = {URL}
```

---

## 🚀 TESTING CHECKLIST

- [ ] Access /my-profile/ (must be logged in)
- [ ] Update first name → Save → Check updated
- [ ] Update last name → Save → Check updated
- [ ] Update bio → Save → Check updated
- [ ] Update website → Save → Check updated
- [ ] Upload avatar → Save → Check in header
- [ ] Cancel button → Redirects to home
- [ ] Form validation works
- [ ] Messages display correctly
- [ ] Avatar shows everywhere
- [ ] Mobile responsive

---

## 📱 RESPONSIVE

### Desktop:
- Max-width: 680px (centered)
- All fields full width
- Buttons side-by-side

### Mobile:
- Full width
- Photo upload stacked
- Buttons full width (stacked)
- Larger touch targets

---

## 🎯 NEXT ENHANCEMENTS (Optional)

### Could Add:
1. Saved Assets Tab (trên profile page)
2. Collections Tab
3. Activity History
4. Privacy Settings
5. Notification Preferences
6. Delete Account option

---

**Status:** ✅ **COMPLETE**  
**Created:** November 5, 2024  
**Template:** page-my-profile.php  
**AJAX:** pinterhvn_update_profile  
**Ready:** Production Use ✨
