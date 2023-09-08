const createGuideBtn = document.getElementById('toggle-guides-form')
const cancelGuideBtn = document.getElementById('guides-cancel-btn')
createGuideBtn.addEventListener('click', createGuidePost)
function createGuidePost(){
    document.querySelector('.guide-content').style.display = 'none'
    document.querySelector('.guides-form-content').style.display = 'block'
}
cancelGuideBtn.addEventListener('click', cancelGuidePost)
function cancelGuidePost(){
    document.querySelector('.guide-content').style.display = 'flex'
    document.querySelector('.guides-form-content').style.display = 'none'
}

// ---------------------------//

const gnewline = document.getElementById('gcomment_nl')
const gins = document.getElementById('gcomment_insertimg')


gins.addEventListener('click', ginsertImg )
gnewline.addEventListener('click', ginsertText)



function ginsertText() {
    const textarea = document.getElementById("guides_desc");
    const newText = "<br>";
  
    // Get the current cursor position
    const cursorPos = textarea.selectionStart;
  
    // Insert the new text at the cursor position
    const currentValue = textarea.value;
    const updatedValue = currentValue.slice(0, cursorPos) + newText + currentValue.slice(cursorPos);
  
    // Set the updated value and adjust the cursor position
    textarea.value = updatedValue;
    textarea.setSelectionRange(cursorPos + newText.length, cursorPos + newText.length);
  }

  function ginsertImg() {
    const textarea = document.getElementById("guides_desc");
    const newText = '<img src="  letakkan links foto/gambar anda disini!!  ">';
  
    // Get the current cursor position
    const cursorPos = textarea.selectionStart;
  
    // Insert the new text at the cursor position
    const currentValue = textarea.value;
    const updatedValue = currentValue.slice(0, cursorPos) + newText + currentValue.slice(cursorPos);
  
    // Set the updated value and adjust the cursor position
    textarea.value = updatedValue;
    textarea.setSelectionRange(cursorPos + newText.length, cursorPos + newText.length);
  }