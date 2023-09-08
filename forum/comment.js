const newline = document.getElementById('comment_nl')
const ins = document.getElementById('comment_insertimg')
const txtarea = document.getElementById('comment_desc')

ins.addEventListener('click', insertImg )
newline.addEventListener('click', insertText)


function insertText() {
    const textarea = document.getElementById("comment_desc");
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

  function insertImg() {
    const textarea = document.getElementById("comment_desc");
    const newText = '<img src="  letakkan links foto/gambar anda disini!!!  ">';
  
    // Get the current cursor position
    const cursorPos = textarea.selectionStart;
  
    // Insert the new text at the cursor position
    const currentValue = textarea.value;
    const updatedValue = currentValue.slice(0, cursorPos) + newText + currentValue.slice(cursorPos);
  
    // Set the updated value and adjust the cursor position
    textarea.value = updatedValue;
    textarea.setSelectionRange(cursorPos + newText.length, cursorPos + newText.length);
  }