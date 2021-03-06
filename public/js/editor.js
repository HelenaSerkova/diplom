"use strict";

var quill = new Quill('#editor-container', {
  modules: {
    toolbar: [
      [{ header: [1, 2, 3, 4, false] }],
      [{ 'font': [] }],
      ['bold', 'italic', 'underline', 'strike'],
      ['blockquote'],
      [{ 'color': [] }, { 'background': [] }],
      ['image', 'video'],
      ['clean']
    ]
  },
  placeholder: 'Место для самых интересных статей...',
  theme: 'snow'  // or 'bubble'
});

var form = document.querySelector('form');
// form.onsubmit = function() {
//   // Populate hidden form on submit
//   var about = document.querySelector('input[name=text]');
//   about.value = JSON.stringify(quill.getContents());
//
//   console.log("Submitted", $(form).serialize(), $(form).serializeArray());
//
//   // No back end to actually submit to!
//   alert('Open the console to see the submit data!')
//   return false;
//
// };


// let addForm = document.forms['add-article'];
form.addEventListener('submit', async (event)=>{
  event.preventDefault();
  var about = document.querySelector('input[name=text]');
  about.value = JSON.stringify(quill.getContents());
  const response = await fetch(form.action,
  {
    method: form.method,
    body: new FormData(form)
  });
  const answer = await response.json();
  console.log(answer);

});
