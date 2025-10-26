from playwright.sync_api import sync_playwright, expect

def run(playwright):
    browser = playwright.chromium.launch(headless=True)
    context = browser.new_context()
    page = context.new_page()

    # Login as default admin user
    page.goto("http://127.0.0.1:8080/login.php")
    page.fill('input[name="username"]', "admin")
    page.fill('input[name="password"]', "password")
    page.click('button[type="submit"]')
    page.wait_for_url("http://127.0.0.1:8080/index.php")

    # Go to admin page, which should trigger the redirect
    page.goto("http://127.0.0.1:8080/admin")

    # Verify redirection to force_password_reset.php
    page.wait_for_url("http://127.0.0.1:8080/admin/force_password_reset.php")
    expect(page.locator("h1")).to_have_text("Changement de mot de passe requis")
    page.screenshot(path="jules-scratch/verification/password_reset_page.png")

    # Change the password
    page.fill('input[name="password"]', "new_password")
    page.fill('input[name="confirm_password"]', "new_password")
    page.click('button[type="submit"]')

    # Verify redirection to admin dashboard
    page.wait_for_url("http://127.0.0.1:8080/admin/index.php")
    expect(page.locator("h1")).to_have_text("Tableau de Bord Administrateur")
    page.screenshot(path="jules-scratch/verification/admin_dashboard.png")

    browser.close()

with sync_playwright() as playwright:
    run(playwright)
