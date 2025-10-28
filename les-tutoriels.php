<?php
$pageTitle = "Liste des Tutoriels";
require_once 'includes/auth_check.php';
require_once 'header.php';

$tutoriels_data = json_decode(file_get_contents('tutoriels.json'), true);
$categories = $tutoriels_data['categories'];
?>

<div class="container mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Nos Tutoriels</h1>

    <?php foreach ($categories as $categorie): ?>
        <?php if (!empty($categorie['tutoriels'])): ?>
            <div class="mb-12">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4 border-b-2 border-indigo-500 pb-2"><?php echo htmlspecialchars($categorie['nom']); ?></h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($categorie['tutoriels'] as $tutoriel): ?>
                        <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-2"><?php echo htmlspecialchars($tutoriel['titre']); ?></h3>
                                <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($tutoriel['sous_categorie']); ?></p>
                                <a href="tutoriel.php?id=<?php echo htmlspecialchars($tutoriel['id']); ?>" class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">Voir le tutoriel</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>

</div>

<?php require_once 'footer.php'; ?>
