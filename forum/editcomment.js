const enewline = document.getElementById('ecomment_nl')
const eins = document.getElementById('ecomment_insertimg')


eins.addEventListener('click', einsertImg )
enewline.addEventListener('click', einsertText)



function einsertText() {
    const textarea = document.getElementById("edit_desc");
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

  function einsertImg() {
    const textarea = document.getElementById("edit_desc");
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