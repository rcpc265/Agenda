@extends('layouts.panel')
@section('title', 'Añadir nueva visita')
@section('content')
  <div class="card shadow">
    <div class="card-header border-1">
      <div class="row align-items-center">
        <div class="col">
          <h2 class="mb-0">Nueva visita</h2>
        </div>
        <div class="col text-right">
          <a href="{{ route('visits.index') }}" class="btn btn-sm btn-success">
            <i class="fas fa-chevron-left"></i>
            Regresar</a>
        </div>
      </div>
    </div>

    <div class="card-body">
        <form action="{{ route('visits.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre de la visita</label>
                <input type="text" name="nombre" class="form-control">
            </div>
            <div class="form-group">
                <label for="asunto">Asunto</label>
                <input type="text" name="asunto" class="form-control">
            </div>

            <button type="submit" class="btn btn-sm btn-primary">Crear visita</button>
        </form>
    </div>
  </div>
@endsection
