
import re
import os
from playwright.sync_api import sync_playwright, Page, expect

def run(playwright):
    # Ensure a clean state by deleting the database
    db_file = 'quiz.db'
    if os.path.exists(db_file):
        os.remove(db_file)

    browser = playwright.chromium.launch(headless=True)
    context = browser.new_context()
    page = context.new_page()

    try:
        # Step 1: Login and handle forced password reset
        page.goto("http://127.0.0.1:8080/login.php")
        page.get_by_label("Nom d'utilisateur").fill("admin")
        page.get_by_label("Mot de passe").fill("password")
        page.get_by_role("button", name="Se connecter").click()

        expect(page).to_have_url(re.compile(r".*/index\.php"))

        page.goto("http://127.0.0.1:8080/admin/users.php")
        expect(page).to_have_url(re.compile(r".*/admin/force_password_reset\.php"))

        new_password = "a_secure_password"
        page.get_by_label("Nouveau mot de passe", exact=True).fill(new_password)
        page.get_by_label("Confirmer le nouveau mot de passe", exact=True).fill(new_password)
        page.get_by_role("button", name="Mettre à jour le mot de passe").click()

        # Step 2: Navigate to the admin users page
        expect(page).to_have_url(re.compile(r".*/admin/index\.php"))
        page.goto("http://127.0.0.1:8080/admin/users.php")

        # Step 3: Verify the profile dropdown menu
        profile_button = page.locator("#profile-menu-button")
        expect(profile_button).to_be_visible()
        profile_button.click()

        dropdown_menu = page.locator("#profile-menu-dropdown")
        expect(dropdown_menu).to_be_visible()

        # Check for a specific link within the dropdown
        gestion_quizz_link = dropdown_menu.get_by_role("link", name="Gestion Quizz")
        expect(gestion_quizz_link).to_be_visible()

        # Step 4: Take a screenshot
        page.screenshot(path="jules-scratch/verification/profile_menu_visible.png")
        print("Verification script ran successfully.")

    finally:
        context.close()
        browser.close()

with sync_playwright() as p:
    run(p)
