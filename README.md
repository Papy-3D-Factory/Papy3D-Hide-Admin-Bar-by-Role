# RoleBound Admin Toolbar

A lightweight and modern WordPress plugin that allows administrators to hide the WordPress admin bar on the front end based on user roles.

---

## ✨ Features

* Hide admin bar by role
* Front-end only
* Keeps toolbar inside wp-admin
* Lightweight and dependency-free
* Native WordPress Settings API
* Multisite uninstall support
* Clean and fully independent architecture
* GPLv3 compatible

---

## 🎯 Use Cases

Perfect for:

* Membership websites
* Client portals
* Community websites
* WooCommerce stores
* Custom dashboards
* Cleaner front-end experience

---

## 📦 Installation

1. Download the plugin
2. Upload the folder to:

```txt
/wp-content/plugins/
```

3. Activate the plugin from WordPress admin
4. Go to:

```txt
Settings → Papy3D Admin Bar
```

5. Select the roles for which the admin bar should be hidden

---

## 📁 Plugin Structure

```txt
papy3d-hide-admin-bar-by-role/
├── papy3d-hide-admin-bar-by-role.php
├── uninstall.php
└── readme.txt
```

---

## ⚙️ Requirements

* WordPress 6.4+
* PHP 8.1+

---

## 🖼️ Screenshots

### Settings Page

Select which roles should not see the admin toolbar on the front end.

### Front-End Experience

Cleaner interface for users without unnecessary WordPress UI elements.

---

## 🔧 Technical Details

The plugin uses:

* `show_admin_bar` filter
* WordPress Settings API
* Object-oriented architecture
* Secure sanitization and validation
* Native role detection

---

## 🗑️ Uninstall

When the plugin is deleted from WordPress:

* All plugin options are automatically removed
* Multisite installations are supported

---

## 📜 License

GPLv3 or later

https://www.gnu.org/licenses/gpl-3.0.html

---

## 👨‍💻 Author

Papy3D

Website:
https://papy-3d-factory.xyz
