
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
        # Connexion
        page.goto("http://127.0.0.1:8080/login.php")
        page.get_by_label("Nom d'utilisateur").fill("admin")
        page.get_by_label("Mot de passe").fill("password")
        page.get_by_role("button", name="Se connecter").click()

        # Après la connexion, on est redirigé vers l'index.
        expect(page).to_have_url(re.compile(r".*/index\.php"))

        # En accédant à une page admin, on est forcé de réinitialiser le mot de passe.
        page.goto("http://127.0.0.1:8080/admin/users.php")
        expect(page).to_have_url(re.compile(r".*/admin/force_password_reset\.php"))

        new_password = "a_secure_password"
        page.get_by_label("Nouveau mot de passe", exact=True).fill(new_password)
        page.get_by_label("Confirmer le nouveau mot de passe", exact=True).fill(new_password)
        page.get_by_role("button", name="Mettre à jour le mot de passe").click()

        # Aller à la gestion des utilisateurs après la réinitialisation
        expect(page).to_have_url(re.compile(r".*/admin/index\.php"))
        page.goto("http://127.0.0.1:8080/admin/users.php")

        # Trouver la ligne de l'utilisateur 'admin' et cliquer sur 'Modifier'
        admin_row = page.locator("tr", has_text="admin")
        admin_row.get_by_role("link", name="Modifier").click()
        expect(page).to_have_url(re.compile(r".*/admin/edit-user\.php"))

        # Changer le pseudo
        new_username = "admin_modifie"
        page.get_by_label("Nom d'utilisateur").fill(new_username)

        # Sauvegarder
        page.get_by_role("button", name="Sauvegarder").click()

        # Vérifier que la redirection a fonctionné et que le nouveau pseudo est affiché
        expect(page).to_have_url("http://127.0.0.1:8080/admin/users.php?status=success")
        expect(page.locator("body")).to_contain_text(new_username)

        # Prendre une capture d'écran
        page.screenshot(path="jules-scratch/verification/username_update_success.png")

        print("Verification script ran successfully.")

    finally:
        # Revert change to not affect other tests
        db_path = 'quiz.db'
        import sqlite3
        try:
            conn = sqlite3.connect(db_path)
            cursor = conn.cursor()
            cursor.execute("UPDATE users SET username = 'admin' WHERE username = 'admin_modifie'")
            conn.commit()
            print("Database reverted successfully.")
        except sqlite3.Error as e:
            print(f"Database error during revert: {e}")
        finally:
            if conn:
                conn.close()

        context.close()
        browser.close()

with sync_playwright() as p:
    run(p)
