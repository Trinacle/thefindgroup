# Deployment — cPanel Git Version Control (auto-deploy on push)

THE FINDGROUP theme updates automatically: **commit to GitHub `main` → cPanel
pulls and deploys within seconds**. This uses cPanel's built-in Git Version
Control feature (no FTP, no GitHub Actions required).

> **Current setup (as configured):**
> - **Live URL:** https://thefindgroup.com/staging/7837
> - **Repo on cPanel:** `public_html/website_21fa4134/staging/7837/wp-content/themes/thefindgroup`
> - **GitHub remote:** `Trinacle/thefindgroup`
> - **Deployment config:** `.cpanel.yml` (this repo)

---

## How it works

```
  You commit & push to GitHub `main`
              │
              ▼
   GitHub fires a webhook → cPanel
              │
              ▼
   cPanel runs `git pull origin main`
              │
              ▼
   cPanel executes `.cpanel.yml` deployment tasks
   (rsync the repo into the live theme folder, excluding dev files)
              │
              ▼
   Live site at /staging/7837 reflects the update
```

The `.cpanel.yml` file (in this repo root) tells cPanel exactly how to publish
each commit. It mirrors the repo into the live theme directory using `rsync`,
excluding `.git`, `.github`, `.cpanel.yml`, `node_modules`, README/DEPLOYMENT
docs, etc.

---

## Initial setup (one-time)

These steps should already be done (the cPanel repository is connected):

### 1. Repository connected in cPanel
**cPanel → Git™ Version Control** shows the `thefindgroup` repo cloned to
`public_html/website_21fa4134/staging/7837/wp-content/themes/thefindgroup`
and status "up-to-date".

### 2. `.cpanel.yml` exists in the repo root
✅ Now committed. This is what cPanel was asking for ("A valid .cpanel.yml
file exists"). Without it, cPanel refuses to deploy.

### 3. No uncommitted changes
cPanel requires a clean working tree before deploying. The `.cpanel.yml`
itself was the missing piece — once pushed, cPanel sees a clean tree.

### 4. Activate the theme in WordPress
- Log into wp-admin at the staging site.
- **Appearance → Themes → activate "THE FINDGROUP — Luxury"**.
- **Settings → Reading → "A static page"** → Front page = your Home page.
- Create the 8 inner pages (About, Contact, Sell With Us, Aircraft, Armored
  Vehicles, Real Estate, Privacy, Terms) and assign each its matching
  template under **Page Attributes**.

---

## Enabling auto-deploy on every GitHub push (the webhook)

By default, cPanel deploys **manually** (you click "Deploy HEAD Commit" in
cPanel). To make it fully automatic on every push, add a webhook:

### In GitHub:
1. Go to **https://github.com/Trinacle/thefindgroup/settings/hooks**
2. **Add webhook →** configure:
   - **Payload URL:** cPanel's webhook receiver URL (see below)
   - **Content type:** `application/json`
   - **Trigger:** just the `push` event
3. The **Payload URL** comes from cPanel:
   - **cPanel → Git™ Version Control → manage `thefindgroup`**
   - Look for the **"Webhook URL"** or **"Pull Deployment"** section
   - Copy that URL into the GitHub webhook Payload URL field

Once the webhook is set, every push to `main` will:
1. Trigger GitHub to POST to cPanel
2. cPanel pulls the latest commit
3. cPanel runs the `.cpanel.yml` deployment tasks
4. The staging site updates automatically — typically within 10–30 seconds

---

## Day-to-day workflow

```bash
# Edit files locally...
git add -A
git commit -m "tweak: refine hero spacing"
git push origin main
# → cPanel auto-deploys within ~30 seconds
```

Or commit directly on GitHub.com via the web editor for small text/PHP tweaks.

To check if a deploy ran, go to **cPanel → Git™ Version Control → manage**
and look at the **deployment history / last deployment time**.

---

## Files that ship to the live server vs. stay in the repo

`.cpanel.yml` uses `rsync --delete` with excludes. **Live site gets** all PHP,
CSS, JS, image, font assets. **Excluded from live** (kept in repo only):

| File | Why excluded |
|---|---|
| `.git/`, `.github/` | Dev metadata — no place in production |
| `.cpanel.yml` | Deploy config — would be visible publicly otherwise |
| `.gitignore`, `.gitattributes` | Dev tooling |
| `node_modules/` | Build artifacts (we ship pre-built CSS/JS) |
| `README.md`, `DEPLOYMENT.md` | Internal docs |

The `.htaccess` at the repo root also ships to the live theme folder and
enforces these blocks at the web-server level (defense in depth).

---

## Security hardening

The repo's `.htaccess` blocks direct web access to:
- All dotfiles (`.git/`, `.cpanel.yml`, `.gitignore`, etc.)
- Config files (`composer.json`, `package.json`, `*.log`, `*.sql`, `*.sh`)
- Directory listings (`Options -Indexes`)

So even if cPanel checks out `.git/` into the web root, it's not browseable.
Verified: `https://thefindgroup.com/staging/7837/wp-content/themes/thefindgroup/.git/config` returns 403.

---

## Troubleshooting

### "The system cannot deploy… A valid .cpanel.yml file exists"
- This was the original error. Fixed by committing `.cpanel.yml`. After
  pushing, refresh cPanel → Git Version Control → the error clears.

### "No uncommitted changes exist on the checked-out branch"
- cPanel requires a clean working tree. If cPanel shows local modifications,
  in cPanel → Git Version Control → **"Reset"** the working tree, or run
  `git checkout -- .` in the cPanel terminal to discard local changes.

### Deploy runs but site doesn't update
- Confirm the theme is **activated** in wp-admin (Appearance → Themes).
- Flush any cache plugin (LiteSpeed, WP Rocket, W3TC) and Cloudflare.
- Verify `.cpanel.yml`'s `$DEPLOYPATH` matches your live theme path. cPanel
  sets `$DEPLOYPATH` automatically to the repo's checkout location, which
  for this setup is `…/wp-content/themes/thefindgroup`.
- Check cPanel → Git Version Control → **deployment log** for rsync errors.

### "Could not connect to GitHub" on pull
- The cPanel-stored GitHub credentials/SSH key may have expired. In cPanel
  → Git Version Control → manage → **"Update Credentials"** or re-auth.

### Files deploy with Windows line endings (CRLF)
- `.gitattributes` forces `eol=lf` for PHP/JS/CSS, so this is handled.

---

## Roll back a bad deployment

Git makes this trivial:

```bash
# Find the last known-good commit
git log --oneline

# Revert (creates a new commit that undoes the bad one) — safe, no force-push
git revert <bad-commit-sha>
git push origin main
# → cPanel auto-deploys the reverted state
```

For a hard rollback:
```bash
git reset --hard <good-commit-sha>
git push --force origin main
```
cPanel will pull and deploy whatever `main` points to.

---

## Moving from staging to production

When ready to launch to the main `thefindgroup.com` domain:
1. Clone/connect the same repo to the production theme path
   (`public_html/wp-content/themes/thefindgroup`).
2. Add a second `.cpanel.yml` if the production path differs (it usually
   won't — cPanel uses `$DEPLOYPATH` which auto-resolves).
3. Set up the same GitHub webhook for the production cPanel repo entry.
4. Both staging and production can track the same `main` branch, or use
   separate branches (`staging` → staging site, `main` → production).
