const word = document.getElementById('word');
const text = document.getElementById('text');
const scoreEl = document.getElementById('score');
const timeEl = document.getElementById('time');
const endgameEl = document.getElementById('end-game-container');
// List of words for game
const words = [
    'web',
    'bytedance',
    'ctf',
    'sing',
    'jump',
    'rap',
    'basketball',
    'hello',
    'world',
    'fighting',
    'flag',
    'game',
    'happy'
].sort(function() {
    return .5 - Math.random();
});
let words_l = 0
let randomWord;
let score = 0;
let time = 26;
text.focus();
const timeInterval = setInterval(updateTime, 1000);
function addWordToDOM() {
    randomWord = words[words_l];
    words_l++
    word.setAttribute("src",randomWord+".mp3")
    word.innerHTML = randomWord;
}

function updateScore() {
    score++;
    scoreEl.innerHTML = score;
}
function updateTime() {
    time--;
    timeEl.innerHTML = time + 's';
    if (time === 0 || score >=words.length ) {
        clearInterval(timeInterval);
        word.parentElement.removeChild(word)
        gameOver();
    }
}
function gameOver() {
    if (score >= words.length) {
        const params = new URLSearchParams(window.location.search)
        const username = params.get('name');
        endgameEl.innerHTML = `
    <h1>^_^</h1>
    Dear ${username},Congratulations on your success.Your final score is ${score}`;
    endgameEl.style.display = 'flex';
    } else {
        score=0
        endgameEl.innerHTML = `
    <h1>*_*</h1>
    Try again`;
    endgameEl.style.display = 'flex';
    }

}

addWordToDOM();
// Typing
function typing(insertedText){
    if (insertedText === randomWord) {
        addWordToDOM();
        updateScore();
        document.querySelector("#text").value = '';
        updateTime();
    }
}

text.addEventListener('input', e => {
    typing(e.target.value)
});
addEventListener("hashchange",e=>{
    typing(location.hash.replace("#","").split("?")[0])
})
