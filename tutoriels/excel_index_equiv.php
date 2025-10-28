<!-- Contenu spécifique au tutoriel Excel INDEX/EQUIV -->

<!-- Styles spécifiques (si nécessaire) -->
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
  <h1 class="text-2xl sm:text-3xl font-bold tracking-tight mb-4">EXCEL — <span class="text-blue-600 dark:text-blue-400">INDEX</span>, <span class="text-blue-600 dark:text-blue-400">EQUIV</span>, <span class="text-blue-600 dark:text-blue-400">INDEX+EQUIV</span></h1>
</div>

<!-- Onglets -->
<div class="max-w-6xl mx-auto px-4 mt-2">
  <div class="inline-flex w-full overflow-x-auto rounded-xl border border-slate-200 dark:border-slate-800 bg-white/90 dark:bg-slate-900/90 backdrop-blur p-1 shadow-sm gap-1">
    <button data-tab="tab-index" class="tab-btn px-4 py-2 rounded-lg text-sm font-semibold bg-blue-600 text-white whitespace-nowrap">Feuille INDEX</button>
    <button data-tab="tab-equiv" class="tab-btn px-4 py-2 rounded-lg text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 whitespace-nowrap">Feuille EQUIV</button>
    <button data-tab="tab-index-equiv" class="tab-btn px-4 py-2 rounded-lg text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 whitespace-nowrap">Feuille INDEX+EQUIV</button>
  </div>
</div>

<div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-[260px,1fr] gap-6 px-4 py-6">
  <!-- TOC Sidebar -->
  <aside class="lg:block bg-white/70 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 h-max sticky top-20 hidden" id="toc">
    <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400 mb-2">Sommaire</h2>
    <nav class="toc text-sm space-y-1" id="tocLinks"></nav>
    <div class="mt-4 flex flex-col gap-2">
      <a target="_blank" href="/tutoriels/downloads/index_equiv_exercices.xlsx" class="px-3 py-2 text-center rounded-md border border-slate-300 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 text-sm">Télécharger exercices (Excel)</a>
      <a target="_blank" href="/tutoriels/downloads/index_equiv_correction.xlsx" class="px-3 py-2 text-center rounded-md border border-slate-300 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 text-sm">Télécharger correction (Excel)</a>
      <a target="_blank" href="/tutoriels/downloads/index_equiv_exercices.pdf" class="px-3 py-2 text-center rounded-md border border-slate-300 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 text-sm">Télécharger support (Excel)</a>
    </div>
  </aside>

  <!-- Main -->
  <main id="content" class="space-y-8">
    <!-- Le reste du contenu HTML du tutoriel va ici, en adaptant les chemins des images -->
    <!-- TAB: INDEX -->
    <section id="tab-index" class="tab-panel space-y-6" data-anchor-title="Feuille INDEX">
      <article class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm fade-in" id="index-intro">
        <h2 class="text-lg font-bold">1) Mise en situation</h2>
        <p class="mt-2">Imagine un <strong>tableau à double entrée</strong> : en lignes, des <strong>produits</strong> (A2:A6) ; en colonnes, des <strong>trimestres</strong> T1–T3 (B1:D1). On veut pouvoir <strong>pointer n’importe quelle case</strong> sans la souris, uniquement avec ses coordonnées (ligne/colonne). C’est exactement ce que fait <strong>INDEX</strong> : on lui donne une <em>matrice</em>, un <em>numéro de ligne</em> et, si besoin, un <em>numéro de colonne</em>, et il renvoie la <strong>valeur</strong>.</p>
        <!-- Image placeholder -->
        <figure class="mt-4">
          <img src="/tutoriels/img/000001.png" alt="Capture tableau Produits x T1..T3" class="w-sm rounded-xl border border-slate-200 dark:border-slate-800" />
          <figcaption class="text-xs text-slate-500 dark:text-slate-400 mt-1">(Capture) Tableau Produits × Trimestres.</figcaption>
        </figure>
      </article>

      <article class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm fade-in" id="index-prereq">
        <button class="acc-btn w-full text-left">
          <h3 class="text-lg font-bold flex items-center justify-between">2) Ce qu’il faut comprendre avant de taper la moindre formule <span class="chev text-slate-400">▾</span></h3>
        </button>
        <div class="acc-panel mt-3 space-y-2">
          <p><strong>La matrice</strong> (ou plage) n’est pas toute la feuille, mais <strong>le rectangle choisi</strong>. Ici : <code class="code bg-slate-100 dark:bg-slate-800 px-1 rounded">B2:D6</code>.</p>
          <p>Les <strong>numéros de ligne/colonne sont relatifs à la matrice</strong>. Dans <code class="code bg-slate-100 dark:bg-slate-800 px-1 rounded">B2:D6</code> : ligne 1 = ligne 2 de la feuille (Produit A) ; colonne 1 = colonne B (T1).</p>
          <p>Si la matrice est <strong>une seule colonne</strong>, on n’indique pas de colonne dans INDEX.</p>
          <!-- Diagram placeholder -->
          <figure class="mt-3">
            <img src="/tutoriels/img/000002.png" alt="Diagramme indices dans la matrice" class="w-sm rounded-xl border border-slate-200 dark:border-slate-800" />
            <figcaption class="text-xs text-slate-500 dark:text-slate-400 mt-1">(Diagramme) Numérotation relative des lignes/colonnes dans la matrice.</figcaption>
          </figure>
        </div>
      </article>

      <article class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm fade-in" id="index-formula">
        <button class="acc-btn w-full text-left">
          <h3 class="text-lg font-bold flex items-center justify-between">3) La formule, expliquée <span class="chev text-slate-400">▾</span></h3>
        </button>
        <div class="acc-panel mt-3 space-y-3">
          <div>
            <div class="text-sm uppercase tracking-wide text-slate-500 dark:text-slate-400 font-semibold mb-1">Syntaxe (FR)</div>
            <pre class="code bg-slate-900 text-slate-50 p-3 rounded-lg overflow-x-auto">=INDEX(matrice; no_ligne; [no_colonne])</pre>
          </div>
          <ul class="list-disc pl-5">
            <li><strong>matrice</strong> : ex. <code class="code bg-slate-100 dark:bg-slate-800 px-1 rounded">B2:D6</code></li>
            <li><strong>no_ligne</strong> : position dans la matrice (1, 2, 3…)</li>
            <li><strong>no_colonne</strong> : position de la colonne (optionnel si une seule colonne)</li>
          </ul>
        </div>
      </article>

      <article class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm fade-in" id="index-demos">
        <h3 class="text-lg font-bold mb-3">4) Démonstration guidée</h3>
        <details class="group border border-slate-200 dark:border-slate-800 rounded-xl p-4 mb-3 open:bg-slate-50 dark:open:bg-slate-900/40">
          <summary class="cursor-pointer font-semibold">Exercice 1 — Atteindre une case par coordonnées</summary>
          <div class="mt-2 space-y-2">
            <p><strong>Objectif</strong> : valeur <strong>ligne 3, colonne 2</strong> dans <code class="code bg-slate-100 dark:bg-slate-800 px-1 rounded">B2:D6</code> (écrire en <strong>G3</strong>).</p>
            <pre class="code bg-slate-900 text-slate-50 p-3 rounded-lg overflow-x-auto">=INDEX(B2:D6; 3; 2)</pre>
            <p><strong>Résultat</strong> : <code class="code">160</code></p>
          </div>
        </details>
        <details class="group border border-slate-200 dark:border-slate-800 rounded-xl p-4 mb-3">
          <summary class="cursor-pointer font-semibold">Exercice 2 — Index sur une colonne simple</summary>
          <div class="mt-2 space-y-2">
            <p><strong>Objectif</strong> : renvoyer la <strong>5ᵉ</strong> valeur de <code class="code bg-slate-100 dark:bg-slate-800 px-1 rounded">D2:D6</code> (écrire en <strong>G6</strong>).</p>
            <pre class="code bg-slate-900 text-slate-50 p-3 rounded-lg overflow-x-auto">=INDEX(D2:D6; 5)</pre>
            <p><strong>Résultat</strong> : <code class="code">120</code></p>
          </div>
        </details>
        <details class="group border border-slate-200 dark:border-slate-800 rounded-xl p-4">
          <summary class="cursor-pointer font-semibold">Exercice 3 — INDEX qui renvoie toute une ligne</summary>
          <div class="mt-2 space-y-2">
            <p><strong>Objectif</strong> : renvoyer <strong>toute la ligne 2</strong> de <code class="code bg-slate-100 dark:bg-slate-800 px-1 rounded">B2:D6</code> et l’<strong>afficher en B9:D9</strong>.</p>
            <pre class="code bg-slate-900 text-slate-50 p-3 rounded-lg overflow-x-auto">=INDEX($B$2:$D$6; 2; )</pre>
            <p><strong>Résultat</strong> : <code class="code">85 | 95 | 100</code> (selon version, Ctrl+Maj+Entrée)</p>
          </div>
        </details>
      </article>
    </section>

    <!-- TAB: EQUIV -->
    <section id="tab-equiv" class="tab-panel hidden space-y-6" data-anchor-title="Feuille EQUIV">
      <article class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm fade-in" id="equiv-intro">
        <h2 class="text-lg font-bold">1) Mise en situation</h2>
        <p class="mt-2">On dispose de listes et de tables (noms, codes, seuils…). <strong>EQUIV</strong> sert à retrouver la <strong>POSITION</strong> d’un élément dans une <strong>plage</strong> (1, 2, 3, …). Ensuite on combine avec <strong>INDEX</strong> pour renvoyer la valeur associée.</p>
        <figure class="mt-4">
          <img src="/tutoriels/img/000003.png" alt="Capture liste Fruits et Seuils" class="w-sm rounded-xl border border-slate-200 dark:border-slate-800" />
          <figcaption class="text-xs text-slate-500 dark:text-slate-400 mt-1">(Capture) Liste des fruits & seuils de remise.</figcaption>
        </figure>
      </article>

      <article class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm fade-in" id="equiv-prereq">
        <button class="acc-btn w-full text-left">
          <h3 class="text-lg font-bold flex items-center justify-between">2) Ce qu’il faut comprendre avant de taper la moindre formule <span class="chev text-slate-400">▾</span></h3>
        </button>
        <div class="acc-panel mt-3 space-y-2">
          <p><strong>EQUIV</strong> renvoie une <strong>position</strong>, pas une valeur.</p>
          <p>Le 3ᵉ argument (<em>type</em>) contrôle la recherche : <strong>0</strong> exacte, <strong>1</strong> approximative <em>croissante</em>, <strong>-1</strong> approximative <em>décroissante</em>.</p>
          <p>Pour <strong>1</strong> et <strong>-1</strong>, la plage doit être <strong>triée</strong> dans le bon sens.</p>
        </div>
      </article>

      <article class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm fade-in" id="equiv-formula">
        <button class="acc-btn w-full text-left">
          <h3 class="text-lg font-bold flex items-center justify-between">3) La formule, expliquée <span class="chev text-slate-400">▾</span></h3>
        </button>
        <div class="acc-panel mt-3 space-y-3">
          <div>
            <div class="text-sm uppercase tracking-wide text-slate-500 dark:text-slate-400 font-semibold mb-1">Syntaxe (FR)</div>
            <pre class="code bg-slate-900 text-slate-50 p-3 rounded-lg overflow-x-auto">=EQUIV(valeur_cherchée; plage_recherche; [type])</pre>
          </div>
          <ul class="list-disc pl-5">
            <li><strong>0</strong> : exact (plage non triée OK)</li>
            <li><strong>1</strong> : approx. (plage triée <em>croissante</em>) → plus grande valeur ≤ la valeur cherchée</li>
            <li><strong>-1</strong> : approx. (plage triée <em>décroissante</em>) → plus petite valeur ≥ la valeur cherchée</li>
          </ul>
        </div>
      </article>

      <article class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm fade-in" id="equiv-demos">
        <h3 class="text-lg font-bold mb-3">4) Démonstration guidée</h3>
        <details class="group border border-slate-200 dark:border-slate-800 rounded-xl p-4 mb-3 open:bg-slate-50 dark:open:bg-slate-900/40">
          <summary class="cursor-pointer font-semibold">Exercice 1 — Recherche exacte (type = 0)</summary>
          <div class="mt-2 space-y-2">
            <p><strong>Objectif</strong> : position de <strong>"Cerise"</strong> dans <code class="code bg-slate-100 dark:bg-slate-800 px-1 rounded">A2:A7</code> (écrire en <strong>E3</strong>).</p>
            <pre class="code bg-slate-900 text-slate-50 p-3 rounded-lg overflow-x-auto">=EQUIV("Cerise"; A2:A7; 0)</pre>
            <p><strong>Résultat</strong> : <code class="code">3</code></p>
          </div>
        </details>
        <details class="group border border-slate-200 dark:border-slate-800 rounded-xl p-4 mb-3">
          <summary class="cursor-pointer font-semibold">Exercice 2 — Approximative croissante (type = 1)</summary>
          <div class="mt-2 space-y-2">
            <p><strong>Objectif</strong> : pour <strong>43 unités</strong>, position dans les <strong>seuils croissants</strong> <code class="code bg-slate-100 dark:bg-slate-800 px-1 rounded">A10:A13</code> (=10, 20, 50, 100) — écrire en <strong>E10</strong>.</p>
            <pre class="code bg-slate-900 text-slate-50 p-3 rounded-lg overflow-x-auto">=EQUIV(43; A10:A13; 1)</pre>
            <p><strong>Résultat</strong> : <code class="code">2</code> (plus grande valeur ≤ 43 = 20, 2ᵉ position)</p>
            <p><strong>Remise (%) associée</strong> :</p>
            <pre class="code bg-slate-900 text-slate-50 p-3 rounded-lg overflow-x-auto">=INDEX(B10:B13; EQUIV(43; A10:A13; 1))</pre>
            <p><strong>Résultat</strong> : <code class="code">8%</code></p>
          </div>
        </details>
        <details class="group border border-slate-200 dark:border-slate-800 rounded-xl p-4">
          <summary class="cursor-pointer font-semibold">Exercice 3 — Approximative décroissante (type = -1)</summary>
          <div class="mt-2 space-y-2">
            <p><strong>Objectif</strong> : sur la liste <strong>décroissante</strong> <code class="code bg-slate-100 dark:bg-slate-800 px-1 rounded">M9:M12</code> (=100, 50, 20, 10), position pour <strong>43</strong> (écrire en <strong>E12</strong>).</p>
            <pre class="code bg-slate-900 text-slate-50 p-3 rounded-lg overflow-x-auto">=EQUIV(43; M9:M12; -1)</pre>
            <p><strong>Résultat</strong> : <code class="code">2</code> (plus petite valeur ≥ 43 = 50, 2ᵉ position)</p>
          </div>
        </details>
      </article>
    </section>

    <!-- TAB: INDEX + EQUIV -->
    <section id="tab-index-equiv" class="tab-panel hidden space-y-6" data-anchor-title="Feuille INDEX+EQUIV">
      <article class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm fade-in" id="combo-intro">
        <h2 class="text-lg font-bold">1) Mise en situation</h2>
        <p class="mt-2">On veut des recherches <strong>flexibles</strong> : par <strong>nom de produit</strong>, par <strong>code</strong>, ou à l’<strong>intersection</strong> d’un <strong>commercial</strong> et d’un <strong>trimestre</strong>. <strong>EQUIV</strong> trouve la <strong>position</strong>, <strong>INDEX</strong> renvoie la <strong>valeur</strong>.</p>
        <figure class="mt-4">
          <img src="/tutoriels/img/000004.png" alt="Capture liste de prix et matrice commerciale" class="w-sm rounded-xl border border-slate-200 dark:border-slate-800" />
          <figcaption class="text-xs text-slate-500 dark:text-slate-400 mt-1">(Capture) Liste de prix & matrice commerciale.</figcaption>
        </figure>
      </article>

      <article class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm fade-in" id="combo-prereq">
        <button class="acc-btn w-full text-left">
          <h3 class="text-lg font-bold flex items-center justify-between">2) Ce qu’il faut comprendre avant de taper la moindre formule <span class="chev text-slate-400">▾</span></h3>
        </button>
        <div class="acc-panel mt-3 space-y-2">
          <p>On combine <strong>EQUIV (où ?)</strong> et <strong>INDEX (quoi ?)</strong>.</p>
          <p>Les plages <em>recherche</em> et <em>retour</em> doivent correspondre (même hauteur/largeur selon le cas).</p>
          <p>Encapsuler avec <code class="code bg-slate-100 dark:bg-slate-800 px-1 rounded">SI</code>/<code class="code bg-slate-100 dark:bg-slate-800 px-1 rounded">ET</code> ou <code class="code bg-slate-100 dark:bg-slate-800 px-1 rounded">SIERREUR</code> pour des messages propres.</p>
        </div>
      </article>

      <article class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm fade-in" id="combo-combos">
        <button class="acc-btn w-full text-left">
          <h3 class="text-lg font-bold flex items-center justify-between">3) Les combinaisons, expliquées simplement <span class="chev text-slate-400">▾</span></h3>
        </button>
        <div class="acc-panel mt-3 space-y-3">
          <div>
            <div class="text-sm uppercase tracking-wide text-slate-500 dark:text-slate-400 font-semibold mb-1">Recherche simple (1 critère)</div>
            <pre class="code bg-slate-900 text-slate-50 p-3 rounded-lg overflow-x-auto">=INDEX(colonne_retour; EQUIV(valeur; colonne_critère; 0))</pre>
          </div>
          <div>
            <div class="text-sm uppercase tracking-wide text-slate-500 dark:text-slate-400 font-semibold mb-1">Double entrée (ligne & colonne variables)</div>
            <pre class="code bg-slate-900 text-slate-50 p-3 rounded-lg overflow-x-auto">=INDEX(matrice; EQUIV(ligne; plage_lignes; 0); EQUIV(colonne; plage_colonnes; 0))</pre>
          </div>
        </div>
      </article>

      <article class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm fade-in" id="combo-demos">
        <h3 class="text-lg font-bold mb-3">4) Démonstration guidée (fidèle aux corrections)</h3>
        <div class="border border-slate-200 dark:border-slate-800 rounded-xl p-4 mb-4">
          <h4 class="font-semibold mb-2">Partie A — Liste de prix</h4>
          <p class="text-sm text-slate-600 dark:text-slate-400">Données : <strong>Code | Produit | Prix HT | Stock</strong> (lignes 2→6). Plages : Produits <code class="code bg-slate-100 dark:bg-slate-800 px-1 rounded">B2:B6</code>, Prix HT <code class="code bg-slate-100 dark:bg-slate-800 px-1 rounded">C2:C6</code>, Stock <code class="code bg-slate-100 dark:bg-slate-800 px-1 rounded">D2:D6</code>, Codes <code class="code bg-slate-100 dark:bg-slate-800 px-1 rounded">A2:A6</code>.</p>
          <details class="group border border-slate-200 dark:border-slate-800 rounded-xl p-4 mt-3 open:bg-slate-50 dark:open:bg-slate-900/40">
            <summary class="cursor-pointer font-semibold">Exercice A.1 — Par PRODUIT, renvoyer le PRIX HT</summary>
            <div class="mt-2 space-y-2">
              <p><strong>Objectif</strong> : saisir un <strong>Produit</strong> en <strong>H3</strong> (ex. <em>Webcam</em>), renvoyer le <strong>Prix HT</strong> en <strong>H4</strong>.</p>
              <pre class="code bg-slate-900 text-slate-50 p-3 rounded-lg overflow-x-auto">=SI(H3<>""; INDEX(C2:C6; EQUIV(H3; B2:B6; 0)); "produit vide")</pre>
              <p><strong>Résultat attendu</strong> (Webcam) : <code class="code">45,00 €</code></p>
            </div>
          </details>
          <details class="group border border-slate-200 dark:border-slate-800 rounded-xl p-4 mt-3">
            <summary class="cursor-pointer font-semibold">Exercice A.2 — Par CODE, renvoyer le STOCK</summary>
            <div class="mt-2 space-y-2">
              <p><strong>Objectif</strong> : saisir un <strong>Code</strong> en <strong>H6</strong> (ex. <em>P-100</em>), renvoyer le <strong>Stock</strong> en <strong>H7</strong>.</p>
              <pre class="code bg-slate-900 text-slate-50 p-3 rounded-lg overflow-x-auto">=SI(H6<>""; INDEX(D2:D6; EQUIV(H6; A2:A6; 0)); "article vide")</pre>
              <p><strong>Résultat attendu</strong> (P-100) : <code class="code">120</code></p>
            </div>
          </details>
        </div>
        <div class="border border-slate-200 dark:border-slate-800 rounded-xl p-4">
          <h4 class="font-semibold mb-2">Partie B — Recherche à double entrée</h4>
          <p class="text-sm text-slate-600 dark:text-slate-400">Plages : Lignes (commerciaux) <code class="code bg-slate-100 dark:bg-slate-800 px-1 rounded">A9:A12</code> — Colonnes (T1..T4) <code class="code bg-slate-100 dark:bg-slate-800 px-1 rounded">B8:E8</code> — Matrice <code class="code bg-slate-100 dark:bg-slate-800 px-1 rounded">B9:E12</code>.</p>
          <details class="group border border-slate-200 dark:border-slate-800 rounded-xl p-4 mt-3">
            <summary class="cursor-pointer font-semibold">Exercice B.3 — Par COMMERCIAL & TRIMESTRE, renvoyer le MONTANT</summary>
            <div class="mt-2 space-y-2">
              <p><strong>Objectif</strong> : saisir un <strong>Commercial</strong> en <strong>H10</strong> (ex. <em>Carla</em>) et un <strong>Trimestre</strong> en <strong>I10</strong> (ex. <em>T3</em>), renvoyer le montant en <strong>H11</strong>.</p>
              <pre class="code bg-slate-900 text-slate-50 p-3 rounded-lg overflow-x-auto">=SI(ET(H10<>""; I10<>""); INDEX(B9:E12; EQUIV(H10; A9:A12; 0); EQUIV(I10; B8:E8; 0)); "")</pre>
              <p><strong>Résultat attendu</strong> (Carla & T3) : <code class="code">15 000,00 €</code></p>
            </div>
          </details>
        </div>
      </article>

      <article class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm fade-in" id="combo-retain">
        <h3 class="text-lg font-bold mb-2">5) À retenir</h3>
        <ul class="list-disc pl-5 space-y-1">
          <li><strong>EQUIV</strong> ⇒ <em>position</em> ; <strong>INDEX</strong> ⇒ <em>valeur</em>.</li>
          <li>Même logique quel que soit le critère (nom, code, trimestre).</li>
          <li>Encapsuler avec <code class="code bg-slate-100 dark:bg-slate-800 px-1 rounded">SI/ET</code> ou <code class="code bg-slate-100 dark:bg-slate-800 px-1 rounded">SIERREUR</code> pour gérer les vides/erreurs.</li>
        </ul>
      </article>
    </section>

  </main>
</div>

<!-- Scripts spécifiques au tutoriel -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Theme toggle with persistence (déjà géré globalement, mais on le laisse au cas où)
    const root = document.documentElement;
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
      const stored = localStorage.getItem('theme');
      if (stored === 'dark' || (!stored && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        root.classList.add('dark');
      }
      themeToggle.addEventListener('click', () => {
        root.classList.toggle('dark');
        localStorage.setItem('theme', root.classList.contains('dark') ? 'dark' : 'light');
      });
    }

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
      panel.classList.remove('hidden'); // default open
      btn.addEventListener('click', () => {
        panel.classList.toggle('hidden');
        btn.querySelector('.chev').textContent = panel.classList.contains('hidden') ? '▸' : '▾';
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

    // Build anchors & TOC for the visible tab
    function slugify(text) {
      return text.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9\-]/g, '').replace(/\-+/g, '-').replace(/^-+|-+$/g, '');
    }

    function buildTOC() {
      const current = Array.from(document.querySelectorAll('.tab-panel')).find(p => !p.classList.contains('hidden'));
      const links = document.getElementById('tocLinks');
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
      // highlight on scroll
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