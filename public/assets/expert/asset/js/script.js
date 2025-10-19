$(document).ready(function(){

    $("#imageUpload").change(function(data){
    
      var imageFile = data.target.files[0];
      var reader = new FileReader();
      reader.readAsDataURL(imageFile);
    
      reader.onload = function(evt){
        $('#imagePreview').attr('src', evt.target.result);
        $('#imagePreview').hide();
        $('#imagePreview').fadeIn(650);
      }
      
    });
    });
    
    // ================ FOOTER SELECT START HERE 
function formatText(icon) {
    return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>');
};
$('.select2-icon').select2({
    width: "100%",
    templateSelection: formatText,
    templateResult: formatText
});
// ================ FOOTER SELECT END HERE 
// ================ PAYMENT INPUT ICON START HERE
function formatText (icon) {
    return $('<span><i class="fas ' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>'); }; $('.select2-icon').select2({ width: "100%", templateSelection: formatText, templateResult: formatText });
// ================ PAYMENT INPUT ICON END HERE