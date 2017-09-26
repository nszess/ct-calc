@extends('layouts.app')

@section('content')
<h1>Contact Time Calculator</h1>

<p>This Contact Time Calculator calculates the contact time provided and the amount of contact time needed to provide adequate inactivation of Giardia and viruses for a range of disinfectants.  These calculations can be useful for determining compliance with the Surface Water Treatment Rule.</p>
<p>The contact time provided is calculated based on user inputs of the disinfectant residual and the time provided.</p>
<p>The amount contact time needed is determined from user inputs of the type of disinfectant, the logs of inactivation needed, temperature, pH, and disinfectant residual.  The calculator uses the methods and tables in EPA Manual EPA815-R-99-013, titled “Disinfection Profiling and Benchmarking Guidance Manual”, dated August 1999, for determining the amount of inactivation needed.</p>

<a href="/calculator">Click here to get started</a>
@endsection
