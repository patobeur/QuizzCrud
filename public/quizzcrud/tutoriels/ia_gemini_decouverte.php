<!-- Contenu spécifique au tutoriel Gemini (gemini.google.com) -->

<!-- Styles spécifiques (identiques à ton template) -->
<style>
    .fade-in {
        opacity: 0;
        transform: translateY(8px);
        transition: all .5s ease
    }

    .fade-in.visible {
        opacity: 1;
        transform: translateY(0)
    }

    .code {
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace
    }

    .toc a {
        display: block;
        padding: .25rem .5rem;
        border-radius: .5rem
    }

    .toc a.active {
        background: rgb(59 130 246 / .12);
        color: rgb(37 99 235)
    }
</style>

<!-- Titre principal -->
<div class="max-w-6xl mx-auto px-4 mt-6">
    <h1 class="text-2xl sm:text-3xl font-bold tracking-tight mb-4">
        DÉMARRER AVEC <span class="text-blue-600 dark:text-blue-400">GEMINI</span> — Web app (gemini.google.com)
    </h1>
</div>

<!-- Onglets -->
<div class="max-w-6xl mx-auto px-4 mt-2">
    <div class="inline-flex w-full overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800 bg-white/90 dark:bg-slate-900/90 backdrop-blur p-1 shadow-sm gap-1">
        <button data-tab="tab-decouverte" class="tab-btn px-4 py-2 rounded-lg text-sm font-semibold bg-blue-600 text-white whitespace-nowrap">Découverte</button>
        <button data-tab="tab-images-videos" class="tab-btn px-4 py-2 rounded-lg text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 whitespace-nowrap">Images & Vidéos</button>
        <button data-tab="tab-avance" class="tab-btn px-4 py-2 rounded-lg text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 whitespace-nowrap">Aller plus loin</button>
    </div>
</div>

<div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-[260px,1fr] gap-6 px-4 py-6">
    <!-- TOC Sidebar -->
    <aside class="lg:block bg-white/70 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 h-max sticky top-20 hidden" id="toc">
        <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400 mb-2">Sommaire</h2>
        <nav class="toc text-sm space-y-1" id="tocLinks"></nav>
        <div class="mt-4 flex flex-col gap-2">
            <a href="tutoriels/downloads/gemini-cheatsheet.pdf" class="px-3 py-2 text-center rounded-md border border-slate-300 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 text-sm">Télécharger la cheatsheet (PDF)</a>
            <a href="tutoriels/downloads/gemini-prompts-exemples.zip" class="px-3 py-2 text-center rounded-md border border-slate-300 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 text-sm">Pack d’exemples (ZIP)</a>
        </div>
    </aside>

    <!-- Main -->
    <main id="content" class="space-y-8">
        <!-- TAB: Découverte -->
        <section id="tab-decouverte" class="tab-panel space-y-6" data-anchor-title="Découverte">
            <article class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm fade-in" id="gmi-intro">
                <h2 class="text-lg font-bold">1) Mise en route (interface & modèles)</h2>
                <p class="mt-2">Rendez-vous sur <strong>gemini.google.com</strong>. En haut au centre, vous verrez le
                    <em>sélecteur de modèle</em> (ex. <strong>2.5 Flash</strong>, <strong>2.5 Pro</strong> selon les comptes),
                    la zone de prompt au milieu, et à gauche l’accès aux conversations récentes. Un bouton <em>micro</em> permet de dicter un prompt.
                </p>
                <figure class="mt-4">
                    <img src="tutoriels/gemini/img/accueil.png" alt="Accueil Gemini web : champ de prompt, sélecteur de modèle, actions" class="w-sm rounded-xl border border-slate-200 dark:border-slate-800" />
                    <figcaption class="text-xs text-slate-500 dark:text-slate-400 mt-1">(Capture) Page d’accueil de Gemini web (ex. “Bonjour”).</figcaption>
                </figure>
            </article>

            <article class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm fade-in" id="gmi-test1">
                <h3 class="text-lg font-bold">2) Test #1 — Bon prompt & choix de modèle</h3>
                <p class="mb-2">Objectif : *voir la différence entre un prompt vague et un prompt cadré*, et tester le changement de modèle.</p>
                <ol class="list-decimal pl-5 space-y-1">
                    <li>Dans Gemini, tape : <span class="code bg-slate-100 dark:bg-slate-800 px-1 rounded">Écris un plan de cours d’1h sur INDEX et EQUIV</span> puis **valide**.</li>
                    <li>Puis reformule précisément : <span class="code bg-slate-100 dark:bg-slate-800 px-1 rounded">Tu es formateur Excel. Fais un plan d’1h avec objectifs, déroulé minute par minute, 3 exercices, critères d’évaluation. Format en liste.</span></li>
                    <li>Bascule de **2.5 Flash** (rapide) à **2.5 Pro** (plus “réfléchi” selon l’offre) et **relance** le prompt cadré.</li>
                </ol>
                <details class="group border border-slate-200 dark:border-slate-800 rounded-xl p-4 mt-3 open:bg-slate-50 dark:open:bg-slate-900/40">
                    <summary class="cursor-pointer font-semibold">Ce qu’on observe</summary>
                    <ul class="mt-2 list-disc pl-5">
                        <li>Réponses plus structurées avec le prompt cadré (rôles, format attendu).</li>
                        <li>Différences de style/qualité entre **Flash** et **Pro** (selon disponibilité de ton compte).</li>
                    </ul>
                </details>
            </article>
        </section>

        <!-- TAB: Images & Vidéos -->
        <section id="tab-images-videos" class="tab-panel hidden space-y-6" data-anchor-title="Images & Vidéos">
            <article class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm fade-in" id="gmi-test2">
                <h2 class="text-lg font-bold">3) Test #2 — Importer une image puis l’éditer</h2>
                <p class="mt-2">Gemini autorise l’<strong>upload d’images</strong> dans la web app. Tu peux demander des retouches simples (recadrage, suppression d’arrière-plan, ajout d’objets) ou des analyses (extraction de texte, description).</p>
                <ol class="list-decimal pl-5 space-y-1">
                    <li>Cliquer sur <em>Ajouter des fichiers</em> (icône trombone ou image) → sélectionne une photo produit.</li>
                    <li>Prompt : <span class="code bg-slate-100 dark:bg-slate-800 px-1 rounded">Supprime l’arrière-plan et remplace par un fond blanc doux. Donne-moi aussi un titre SEO (60–65 caractères) + 3 puces.</span></li>
                    <li>Essaye une **variante** : <span class="code bg-slate-100 dark:bg-slate-800 px-1 rounded">Génère une vignette 1000×1000 adaptée à une fiche e-commerce.</span></li>
                </ol>
                <figure class="mt-4">
                    <img src="tutoriels/gemini/img/upload_image.png" alt="Bouton Ajouter des fichiers dans la zone de prompt" class="w-sm rounded-xl border border-slate-200 dark:border-slate-800" />
                    <figcaption class="text-xs text-slate-500 dark:text-slate-400 mt-1">(Capture) Ajout d’image dans Gemini web.</figcaption>
                </figure>
            </article>

            <article class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm fade-in" id="gmi-test3">
                <h2 class="text-lg font-bold">4) Test #3 — Analyser une vidéo courte</h2>
                <p class="mt-2">Gemini peut <strong>analyser une vidéo</strong> (fichier court) ou un **lien YouTube** pour en tirer un résumé, des chapitres, ou trouver un passage précis.</p>
                <ol class="list-decimal pl-5 space-y-1">
                    <li>Charge une vidéo ≤ 5 min <em>(ou colle un lien YouTube public)</em>.</li>
                    <li>Prompt : <span class="code bg-slate-100 dark:bg-slate-800 px-1 rounded">Donne un résumé en 5 points + la liste des actions mentionnées avec timecodes.</span></li>
                    <li>Variante : <span class="code bg-slate-100 dark:bg-slate-800 px-1 rounded">À quel moment on parle de &lt;concept&gt; ? Donne le timestamp exact et un extrait.</span></li>
                </ol>
                <figure class="mt-4">
                    <img src="tutoriels/gemini/img/analyse_video.png" alt="Analyse vidéo dans Gemini web" class="w-sm rounded-xl border border-slate-200 dark:border-slate-800" />
                    <figcaption class="text-xs text-slate-500 dark:text-slate-400 mt-1">(Capture) Chargement/Analyse d’une vidéo.</figcaption>
                </figure>
            </article>
        </section>

        <!-- TAB: Aller plus loin -->
        <section id="tab-avance" class="tab-panel hidden space-y-6" data-anchor-title="Aller plus loin">
            <article class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm fade-in" id="gmi-bonus">
                <h2 class="text-lg font-bold">5) Bonus — “Deep Research”, extensions & exports</h2>
                <ul class="list-disc pl-5 space-y-1">
                    <li><strong>Deep Research (Gemini Advanced, EN)</strong> : demande une <em>recherche multi-étapes</em> avec plan, sources et export Google Docs.</li>
                    <li><strong>Lire à voix haute</strong> & micro : écoute une réponse ou **dicte** ton prompt (pratique sur mobile).</li>
                    <li><strong>Exports</strong> : copie rapide, transfert vers Docs/Sheets, ou sauvegarde dans un projet.</li>
                </ul>
                <details class="group border border-slate-200 dark:border-slate-800 rounded-xl p-4 mt-3">
                    <summary class="cursor-pointer font-semibold">Exemple Deep Research (si dispo)</summary>
                    <pre class="code bg-slate-900 text-slate-50 p-3 rounded-lg overflow-x-auto">Fais une revue de littérature sur l'usage des LLM en classe de BTS (FR & EN) :\n- étapes et mots-clés de recherche\n- 8 sources récentes fiables (lien + 2 phrases de synthèse)\n- tableau comparatif (critères, forces/faiblesses)\n- exporte vers Google Docs</pre>
                </details>
            </article>
        </section>
        <!-- ANNEXE — Galerie d’images complète -->
        <section id="galerie-gemini" class="space-y-6" data-anchor-title="Annexes — Galerie d’images">
            <article class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm fade-in">
                <h2 class="text-lg font-bold">Annexes — Galerie d’images (Gemini)</h2>
                <p class="text-sm text-slate-600 dark:text-slate-400">Toutes les captures évoquées dans le tuto, regroupées ici. Remplace les <code class="code">src</code> par tes propres fichiers si besoin.</p>
                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <figure class="bg-white/40 dark:bg-slate-900/40 rounded-xl p-3 border border-slate-200 dark:border-slate-800"><img src="tutoriels/gemini/img/accueil.png" alt="Accueil Gemini web" class="w-sm rounded-lg border border-slate-200 dark:border-slate-800" />
                        <figcaption class="text-xs text-slate-500 dark:text-slate-400 mt-1">Accueil</figcaption>
                    </figure>
                    <figure class="bg-white/40 dark:bg-slate-900/40 rounded-xl p-3 border border-slate-200 dark:border-slate-800"><img src="tutoriels/gemini/img/select_modele.png" alt="Sélecteur de modèle" class="w-sm rounded-lg border border-slate-200 dark:border-slate-800" />
                        <figcaption class="text-xs">Sélecteur de modèle</figcaption>
                    </figure>
                    <figure class="bg-white/40 dark:bg-slate-900/40 rounded-xl p-3 border border-slate-200 dark:border-slate-800"><img src="tutoriels/gemini/img/nouvelle_conversation.png" alt="Nouvelle conversation" class="w-sm rounded-lg border border-slate-200 dark:border-slate-800" />
                        <figcaption class="text-xs">Nouvelle conversation</figcaption>
                    </figure>

                    <figure class="bg-white/40 dark:bg-slate-900/40 rounded-xl p-3 border border-slate-200 dark:border-slate-800"><img src="tutoriels/gemini/img/prompt_vague.png" alt="Prompt vague" class="w-sm rounded-lg border border-slate-200 dark:border-slate-800" />
                        <figcaption class="text-xs">Prompt vague</figcaption>
                    </figure>
                    <figure class="bg-white/40 dark:bg-slate-900/40 rounded-xl p-3 border border-slate-200 dark:border-slate-800"><img src="tutoriels/gemini/img/prompt_cadre.png" alt="Prompt cadré" class="w-sm rounded-lg border border-slate-200 dark:border-slate-800" />
                        <figcaption class="text-xs">Prompt cadré</figcaption>
                    </figure>
                    <figure class="bg-white/40 dark:bg-slate-900/40 rounded-xl p-3 border border-slate-200 dark:border-slate-800"><img src="tutoriels/gemini/img/historique.png" alt="Historique de conversation" class="w-sm rounded-lg border border-slate-200 dark:border-slate-800" />
                        <figcaption class="text-xs">Historique</figcaption>
                    </figure>

                    <figure class="bg-white/40 dark:bg-slate-900/40 rounded-xl p-3 border border-slate-200 dark:border-slate-800"><img src="tutoriels/gemini/img/upload_image.png" alt="Upload image" class="w-sm rounded-lg border border-slate-200 dark:border-slate-800" />
                        <figcaption class="text-xs">Upload image</figcaption>
                    </figure>
                    <figure class="bg-white/40 dark:bg-slate-900/40 rounded-xl p-3 border border-slate-200 dark:border-slate-800"><img src="tutoriels/gemini/img/avant.png" alt="Avant retouche" class="w-sm rounded-lg border border-slate-200 dark:border-slate-800" />
                        <figcaption class="text-xs">Avant retouche</figcaption>
                    </figure>
                    <figure class="bg-white/40 dark:bg-slate-900/40 rounded-xl p-3 border border-slate-200 dark:border-slate-800"><img src="tutoriels/gemini/img/apres.png" alt="Après retouche" class="w-sm rounded-lg border border-slate-200 dark:border-slate-800" />
                        <figcaption class="text-xs">Après retouche</figcaption>
                    </figure>

                    <figure class="bg-white/40 dark:bg-slate-900/40 rounded-xl p-3 border border-slate-200 dark:border-slate-800"><img src="tutoriels/gemini/img/ocr.png" alt="OCR depuis image" class="w-sm rounded-lg border border-slate-200 dark:border-slate-800" />
                        <figcaption class="text-xs">OCR sur image</figcaption>
                    </figure>
                    <figure class="bg-white/40 dark:bg-slate-900/40 rounded-xl p-3 border border-slate-200 dark:border-slate-800"><img src="tutoriels/gemini/img/analyse_video.png" alt="Analyse vidéo" class="w-sm rounded-lg border border-slate-200 dark:border-slate-800" />
                        <figcaption class="text-xs">Analyse vidéo</figcaption>
                    </figure>
                    <figure class="bg-white/40 dark:bg-slate-900/40 rounded-xl p-3 border border-slate-200 dark:border-slate-800"><img src="tutoriels/gemini/img/youtube_link.png" alt="Lien YouTube" class="w-sm rounded-lg border border-slate-200 dark:border-slate-800" />
                        <figcaption class="text-xs">Lien YouTube</figcaption>
                    </figure>

                    <figure class="bg-white/40 dark:bg-slate-900/40 rounded-xl p-3 border border-slate-200 dark:border-slate-800"><img src="tutoriels/gemini/img/chapitres.png" alt="Chapitres et timecodes" class="w-sm rounded-lg border border-slate-200 dark:border-slate-800" />
                        <figcaption class="text-xs">Chapitres & timecodes</figcaption>
                    </figure>
                    <figure class="bg-white/40 dark:bg-slate-900/40 rounded-xl p-3 border border-slate-200 dark:border-slate-800"><img src="tutoriels/gemini/img/deep_research.png" alt="Deep Research" class="w-sm rounded-lg border border-slate-200 dark:border-slate-800" />
                        <figcaption class="text-xs">Deep Research</figcaption>
                    </figure>
                    <figure class="bg-white/40 dark:bg-slate-900/40 rounded-xl p-3 border border-slate-200 dark:border-slate-800"><img src="tutoriels/gemini/img/export_docs.png" alt="Exporter vers Google Docs" class="w-sm rounded-lg border border-slate-200 dark:border-slate-800" />
                        <figcaption class="text-xs">Export Google Docs</figcaption>
                    </figure>
                </div>
            </article>
        </section>

    </main>
</div>

<!-- Scripts (identiques au template) -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tabs
        const tabBtns = document.querySelectorAll('.tab-btn');
        const panels = document.querySelectorAll('.tab-panel');
        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-tab');
                tabBtns.forEach(b => b.classList.remove('bg-blue-600', 'text-white'));
                btn.classList.add('bg-blue-600', 'text-white');
                panels.forEach(p => p.classList.add('hidden'));
                document.getElementById(id).classList.remove('hidden');
                document.getElementById(id).querySelectorAll('.fade-in').forEach(el => el.classList.add('visible'));
                buildTOC(); // refresh TOC for current tab
            });
        });

        // Accordions
        document.querySelectorAll('.acc-btn').forEach(btn => {
            const panel = btn.nextElementSibling;
            panel.classList.remove('hidden'); // open by default
            btn.addEventListener('click', () => {
                panel.classList.toggle('hidden');
                const chev = btn.querySelector('.chev');
                if (chev) {
                    chev.textContent = panel.classList.contains('hidden') ? '▸' : '▾';
                }
            });
        });

        // Fade-in on scroll
        const obs = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) e.target.classList.add('visible');
            });
        }, {
            threshold: 0.12
        });
        document.querySelectorAll('.fade-in').forEach(el => obs.observe(el));

        // Build anchors & TOC
        function slugify(text) {
            return text.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9\-]/g, '').replace(/\-+/g, '-').replace(/^-+|-+$/g, '');
        }

        function buildTOC() {
            const current = Array.from(document.querySelectorAll('.tab-panel')).find(p => !p.classList.contains('hidden'));
            const links = document.getElementById('tocLinks');
            if (!links) return;
            links.innerHTML = '';
            if (!current) return;
            const headings = current.querySelectorAll('h2, h3');
            headings.forEach(h => {
                if (!h.id) {
                    h.id = slugify(h.textContent.trim());
                }
                const a = document.createElement('a');
                a.href = `#${h.id}`;
                a.textContent = h.textContent.trim();
                a.className = h.tagName === 'H2' ? 'font-semibold' : 'ml-3';
                links.appendChild(a);
            });
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    const id = entry.target.id;
                    const el = links.querySelector(`a[href="#${CSS.escape(id)}"]`);
                    if (!el) return;
                    if (entry.isIntersecting) {
                        links.querySelectorAll('a').forEach(x => x.classList.remove('active'));
                        el.classList.add('active');
                    }
                });
            }, {
                rootMargin: '-40% 0px -55% 0px'
            });
            headings.forEach(h => observer.observe(h));
        }
        buildTOC();
    });
</script>