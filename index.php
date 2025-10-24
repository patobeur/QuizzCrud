<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Portail des tests de positionnement</title>
    <meta name="description" content="Choisissez votre test de positionnement." />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">
    <?php include 'header.php'; ?>
    <div class="max-w-5xl mx-auto p-4 md:p-8 w-full">
        <!-- Header -->
        <header class="mb-8 md:mb-10">
            <h1 class="text-2xl md:text-4xl font-bold">Tests de positionnement</h1>
            <p class="text-sm md:text-base text-gray-700 mt-2">
                Choisissez votre niveau pour démarrer. Chaque test comporte
                <strong>20 questions</strong>, un
                <strong>feedback personnalisé</strong> et un
                <strong>score par points</strong>.
            </p>
        </header>

        <!-- Cartes -->
        <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <?php
            // Charger la configuration
            $config_content = file_get_contents(__DIR__ . '/config.json');
            $config = json_decode($config_content, true);

            // Fonction pour mapper un nom de couleur simple à un ensemble de classes Tailwind CSS
            function getColorClasses(string $color_name): array
            {
                // Définir les palettes de classes pour chaque couleur
                $color_styles = [
                    'emerald' => [
                        'border' => 'hover:border-emerald-200',
                        'focus_ring' => 'focus:ring-emerald-200',
                        'level_bg' => 'bg-emerald-50',
                        'level_text' => 'text-emerald-700',
                        'level_border' => 'border-emerald-200',
                        'theme_bg' => 'bg-emerald-50',
                        'theme_text' => 'text-emerald-700',
                        'theme_border' => '',
                        'button_bg' => 'bg-emerald-600',
                        'button_hover_bg' => 'group-hover:bg-emerald-700',
                    ],
                    'indigo' => [
                        'border' => 'hover:border-indigo-200',
                        'focus_ring' => 'focus:ring-indigo-200',
                        'level_bg' => 'bg-indigo-50',
                        'level_text' => 'text-indigo-700',
                        'level_border' => 'border-indigo-200',
                        'theme_bg' => 'bg-indigo-50',
                        'theme_text' => 'text-indigo-700',
                        'theme_border' => '',
                        'button_bg' => 'bg-indigo-600',
                        'button_hover_bg' => 'group-hover:bg-indigo-700',
                    ],
                    'gray' => [
                        'border' => 'hover:border-gray-300',
                        'focus_ring' => 'focus:ring-gray-300',
                        'level_bg' => 'bg-gray-50',
                        'level_text' => 'text-gray-800',
                        'level_border' => 'border-gray-200',
                        'theme_bg' => 'bg-gray-50',
                        'theme_text' => 'text-gray-800',
                        'theme_border' => 'border border-gray-200',
                        'button_bg' => 'bg-gray-900',
                        'button_hover_bg' => 'group-hover:bg-black',
                    ],
                    'fuchsia' => [
                        'border' => 'hover:border-fuchsia-200',
                        'focus_ring' => 'focus:ring-fuchsia-200',
                        'level_bg' => 'bg-fuchsia-50',
                        'level_text' => 'text-fuchsia-700',
                        'level_border' => 'border-fuchsia-200',
                        'theme_bg' => 'bg-fuchsia-50',
                        'theme_text' => 'text-fuchsia-700',
                        'theme_border' => '',
                        'button_bg' => 'bg-fuchsia-600',
                        'button_hover_bg' => 'group-hover:bg-fuchsia-700',
                    ],
                    'pink' => [
                        'border' => 'hover:border-pink-200',
                        'focus_ring' => 'focus:ring-pink-200',
                        'level_bg' => 'bg-pink-50',
                        'level_text' => 'text-pink-700',
                        'level_border' => 'border-pink-200',
                        'theme_bg' => 'bg-pink-50',
                        'theme_text' => 'text-pink-700',
                        'theme_border' => '',
                        'button_bg' => 'bg-pink-600',
                        'button_hover_bg' => 'group-hover:bg-pink-700',
                    ],
                    'violet' => [
                        'border' => 'hover:border-violet-200',
                        'focus_ring' => 'focus:ring-violet-200',
                        'level_bg' => 'bg-violet-50',
                        'level_text' => 'text-violet-700',
                        'level_border' => 'border-violet-200',
                        'theme_bg' => 'bg-violet-50',
                        'theme_text' => 'text-violet-700',
                        'theme_border' => '',
                        'button_bg' => 'bg-violet-600',
                        'button_hover_bg' => 'group-hover:bg-violet-700',
                    ],
                    'purple' => [
                        'border' => 'hover:border-purple-200',
                        'focus_ring' => 'focus:ring-purple-200',
                        'level_bg' => 'bg-purple-50',
                        'level_text' => 'text-purple-700',
                        'level_border' => 'border-purple-200',
                        'theme_bg' => 'bg-purple-50',
                        'theme_text' => 'text-purple-700',
                        'theme_border' => '',
                        'button_bg' => 'bg-purple-600',
                        'button_hover_bg' => 'group-hover:bg-purple-700',
                    ],
                ];

                return $color_styles[$color_name] ?? $color_styles['gray'];
            }

            $quizzes_dir = __DIR__ . '/quizzes';
            $quiz_files = glob($quizzes_dir . '/*.json');

            if (empty($quiz_files)) {
                echo '<p class="text-red-500 col-span-full">Aucun quiz trouvé.</p>';
            } else {
                foreach ($quiz_files as $file) {
                    $content = file_get_contents($file);
                    $data = json_decode($content, true);

                    if (!$data || !isset($data['id'])) continue;

                    $quiz_id = $data['id'];
                    $level = htmlspecialchars($data['level'] ?? 'Niveau non défini');
                    $time = htmlspecialchars($data['time'] ?? 'N/A');
                    $main_title = htmlspecialchars($data['main_title'] ?? 'Titre non défini');
                    $card_description = htmlspecialchars($data['card_description'] ?? 'Pas de description.');
                    $features = $data['features'] ?? [];
                    $themes = $data['themes'] ?? [];

                    $level_color_name = $config['levels'][$level]['color'] ?? 'gray';
                    $level_colors = getColorClasses($level_color_name);

                    $features_html = '';
                    foreach ($features as $feature) {
                        $features_html .= '<li>• ' . htmlspecialchars($feature) . '</li>';
                    }

                    $themes_html = '';
                    foreach ($themes as $theme) {
                        $theme_color_name = $config['themes'][$theme]['color'] ?? 'gray';
                        $theme_colors = getColorClasses($theme_color_name);
                        $themes_html .= sprintf(
                            '<span class="text-xs px-2 py-1 rounded-full %s %s %s">%s</span>',
                            $theme_colors['theme_bg'],
                            $theme_colors['theme_text'],
                            $theme_colors['theme_border'],
                            htmlspecialchars($theme)
                        );
                    }

                    echo <<<HTML
                    <a href="qcm.php?quiz={$quiz_id}"
                       class="group block bg-white rounded-2xl shadow p-5 md:p-6 border border-transparent {$level_colors['border']} hover:shadow-lg focus:outline-none focus:ring-4 {$level_colors['focus_ring']} transition">

                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-2 text-xs font-semibold px-2.5 py-1 rounded-full {$level_colors['level_bg']} {$level_colors['level_text']} border {$level_colors['level_border']}">
                                ● {$level}
                            </span>
                            <span class="text-xs text-gray-500">{$time}</span>
                        </div>

                        <h2 class="text-lg md:text-xl font-semibold mt-3">{$main_title}</h2>
                        <p class="text-sm text-gray-700 mt-2">{$card_description}</p>

                        <ul class="mt-4 space-y-1 text-sm text-gray-700">
                            {$features_html}
                        </ul>

                        <div class="mt-5 flex items-center gap-2">
                            <span class="inline-flex items-center text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-700">Thèmes</span>
                            <div class="flex flex-wrap gap-1">
                                {$themes_html}
                            </div>
                        </div>

                        <div class="mt-6">
                            <span class="inline-flex items-center justify-center px-4 py-2 rounded-xl {$level_colors['button_bg']} text-white text-sm {$level_colors['button_hover_bg']} transition">
                                Passer le test
                            </span>
                        </div>
                    </a>
HTML;
                }
            }
            ?>
        </section>

    </div>
    <?php include 'footer.php'; ?>
    <script src="js/main.js"></script>
</body>
</html>
