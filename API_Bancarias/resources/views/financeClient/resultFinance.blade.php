@extends('home.layout')

@section('content')
<div class="card text-center">
    <div class="card-header">
      Resultado de Financiación
    </div>
    <div class="card-body">
      <h5 class="card-title">Tu Finaciación Fue:</h5>
      <p class="card-text">{{$dataClient->status}} para pagar en {{$dataClient->cuotas}} cuotas</p>
      {{-- <a href="#" class="btn btn-primary">Go somewhere</a> --}}
    </div>
  </div>
@endsection
