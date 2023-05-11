@extends('layouts.panel')
@section('title', 'Añadir nueva visita')
@section('content')
  <div class="card shadow">
    <div class="card-header border-1">
      <div class="row align-items-center">
        <div class="col">
          <h2 class="mb-0">Editar información del visitante</h2>
        </div>
        <div class="col text-right">
          <a href="{{ route('visitors.index') }}" class="btn btn-sm btn-success">
            <i class="fas fa-chevron-left"></i>
            Regresar</a>
        </div>
      </div>
    </div>

    <div class="card-body">
      <form action="{{ route('visitors.update', $visitor) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
          <label class="form-label" for="name">Nombre de la visita:</label>
          <input type="text" name="name" class="form-control" value="{{ old('name', $visitor->name) }}">
          @error('name')
            <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
              <i class="fas fa-exclamation-circle mr-1"></i>
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="entity">Entidad:</label>
          <input type="text" name="entity" class="form-control" value="{{ old('entity', $visitor->entity) }}">
          @error('entity')
            <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
              <i class="fas fa-exclamation-circle mr-1"></i>
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="dni">DNI:</label>
          <input type="text" name="dni" class="form-control" value="{{ old('dni', $visitor->dni) }}">
          @error('dni')
            <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
              <i class="fas fa-exclamation-circle mr-1"></i>
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="phone_number">Número de celular:</label>
          <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $visitor->phone_number) }}">
          @error('phone_number')
            <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
              <i class="fas fa-exclamation-circle mr-1"></i>
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="email">Correo electrónico:</label>
          <input type="text" name="email" class="form-control" value="{{ old('email', $visitor->email) }}">
          @error('email')
            <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
              <i class="fas fa-exclamation-circle mr-1"></i>
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>

        <button type="submit" class="btn btn-sm btn-primary">Actualizar visita</button>
      </form>
    </div>
  </div>
@endsection

@section('script')
  <script>
    $(document).ready(function() {
      const firstError = $('.error-alert:first');

      // check if there are error alerts
      if (firstError.length) {
        // scroll to the first error
        $('html, body').animate({
          scrollTop: firstError.offset().top - 250
        }, 400, 'swing', function() {
          // focus on the closest input field
          firstError.closest('.form-group').find('.form-control').focus();
        });
      } else {
        // focus on the first element with autofocus
        $('[autofocus]').focus();
      }
    })
  </script>
@endsection
