// ==================================================
// debug tool
// ==================================================
let isDebugMode = false;
const domDebug = document.querySelector('.js_debug');
function openDebug(e) {
  console.log(e);
  let isOK = false;
  if (e.keyCode === 65) {
    // z
    isDebugMode = !isDebugMode;
    if (isDebugMode) {
      domDebug.classList.remove('hidden');
    } else {
      domDebug.classList.add('hidden');
    }
  }
}
window.addEventListener('keyup', openDebug);
