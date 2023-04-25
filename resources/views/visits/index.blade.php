@extends('layouts.panel')
@section('title', 'Mostar visitas')
@section('content')
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
            <th scope="col">Opciones</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">
              /argon/
            </th>
            <td>
              3,569
            </td>
            <td>
              <a href="" class="btn btn-sm btn-primary">Editar</a>
              <a href="" class="btn btn-sm btn-danger">Eliminar</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
@endsection
