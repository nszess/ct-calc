@extends('layouts.app')

@section('content')
<h1>Contact Time Calculator</h1>

{{-- Form Begin --}}
      {{-- INSTALL FORM HERE https://laravelcollective.com/docs/5.4/html --}}
      {!! Form::open(['url' => 'calculator', 'method' => 'post']) !!}
      <fieldset>
        <legend>Calculation Inputs</legend>

        {{-- Disinfectant Type Input --}}
        <div class="form-group row {{ $errors->has('disinfectantType') ? 'alert-danger' : '' }}">
          <label for="disinfectantType" class="col-4 col-form-label">Disinfectant Type:</label>
          <div class="col-3">
            {!!
              Form::select('disinfectantType', [
                '1' => 'Free Chlorine',
                '2' => 'Chlorine Dioxide',
                '3' => 'Chloramine',
                '4' => 'Ozone',
              ],
              $disinfectantType, [
                'id' => 'disinfectantTypeInput',
                'name' => 'disinfectantType',
                'class' => 'form-control',
                'placeholder' => '-- Select --'
              ]);
            !!}
          </div>
          @if ($errors->has('disinfectantType'))
          <div class="error-message col-5">
            {{ $errors->get('disinfectantType')[0] }}
          </div>
          @endif
        </div>

          {{-- Disinfectant Concentration Input --}}
          <div id="disinfectantConcentrationContainer" class="form-group row {{ $errors->has('disinfectantConcentration') ? 'alert-danger' : '' }}">
            <label for="disinfectantConcentration" class="col-4 col-form-label">Disinfectant Concentration (mg/L):</label>
            <div class="col-3">
              <input type="number" class="form-control" name="disinfectantConcentration" step="0.01" min="0" value="{{ old('disinfectantConcentration') ? old('disinfectantConcentration') : $disinfectantConcentration }}">
            </div>
            @if ($errors->has('disinfectantConcentration'))
            <div class="error-message col-5">
              {{ $errors->get('disinfectantConcentration')[0] }}
            </div>
            @endif
          </div>

          {{-- Time Input --}}
          <div id="timeContainer" class="form-group row {{ $errors->has('time') ? 'alert-danger' : '' }}">
            <label for="time" class="col-4 col-form-label">Time (Minutes):</label>
            <div class="col-3">
              <input type="number" class="form-control" name="time" step="0.01" min="0" value="{{ old('time') ? old('time') : $time }}">
            </div>
            @if ($errors->has('time'))
            <div class="error-message col-5">
              {{ $errors->get('time')[0] }}
            </div>
            @endif
          </div>

          {{-- Temperature Input --}}
          <div id="temperatureContainer" class="form-group row {{ $errors->has('temp') ? 'alert-danger' : '' }}">
            <label for="temp" class="col-4 col-form-label">Temperature (°C):</label>
            <div class="col-3">
              <input type="number" class="form-control" name="temp" step="0.01" min="0" value="{{ old('temp') ? old('temp') : $temp }}">
            </div>
            @if ($errors->has('temp'))
            <div class="error-message col-5">
              {{ $errors->get('temp')[0] }}
            </div>
            @endif
          </div>

          {{-- ph Input --}}
          <div id="phContainer" class="form-group row {{ $errors->has('ph') ? 'alert-danger' : '' }}">
            <label for="ph" class="col-4 col-form-label">pH:</label>
            <div class="col-3">
              <input type="number" class="form-control" name="ph" step="0.01" min="0" value="{{ old('ph') ? old('ph') : $ph }}">
            </div>
            @if ($errors->has('ph'))
            <div class="error-message col-5">
              {{ $errors->get('ph')[0] }}
            </div>
            @endif
          </div>

          {{-- Log Giardia Input --}}
            <div class="form-group row {{ $errors->has('logGiardia') ? 'alert-danger' : '' }}">
              <label for="logGiardia" class="col-4 col-form-label">Logs of Giardia Inactivation:</label>
              <div class="col-3">
                {!!
                  Form::select('logGiardia', [
                  '0.5' => '0.5',
                  '1.0' => '1',
                  '1.5' => '1.5',
                  '2.0' => '2',
                  '2.5' => '2.5',
                  '3.0' => '3',
                  ],
                  $logGiardia, [
                  'name' => 'logGiardia',
                  'class' => 'form-control',
                  'placeholder' => '-- Select --',
                  ]);
                  !!}
              </div>
              @if ($errors->has('logGiardia'))
              <div class="error-message col-5">
                {{ $errors->get('logGiardia')[0] }}
              </div>
              @endif
            </div>

            {{-- Log Virus Input --}}
              <div class="form-group row {{ $errors->has('logVirus') ? 'alert-danger' : '' }}">
                <label for="logVirus" class="col-4 col-form-label">Logs of Virus Inactivation:</label>
                <div class="col-3">
                  {!!
                    Form::select('logVirus', [
                      '2' => '2',
                      '3' => '3',
                      '4' => '4',
                    ],
                    $logVirus, [
                      'name' => 'logVirus',
                      'class' => 'form-control',
                      'placeholder' => '-- Select --',
                    ]);
                  !!}
                </div>
                @if ($errors->has('logVirus'))
                <div class="error-message col-5">
                  {{ $errors->get('logVirus')[0] }}
                </div>
                @endif
              </div>

              {{-- Methodology Input --}}
              <div id="methodologyContainer" class="form-group row {{ $errors->has('calcMethod') ? 'alert-danger' : '' }}">
                <label for="time" class="col-4 col-form-label">Methodology:</label>

                <div class="col-3">
                  <div class="form-check form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" name="calcMethod" class="form-check-input" value="round" {{$calcMethod == 'round' ? 'checked' : ''}}>
                      Round
                    </label>
                  </div>

                  <div class="form-check form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" name="calcMethod" class="form-check-input" value="formula" {{$calcMethod == 'formula' ? 'checked' : ''}}>
                      Formula
                    </label>
                  </div>
                </div>

                @if ($errors->has('calcMethod'))
                <div class="error-message col-5">
                  {{ $errors->get('calcMethod')[0] }}
                </div>
                @endif
              </div>



              <br />

              {{-- Submit Buttons --}}
              <div class="form-group">
                <div id="phWarning" class="alert alert-warning">
                  <strong>Warning:</strong> pH levels are assumed to be between 6.0 - 9.0
                </div>
                <div class="">
                  <button type="button" class="btn btn-default" onclick="window.location='{{ url("calculator") }}'">Clear</button>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </div>

            </fieldset>
            {!! Form::close() !!}
@endsection
