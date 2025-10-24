from playwright.sync_api import sync_playwright

def run(playwright):
    browser = playwright.chromium.launch()
    page = browser.new_page()
    page.goto("http://127.0.0.1:8080/qcm.php?quiz=ia_avance")

    # Screenshot before validation
    page.screenshot(path="jules-scratch/verification/qcm_before_validation.png")

    # Click the first option
    page.locator('input[type="radio"]').first.click()

    # Click the validate button
    page.get_by_role("button", name="Valider").click()

    # Screenshot after validation
    page.screenshot(path="jules-scratch/verification/qcm_after_validation.png")

    browser.close()

with sync_playwright() as playwright:
    run(playwright)
