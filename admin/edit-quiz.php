<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin - Édition de Quiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">
    <?php
    include '../header.php';
    // Charger la configuration pour les niveaux et thèmes
    $config_content = file_get_contents(__DIR__ . '/../config.json');
    $config = json_decode($config_content, true);
    $levels = array_keys($config['levels']);
    $themes = array_keys($config['themes']);

    $quiz_data = [];
    $quiz_id = $_GET['quiz_id'] ?? null;
    $is_editing = false;

    if ($quiz_id) {
        $is_editing = true;
        $quizzes_dir = __DIR__ . '/../quizzes';
        $quiz_files = glob($quizzes_dir . '/*.json');
        foreach ($quiz_files as $file) {
            $content = file_get_contents($file);
            $data = json_decode($content, true);
            if (isset($data['id']) && $data['id'] === $quiz_id) {
                $quiz_data = $data;
                break;
            }
        }
    }
    ?>
    <div class="max-w-5xl mx-auto p-4 md:p-8 w-full">
        <header class="mb-8 md:mb-10">
            <h1 class="text-2xl md:text-4xl font-bold"><?php echo $is_editing ? 'Modifier le Quiz' : 'Créer un Quiz'; ?></h1>
        </header>

        <section class="bg-white rounded-2xl shadow p-5 md:p-6">
            <form id="quiz-form" action="save-quiz.php" method="POST">
                <input type="hidden" name="quiz_id" value="<?php echo htmlspecialchars($quiz_id ?? ''); ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="main_title" class="block text-sm font-medium text-gray-700">Titre principal</label>
                        <input type="text" id="main_title" name="main_title" value="<?php echo htmlspecialchars($quiz_data['main_title'] ?? ''); ?>" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="level" class="block text-sm font-medium text-gray-700">Niveau</label>
                        <select id="level" name="level" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <?php foreach ($levels as $level): ?>
                                <option value="<?php echo $level; ?>" <?php echo (isset($quiz_data['level']) && $quiz_data['level'] === $level) ? 'selected' : ''; ?>>
                                    <?php echo $level; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="card_description" class="block text-sm font-medium text-gray-700">Description de la carte</label>
                    <textarea id="card_description" name="card_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"><?php echo htmlspecialchars($quiz_data['card_description'] ?? ''); ?></textarea>
                </div>

                <div class="mt-6">
                    <label for="themes" class="block text-sm font-medium text-gray-700">Thèmes</label>
                    <select id="themes" name="themes[]" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <?php foreach ($themes as $theme): ?>
                            <option value="<?php echo $theme; ?>" <?php echo (isset($quiz_data['themes']) && in_array($theme, $quiz_data['themes'])) ? 'selected' : ''; ?>>
                                <?php echo $theme; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mt-10">
                    <h2 class="text-xl font-semibold mb-4">Questions</h2>
                    <div id="questions-container" class="space-y-6">
                        <!-- Questions will be added here by JavaScript -->
                    </div>
                    <button type="button" id="add-question-btn" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Ajouter une question
                    </button>
                </div>

                <div class="mt-8 border-t pt-6 flex justify-end">
                    <button type="submit" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition">
                        Sauvegarder le quiz
                    </button>
                </div>
            </form>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const questionsContainer = document.getElementById('questions-container');
            const addQuestionBtn = document.getElementById('add-question-btn');
            let questions = <?php echo json_encode($quiz_data['questions'] ?? []); ?>;

            function renderQuestions() {
                questionsContainer.innerHTML = '';
                questions.forEach((q, index) => {
                    const questionElement = document.createElement('div');
                    questionElement.className = 'p-4 border rounded-lg';
                    questionElement.innerHTML = `
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium">Question ${index + 1}</h3>
                            <button type="button" class="remove-question-btn text-red-500 hover:text-red-700" data-index="${index}">Supprimer</button>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Texte de la question</label>
                            <input type="text" value="${q.question || ''}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" onchange="updateQuestion(this.value, ${index}, 'question')">
                        </div>
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Type de sélection</label>
                                <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" onchange="updateQuestion(this.value, ${index}, 'selectionType')">
                                    <option value="single" ${q.selectionType === 'single' ? 'selected' : ''}>Unique</option>
                                    <option value="multi" ${q.selectionType === 'multi' ? 'selected' : ''}>Multiple</option>
                                    <!-- Add other types as needed -->
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Thème de la question</label>
                                <select class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" onchange="updateQuestion(this.value, ${index}, 'theme')">
                                    <?php foreach ($themes as $theme): ?>
                                        <option value="<?php echo $theme; ?>" ${q.theme === '<?php echo $theme; ?>' ? 'selected' : ''}>
                                            <?php echo $theme; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Feedback (correct)</label>
                            <input type="text" value="${q.feedback_correct || ''}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" onchange="updateQuestion(this.value, ${index}, 'feedback_correct')">
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Feedback (incorrect)</label>
                            <input type="text" value="${q.feedback_incorrect || ''}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" onchange="updateQuestion(this.value, ${index}, 'feedback_incorrect')">
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Pertinence</label>
                            <textarea rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" onchange="updateQuestion(this.value, ${index}, 'relevance')">${q.relevance || ''}</textarea>
                        </div>
                        <div class="mt-4">
                            <h4 class="text-md font-medium">Options</h4>
                            <div class="options-container space-y-2 mt-2">
                                ${renderOptions(q.options || [], index)}
                            </div>
                            <button type="button" class="add-option-btn mt-2 text-sm text-indigo-600 hover:text-indigo-800" data-index="${index}">Ajouter une option</button>
                        </div>
                    `;
                    questionsContainer.appendChild(questionElement);
                });
            }

            function renderOptions(options, questionIndex) {
                return options.map((opt, optIndex) => `
                    <div class="flex items-center gap-2">
                        <input type="text" value="${opt.label || ''}" class="flex-grow rounded-md border-gray-300 shadow-sm" onchange="updateOption(${questionIndex}, ${optIndex}, 'label', this.value)">
                        <input type="number" value="${opt.points || 0}" class="w-20 rounded-md border-gray-300 shadow-sm" onchange="updateOption(${questionIndex}, ${optIndex}, 'points', this.value)">
                        <button type="button" class="remove-option-btn text-red-500 hover:text-red-700" data-q-index="${questionIndex}" data-opt-index="${optIndex}">X</button>
                    </div>
                `).join('');
            }

            window.updateQuestion = (value, index, field) => {
                questions[index][field] = value;
            };

            window.updateOption = (qIndex, optIndex, field, value) => {
                questions[qIndex].options[optIndex][field] = value;
            };

            addQuestionBtn.addEventListener('click', () => {
                questions.push({
                    question: '',
                    selectionType: 'single',
                    options: [{ label: '', points: 1 }]
                });
                renderQuestions();
            });

            questionsContainer.addEventListener('click', (e) => {
                if (e.target.classList.contains('remove-question-btn')) {
                    const index = parseInt(e.target.dataset.index, 10);
                    questions.splice(index, 1);
                    renderQuestions();
                } else if (e.target.classList.contains('add-option-btn')) {
                    const index = parseInt(e.target.dataset.index, 10);
                    questions[index].options.push({ label: '', points: 0 });
                    renderQuestions();
                } else if (e.target.classList.contains('remove-option-btn')) {
                    const qIndex = parseInt(e.target.dataset.qIndex, 10);
                    const optIndex = parseInt(e.target.dataset.optIndex, 10);
                    questions[qIndex].options.splice(optIndex, 1);
                    renderQuestions();
                }
            });

            document.getElementById('quiz-form').addEventListener('submit', function(e) {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'questions_json';
                hiddenInput.value = JSON.stringify(questions);
                this.appendChild(hiddenInput);
            });

            renderQuestions();
        });
    </script>
    <?php include '../footer.php'; ?>
</body>
</html>
