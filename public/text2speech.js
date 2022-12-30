let sound = document.querySelector('main .quiz .quiz-body .quiz-body-head .sound');
let text = document.querySelector('main .quiz .quiz-body .quiz-body-body .question h5')
let speech = new SpeechSynthesisUtterance();
sound.onclick = function TextToSpeech() {
    speech.text = text.innerText;
    speech.rate = 1;
    speech.volume = 1;
    speech.pitch = 1;
    speech.lang = "en-US";
    speechSynthesis.speak(speech);
}