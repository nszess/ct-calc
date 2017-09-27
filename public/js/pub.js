//Show and Hide Methodology fields depending on disinfectantTypeInput, Show for Free Chlorine and Hide for all others
function toggleInputs() {
  if( $('#disinfectantTypeInput').val() == 'free_chlorine' ) {
    //$('#disinfectantConcentrationContainer').show();
    //$('#timeContainer').show();
    $('#phContainer').show();
    $('#methodologyContainer').show();
    $('#phWarning').hide();
  }
  else {
    //$('#disinfectantConcentrationContainer').hide();
    //$('#timeContainer').hide();
    $('#phContainer').hide();
    $('#methodologyContainer').hide();
    $('#phWarning').show();
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
