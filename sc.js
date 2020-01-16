$(document).ready(function(){
  $('form input').change(function () {
    $('form p').text(this.files.length + " fisiere selectate.");
  });
});