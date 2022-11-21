@extends('home.layout')

@section('content')
    <div class="container" >
        <div class="p-4">
            <h3 class="">Bienvenido {{ $dataClient['firstName']}} {{ $dataClient['lastName']}} </h3>
            <form method="post" action=" {{ route('financeUpdate', $dataClient) }}">
                @method('patch')
                @csrf
                <div class="row g-4">
                        <div class="col mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" value="{{$dataClient['email']}}" class="form-control" placeholder="Dirección Email" aria-describedby="email">
                        </div>
                        <div class="col mb-3">
                            <label for="" class="form-label">Telefono</label>
                            <input type="number" name="phone" id="phone" class="form-control" value="{{ $dataClient['mobileNumber'] }}" placeholder="Su telefono perso" readonly>
                        </div>
                </div>
                <div class="row g-4">
                        <div class="col mb-3">
                            <label for="" class="form-label">Tipo de documento</label>
                            <select class="form-select" name="docType" aria-label="Default select example">
                            @foreach([1 => 'Cedula de Ciudadania', 2 => 'Cedula Extranjeria', 3 => 'Pasaporte'] as $key => $docType)
                                <option disabled value="{{ $key }}" {{ ($key == $dataClient->clientDocType) ? 'selected' : '' }}>{{ $docType }}</option>                                         
                            @endforeach
                            </select>
                        </div>

                        <div class="col mb-3">
                            <label for="" class="form-label">Numero Documento</label>
                            <input type="text" name="docNumber" id=""  value="{{ $dataClient['clientDocNumber'] }} " class="form-control" readonly>
                        </div>

                </div>
                <div class="row g-4">
                    <div class="col mb-3">
                        <label for="" class="form-label">Decripción compra</label>
                        <input type="text" name="purchaseDescription" id=""  value="{{ $dataClient['purchaseDescription'] }} " class="form-control" readonly>
                    </div>

                        <div class="col mb-3">
                            <label for="" class="form-label">Total a Financiar</label>
                            <input type="text" name="totalValue" value="{{ $newTotal }} " name="" id="" class="form-control" placeholder=""  readonly>                        
                        </div>

                </div>
                <div class="row g-4">
                    <div class="col mb-3">
                        <label for="" class="form-label">Tasa de Interes</label>
                        <input type="text" name="interests"  value="15%" name="" id="" class="form-control" placeholder="" readonly>                        
                    </div>
                    <div class="col mb-3">
                        <label for="" class="form-label">Cuotas</label>
                        <select name="dues" class="form-select" aria-label="Default select example">
                            <option disabled selected>Seleccione la cantidad de cuotas</option>
                            @for ($i=0; $i<36; $i++)
                                <option value="{{ $i+1 }}">{{$i+1}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="text-center">
                    <a href="/"  class="btn btn-secondary btn-lg">Cancelar Financiamiento</a>
                    <button class="btn btn-success btn-lg" type="submit">Financiar Compra</button>
                </div>
            </form>
        </div>        
    </div>
@endsection

