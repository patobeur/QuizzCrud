<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Ma progression</title>
    <meta name="description" content="Suivez votre progression sur les tests de positionnement." />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">
    <?php include 'header.php'; ?>
    <div class="max-w-5xl mx-auto p-4 md:p-8 w-full">
        <header class="mb-8 md:mb-10">
            <h1 class="text-2xl md:text-4xl font-bold">Ma progression</h1>
            <p class="text-sm md:text-base text-gray-700 mt-2">
                Retrouvez ici un résumé de vos résultats aux différents tests.
            </p>
        </header>

        <section id="progression-container" class="space-y-4">
            <!-- Le contenu sera généré par JavaScript -->
        </section>
    </div>
    <?php include 'footer.php'; ?>
    <script src="js/main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const resultsKey = 'qcm_results';
            const allResults = JSON.parse(localStorage.getItem(resultsKey)) || {};
            const container = document.getElementById('progression-container');

            if (Object.keys(allResults).length === 0) {
                container.innerHTML = '<p class="text-gray-600">Vous n\'avez pas encore terminé de test.</p>';
                return;
            }

            for (const quizId in allResults) {
                const result = allResults[quizId];
                const card = document.createElement('div');
                card.className = 'bg-white rounded-2xl shadow p-5 md:p-6';

                card.innerHTML = `
                    <h2 class="text-lg md:text-xl font-semibold">${quizId}</h2>
                    <p class="text-sm text-gray-700 mt-2">
                        Score : ${result.score} / ${result.total} (${result.percentage}%)
                    </p>
                    <div class="w-full bg-gray-200 h-2 rounded mt-2">
                        <div class="bg-indigo-500 h-2 rounded" style="width: ${result.percentage}%"></div>
                    </div>
                `;

                if (result.percentage === 100) {
                    const successBadge = document.createElement('span');
                    successBadge.className = 'mt-2 inline-flex items-center gap-2 text-xs font-semibold px-2.5 py-1 rounded-full bg-green-50 text-green-700 border border-green-200';
                    successBadge.textContent = '✅ Terminé avec succès';
                    card.appendChild(successBadge);
                }

                container.appendChild(card);
            }
        });
    </script>
</body>
</html>
