@extends('layouts.panel')
@section('title', 'Mostar visitas')
@section('content')
  @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <span class="alert-icon"><i class="fas fa-check-circle"></i></span>
      <span class="font-weight-bold">{{ session('status') }}</strong>
        <button type="button my-auto" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true" class="pt-1 mt-4 pt-md-0 mt-md-1">&times;</span>
        </button>
    </div>
  @endif

  <div class="card shadow">
    <div class="card-header border-1">
      <div class="row align-items-center">
        <div class="col">
          <h2 class="mb-0">Visitas</h2>
        </div>
        <div class="col text-right">
          <a href="{{ route('visits.create') }}" class="btn btn-sm btn-primary">Nueva visita</a>
        </div>
      </div>
    </div>
    <div class="table-responsive">
      <!-- Projects table -->
      <table class="table align-items-center table-flush">
        <thead class="thead-light">
          <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Asunto</th>
            <th scope="col">Cargo</th>
            <th scope="col">Estado</th>
            <th scope="col">Nombre de la oficina</th>
            <th scope="col">Opciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($visits as $visit)
            <tr>
              <th scope="row">{{ $visit->name }}</th>
              <td>{{ $visit->subject }}</td>
              <td>{{ $visit->code }}</td>
              <td class="font-weight-bold {{ $visit->statusColor }}">
                {{ $visit->statusDisplay }}
              </td>
              <td>{{ $visit->office_name }}</td>
              <td>
                <a href="" class="btn btn-sm btn-primary">Editar</a>
                <a href="" class="btn btn-sm btn-danger">Eliminar</a>
              </td>
            </tr>
          @endforeach
          <tr>
            <td colspan="6" class="pl-3 pb-0 pt-3">
              {{ $visits->links() }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
@endsection
