<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Portail des tests de positionnement</title>
    <meta name="description" content="Bienvenue sur le portail des tests de positionnement." />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">
    <?php
    require_once 'includes/db_setup.php';
    include 'header.php';
    ?>
    <div class="max-w-5xl mx-auto p-4 md:p-8 w-full">
        <!-- Header -->
        <header class="mb-8 md:mb-10 text-center">
            <h1 class="text-2xl md:text-4xl font-bold">Bienvenue sur notre portail de tests de positionnement</h1>
            <p class="text-sm md:text-base text-gray-700 mt-2">
                Évaluez vos compétences et connaissances avec nos quizz interactifs.
            </p>
        </header>

        <!-- Content -->
        <section class="bg-white rounded-2xl shadow p-5 md:p-6">
            <h2 class="text-xl md:text-2xl font-semibold mb-4">À propos de ce site</h2>
            <p class="text-gray-700 leading-relaxed">
                Ce site est conçu pour vous aider à évaluer votre niveau de compétence dans divers domaines. Nous proposons une série de tests de positionnement qui vous fourniront un feedback personnalisé et un score détaillé pour vous aider à identifier vos points forts et vos axes d'amélioration.
            </p>
            <p class="text-gray-700 leading-relaxed mt-4">
                Que vous soyez débutant ou expert, nos quizz sont adaptés à tous les niveaux. Chaque test est soigneusement élaboré pour couvrir les concepts clés et vous offrir une expérience d'apprentissage enrichissante.
            </p>
            <div class="mt-6 text-center">
                <a href="les-quizz.php" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">
                    Voir les quizz
                </a>
            </div>
        </section>

    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
