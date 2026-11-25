# XCIV Social

Private social network for sovereign hospitality and capital operators. A platform of SUPR XCIV PLATFORM HOLDINGS LLC & THE SUPER NINETY FOUR EVENTS COMPANY. WordPress MVC theme + core plugin, WPGraphQL, Vanilla JS.

**Live:** [https://xcivsocial.com](https://xcivsocial.com)

## App layout

| Path | Role |
|------|------|
| `wp-content/themes/xciv-social/` | MVC theme (HTML/CSS/PHP + Vanilla JS) |
| `wp-content/plugins/xciv-social-core/` | Roles, admissions, admin queue, GraphQL stubs |

## Deploy

Pushing to `main` (theme or plugin changes) runs [`.github/workflows/deploy.yml`](.github/workflows/deploy.yml) and SFTP-deploys to DreamHost VPS `vps72256.dreamhostps.com`.

Required GitHub Actions secrets:

| Secret | Purpose |
|--------|---------|
| `FTP_PASSWORD` | SFTP password for `xcivsocialapp` |
| `FTP_REMOTE_PATH` | Site root, e.g. `/home/xcivsocialapp/xcivsocial.com` |

Manual run: Actions → **Deploy to xcivsocial.com** → **Run workflow**.

## Local

See XAMPP setup under `http://localhost/xciv-social/`. Keep `wp-config.php` and DB credentials local only (gitignored).
