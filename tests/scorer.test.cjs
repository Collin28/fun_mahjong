const { test } = require('node:test');
const assert = require('node:assert/strict');
const { readFileSync } = require('node:fs');
const vm = require('node:vm');

function openScorer() {
    const elements = new Map();
    function element() {
        return { value: '', innerHTML: '', textContent: '', listeners: {}, addEventListener(type, callback) { this.listeners[type] = callback; } };
    }
    const selects = Array.from({ length: 4 }, element);
    selects.forEach((select) => { select.querySelector = () => ({ dataset: { name: 'Player', emoji: '🐼' } }); });
    const stored = new Map();
    const document = {
        getElementById(id) {
            if (!elements.has(id)) elements.set(id, element());
            return elements.get(id);
        },
        querySelectorAll: () => selects,
        querySelector: () => null,
    };
    const source = readFileSync('resources/views/scorer/index.blade.php', 'utf8').match(/<script>([\s\S]*?)<\/script>/)[1].replace(/\{\{[\s\S]*?\}\}/g, '/admin/adjust-stat');
    vm.runInNewContext(source, {
        document, CSS: { escape: (value) => value },
        localStorage: { getItem: (key) => stored.get(key) || null, setItem: (key, value) => stored.set(key, value) },
        confirm: () => true, alert: () => {},
        fetch: () => { throw new Error('Manual table scores must not alter leaderboard statistics'); },
    });
    selects.forEach((select, index) => { select.value = 'player' + index; select.listeners.change(); });
    return {
        elements,
        change(index, value) {
            const input = { value, dataset: { score: String(index) } };
            elements.get('players-grid').querySelector = () => input;
            elements.get('players-grid').listeners.click({ target: { closest: () => ({ dataset: { scoreSave: String(index) } }) } });
        },
        state() { return JSON.parse([...stored.values()][0]); },
    };
}

test('manual score replaces the previous total instead of incrementing it', () => {
    const scorer = openScorer();
    scorer.change(0, '12');
    assert.equal(scorer.state().scores[0], 12);
    scorer.change(0, '7');
    assert.equal(scorer.state().scores[0], 7);
    assert.equal(scorer.state().scores[1], 0);
});

test('invalid and empty scores do not change saved scores', () => {
    const scorer = openScorer();
    scorer.change(0, '12');
    for (const invalid of ['', '1.5', '-1', 'abc', '9007199254740992']) scorer.change(0, invalid);
    assert.equal(scorer.state().scores[0], 12);
});

test('undo restores the exact score before the manual edit', () => {
    const scorer = openScorer();
    scorer.change(0, '12');
    scorer.change(0, '7');
    scorer.elements.get('btn-undo').listeners.click();
    assert.equal(scorer.state().scores[0], 12);
});

test('reset clears manual scores and edit history', () => {
    const scorer = openScorer();
    scorer.change(0, '12');
    scorer.elements.get('btn-reset').listeners.click();
    assert.deepEqual(scorer.state().scores, [0, 0, 0, 0]);
    assert.deepEqual(scorer.state().history, []);
});
