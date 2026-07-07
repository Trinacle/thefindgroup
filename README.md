# THE FINDGROUP — Luxury WordPress Theme

A bespoke, hand-crafted classic WordPress theme for THE FINDGROUP — a full-service luxury brokerage specializing in Yachts, Real Estate, Aircraft, and Armored Luxury Vehicles. "Selling Luxury Assets Since 1985."

## Design Language

- **Palette:** Black · White · Silver monochrome
- **Dual-mode:** Dark (default) + Light toggle, persisted per visitor, respects `prefers-color-scheme`
- **Typography:** Cormorant Garamond (display) + Inter (body/UI)
- **Motion:** GSAP ScrollTrigger + Lenis smooth scroll, all gated behind `prefers-reduced-motion`
- **Layout philosophy:** Each page uses a different composition (cinematic, editorial split, magazine spread, catalog index, diptych, stacked panels) so the site feels curated, not templated.

## Architecture

```
theme/
├── style.css                  # Theme header (required by WP)
├── functions.php              # Loads inc/*.php
├── front-page.php             # Home (11 sections)
├── page.php                   # Default page
├── page-about.php             # About (magazine narrative + team grid)
├── page-contact.php           # Contact (form primary CTA)
├── page-sell-with-us.php      # Sell With Us (8 reasons + form)
├── page-aircraft.php          # Aircraft (stacked panels)
├── page-armored-vehicles.php  # Armored (diptych + capabilities)
├── page-real-estate.php       # Real Estate (editorial split + grid)
├── page-legal.php             # Privacy / Terms (long-form + TOC)
├── search.php                 # Search results
├── 404.php                    # Cinematic 404
├── header.php / footer.php    # Global chrome
├── header-shop.php / footer-shop.php  # WooCommerce wrappers
├── inc/
│   ├── setup.php              # Theme supports, image sizes, menus, body classes
│   ├── assets.php             # Font/CSS/JS enqueuing, no-FOUC script
│   ├── cpt.php                # team_member + office CPTs, seed data (19 team, 6 offices)
│   ├── woocommerce.php        # WC support, product card hooks, single-product overrides, broker tab
│   ├── helpers.php            # Content queries, price formatting, contact form, newsletter AJAX
│   └── customizer.php         # Phone, social, live-chat snippet, tagline
├── template-parts/
│   ├── section-categories.php
│   ├── section-trending.php
│   ├── section-statement.php
│   ├── section-brands.php
│   ├── section-stats.php
│   ├── section-why-sell.php
│   ├── section-team-teaser.php
│   ├── section-associations.php
│   ├── section-closing-cta.php
│   └── content-listing-card.php
├── woocommerce/
│   ├── archive-product.php    # Listings archive (yachts/RE/aircraft/armored)
│   ├── single-product.php     # Listing detail
│   ├── content-product.php    # Card hook orchestrator
│   ├── no-products-found.php
│   ├── header-shop.php / footer-shop.php
│   └── loop/
│       ├── loop-start.php
│       ├── loop-end.php
│       └── pagination.php
└── assets/
    ├── css/
    │   ├── tokens.css         # Design tokens (dark/light CSS variables)
    │   ├── base.css           # Reset, typography, layout primitives
    │   ├── components.css     # Buttons, header, nav, cards, forms, footer, cursor
    │   ├── layout.css         # Page-specific layouts
    │   ├── woocommerce.css    # WC overrides
    │   ├── forminator.css     # Forminator form restyle
    │   └── editor.css         # Block editor styles
    ├── js/
    │   └── main.js            # Theme toggle, nav, search, Lenis, GSAP, cursor, newsletter
    └── img/                   # Static hero/section images (see img/README.md)
```

## Key Decisions

### Listings = WooCommerce Products
All listings (Yachts, Real Estate, Aircraft, Armored Vehicles) are WooCommerce products organized by `product_cat`. The four categories are auto-created on theme activation. Each product can have:
- **Attributes** (length, year, beds/baths, etc.) → rendered as a spec table
- **A broker** (linked `team_member`) via the "Assigned Broker" meta box → shown in a Broker tab
- **Price** → formatted as `$X,XXX,XXX` (no decimals) or "Price on request" if empty
- **Sale price** → shows strikethrough original + "Reduced" badge

### Form = Primary CTA
- The Forminator "Send Us a Message" form (ID 16174) is the primary conversion mechanism, embedded on Contact and Sell With Us pages and restyled via `assets/css/forminator.css` (hairline underline fields, floating uppercase labels, custom selects, intl phone picker preserved).
- A fallback HTML form (same fields) is rendered if Forminator is unavailable, posting to `admin-post.php`.
- The contact page is the **backup CTA** — Schedule-a-Call has been removed; that CTA now routes to `/contact/`.
- Live chat: paste a provider snippet (Tawk.to, Intercom, Crisp, HubSpot) into Customizer → "Live Chat" → it injects before `</body>`. A pulsing FAB is shown as fallback when no snippet is set.

### Team & Offices
- 19 team members + 6 offices are seeded on theme activation (`inc/cpt.php`).
- **Placeholder/lorem-ipsum slots from the live site are excluded.**
- Team is filterable by Division taxonomy (Yachts, Real Estate, Aviation, Marketing, etc.).

## Installation

1. **Upload the theme:** Copy this folder to `wp-content/themes/thefindgroup-luxury/` (or zip it and upload via Appearance → Themes → Add New → Upload).
2. **Activate:** Appearance → Themes → activate "THE FINDGROUP — Luxury".
3. **Plugins required:** WooCommerce, Forminator (optional but recommended).
4. **Seed data:** On activation, the theme auto-creates 6 offices, 19 team members, and the 4 product categories. (Only runs once.)
5. **Assign page templates:** Edit each page (About, Contact, Sell With Us, Aircraft, Armored Vehicles, Real Estate, Privacy, Terms) and select the matching template from Page Attributes.
6. **Set front page:** Settings → Reading → "A static page" → Front page = your Home page (uses `front-page.php`).
7. **Customizer:** Appearance → Customize → "THE FINDGROUP" → set phone, social URLs, contact email, live-chat snippet, hero tagline.
8. **Logo:** Site Identity → Logo (upload the SVG/PNG wordmark).
9. **Images:** Add product images via WooCommerce; add static section images to `assets/img/` (see `assets/img/README.md`).

## Tech Notes

- **No build step required.** CSS is hand-authored and enqueued directly. JS is vanilla + CDN-loaded GSAP/Lenis.
- **Performance target:** Lighthouse 90+, LCP < 2.5s, CLS < 0.05.
- **Accessibility:** WCAG AA contrast, keyboard nav, focus-visible rings, reduced-motion support, semantic HTML, ARIA on menus/forms.
- **SEO:** Clean headings, schema.org-ready, Open Graph via WP, sitemap via WP core.
- **Cart/checkout disabled** — this is a brokerage, not an e-commerce store. The "Add to cart" is replaced with an "Enquire" CTA on every product.

## Browser Support

Modern evergreen browsers (Chrome, Firefox, Safari, Edge — latest 2 versions). Custom cursor and magnetic hover are desktop-only (touch devices get standard interactions).

## License

GPL v2 or later. Bundled fonts (Cormorant Garamond, Inter) are OFL via Google Fonts.
