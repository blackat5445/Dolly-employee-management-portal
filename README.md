# Dolly Portal

The WordPress theme for the [Dolly Employee Management](https://github.com/blackat5445/Dolly-employee-management) plugin. It provides the layout for the employee portal, the login and password-recovery pages and the workplace QR/PIN display.

The theme only handles layout and presentation. Accounts, attendance, requests and every other feature live in the plugin, so nothing is lost if you switch themes.

> **Language:** the interface is in Italian, matching the plugin.

## Features

- **Portal templates:** one template per application view in `dolly/`, all sharing a single layout (`template-parts/app-layout.php`). The plugin renders the content of each view.
- **Branded password reset:** the WordPress password-reset screen (`wp-login.php?action=rp`), reached from the recovery email, uses the navy/gold palette and the logo set in the plugin settings, or a text wordmark if no logo is set.
- **Back to the portal:** after resetting their password, portal users are sent to `/accesso/` instead of `wp-login.php`.
- **Private by default:** every page is marked `noindex, nofollow`.
- **Plugin check:** if the plugin is inactive, visitors see a maintenance page and administrators see a notice in wp-admin.
- **Accessible:** skip link, visible focus states and 44px touch targets.

## Requirements

- **WordPress 6.2+** with pretty permalinks enabled.
- **PHP 7.4+.**
- **[Dolly Employee Management](https://github.com/blackat5445/Dolly-employee-management)** installed and active.

## Installation

1. Install and activate the **Dolly Employee Management** plugin.
2. Download or clone this repository into `wp-content/themes/dolly-portal`.
3. Activate **Dolly Portal** under *Appearance › Themes*.

## Templates

The plugin looks for a template named `dolly/{view}.php` in the active theme. This theme provides one for each view:

| Template | URL | Purpose |
|---|---|---|
| `dolly/login.php` | `/accesso/` | Employee login |
| `dolly/login-sede.php` | `/accesso-sede/` | Workplace display login |
| `dolly/recupero-password.php` | `/recupero-password/` | Password recovery |
| `dolly/portale.php` | `/portale/` | Employee portal |
| `dolly/sede.php` | `/sede/` | Workplace QR/PIN display |

`index.php` is used only when the plugin's front-page redirect is disabled or the plugin is inactive. It shows a short welcome card with links to both login pages.

## Customization

- **Colors:** the brand colors are the `--dolly-navy` and `--dolly-gold` custom properties in `style.css`. The password-reset screen (`assets/login.css`) uses the same values, written out directly.
- **Logo:** upload it in the plugin under *Gestione Dipendenti › Impostazioni*. The theme uses it on the password-reset screen too.

## License

[MIT](LICENSE) © Kasra Falahati
