from playwright.sync_api import sync_playwright

def run(playwright):
    browser = playwright.chromium.launch()
    page = browser.new_page()

    page.goto("http://127.0.0.1:8080")

    # Click the profile menu button
    profile_button = page.locator('button#profile-menu-button')
    profile_button.click()

    # Wait for the dropdown to be visible
    dropdown = page.locator('div#profile-menu-dropdown')
    dropdown.wait_for(state="visible")

    # Click a link in the dropdown
    link = dropdown.locator('a:has-text("Mon compte")')
    link.click()

    page.screenshot(path="jules-scratch/verification/profile_menu_click_final.png")

    browser.close()

with sync_playwright() as playwright:
    run(playwright)
