@extends('layouts.panel')
@section('title', 'Añadir nueva visita')
@section('content')
  <div class="card shadow">
    <div class="card-header border-1">
      <div class="row align-items-center">
        <div class="col">
          <h2 class="mb-0">Editar visita</h2>
        </div>
        <div class="col text-right">
          <a href="{{ route('visits.index') }}" class="btn btn-sm btn-success">
            <i class="fas fa-chevron-left"></i>
            Regresar</a>
        </div>
      </div>
    </div>
    
    {{-- Display all errors --}}
    @if ($errors->any())
      <div class="alert alert-danger" role="alert">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="card-body">
      <form action="{{ route('visits.update', $visit) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
          <label class="form-label" for="subject">Asunto</label>
          <input type="text" id="subject" name="subject" class="form-control"
            value="{{ old('subject', $visit->subject) }}" autofocus>
          @error('subject')
            <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
              <i class="fas fa-exclamation-circle mr-1"></i>
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="start_date">Fecha inicial:</label>
          <input type="datetime-local" name="start_date" class="form-control"
            value="{{ old('start_date', $visit->start_date) }}">
          @error('start_date')
            <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
              <i class="fas fa-exclamation-circle mr-1"></i>
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="end_date">Fecha final:</label>
          <input type="datetime-local" name="end_date" class="form-control"
            value="{{ old('end_date', $visit->end_date) }}">
          @error('end_date')
            <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
              <i class="fas fa-exclamation-circle mr-1"></i>
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="status">Seleccionar estado:</label>
          <select class="form-control" name="status" title="Seleccionar estado">
            @foreach ($statuses as $status)
              <option value="{{ $status }}"
                {{ old('status', $visit->status) === $status ? 'selected' : '' }}>
                {{ $status }}
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

        <button type="submit" class="btn btn-sm btn-primary">Actualizar visita</button>
      </form>
    </div>
  </div>
@endsection

<!-- Error handling script -->
@include('includes.form.error')
