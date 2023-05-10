@extends('layouts.panel')
@section('title', 'Añadir nueva secretaria')
@section('content')
  <div class="card shadow">
    <div class="card-header border-1">
      <div class="row align-items-center">
        <div class="col">
          <h2 class="mb-0">Nueva secretaria</h2>
        </div>
        <div class="col text-right">
          <a href="{{ route('secretaries.index') }}" class="btn btn-sm btn-success">
            <i class="fas fa-chevron-left"></i>
            Regresar</a>
        </div>
      </div>
    </div>

    <div class="card-body">
      <form action="{{ route('secretaries.store') }}" method="POST">
        @csrf
        <div class="form-group">
          <label class="form-label" for="name">Nombre de la secretaria:</label>
          <input type="text" name="name" class="form-control" value="{{ old('name') }}">
          @error('name')
            <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
              <i class="fas fa-exclamation-circle mr-1"></i>
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="email">Correo electrónico:</label>
          <input type="text" name="email" class="form-control" value="{{ old('email') }}">
          @error('email')
            <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
              <i class="fas fa-exclamation-circle mr-1"></i>
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>

        <button type="submit" class="btn btn-sm btn-primary">Crear secretaria</button>
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
