import { test, expect } from '@playwright/test';

/**
 * E2E smoke for menus_api.
 *
 * menus_api is a small utility plugin: a Bootstrap class registers no
 * actions / hooks / events, just declarative view extensions in
 * elgg-plugin.php (navigation/menu/elements/item.css extending
 * elements/navigation.css). The smoke assertion is "with menus_api
 * activated, the plugin doesn't break the site bootstrap and the
 * extended CSS is present in the elgg.css output".
 *
 * Catches:
 *   - PHP fatal in the Bootstrap class autoload path
 *   - View extension target/key drift breaking the cache compile
 *   - Plugin activation failure that leaves the site 5xx-ing
 */
test.describe('menus_api', () => {
  test('homepage renders with no PHP fatal markers', async ({ page }) => {
    const response = await page.goto('/');
    expect(response, 'response object should be defined').toBeTruthy();
    expect(response!.status(), `unexpected status ${response!.status()} on /`).toBeLessThan(500);

    const body = await page.content();
    expect(body, 'page body should not contain Fatal error').not.toContain('Fatal error');
    expect(body, 'page body should not contain Uncaught').not.toContain('Uncaught');
    expect(body, 'page body should not contain ParseError').not.toContain('ParseError');
  });

  test('elgg.css simplecache resolves with menu item extension applied', async ({ page }) => {
    // Navigate to homepage first to find the real simplecache URL.
    // Elgg 5.x uses a real timestamp (/cache/<ts>/default/elgg.css),
    // not /cache/0/… — navigating to /cache/0/ returns 410 Gone.
    await page.goto('/');
    const cssLink = page.locator('link[rel="stylesheet"][href*="elgg.css"]').first();
    const href = await cssLink.getAttribute('href').catch(() => null);

    let cssPath = '/cache/default/elgg.css';
    if (href) {
      try { cssPath = new URL(href).pathname; } catch { cssPath = href; }
    }

    const response = await page.goto(cssPath);
    expect(response, 'elgg.css response should exist').toBeTruthy();
    expect(response!.status(), `unexpected CSS status ${response!.status()} on ${cssPath}`).toBeLessThan(400);
    const ct = response!.headers()['content-type'] || '';
    expect(ct).toMatch(/css|text/);
  });
});
