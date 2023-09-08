const masuk2 = document.getElementById('login-up')
const masuk = document.getElementById('btn-signin')
const noAkun = document.querySelector('.noakun a')
const btnregis2 = document.getElementById('register-up')
const pnyAkun = document.querySelector('.punya-akun a')
const closebtn = document.querySelector('.clsbtn')
const closebtn2 = document.querySelector('.clsbtn2')
const closebtn3 = document.querySelector('.clsbtn3')
const respnavi = document.querySelector('.logo img')
const inputText = document.getElementById('reg-username')
const inputEmail = document.getElementById('reg-email')
const inputPassword = document.getElementById('reg-password')
const bode = document.body
const valdi = document.getElementById('form-validate')
const valdi2 = document.getElementById('form-validate2')



document.querySelectorAll('input[type = "number"]').forEach(input => {
    input.oninput = () => {
        if (input.value.length > input.maxLength)
            input.value = input.value.slice(0, input.maxLength)

    }
})

function multiAttributeSet(elem, elemAttributes) {
    for (let i in elemAttributes) {
        elem.setAttribute(i, elemAttributes[i]);
    }

}
multiAttributeSet(inputText, { "onkeypress": "return noSpace(event)" });
multiAttributeSet(inputEmail, { "onkeypress": "return noSpace(event)" });
multiAttributeSet(inputPassword, { "onkeypress": "return noSpace(event)" });


function noSpace(event) {
    var k = event ? event.which : window.event.keyCode;
    if (k == 32) return false;
}


masuk.addEventListener('click', signIn);
function signIn() {
    valdi.removeAttribute('novalidate')
    valdi2.removeAttribute('novalidate')
    bode.style.overflowY = 'hidden'
    document.getElementById("latar-formulir").style.opacity = "1"
    document.getElementById("latar-formulir").style.pointerEvents = "auto"
    document.querySelector('.formulir').style.display = 'block'
    window.addEventListener('wheel', function (e) {
        e.preventDefault();
    });
    window.scrollTo({
        top: 0,
        behavior: 'smooth'})

}
masuk2.addEventListener('click', signIn2);
function signIn2() {
    valdi.removeAttribute('novalidate')
    valdi2.removeAttribute('novalidate')
    bode.style.overflowY = 'hidden'
    document.getElementById("latar-formulir").style.opacity = "1"
    document.getElementById("latar-formulir").style.pointerEvents = "auto"
    document.querySelector('.formulir').style.display = 'block'
    window.addEventListener('wheel', function (e) {
        e.preventDefault();
    });
    window.scrollTo({
        top: 0,
        behavior: 'smooth'})

}


closebtn.addEventListener('click', close);
function close() {
    document.getElementById("latar-formulir").style.opacity = "0"
    document.getElementById("latar-formulir").style.pointerEvents = "none"
    document.querySelector('.formulir').style.display = 'none'
    document.querySelector('.formulir-regis').style.display = 'none'
    document.getElementById('log-password').value = ''
    document.getElementById('reg-password').value = ''
    document.getElementById('log-email').value = ''
    document.getElementById('reg-email').value = ''
    document.getElementById('pin').value = ''
    document.getElementById('reg-username').value = ''
    valdi.setAttribute('novalidate', true)
    valdi2.setAttribute('novalidate', true)
    bode.style.overflowY = 'scroll'


}

closebtn2.addEventListener('click', close2);
function close2() {
    document.getElementById("latar-formulir").style.opacity = "0"
    document.getElementById("latar-formulir").style.pointerEvents = "none"
    document.querySelector('.formulir').style.display = 'none'
    document.querySelector('.formulir-regis').style.display = 'none'
    document.getElementById('log-password').value = ''
    document.getElementById('reg-password').value = ''
    document.getElementById('log-email').value = ''
    document.getElementById('reg-email').value = ''
    document.getElementById('pin').value = ''
    document.getElementById('reg-username').value = ''
    valdi.setAttribute('novalidate',true)
    valdi2.setAttribute('novalidate',true)
    bode.style.overflowY = 'scroll'

}

btnregis2.addEventListener('click', regis2)
function regis2() {
    bode.style.overflowY = 'hidden'
    valdi.removeAttribute('novalidate')
    valdi2.removeAttribute('novalidate')
    document.getElementById("latar-formulir").style.opacity = "1"
    document.getElementById("latar-formulir").style.pointerEvents = "auto"
    document.querySelector('.formulir-regis').style.display = 'block'
    document.querySelector('.formulir').style.display = 'none'
    window.addEventListener('wheel', function (e) {
        e.preventDefault();
    });
    window.scrollTo({
        top: 0,
        behavior: 'smooth'})

}


noAkun.addEventListener('click', regis)
function regis() {
    valdi.removeAttribute('novalidate')
    valdi2.removeAttribute('novalidate')
    document.querySelector('.formulir-regis').style.display = 'block'
    document.querySelector('.formulir').style.display = 'none'
    document.getElementById('log-password').value = ''
    document.getElementById('reg-password').value = ''
    document.getElementById('log-email').value = ''
    document.getElementById('reg-email').value = ''
    document.getElementById('pin').value = ''
    document.getElementById('reg-username').value = ''

}


pnyAkun.addEventListener('click', login)
function login() {
    valdi.removeAttribute('novalidate')
    valdi2.removeAttribute('novalidate')
    document.querySelector('.formulir').style.display = 'block'
    document.querySelector('.formulir-regis').style.display = 'none'


}
// ----------------------------------//
// document.addEventListener("DOMContentLoaded", function() {
//     const slidesContainer = document.querySelector(".slides");
//     const prevButton = document.querySelector(".prev-button");
//     const nextButton = document.querySelector(".next-button");
//     const slideWidth = slidesContainer.clientWidth / 4; // Assuming 3 slides
//     let currentIndex = 0;
  
//     prevButton.addEventListener("click", function() {
//       if (currentIndex > 0) {
//         currentIndex--;
//         slidesContainer.style.transition = "transform 0.5s ease";
//         slidesContainer.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
//       }
//     });
  
//     nextButton.addEventListener("click", function() {
//       const maxIndex = slidesContainer.children.length - 1;
  
//       if (currentIndex < maxIndex) {
//         currentIndex++;
//         slidesContainer.style.transition = "transform 0.5s ease";
//         slidesContainer.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
//       }
//     });
  
//     slidesContainer.addEventListener("transitionend", function() {
//       slidesContainer.style.transition = ""; // Remove transition after the animation
//     });
//   });
  
// var slideIndex = 1;
// showDivs(slideIndex);

// function plusDivs(n) {
//   showDivs(slideIndex += n);
// }

// function showDivs(n) {
//   var i;
//   var x = document.getElementsByClassName("slide");
//   if (n > x.length) {slideIndex = 1}
//   if (n < 1) {slideIndex = x.length}
//   for (i = 0; i < x.length; i++) {
//     x[i].style.display = "none";  
//   }
//   x[slideIndex-1].style.display = "flex";  
// }
// const slideshow = document.getElementById('slideshow');
// const slides = slideshow.getElementsByClassName('slide');
// const nextBtn = document.getElementById('nextBtn');
// let currentIndex = 1;

// nextBtn.addEventListener('click', () => {
//   // Hide the current slide
//   slides[currentIndex].style.transform = 'translateX(-100%)';

//   // Update the current index
//   currentIndex = (currentIndex + 1) % slides.length;

//   // Show the next slide
//   slides[currentIndex].style.transform = 'translateX(0)';
// });
const slideshow = document.getElementById('slideshow');
const slides = slideshow.getElementsByClassName('slide');
const nextBtn = document.getElementById('nextBtn');
const prevBtn = document.getElementById('prevBtn');
let currentIndex = 0;

// Hide all slides except the first one
for (let i = 1; i < slides.length; i++) {
  slides[i].style.transform = 'translateX(-100%)';
}

nextBtn.addEventListener('click', () => {
  goToSlide((currentIndex + 1) % slides.length);
});

prevBtn.addEventListener('click', () => {
  goToSlide((currentIndex - 1 + slides.length) % slides.length);
});

function goToSlide(index) {
  // Hide the current slide
  slides[currentIndex].style.transform = 'translateX(-100%)';

  // Show the next slide
  slides[index].style.transform = 'translateX(0)';

  // Update the current index
  currentIndex = index;
}
