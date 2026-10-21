# Dolly Portal

A base WordPress theme for an employee portal site built on the [Dolly Employee Management](https://github.com/blackat5445/Dolly-employee-management) plugin.

The theme provides only the page layout. Everything else comes from the plugin, so it works the same with any theme and nothing is lost if you switch:

- content, styles, colors, fonts, logo and brand name (*Gestione Dipendenti › Aspetto*);
- languages;
- the branded WordPress sign-in and password-reset screens;
- redirects and search-engine rules.

## Features

- **Portal templates:** one template per application view in `dolly/`, all sharing a single layout (`template-parts/app-layout.php`). The plugin renders the content of each view.
- **Same design everywhere:** the theme's own pages (front page, pages) use the plugin's stylesheet and Appearance settings, through `Dolly_Frontend::enqueue_styles()`.
- **Browser bar color:** on phones it follows the header color chosen in *Aspetto*.
- **Private by default:** every page of the site is marked `noindex, nofollow`.
- **Plugin check:** if the plugin is inactive, visitors see a maintenance page and administrators see a notice in wp-admin.
- **Accessible:** skip link, visible focus states and 44px touch targets.

## Requirements

- **WordPress 6.2+** with pretty permalinks enabled.
- **PHP 7.4+.**
- **[Dolly Employee Management](https://github.com/blackat5445/Dolly-employee-management) 1.11+** installed and active.

## Installation

1. Install and activate the **Dolly Employee Management** plugin.
2. Download or clone this repository into `wp-content/themes/dolly-portal`.
3. Activate **Dolly Portal** under *Appearance › Themes*.
4. Set your colors, logo and brand in *Gestione Dipendenti › Aspetto*.

## Templates

The plugin looks for a template named `dolly/{view}.php` in the active theme. This theme provides one for each view:

| Template | URL | Purpose |
|---|---|---|
| `dolly/login.php` | `/accesso/` | Employee sign-in |
| `dolly/login-sede.php` | `/accesso-sede/` | Workplace display sign-in |
| `dolly/recupero-password.php` | `/recupero-password/` | Password recovery |
| `dolly/portale.php` | `/portale/` | Employee portal |
| `dolly/sede.php` | `/sede/` | Workplace QR/PIN display |

Each template only calls the shared layout. The layout uses these plugin functions:

| Function | Purpose |
|---|---|
| `Dolly_Frontend::render_view()` | Content of the current view |
| `Dolly_Frontend::skip_link()` | Translated "skip to content" link |
| `Dolly_Frontend::theme_color()` | Color for `<meta name="theme-color">` |
| `Dolly_Frontend::enqueue_styles()` | Plugin styles on pages that are not plugin views |
| `Dolly_Frontend::render_welcome()` | Card with links to both sign-in pages |
| `Dolly_Frontend::brand()` | Logo or brand name |

The plugin adds the `dolly-body` and `dolly-view-{view}` body classes and the `noindex` rule to its views by itself.

`index.php` is used only when the plugin's front-page redirect is disabled (filter `dolly_redirect_front_page`) or the plugin is inactive. It shows a page's content in the plugin's card, or a welcome card with links to both sign-in pages.

## Customization

- **Colors, logo, fonts, brand name:** *Gestione Dipendenti › Aspetto* in the plugin. `style.css` only uses the plugin's `--dolly-*` CSS variables, with fallback values for when the plugin is inactive.
- **Language:** the plugin translates everything shown with it active. The theme's own texts (maintenance page and admin notice) are in English with an Italian translation in `languages/`.

## License

[MIT](LICENSE) © Kasra Falahati
