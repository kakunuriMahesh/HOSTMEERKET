# HostMeerkat.co.uk - Project Overview

## Tech Stack

| Layer | Technology |
|-------|-----------|
| **Markup** | HTML5 |
| **Styling** | CSS3, Bootstrap 5.2.1, Font Awesome 6.5.1, Bootstrap Icons |
| **Fonts** | Google Fonts (Poppins, Inter) |
| **JavaScript** | Vanilla JS, jQuery 3.6.1 |
| **UI Components** | OwlCarousel 2.3.4, SweetAlert2 |
| **Backend** | PHP (vanilla, no framework) |
| **Server** | Apache (`.htaccess` for redirects) |
| **Email** | PHP `mail()` function |
| **Billing/Portal** | WHMCS (external - `clients.hostmeerkat.co.uk`) |
| **SSL** | Local SSL cert files stored in repository |

## Project Structure

```
hostmeerkat/
├── index.html                 # Homepage
├── about.html                 # About Us
├── web-hosting.html           # Web Hosting plans page
├── wordpress-hosting.html     # WordPress Hosting plans
├── reseller-hosting.html      # Reseller Hosting plans
├── vps-hosting.html           # VPS Hosting plans
├── design-development.html    # Design & Development services
├── why-chose.html             # Why Choose Us
├── contact.php                # Contact form (PHP backend)
├── message.php                # Success page after contact form
├── send-contact.php           # Alternative contact mailer
├── sitemap.html               # HTML sitemap
├── sitemap.xml                # XML sitemap
├── sitemap.txt                # TXT sitemap
├── robots.txt                 # Robots exclusion rules
├── ror.xml                    # ROR (Resource of Resources) sitemap
├── urllist.txt                # URL list
├── privacy-policy.html        # Privacy Policy
├── terms-and-conditions.html  # Terms & Conditions
├── anti-spam-policy.html      # Anti-Spam Policy
├── report-abuse.html          # Report Abuse
├── reseller-agreement.html    # Reseller Agreement
├── cancellation-and-refund.html # Cancellation & Refund Policy
│
├── assets/
│   ├── css/                   # Page-specific stylesheets
│   ├── js/
│   │   ├── main.js            # Legacy JS (scroll, countdown, cookie)
│   │   └── custom.js          # Theme toggle, header logic, coupon copy, countdown
│   ├── images/                # Images, icons, SVGs
│   │   └── products_img/      # Game server images (Minecraft, ARK, etc.)
│   └── img/                   # Duplicate image directory (unused/messy)
│
├── ssl/
│   ├── ssl.db                 # SSL database
│   ├── ssl.db.cache           # SSL DB cache
│   └── keys/                  # SSL private keys (sensitive - should not be in repo)
│
├── whatsapp/
│   └── .htaccess              # 301 redirect to WhatsApp
│
├── *.orig                     # Backup/original copies of edited files
├── error_log                  # PHP error log (should be ignored)
├── whmcslogo.png              # WHMCS billing integration logos
└── PROJECT.md                 # This file
```

## How to Run Locally

The project is a **static HTML site** with a single PHP contact form. No build step, no package manager, **no database**.

### Since PHP is not installed on your machine

You can serve the site with any static file server. HTML pages will work fully. The contact form (`contact.php`) requires PHP to process, but all other pages work fine.

```bash
# Option A: Python (comes with Windows, install from Microsoft Store if missing)
python -m http.server 8000

# Option B: Node.js (install from nodejs.org)
npx serve .

# Option C: VS Code extension "Live Server" (right-click index.html > Open with Live Server)
```

Then open `http://localhost:8000` in your browser.

### Option D: Install PHP (for contact form to work)
Download PHP from https://windows.php.net/download/ and add it to your PATH, then:
```bash
php -S localhost:8000
```

### Hosting Requirements (Production)
- **Web Server**: Apache with `mod_rewrite` (for `.htaccess` redirects)
- **PHP**: 7.4+ (only needed for `contact.php` and `send-contact.php` - the contact form mailer)
- **No database required** - this is a purely static marketing site

---

## Database?

**There is no database.** Zero. This is a completely static brochure/marketing website. All content is in flat HTML files. The only dynamic behavior is:
- The **contact form** (`contact.php`) which sends an email via PHP's `mail()` function - no DB involved
- The **client portal** links point to an external WHMCS installation at `clients.hostmeerkat.co.uk` (that has its own database, but it's a separate system)
- The **coupon countdown timer** is client-side JavaScript

---

## What is the `ssl/` directory for?

The `ssl/` folder contains **Let's Encrypt SSL certificate data** managed by cPanel's SSL manager (or AutoSSL). It stores:

| Item | Purpose |
|------|---------|
| `ssl.db` | SQLite database tracking all certificates issued for the domain(s) |
| `ssl.db.cache` | Cache file for the SSL database |
| `keys/*.key` | RSA private keys (2048-bit) for each certificate |
| `certs/` | Certificate files (`.pem` / `.crt`) |
| `csrs/` | Certificate Signing Requests |

These are **server-side configuration files** generated by the hosting control panel (cPanel/AutoSSL). They should **not** be committed to version control and are only relevant on the production server. They exist here because the entire web root was likely downloaded via FTP/cPanel backup.

**⚠️ Security warning**: The private keys in `ssl/keys/` can decrypt HTTPS traffic. Remove them from this repo immediately.

---

## How were the assets created?

| Asset Type | How they were created |
|------------|-----------------------|
| **CSS files** | Hand-written or custom-designed. Each page has its own CSS file (e.g., `about.css`, `contact.css`) loaded alongside global stylesheets (`main.css`, `style.css`). No CSS preprocessor (Sass/SCSS/Less) was used. |
| **JavaScript** | Hand-written vanilla JS, split into `main.js` (legacy) and `custom.js` (newer). jQuery is loaded from CDN for minor DOM manipulation. |
| **Images** | Designed externally (Photoshop, Illustrator, Canva, etc.) and exported to `assets/images/`. These are standard PNG, SVG, JPG, WebP, and ICO formats. |
| **Icons** | Font Awesome 6.5.1, Bootstrap Icons, and SVG icons loaded from CDN. |
| **HTML pages** | Hand-written HTML files. The navigation bar and footer are duplicated across every page (not using includes/templates). |
| **PHP** | Hand-written. The contact form handler (`contact.php`) is a single-file PHP script that uses PHP's built-in `mail()` function. No framework, no Composer dependencies. |

There was **no build tool** (Webpack, Vite, Gulp, etc.) used. The site is raw HTML/CSS/JS created directly in a code editor.

---

## How to deploy to production (upload to server)

Since there's no build step, deployment is just **file upload**:

```
hostmeerkat/              ← upload entire contents of this folder to server's public_html (or wwwroot)
├── index.html
├── about.html
├── contact.php
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
├── .htaccess             ← already present in whatsapp/ folder
├── ssl/                  ← ⚠️ DO NOT upload this - it's server-managed
├── *.orig                ← ⚠️ Don't upload backup files
└── error_log             ← ⚠️ Don't upload error logs
```

### Steps:
1. **Choose a hosting provider** that supports Apache + PHP (e.g., Hostinger, SiteGround, Namecheap, or any cPanel host)
2. **Point your domain** (`hostmeerkat.co.uk`) to the server's nameservers
3. **Upload files** via FTP or cPanel File Manager to `public_html/`
4. **Set up SSL** via the hosting panel (cPanel AutoSSL or Let's Encrypt) - do NOT upload the local `ssl/` folder
5. **Test the contact form** - ensure PHP mail is configured on the server

**Important**: The contact form uses PHP's `mail()` function. Some hosting providers block this or route it through SMTP. You may need to update `contact.php` to use SMTP credentials or a mail API (e.g., SendGrid, Mailgun) if mail doesn't send.

---

## How to work with this stack

### If you want to make changes:
1. **Edit HTML** directly in the `.html` files (no templates - each page is standalone)
2. **Edit CSS** in `assets/css/` - global styles go in `main.css`, page-specific styles in their own file
3. **Edit JS** in `assets/js/custom.js` (primary) or `main.js` (legacy)
4. **Add a new page**: copy an existing `.html` file, change the content, link it from the navbar in every page

### If you want to modernize (recommended improvements):
| Improvement | How |
|-------------|-----|
| Avoid duplicating nav/footer across 15 files | Use a static site generator (11ty, Hugo) or PHP includes (`<?php include 'nav.php'; ?>`) |
| CSS preprocessing | Switch to Sass/SCSS (Bootstrap is already on v5) |
| JS bundling | Use Vite or Webpack to combine/minify JS |
| Contact form | Replace `mail()` with PHPMailer + SMTP for reliability |
| Package management | Add `package.json` with dev dependencies |
| Version control | Add `.gitignore` to exclude `ssl/`, `*.orig`, `error_log` |

## Observations & Cleanup Suggestions

### Issues found

| Issue | Location | Suggestion |
|-------|----------|------------|
| **SSL keys committed** | `ssl/keys/*.key` | **DO NOT** commit private keys to version control. Add to `.gitignore`. |
| **Backup files in root** | `*.orig` files | Remove or move to a `_backup/` folder |
| **Error log tracked** | `error_log` | Add to `.gitignore` |
| **Duplicate asset dirs** | `assets/img/` vs `assets/images/` | Consolidate into one directory |
| **No build tooling** | No `package.json` | Consider adding if you want to automate tasks |
| **No `.gitignore`** | Root | Add one to exclude `error_log`, `.orig`, `ssl/keys/`, etc. |
| **Mixed PHP/HTML** | `contact.php` is both the PHP handler and the HTML page | Separate into controller + template for cleaner architecture |
| **Inline JS/CSS** | Large JS arrays (country data), inline `<style>` blocks | Move to external files |
| **`main.css.orig`** | In `assets/css/` | Clean up backup files |
| **Cookie consent** | References `wpcc` (WordPress Cookie Consent) but this isn't a WordPress site | Remove or replace |

### Architecture notes
- This is a **traditional flat-file website** - no framework, no SPA, no bundler
- Each page is self-contained with its own CSS file (loaded alongside global `main.css` and `style.css`)
- The JS is split between `main.js` (legacy) and `custom.js` (newer implementation with some overlap)
- The contact form uses PHP's native `mail()` (no PHPMailer or SMTP library)
- External services: WHMCS (client portal), WhatsApp (support chat)
