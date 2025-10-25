/** ==============================================================
 *  LOGIQUE DU QUIZ GÉNÉRIQUE
 *  ============================================================== */

/* ==============================================================
   LOGIQUE / ETAT
   ============================================================== */
const state = {
	index: 0,
	validated: Array(QUESTIONS.length).fill(false),
	answers: Array(QUESTIONS.length).fill(null), // single: number | null ; multi: number[] | null ; select: number|null ; multiselect: number[]|null ; toggle: 0|1|null ; range: number|null ; ranking: number[]|null ; image: number|null
	pointsEarned: Array(QUESTIONS.length).fill(0),
	score: 0,
};

async function saveState() {
    try {
        await fetch('api/progress.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                quiz_id: QUIZ_ID,
                score: state.score,
                progress: Math.round((state.validated.filter(v => v).length / QUESTIONS.length) * 100),
                // To resume quiz, we need the full state. Let's adapt the API and DB for this.
                // For now, let's just save score and progress percentage.
                // The full state persistence will be added in a later step.
            }),
        });
    } catch (e) {
        console.error("Impossible de sauvegarder l'état", e);
    }
}


async function loadState() {
    try {
        const response = await fetch(`api/progress.php?quiz_id=${QUIZ_ID}`);
        if (response.ok) {
            const savedState = await response.json();
            if (savedState) {
                // For now, we only load the score as we are not storing the full state yet.
                // This will be improved.
                // Object.assign(state, savedState);
            }
        }
    } catch (e) {
        console.error("Impossible de charger l'état", e);
    }
}


const els = {
	progressLabel: document.getElementById("progress-label"),
	scoreLabel: document.getElementById("score-label"),
	progressBar: document.getElementById("progress-bar"),
	theme: document.getElementById("theme"),
	question: document.getElementById("question"),
	multiHelp: document.getElementById("multi-help"),
	options: document.getElementById("options"),
	feedback: document.getElementById("feedback"),
	relevanceBox: document.getElementById("relevance"),
	relevanceText: document.getElementById("relevance-text"),
	prevBtn: document.getElementById("prev-btn"),
	validateBtn: document.getElementById("validate-btn"),
	nextBtn: document.getElementById("next-btn"),
	finishBtn: document.getElementById("finish-btn"),
	final: document.getElementById("final"),
	finalSummary: document.getElementById("final-summary"),
	finalFlags: document.getElementById("final-flags"),
	recos: document.getElementById("recos"),
	recap: document.getElementById("recap"),
	restartBtn: document.getElementById("restart-btn"),
	exportBtn: document.getElementById("export-btn"),
};

function setInputsDisabled(disabled) {
	[
		...els.options.querySelectorAll(
			"input, select, button, textarea"
		),
	].forEach((el) => (el.disabled = disabled));
	if (disabled) {
		els.options.classList.add("pointer-events-none");
	} else {
		els.options.classList.remove("pointer-events-none");
	}
	[...els.options.querySelectorAll("label,.card-choice")].forEach(
		(lab) => {
			lab.classList.toggle("opacity-60", disabled);
			lab.classList.toggle("cursor-not-allowed", disabled);
		}
	);
	// Ranking: désactiver le drag
	els.options
		.querySelectorAll('[draggable="true"]')
		.forEach((n) => n.setAttribute("draggable", String(!disabled)));
}

function maxPointsForQuestion(q) {
	switch (q.selectionType) {
		case "single":
		case "select":
		case "image":
			return Math.max(...q.options.map((o) => o.points ?? 0));
		case "multi":
		case "multiselect":
			return q.options.reduce(
				(s, o) => s + Math.max(0, o.points ?? 0),
				0
			);
		case "toggle":
			return Math.max(...q.options.map((o) => o.points ?? 0));
		case "range":
			return Math.max(
				...(q.range?.bands ?? []).map((b) => b.points)
			);
		case "ranking": {
			const p = q.ranking?.pointsPerItem ?? 1;
			const n = (q.options ?? []).length;
			return p * n;
		}
		default:
			return 0;
	}
}
const TOTAL_MAX = QUESTIONS.reduce(
	(acc, q) => acc + maxPointsForQuestion(q),
	0
);

/* ---------- Rendu ---------- */
function renderQuestion() {
	const i = state.index;
	const q = QUESTIONS[i];

	els.progressLabel.textContent = `Question ${i + 1} / ${
		QUESTIONS.length
	}`;
	const pct = Math.max(5, Math.round((i / QUESTIONS.length) * 100));
	els.progressBar.style.width = `${pct}%`;

	els.theme.textContent = q.theme;
	els.question.innerHTML = q.question;

	els.multiHelp.classList.toggle(
		"hidden",
		!["multi", "multiselect"].includes(q.selectionType)
	);

	// Options
	els.options.innerHTML = "";
	const saved = state.answers[i];

	if (q.selectionType === "single") {
		q.options.forEach((opt, idx) => {
			const id = `q${i}_opt${idx}`;
			const checked = saved === idx ? "checked" : "";
			els.options.insertAdjacentHTML(
				"beforeend",
				`
<label for="${id}" class="flex items-start gap-3 p-3 border rounded-xl hover:bg-gray-50 cursor-pointer">
<input ${checked} id="${id}" name="q${i}" type="radio" value="${idx}" class="mt-1" />
<span>${opt.label}</span>
</label>
`
			);
		});
	} else if (q.selectionType === "multi") {
		const arr = Array.isArray(saved) ? saved : [];
		q.options.forEach((opt, idx) => {
			const id = `q${i}_opt${idx}`;
			const checked = arr.includes(idx) ? "checked" : "";
			els.options.insertAdjacentHTML(
				"beforeend",
				`
<label for="${id}" class="flex items-start gap-3 p-3 border rounded-xl hover:bg-gray-50 cursor-pointer">
<input ${checked} id="${id}" name="q${i}" type="checkbox" value="${idx}" class="mt-1" />
<span>${opt.label}</span>
</label>
`
			);
		});
	} else if (q.selectionType === "select") {
		const current = Number.isInteger(saved) ? saved : null;
		const opts = q.options
			.map(
				(opt, idx) =>
					`<option value="${idx}" ${
						current === idx ? "selected" : ""
					}>${opt.label}</option>`
			)
			.join("");
		els.options.innerHTML = `
<label class="block text-sm font-medium text-gray-700 mb-1">Choisissez une option</label>
<select class="w-full border rounded-xl p-2">
<option value="" ${
	current === null ? "selected" : ""
} disabled>— Sélectionnez —</option>
${opts}
</select>
`;
	} else if (q.selectionType === "multiselect") {
		const arr = Array.isArray(saved) ? saved : [];
		const opts = q.options
			.map(
				(opt, idx) =>
					`<option value="${idx}" ${
						arr.includes(idx) ? "selected" : ""
					}>${opt.label}</option>`
			)
			.join("");
		els.options.innerHTML = `
<label class="block text-sm font-medium text-gray-700 mb-1">Sélection multiple (Ctrl/Cmd ou Maj pour plusieurs)</label>
<select multiple size="${Math.min(
8,
q.options.length
)}" class="w-full border rounded-xl p-2">
${opts}
</select>
`;
	} else if (q.selectionType === "toggle") {
		const isOn = saved === 1;
		els.options.innerHTML = `
<label class="flex items-center gap-3 select-none">
<input id="toggle_${i}" type="checkbox" class="sr-only" ${
	isOn ? "checked" : ""
}>
<span data-role="track" class="relative inline-flex h-6 w-11 items-center rounded-full transition ${
	isOn ? "bg-emerald-500" : "bg-gray-300"
}">
<span data-role="knob" class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition ${
	isOn ? "translate-x-5" : "translate-x-1"
}"></span>
</span>
<span data-role="toggle-label">${
	isOn ? q.options[1].label : q.options[0].label
}</span>
</label>
`;
		const t = document.getElementById(`toggle_${i}`);
		const track = els.options.querySelector('[data-role="track"]');
		const knob = els.options.querySelector('[data-role="knob"]');
		const text = els.options.querySelector(
			'[data-role="toggle-label"]'
		);
		function sync() {
			track.classList.toggle("bg-emerald-500", t.checked);
			track.classList.toggle("bg-gray-300", !t.checked);
			knob.classList.toggle("translate-x-5", t.checked);
			knob.classList.toggle("translate-x-1", !t.checked);
			text.textContent = t.checked
				? q.options[1].label
				: q.options[0].label;
		}
		t?.addEventListener("change", sync);
	} else if (q.selectionType === "range") {
		const val =
			typeof saved === "number"
				? saved
				: Math.round((q.range.min + q.range.max) / 2);
		els.options.innerHTML = `
<div class="flex items-center gap-3">
<input id="range_${i}" type="range" min="${q.range.min}" max="${q.range.max}" step="${q.range.step}" value="${val}" class="w-full">
<span id="range_val_${i}" class="w-10 text-right text-sm font-medium">${val}</span>
</div>
`;
		const r = document.getElementById(`range_${i}`);
		const out = document.getElementById(`range_val_${i}`);
		r?.addEventListener("input", () => (out.textContent = r.value));
	} else if (q.selectionType === "ranking") {
		const order = Array.isArray(saved)
			? saved
			: q.options.map((_, idx) => idx);
		const list = document.createElement("ul");
		list.className = "space-y-2";
		order.forEach((idx) => {
			const li = document.createElement("li");
			li.className = "p-3 border rounded-xl bg-gray-50 cursor-move";
			li.setAttribute("draggable", "true");
			li.dataset.idx = String(idx);
			li.innerHTML = `<span class="text-sm">${q.options[idx].label}</span>`;
			list.appendChild(li);
		});
		els.options.appendChild(list);

		// DnD
		let dragging = null;
		list.addEventListener("dragstart", (e) => {
			dragging = e.target;
			e.target.classList.add("opacity-70");
		});
		list.addEventListener("dragend", (e) =>
			e.target.classList.remove("opacity-70")
		);
		list.addEventListener("dragover", (e) => {
			e.preventDefault();
			const after = [...list.querySelectorAll("li")].find((li) => {
				const rect = li.getBoundingClientRect();
				return e.clientY < rect.top + rect.height / 2;
			});
			if (!after) list.appendChild(dragging);
			else list.insertBefore(dragging, after);
		});
	} else if (q.selectionType === "image") {
		const current = Number.isInteger(saved) ? saved : null;
		const wrap = document.createElement("div");
		wrap.className = "grid grid-cols-1 sm:grid-cols-3 gap-3";
		q.options.forEach((opt, idx) => {
			const isSel = current === idx;
			const card = document.createElement("button");
			card.type = "button";
			card.className = `card-choice border rounded-xl p-4 text-left hover:shadow ${
				isSel ? "border-emerald-400 ring-2 ring-emerald-200" : ""
			}`;
			card.innerHTML = `
<div class="text-3xl">${opt.emoji ?? "🧠"}</div>
<div class="mt-2 text-sm">${opt.label}</div>
`;
			card.addEventListener("click", () => {
				// unselect others
				wrap
					.querySelectorAll(".card-choice")
					.forEach((c) =>
						c.classList.remove(
							"border-emerald-400",
							"ring-2",
							"ring-emerald-200"
						)
					);
				card.classList.add(
					"border-emerald-400",
					"ring-2",
					"ring-emerald-200"
				);
				state.answers[i] = idx; // sélection immédiate (non validée)
			});
			wrap.appendChild(card);
		});
		els.options.appendChild(wrap);
	}

	// Reset feedback
	els.feedback.classList.add("hidden");
	els.feedback.classList.remove(
		"bg-green-50",
		"text-green-800",
		"bg-amber-50",
		"text-amber-800",
		"bg-red-50",
		"text-red-800"
	);
	els.feedback.innerHTML = "";
	els.relevanceBox.classList.add("hidden");
	els.relevanceText.textContent = "";

	// Boutons / états
	const isValidated = state.validated[i];
	els.prevBtn.disabled = i === 0;
	els.validateBtn.classList.toggle("hidden", isValidated);

	const isLast = i === QUESTIONS.length - 1;
	els.nextBtn.classList.toggle("hidden", isLast || !isValidated);
	els.prevBtn.classList.toggle("hidden", i === 0);
	els.nextBtn.disabled = !isValidated;
	els.finishBtn.classList.toggle("hidden", !(isValidated && isLast));

	// Verrouillage si déjà validée
	setInputsDisabled(isValidated);

	// Restaurer feedback si déjà validée
	if (isValidated) showFeedback();
}

/* ---------- Lecture de la sélection ---------- */
function getCurrentSelection() {
	const i = state.index;
	const q = QUESTIONS[i];
	if (q.selectionType === "single") {
		const checked = els.options.querySelector(
			'input[type="radio"]:checked'
		);
		return checked ? Number(checked.value) : null;
	}
	if (q.selectionType === "multi") {
		const checked = [
			...els.options.querySelectorAll(
				'input[type="checkbox"]:checked'
			),
		].map((n) => Number(n.value));
		return checked.length ? checked : null;
	}
	if (q.selectionType === "select") {
		const sel = els.options.querySelector("select");
		if (!sel || sel.value === "") return null;
		return Number(sel.value);
	}
	if (q.selectionType === "multiselect") {
		const sel = els.options.querySelector("select");
		if (!sel) return null;
		const vals = [...sel.selectedOptions].map((o) =>
			Number(o.value)
		);
		return vals.length ? vals : null;
	}
	if (q.selectionType === "toggle") {
		const chk = els.options.querySelector(
			'input[type="checkbox"]#toggle_' + i
		);
		if (!chk) return null;
		return chk.checked ? 1 : 0;
	}
	if (q.selectionType === "range") {
		const r = els.options.querySelector('input[type="range"]');
		return r ? Number(r.value) : null;
	}
	if (q.selectionType === "ranking") {
		const items = [...els.options.querySelectorAll("li")];
		if (!items.length) return null;
		return items.map((li) => Number(li.dataset.idx));
	}
	if (q.selectionType === "image") {
		const current = state.answers[i];
		return Number.isInteger(current) ? current : null;
	}
	return null;
}

/* ---------- Points ---------- */
function pointsForSelection(q, selection) {
	if (selection === null) return 0;
	switch (q.selectionType) {
		case "single":
		case "select":
		case "image": {
			const idx = selection;
			return q.options[idx]?.points ?? 0;
		}
		case "multi":
		case "multiselect": {
			return selection.reduce(
				(sum, idx) => sum + (q.options[idx]?.points ?? 0),
				0
			);
		}
		case "toggle": {
			const idx = selection; // 0 ou 1
			return q.options[idx]?.points ?? 0;
		}
		case "range": {
			const val = selection;
			const band = (q.range?.bands ?? []).find(
				(b) => val >= b.min && val <= b.max
			);
			return band ? band.points : 0;
		}
		case "ranking": {
			const order = selection; // tableau d'indices
			const expected = q.ranking?.correctOrder ?? [];
			const per = q.ranking?.pointsPerItem ?? 1;
			let good = 0;
			expected.forEach((idx, pos) => {
				if (order[pos] === idx) good += 1;
			});
			return good * per;
		}
		default:
			return 0;
	}
}

/* ---------- Feedback ---------- */
function showFeedback() {
	const i = state.index;
	const q = QUESTIONS[i];
	const earned = state.pointsEarned[i];
	const maxP = maxPointsForQuestion(q);
	const ratio = maxP ? earned / maxP : 0;

	els.feedback.classList.remove("hidden");
	els.feedback.classList.toggle("bg-green-50", ratio === 1);
	els.feedback.classList.toggle("text-green-800", ratio === 1);
	els.feedback.classList.toggle(
		"bg-amber-50",
		ratio > 0 && ratio < 1
	);
	els.feedback.classList.toggle(
		"text-amber-800",
		ratio > 0 && ratio < 1
	);
	els.feedback.classList.toggle("bg-red-50", ratio === 0);
	els.feedback.classList.toggle("text-red-800", ratio === 0);

	let text = "";
	if (ratio === 1) {
		text = q.feedback_correct || "Super 👍";
	} else if (ratio === 0) {
		text = q.feedback_incorrect || "Pas de souci 🙌";
	} else {
		text = q.feedback_partial || "Bien 😊";
	}
	els.feedback.innerHTML = `<div class="font-medium">${text}</div><div class="mt-1 text-gray-700">Points obtenus : <strong>${earned}</strong> / ${maxP}</div>`;

	els.relevanceBox.classList.remove("hidden");
	els.relevanceText.textContent = q.relevance || "";
}

/* ---------- Navigation & validation ---------- */
function validate() {
	const i = state.index;
	const q = QUESTIONS[i];
	if (state.validated[i]) return;

	const sel = getCurrentSelection();
	if (sel === null) {
		els.options.classList.add("ring-2", "ring-red-300");
		setTimeout(
			() => els.options.classList.remove("ring-2", "ring-red-300"),
			500
		);
		return;
	}
	state.answers[i] = sel;
	const earned = pointsForSelection(q, sel);

	state.validated[i] = true;
	state.pointsEarned[i] = earned;
	state.score += earned;
	els.scoreLabel.textContent = `Score : ${state.score}`;

	setInputsDisabled(true);
	els.validateBtn.classList.add("hidden");

	const isLast = i === QUESTIONS.length - 1;
	if (isLast) {
		els.finishBtn.classList.remove("hidden");
		els.nextBtn.classList.add("hidden");
	} else {
		els.nextBtn.disabled = false;
		els.nextBtn.classList.remove("hidden");
	}

	showFeedback();
	saveState();
}

function nextQ() {
	if (state.index < QUESTIONS.length - 1) {
		state.index += 1;
		renderQuestion();
		saveState();
	}
}
function prevQ() {
	if (state.index > 0) {
		state.index -= 1;
		renderQuestion();
		saveState();
	}
}

/* ---------- Finalisation ---------- */
function finalize() {
	saveState(); // Save final state

	const total = TOTAL_MAX;
	const score = state.score;
	const pct = Math.round((score / total) * 100);

	// Drapeaux doux (selon questions clés) - ceci est un exemple et peut être personnalisé
	const flags = [];
	if (QUESTIONS.find(q => q.id === "IA12")) {
		const bad = (id) => {
			const idx = QUESTIONS.findIndex((q) => q.id === id);
			if (idx < 0) return false;
			const maxP = maxPointsForQuestion(QUESTIONS[idx]);
			return (state.pointsEarned[idx] || 0) < maxP;
		};
		if (bad("IA12"))
			flags.push(
				"Confidentialité à renforcer (limiter/masquer les données sensibles)."
			);
		if (bad("IA04") || bad("IA06"))
			flags.push(
				"Pensez à vérifier les informations (hallucinations possibles)."
			);
		if (bad("IA08"))
			flags.push(
				"Structure des prompts à préciser (objectif, contexte, format, exemple)."
			);
	}

	// Verdict bienveillant - ceci est un exemple et peut être personnalisé
	let verdict = "";
	let style = "bg-blue-50 text-blue-900 border-blue-200";
	if (pct >= 75 && flags.length === 0) {
		verdict =
			"✅ Très bon positionnement : vous pouvez aborder des ateliers pratiques sans difficulté.";
		style = "bg-emerald-50 text-emerald-900 border-emerald-200";
	} else if (pct >= 55) {
		verdict =
			"🟡 Bases solides : vous pouvez suivre la formation modeste, avec quelques rappels ciblés.";
		style = "bg-amber-50 text-amber-900 border-amber-200";
	} else if (pct >= 35) {
		verdict =
			"🟠 Position intermédiaire : un module d’initiation supplémentaire vous mettra parfaitement à l’aise.";
		style = "bg-orange-50 text-orange-900 border-orange-200";
	} else {
		verdict =
			"🔴 Recommandation : commencez par un module d’introduction (vocabulaire, sécurité, prompts de base).";
		style = "bg-red-50 text-red-900 border-red-200";
	}

	els.finalSummary.textContent = `Score : ${score} / ${total} (${pct} %)`;
	els.finalFlags.innerHTML = "";
	flags.forEach((f) => {
		const li = document.createElement("li");
		li.textContent = f;
		els.finalFlags.appendChild(li);
	});
	els.recos.className = `p-4 rounded-xl border ${style}`;
	els.recos.textContent = verdict;

	// Récap par question
	els.recap.innerHTML = "";
	QUESTIONS.forEach((q, idx) => {
		const maxP = maxPointsForQuestion(q);
		const earned = state.pointsEarned[idx] || 0;

		let displayAns = "(aucune réponse)";
		const userAns = state.answers[idx];
		if (q.selectionType === "range" && typeof userAns === "number") {
			displayAns = String(userAns);
		} else if (
			q.selectionType === "ranking" &&
			Array.isArray(userAns)
		) {
			displayAns = userAns
				.map((i) => q.options[i].label)
				.join(" → ");
		} else if (Array.isArray(userAns)) {
			displayAns = userAns
				.map((i) => q.options[i].label)
				.join(" ; ");
		} else if (Number.isInteger(userAns)) {
			displayAns = q.options[userAns]?.label ?? displayAns;
		}

		const bestLabels = (() => {
			if (q.selectionType === "ranking") {
				return (q.ranking?.correctOrder ?? [])
					.map((i) => q.options[i].label)
					.join(" → ");
			}
			if (q.selectionType === "range") {
				const bands = q.range?.bands ?? [];
				const best = bands.reduce(
					(m, b) => (b.points > m.points ? b : m),
					{ points: -1 }
				);
				if (best.points < 0) return "(—)";
				return `Meilleure zone : ${best.min}–${best.max}`;
			}
			if (["multi", "multiselect"].includes(q.selectionType)) {
				return (
					q.options
						.filter((o) => (o.points ?? 0) > 0)
						.map((o) => o.label)
						.join(" ; ") || "(—)"
				);
			}
			return (
				q.options.reduce(
					(best, o) =>
						(o.points ?? 0) > (best.points ?? -1) ? o : best,
					{}
				).label || "(—)"
			);
		})();

		const ratio = maxP ? earned / maxP : 0;
		const good = ratio === 1;
		const mid = ratio > 0 && ratio < 1;
		const card = document.createElement("div");
		card.className = `p-3 rounded-xl border ${
			good
				? "bg-green-50 border-green-200"
				: mid
				? "bg-amber-50 border-amber-200"
				: "bg-red-50 border-red-200"
		}`;
		card.innerHTML = `
<div class="text-xs uppercase tracking-wide text-gray-500">${
	q.theme
}</div>
<div class="font-medium mt-1">${idx + 1}. ${q.question}</div>
<div class="mt-1 text-sm"><span class="font-semibold">Votre réponse :</span> ${displayAns}</div>
<div class="text-sm"><span class="font-semibold">Pistes pertinentes :</span> ${bestLabels}</div>
<div class="text-sm mt-1"><span class="font-semibold">Points :</span> ${earned} / ${maxP}</div>
`;
		els.recap.appendChild(card);
	});

	els.final.classList.remove("hidden");
	els.final.scrollIntoView({ behavior: "smooth", block: "start" });
}

/* ---------- Utilitaires ---------- */
async function restart() {
    state.index = 0;
    state.validated = Array(QUESTIONS.length).fill(false);
    state.answers = Array(QUESTIONS.length).fill(null);
    state.pointsEarned = Array(QUESTIONS.length).fill(0);
    state.score = 0;
    els.scoreLabel.textContent = `Score : 0`;
    els.final.classList.add("hidden");
    await saveState(); // This will save the reset state to the server
    renderQuestion();
}

function exportAnswers() {
	const payload = {
		date: new Date().toISOString(),
		score: state.score,
		totalMax: TOTAL_MAX,
		percent: Math.round((state.score / TOTAL_MAX) * 100),
		answers: QUESTIONS.map((q, idx) => ({
			id: q.id,
			question: q.question,
			selectionType: q.selectionType,
			selected: Array.isArray(state.answers[idx])
				? state.answers[idx]
				: state.answers[idx] === null
				? null
				: state.answers[idx],
			selectedLabels: (() => {
				const a = state.answers[idx];
				if (q.selectionType === "range" && typeof a === "number")
					return [String(a)];
				if (q.selectionType === "ranking" && Array.isArray(a))
					return a.map((i) => q.options[i].label);
				if (Array.isArray(a))
					return a.map((i) => q.options[i].label);
				if (Number.isInteger(a))
					return [q.options[a]?.label ?? ""];
				return [];
			})(),
			earned: state.pointsEarned[idx],
			maxPoints: maxPointsForQuestion(q),
		})),
	};
	const blob = new Blob([JSON.stringify(payload, null, 2)], {
		type: "application/json",
	});
	const url = URL.createObjectURL(blob);
	const a = document.createElement("a");
	a.href = url;
	a.download = "resultat-test.json";
	document.body.appendChild(a);
	a.click();
	URL.revokeObjectURL(url);
	a.remove();
}

/* ---------- Raccourcis clavier ---------- */
document.addEventListener("keydown", (e) => {
	if (e.key === "ArrowRight") nextQ();
	if (e.key === "ArrowLeft") prevQ();
	if (e.key.toLowerCase() === "v") validate();
});

/* ---------- Boutons ---------- */
els.prevBtn.addEventListener("click", prevQ);
els.validateBtn.addEventListener("click", validate);
els.nextBtn.addEventListener("click", nextQ);
els.finishBtn.addEventListener("click", finalize);
els.restartBtn.addEventListener("click", restart);
els.exportBtn.addEventListener("click", exportAnswers);

/* ---------- Init ---------- */
(async () => {
    await loadState();
    renderQuestion();
})();
