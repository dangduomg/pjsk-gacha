const gacha = document.querySelector('#gacha');
const pull1 = document.querySelector('#pull-1');
const pull10 = document.querySelector('#pull-10');
const result = document.querySelector('#result');
const cardTemplate = document.querySelector('#card-template');
const cardsTemplate = document.querySelector('#cards-template');

pull1.addEventListener('click', e => {
    e.preventDefault();
    sendAndGetResult('/api/pull1', result);
})

pull10.addEventListener('click', e => {
    e.preventDefault();
    sendAndGetResult('/api/pull10', result);
})

async function sendAndGetResult(url, resultElem) {
    const response = await fetch(url);
    if (!response.ok) {
        resultElem.textContent = 'Sending request to server unsuccessful';
        return;
    }
    const json = await response.json();
    if (json.status === 'failure') {
        resultElem.textContent =
            `Server told something was wrong: ${json.message}`;
        return;
    }
    const cards = json.message;
    resultElem.replaceChildren();
    const cardsContainer = cardsTemplate.content
        .cloneNode(true)
        .querySelector('.cards');
    for (const card of cards) {
        const el = cardTemplate.content.cloneNode(true);
        for (const field of ['rarity', 'attribute', 'character', 'name'])
            el.querySelector(`[data-field="${field}"]`).textContent = card[field];
        cardsContainer.appendChild(el);
    }
    resultElem.appendChild(cardsContainer);
}