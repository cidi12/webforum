const topicwrap = document.querySelector('.topic-wrapper')
const editpostwrap = document.querySelector('.editpost')
const editpostback = document.getElementById('editpostback')

const editpostbtn2 = document.getElementById('GUIDEeditpostbtn')


// pys //
const editpostbtn = document.getElementById('editpostbtn')
editpostbtn.addEventListener('click', editposting)
function editposting(){
    topicwrap.style.display = 'none'
    editpostwrap.style.display = 'block'
}
editpostback.addEventListener('click', goback)
function goback(){
    topicwrap.style.display = 'flex'
    editpostwrap.style.display = 'none'
}

// // guide //
// editpostbtn2.addEventListener('click', editposting2)
// function editposting2(){
//     topicwrap.style.display = 'none'
//     editpostwrap.style.display = 'block'
// }
// editpostback.addEventListener('click', goback2)
// function goback2(){
//     topicwrap.style.display = 'flex'
//     editpostwrap.style.display = 'none'
// }
// ---------------------------------//

// pys //
const pynewline = document.getElementById('tpcomment_nl')
const pyins = document.getElementById('tpcomment_insertimg')


pyins.addEventListener('click', tpinsertImg )
pynewline.addEventListener('click', tpinsertText)

 

function tpinsertText() {
    const textarea = document.getElementById("edit_post_desc");
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

  function tpinsertImg() {
    const textarea = document.getElementById("edit_post_desc");
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

