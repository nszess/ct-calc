@extends('layouts.app')

@section('content')

    <h1>Contact Time Results</h1>
    <div class="row">

      <div id="inputs" class="col-5">
        <h2>Inputs</h2>

        {{-- Disinfectant Type Input --}}
        <div class="row">
          <div class="col-8 input-label">Disinfectant Type:</div>
          <div class="col-2">{{ $disinfectantType }}</div>
        </div>


        {{-- Disinfectant Concentration Input --}}
        <div class="row">
          <div class="col-8 input-label">Disinfectant Concentration (mg/L):</div>
          <div class="col-2">{{ $disinfectantConcentration }}</div>
        </div>

        {{-- Time Input --}}
        <div class="row">
          <div class="col-8 input-label">Time (Minutes):</div>
          <div class="col-2">{{ $time }}</div>
        </div>

        {{-- Temperature Input --}}
        <div class="row">
          <div class="col-8 input-label">Temperature (°C):</div>
          <div class="col-2">{{ $temp }}</div>
        </div>

        {{-- ph Input --}}
        <div class="row {{ $ph ? '' : 'no-display' }}">
          <div class="col-8 input-label">pH:</div>
          <div class="col-2">{{ $ph }}</div>
        </div>

        {{-- Log Giardia Input --}}
        <div class="row">
          <div class="col-8 input-label">Logs of Giardia Inactivation:</div>
          <div class="col-2">{{ $logGiardia }}</div>
        </div>

        {{-- Log Virus Input --}}
        <div class="row">
          <div class="col-8 input-label">Logs of Virus Inactivation:</div>
          <div class="col-2">{{ $logVirus }}</div>
        </div>

        {{-- Methodology Input --}}
        <div class="row {{ $calcMethod ? '' : 'no-display' }}">
          <div class="col-8 input-label">Methodology:</div>
          <div class="col-2">{{ $calcMethod }}</div>
        </div>
      </div>

      <div class="col-1"></div>{{-- vertical padding --}}

      <div class="col-5">
        {{-- Giardia Solutions --}}
        <div id="giardiaSolutions">
          <h2>Giardia Solutions</h2>

          <div class="row">
            <div class="col-5">CT Provided:</div>
            <div class="col-3">{{ $ctProvided }}</div>
          </div>

          <div class="row">
            <div class="col-5">CT Required:</div>
            <div class="col-3">{{ $ctRequiredGiardia }}</div>
          </div>

          <div class="row">
            <div class="col-5">Compliance Ratio:</div>
            <div class="col-3">{{ $ctComplianceRatioGiardia }}</div>
          </div>
        </div>{{-- /#giardiaSolutions --}}

        {{-- Virus Solutions --}}
        <div id="virusSolutions">
          <h2>Virus Solutions</h2>
          <div class="row">
            <div class="col-5 input-label">CT Provided:</div>
            <div class="col-3">{{ $ctProvided }}</div>
          </div>

          <div class="row">
            <div class="col-5 input-label">CT Required:</div>
            <div class="col-3">{{ $ctRequiredVirus }}</div>
          </div>

          <div class="row">
            <div class="col-5 input-label">Compliance Ratio:</div>
            <div class="col-3">{{ $ctComplianceRatioVirus }}</div>
          </div>
        </div>{{-- /#virusSolutions --}}
      </div>{{-- /col --}}

    </div>{{-- /row --}}


    <button type="button" class="btn btn-primary" onclick="window.location='{{ url("calculator") }}'">Reset</button>
    {{--
      BUTTONS
      <button type="button" class="btn btn-primary" onclick="window.location='{{ url("calculator?dis=" + $dis) }}'">Reset With Inputs</button>
      <button type="button" class="btn btn-primary" onclick="window.location='{{ url("calculator") }}'">Export</button>
    --}}

@endsection
