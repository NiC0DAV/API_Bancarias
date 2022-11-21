@extends('home.layout')

@section('content')
  <div class="container">
    <div class="card text-center">
      <div class="card-header">
        Resultado de Financiación
      </div>
      <div class="card-body">
        <h5 class="card-title">Tu Finaciación Fue:</h5>
        <p class="card-text">{{$dataClient->status}} para pagar en {{$dataClient->cuotas}} cuotas</p>
        {{-- <a href="#" class="btn btn-primary">Go somewhere</a> --}}
      </div>
      <div class="text-align-center mb-3">
        <a href="{{route("returnToStore",$dataClient)}}" class="btn btn-success" type="button">Regresar al Comercio</a>
      </div>
    </div>
  </div>
@endsection
