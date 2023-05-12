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
          <label class="form-label" for="name">Nombre de la visita:</label>
          <input type="text" name="name" class="form-control" value="{{ old('name') }}">
          @error('name')
            <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
              <i class="fas fa-exclamation-circle mr-1"></i>
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="subject">Asunto</label>
          <input type="text" id="subject" name="subject" class="form-control" value="{{ old('subject') }}" autofocus>
          @error('subject')
            <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
              <i class="fas fa-exclamation-circle mr-1"></i>
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="start_date">Fecha inicial:</label>
          <input type="datetime-local" name="start_date" class="form-control" value="{{ old('start_date') }}">
          @error('start_date')
            <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
              <i class="fas fa-exclamation-circle mr-1"></i>
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="end_date">Fecha final:</label>
          <input type="datetime-local" name="end_date" class="form-control" value="{{ old('end_date') }}">
          @error('end_date')
            <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
              <i class="fas fa-exclamation-circle mr-1"></i>
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="code">Cargo:</label>
          <input type="text" name="code" class="form-control" value="{{ old('code') }}">
          @error('code')
            <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
              <i class="fas fa-exclamation-circle mr-1"></i>
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="status">Seleccionar estado:</label>
          <select class="form-control" name="status" title="Seleccionar estado">
            @foreach ($statuses as $statusValue => $statusDisplay)
              <option value="{{ $statusValue }}" {{ old('status') === $statusValue ? 'selected' : '' }}>
                {{ $statusDisplay }}
              </option>
            @endforeach
          </select>
          @error('status')
            <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
              <i class="fas fa-exclamation-circle mr-1"></i>
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="office_name">Nombre de la oficina:</label>
          <input type="text" name="office_name" class="form-control" value="{{ old('office_name') }}">
          @error('office_name')
            <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
              <i class="fas fa-exclamation-circle mr-1"></i>
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>

        <label class="form-label" for="visitor_id">Seleccionar visitante:</label>
        <div class="form-group row">
          <div class="col">
            <select id="visitor_id" name="visitor_id" class="form-control">
              @foreach ($visitors as $visitor)
                <option value="{{ $visitor->id }}" {{ old('visitor_id') == $visitor->id ? 'selected' : '' }}>
                  {{ $visitor->name }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-auto">
            <button type="button" class="btn btn-success form-control">
              <i class="fas fa-plus"></i>
            </button>
          </div>
          @error('visitor_id')
            <div class="col alert alert-danger rounded py-2 mt-2 mb-1">{{ $message }}</div>
          @enderror
        </div>
        <div class="d-none">
          <input value="{{ auth()->user()->id }}" name="user_id">
        </div>
        <button type="submit" class="btn btn-sm btn-primary">Crear visita</button>
      </form>
    </div>
  </div>
@endsection

@push('script')
  <script>
    // Get all the form-control selectors
    const formControls = document.querySelectorAll('select.form-control');

    // Loop through each form control and create a Choices instance
    formControls.forEach(formControl => {
      new Choices(formControl);
    });
  </script>
@endpush

<!-- Error handling script -->
@include('includes.form.error')
