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
            <th scope="col">Nombre de<br>la oficina</th>
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
                {{ $visit->status }}
              </td>
              <td>{{ $visit->office_name }}</td>
              <td>
                <a href="{{ route('visits.edit', $visit) }}" class="btn btn-sm btn-primary">Editar</a>

                <!-- Button trigger modal -->
                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                  data-target="#deleteModal{{ $visit->id }}">Eliminar</button>
              </td>
            </tr>

            <!-- Modal -->
            <div class="modal fade" id="deleteModal{{ $visit->id }}" tabindex="-1" role="dialog"
              aria-labelledby="deleteModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h3 class="modal-title" id="deleteModalLabel">
                      Confirmar acción
                    </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body py-0 my-0">
                    ¿Está seguro(a) que desea <span class="text-dark">eliminar</span> la visita "{{ $visit->name }}"?
                  </div>
                  <div class="modal-footer pt-3">
                    <form action="{{ route('visits.destroy', $visit) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                      <button type="submit" class="btn btn-danger">Confirmar</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </tbody>
      </table>


      <hr class="mt-1 mb-3">
      <div class="card-body d-sm-flex justify-content-center py-0">
        {{ $visits->links() }}
      </div>
    </div>
  </div>
@endsection
