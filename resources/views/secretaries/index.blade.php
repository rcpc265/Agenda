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
          <h2 class="mb-0">Secretarias</h2>
        </div>
        <div class="col text-right">
          <a href="{{ route('secretaries.create') }}" class="btn btn-sm btn-primary">Nueva secretaria</a>
        </div>
      </div>
    </div>
    <div class="table-responsive">
      <!-- Projects table -->
      <table class="table align-items-center table-flush">
        <thead class="thead-light">
          <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Correo</th>
            <th scope="col">Opciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($secretaries as $secretary)
            <tr>
              <th scope="row">{{ $secretary->name }}</th>
              <td>{{ $secretary->email }}</td>
              <td>
                <form action="{{ route('secretaries.destroy', $secretary) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <a href="{{ route('secretaries.edit', $secretary) }}" class="btn btn-sm btn-primary">Editar</a>
                  <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>


      <hr class="mt-1 mb-3">
      <div class="card-body d-sm-flex justify-content-center py-0">
        {{ $secretaries->links() }}
      </div>
    </div>
  </div>
@endsection
