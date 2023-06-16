$(document).ready(function () {
  var likeButtons = document.querySelectorAll('.like-btn');
  var commentButtons = document.querySelectorAll('.comment-btn');

  likeButtons.forEach(function(button) {
    button.addEventListener('click', function(event) {
      event.preventDefault();
      $('#exampleModal').modal('show');
    });
  });

  commentButtons.forEach(function(button) {
    button.addEventListener('click', function(event) {
      event.preventDefault();
      $('#exampleModal').modal('show');
    });
  });

  var originalValues = {};

  $('#edit').click(function() {
    $('input[name!="email"]').each(function() {
      originalValues[$(this).attr('name')] = $(this).val();
    });
    $('input[name!="email"]').prop('disabled', false);
    $('.profile').removeClass('d-none');
  });

  $('#cancel').click(function() {
    $('input[name!="email"]').each(function() {
      var name = $(this).attr('name');
      $(this).val(originalValues[name]);
    });
    $('input[name!="email"]').prop('disabled', true);
    $('.profile').addClass('d-none');
  });
});