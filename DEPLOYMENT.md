# Deployment — Automatic GitHub → cPanel

THE FINDGROUP theme updates automatically. Commit to the `main` branch on
GitHub, and within ~60 seconds the live WordPress site reflects the change.

**Method chosen:** GitHub Action that mirrors the repo to the cPanel-hosted
WordPress theme folder via FTP/FTPS.

---

## How it works

```
  You (or ZCode) commits to `main`
              │
              ▼
   GitHub Action runs (.github/workflows/deploy.yml)
              │
              ▼
   FTP-Deploy-Action syncs only the changed files
              │
              ▼
   /public_html/wp-content/themes/thefindgroup-luxury/  ← on cPanel
              │
              ▼
   Live site at https://thefindgroup.com reflects the update
```

- **Branch:** `main` triggers deployment. Use other branches for work-in-progress.
- **Theme folder on server:** `wp-content/themes/thefindgroup-luxury/` (defined in `deploy.yml` → `env.THEME_DIR`).
- **Deletions are synced** — if you remove a file from the repo, it's removed from the server too.
- **Excluded from upload:** `.git`, `.github`, `README.md`, this doc, `node_modules`, OS junk (see `.ftpdeploy`).

---

## One-time setup (≈5 minutes)

### Step 1 — Get cPanel FTP credentials

In cPanel (`https://thefindgroup.com:2083`):

1. **Files → FTP Accounts → Create FTP Account** (or use the default cPanel login).
2. Note these three values:

| Value | Where to find it | Example |
|---|---|---|
| **FTP server / host** | cPanel → FTP Accounts → "FTP Server" | `ftp.thefindgroup.com` or the server IP |
| **FTP username** | The account you created | `thefindgroup` or `user@thefindgroup.com` |
| **FTP password** | The password you set | (keep secret) |

3. Confirm the FTP account's **home directory** is `public_html` (or higher), so it can reach `wp-content/themes/`.

> **Tip:** Test the credentials first in FileZilla. If port 21 + TLS fails, try plain FTP — and switch `security: strict` to `security: loose` in `.github/workflows/deploy.yml`.

### Step 2 — Add the credentials to GitHub as Secrets

On GitHub, repo **Trinacle/thefindgroup**:

1. **Settings → Secrets and variables → Actions → New repository secret**
2. Add these three secrets (exact names — the workflow looks for them):

| Secret name | Value |
|---|---|
| `FTP_SERVER` | (your FTP host) |
| `FTP_USERNAME` | (your FTP username) |
| `FTP_PASSWORD` | (your FTP password) |

Secrets are encrypted by GitHub and never printed in logs.

### Step 3 — First deployment

1. Make any commit and push to `main` (or trigger the workflow manually from the **Actions** tab → "Deploy to cPanel" → "Run workflow").
2. Watch the run under the **Actions** tab. Green ✓ = deployed.
3. In WordPress: **Appearance → Themes → activate "THE FINDGROUP — Luxury"**.
4. **Appearance → Customize → THE FINDGROUP** → set phone, social, live-chat snippet.
5. Create the 8 inner pages (About, Contact, Sell With Us, Aircraft, Armored Vehicles, Real Estate, Privacy, Terms) and assign each its matching template under **Page Attributes**.
6. **Settings → Reading → "A static page"** → Front page = Home.

That's it — every future push to `main` deploys automatically.

---

## Day-to-day workflow

```bash
# Edit files locally...
git add -A
git commit -m "tweak: refine hero spacing"
git push origin main
# → Action runs → live site updates in ~60s
```

Or commit directly on GitHub.com via the web editor for small text/PHP tweaks.

---

## Troubleshooting

### Action fails with "530 Login authentication failed"
- Verify `FTP_USERNAME` and `FTP_PASSWORD` secrets match exactly (no trailing spaces).
- Some cPanel hosts require the full `user@domain.com` format for the username.

### Action runs but site doesn't change
- Confirm WordPress isn't using a ** caching plugin** or **Cloudflare** that needs a purge.
- Confirm the theme is **activated** (Appearance → Themes) — uploads to an inactive theme folder have no visible effect.
- Check that `server-dir` in `deploy.yml` matches your actual server path. Run `pwd` via cPanel File Manager inside `wp-content/themes/` to confirm.

### "425 Cannot open data connection" or hangs
- cPanel FTP may require **passive mode** or a specific port range. The action uses passive by default; if it fails, set `security: loose` and retry.
- Confirm port 21 is open on the firewall (or use port 22/SFTP if your host supports it — see alternative below).

### Files upload but with wrong line endings
- The repo uses `.gitattributes` to normalize. Already handled.

---

## Alternative: cPanel Git Version Control (no GitHub Actions)

If you'd rather not use FTP at all, cPanel has a built-in **Git Version Control**
feature that pulls directly from GitHub. Setup:

1. cPanel → **Git™ Version Control → Create** → "Clone a repository".
2. Repository URL: `https://github.com/Trinacle/thefindgroup.git`
3. cPanel will create a working copy at `~/thefindgroup-repo` (NOT inside `public_html`).
4. After cloning, cPanel shows a **"Deploy HEAD commit"** button. But cPanel's deploy copies the whole repo flat — for a theme you'll want a **deployment script**:

   Create `.cpanel.yml` in the repo root:
   ```yaml
   ---
   deployment:
     tasks:
       - export DEPLOYPATH=/home/USER/public_html/wp-content/themes/thefindgroup-luxury
       - /bin/cp -R * $DEPLOYPATH/
       - /bin/cp -R .ftpdeploy $DEPLOYPATH/ 2>/dev/null || true
   ```
   (Replace `USER` with your cPanel username.)

5. Then either **manually click "Deploy"** in cPanel, or set up a **GitHub webhook** to cPanel's pull URL for automatic sync.

**Recommendation:** The FTP GitHub Action (the default in this repo) is simpler and triggers on every push automatically. Use cPanel Git Version Control only if FTP is blocked on the host.

---

## Roll back a bad deployment

Git makes this trivial:

```bash
# Find the last known-good commit
git log --oneline

# Revert the bad commit (creates a new commit that undoes it)
git revert <bad-commit-sha>
git push origin main
# → Action deploys the reverted state automatically
```

For a faster nuclear option, force-push a known-good commit:

```bash
git reset --hard <good-commit-sha>
git push --force origin main
```

The Action re-deploys whatever `main` points to.

---

## Secrets reference

| Secret | Purpose | Required |
|---|---|---|
| `FTP_SERVER` | cPanel FTP host | ✅ |
| `FTP_USERNAME` | FTP account username | ✅ |
| `FTP_PASSWORD` | FTP account password | ✅ |
