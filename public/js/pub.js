
//Show and Hide Methodology fields depending on disinfectantTypeInput, Show for Free Chlorine and Hide for all others
function toggleInputs() {
  if( $('#disinfectantTypeInput').val() == 'free_chlorine' ) {
    $('#phContainer').css('display', 'flex');//replace with show, show forces display:block
    $('#methodologyContainer').css('display', 'flex');
    $('#phWarning').hide();
  } else {
    $('#phContainer').hide();
    $('#methodologyContainer').hide();
    $('#phWarning').css('display', 'flex');
  }
}

//preform toggle methodology on page load
$(document).ready(function() {
  toggleInputs();
});

//preform toggle methodology on input change
$(document).on('change', '#disinfectantTypeInput', function() {
    toggleInputs();
});
