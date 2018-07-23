var mainform =document.querySelector('.contact');
var form =mainform.querySelector('.contact__fildset');
var nameimput = form.querySelector('#name');
var email =form.querySelector('#email');
var validateBtn = form.querySelector('.submit');
var comment=form.querySelector('#comment');
var elems=form.querySelectorAll('.contact__input');

var valid=true;

mainform.addEventListener('submit', function (event) {
  event.preventDefault();
 var errors = form.querySelectorAll('.error');
    for(var i=0;i<errors.length;i++){
      errors[i].remove();
    }
  for(var i=0;i<elems.length-2;i++)
  {
    if(!elems[i].value)
    {
        console.log(elems[i]+" is Empty");
        var error = document.createElement('span');
        error.className='error';
        error.innerHTML = 'Is Empty!';
        elems[i].parentElement.insertBefore(error, elems[i]);
        valid=false;
    }
  }
  var file=form.querySelector('#file');
 if(valid) {
   var data= new FormData();
   data.append('name',nameimput.value);
   data.append('email',email.value);
   data.append('comment', comment.value);
   $.ajax({
    url: '/handler.php',
    data: data,
    success: function(data) {
    console.log(data);
  },
  error: function (request, status, error) {
    console.log(request);
    console.log(status);
    console.log(error);
  }
});
 }
});
