# Deployment — GitHub Push → cPanel Auto-Deploy

THE FINDGROUP theme updates automatically: **commit to GitHub `main` → the
live staging site pulls and updates within ~10 seconds**.

This uses a tiny PHP webhook script on cPanel that GitHub calls on every
push. No FTP, no GitHub Actions, no cPanel paid plugins required.

> **How it works (one-time setup, then automatic forever):**
> 1. GitHub fires a webhook → your `github-deploy.php` script
> 2. The script verifies the request's cryptographic signature
> 3. The script runs `git pull` in the theme folder
> 4. Live site reflects the new commit

---

## Files involved

```
public_html/website_21fa4134/staging/7837/
├── github-deploy.php             ← webhook receiver (from webhook/ folder)
├── generate-secret.sh            ← one-time secret generator (from webhook/ folder)
├── .github-webhook-secret        ← secret string (NOT in git, perms 600)
├── .github-deploy.log            ← deploy log (auto-created, gitignored)
└── wp-content/themes/thefindgroup/   ← the git repo (this theme)
    ├── .cpanel.yml               ← enables cPanel's "Deploy" button
    ├── .htaccess                 ← blocks web access to dotfiles/secret
    └── (theme files)
```

The webhook script + secret live **above** the theme folder, so updating
the theme never deletes them.

---

## Setup (≈5 minutes, one-time)

### Step 1 — Upload the webhook script

Upload these two files (from this repo's `webhook/` folder) to your cPanel
staging root via File Manager or FTP:

- `webhook/github-deploy.php` → `public_html/website_21fa4134/staging/7837/github-deploy.php`
- `webhook/generate-secret.sh` → `public_html/website_21fa4134/staging/7837/generate-secret.sh`

### Step 2 — Generate the shared secret

Open **cPanel → Terminal** (or SSH) and run:

```bash
cd  public_html/website_21fa4134/staging/7837
bash generate-secret.sh
```

This creates `.github-webhook-secret` (perms 600) and prints a 64-character
secret string. **Copy it** — you'll paste it into GitHub next.

> If cPanel Terminal isn't enabled, generate a secret locally instead:
> ```bash
> openssl rand -hex 32
> ```
> Then create `.github-webhook-secret` via File Manager, paste the secret,
> save, and set permissions to 600 (right-click → chmod).

### Step 3 — Add the webhook in GitHub

Go to **https://github.com/Trinacle/thefindgroup/settings/hooks/new** and configure:

| Field | Value |
|---|---|
| **Payload URL** | `https://thefindgroup.com/staging/7837/github-deploy.php` |
| **Content type** | `application/json` |
| **Secret** | (the string from Step 2) |
| **Which events trigger** | Just the `push` event |

Click **Add webhook**. GitHub immediately sends a `ping` — you should see
a green ✓ next to the webhook within a few seconds.

### Step 4 — Test it

Make any commit and push:

```bash
git commit --allow-empty -m "test: webhook deploy"
git push origin main
```

Then check:
- **GitHub:** the webhook shows a recent "push" delivery (green ✓)
- **cPanel Terminal:** `cat .github-deploy.log` shows `DEPLOY OK: now at commit …`
- **Browser:** `https://thefindgroup.com/staging/7837/wp-content/themes/thefindgroup/.deployed` shows a fresh timestamp

If all three check out, you're fully automated. 🎉

---

## Day-to-day workflow

```bash
# Edit any file in the theme...
git add -A
git commit -m "tweak: refine hero spacing"
git push origin main
# → webhook fires → git pull runs → live site updates in ~10 seconds
```

You can also edit directly on GitHub.com via the web editor — it commits
and pushes for you, which triggers the same webhook.

### Manual deploy (if webhook is down)

In cPanel → **Git™ Version Control → manage `thefindgroup`** → click
**"Deploy HEAD Commit"**. The `.cpanel.yml` in this repo enables that button.

---

## Verifying a deploy ran

Three ways to confirm:

1. **GitHub webhook log:** `github.com/Trinacle/thefindgroup/settings/hooks`
   → click the webhook → "Recent Deliveries" → green ✓ = delivered.
2. **Server log:** `cat .github-deploy.log` in the staging root shows each
   deploy with timestamp, pusher, and commit SHA.
3. **Timestamp file:** the `.cpanel.yml` writes `.deployed` on each run.
   Visit `…/wp-content/themes/thefindgroup/.deployed` (the file extension
   is unusual but readable; or `curl` it).

---

## Security

| Layer | Protection |
|---|---|
| **HMAC-SHA256 signature** | Every request is cryptographically verified against the shared secret. Forged requests get HTTP 403. |
| **Secret stored outside git** | `.github-webhook-secret` lives above the theme folder and is never committed. Perms 600. |
| **`.htaccess` blocks** | Denies web access to `.git/`, `.cpanel.yml`, dotfiles, the secret file, and the log. |
| **Branch check** | Only pushes to `main` trigger a deploy. Pushes to other branches are acknowledged but ignored. |
| **Minimal output** | The script returns just `Deployed <sha>` or `Forbidden` — no paths or secrets leak. |
| **No `eval` / no shell injection** | Paths are `escapeshellarg()`-escaped; the only variable content is the trusted git command. |

**Verify it:** `https://thefindgroup.com/staging/7837/wp-content/themes/thefindgroup/.git/config` should return **403 Forbidden** (not the file contents).

---

## Troubleshooting

### Webhook shows red ✗ in GitHub
- Click the failed delivery → "Response". A **403** means the secret doesn't match — regenerate via `generate-secret.sh` and update both the file AND the GitHub webhook Secret field.
- A **500** means a server error — check `.github-deploy.log` for the stack trace.
- A **timeout** means cPanel is unreachable or the script took >10s — check the log; `git pull` usually completes in 2–5s.

### Deploy runs but site doesn't change
- Confirm the theme is **activated** in wp-admin (Appearance → Themes).
- Flush any cache plugin (LiteSpeed Cache, WP Rocket, W3TC) and Cloudflare.
- Check `.github-deploy.log` — if it says `DEPLOY OK` but files look old, the
  `GIT_DIR` path in `github-deploy.php` may be wrong. Confirm with:
  ```bash
  ls -la public_html/website_21fa4134/staging/7837/wp-content/themes/thefindgroup/.git
  ```
  If that path differs, edit `$GIT_DIR` at the top of `github-deploy.php`.

### "git fetch fails / permission denied"
- The cPanel user must own the `.git` folder. In Terminal:
  ```bash
  cd public_html/website_21fa4134/staging/7837/wp-content/themes/thefindgroup
  chown -R $USER:$USER .
  ```
  (Replace `$USER` with your cPanel username if needed.)

### GitHub says "Last delivery was 8 hours ago"
- Re-trigger by pushing any commit, or use GitHub's "Redeliver" button on the
  most recent delivery.

### `git reset --hard` wiped my live edits
- This is by design — the repo is the source of truth. Never edit files
  directly on the server; always commit via git. If you need to recover,
  `git reflog` in the theme folder shows every position HEAD has held.

---

## Roll back a bad deployment

```bash
# Find the last known-good commit
git log --oneline

# Revert (safe, creates a new commit)
git revert <bad-commit-sha>
git push origin main
# → webhook auto-deploys the reverted state
```

For a hard rollback:
```bash
git reset --hard <good-commit-sha>
git push --force origin main
```

---

## Moving staging → production

When you launch to the main `thefindgroup.com` domain:

1. Clone the same repo to the production theme path:
   `public_html/wp-content/themes/thefindgroup`
2. Copy `github-deploy.php` + `.github-webhook-secret` to the production root.
3. Update `$GIT_DIR` in the production `github-deploy.php` to the new path.
4. Add a **second** GitHub webhook pointing to the production script URL
   (both staging and production can receive the same push).
5. Optionally use separate branches: `staging` → staging, `main` → production.
   Edit the `$branch !== 'main'` check in `github-deploy.php` accordingly.
