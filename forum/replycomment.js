const rnewline = document.getElementById('rcomment_nl')
const rins = document.getElementById('rcomment_insertimg')


rins.addEventListener('click', rinsertImg )
rnewline.addEventListener('click', rinsertText)



function rinsertText() {
    const textarea = document.getElementById("reply_desc");
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

  function rinsertImg() {
    const textarea = document.getElementById("reply_desc");
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