<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- Bootstrap4 --}}
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <link rel="stylesheet" href="{{asset('css/app.css')}}">

  {{--TODO move to style file--}}
  <style>
  h1 {
  padding-top: 30px;
  padding-bottom: 10px;
}

/*Form styling*/
form {
  padding: 20px;
  background-color: #f4f4f4;
  border: 1px solid #e3e3e3;
  border-radius: 4px;
}

/*Vertical align labels and error messages, matched from input padding*/
.row>label, .row>div.error-message {
  padding: 8px 12px;
}

/*Vertical align labels for radio buttons*/
.radio-inline>label {
  padding: 8px 0px;
}

/*Red box around incorect field after validation*/
.alert-danger {
  padding-top: 5px;
  padding-bottom: 5px;
  border: 1px solid transparent;
  border-radius: 4px;
}

/* RESULTS ////////////////////////////////// */

/*Form styling*/
#inputs {
  padding: 20px;
  background-color: #f4f4f4;
  border: 1px solid #e3e3e3;
  border-radius: 4px;
}

/*float all input values to right*/
div.col-2, div.col-3 {
  text-align: right;
}

/*margin between each horizontal input*/
div.row {
  margin-bottom: .5rem;
}

.input-label {
  /*MAKE BOLD*/
}

.no-display {
    display: none;
}

#giardiaSolutions, #virusSolutions {
  padding-top: 20px;
}

  </style>

</head>
<body>
  <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="/">CT Calc</a>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
        <a class="nav-link" href="/">Home</a>
      </li>
      <li class="nav-item {{ Request::is('calculator') || Request::is('results') ? 'active' : '' }}">
        <a class="nav-link" href="/calculator">Calculator</a>
      </li>
      <li class="nav-item {{ Request::is('about') ? 'active' : '' }}">
        <a class="nav-link" href="/about">About</a>
      </li>
    </ul>
  </div>
</nav>

  <div class="container">
    @yield('content')
  </div>

  {{--Bootstrap 4--}}
  <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

  <script>
  //Show and Hide Methodology fields depending on disinfectantTypeInput, Show for Free Chlorine and Hide for all others
  function toggleInputs() {
    if( $('#disinfectantTypeInput').val() == 1 ) {
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
  </script>
</body>
</html>
