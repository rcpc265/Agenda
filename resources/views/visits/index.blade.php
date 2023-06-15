@extends('layouts.panel')
@section('title', 'Mostar visitas')
@section('content')
  @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show"
      role="alert">
      <span class="alert-icon"><i class="fas fa-check-circle"></i></span>
      <span class="font-weight-bold">{{ session('status') }}</strong>
        <button class="close"
          data-dismiss="alert"
          type="button my-auto"
          aria-label="Close">
          <span class="pt-1 mt-4 pt-md-0 mt-md-1"
            aria-hidden="true">&times;</span>
        </button>
    </div>
  @endif
  <div class="card shadow">
    <div class="card-header border-1">
      <div class="row align-items-center">
        <div class="col">
          <h2>Visitas
          </h2>
        </div>
        <div class="col-8">
          <form class="form-inline pr-5"
            action="{{ route('visits.index') }}">
            <div class="input-group-append"
              x-data="{ isActive: false }">
              <input name="visitor"
                type="text"
                value="{{ request('visitor') }}"
                style="height: 30px !important; padding-right: 100px !important;"
                x-cloak
                @input="isActive = true"
                @blur="isActive = false"
                :class="['form-control mr-2 pr-5']"
                placeholder="Nombre del visitante">
              <button type="submit"
                x-cloak
                :class="{ 'py-0': true, 'btn': true, 'btn-outline-primary': true, 'active': isActive }">Buscar</button>
            </div>
          </form>
        </div>

        <button class="btn btn-sm btn-primary "
          data-toggle="modal"
          data-target="#generatePDF"
          data-placement="left"
          type="button">PDF</button>

        @auth()
          <a class="btn btn-sm btn-primary btn-sm float-right"
            data-placement="left"
            href="{{ route('visits.create') }}">Nueva visita</a>
        @endauth()

        <div class="modal fade"
          id="generatePDF"
          role="dialog"
          aria-hidden="true"
          tabindex="-1">
          <div class="modal-dialog modal-dialog-centered"
            role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h2 class="modal-title text-uppercase"
                  id="deleteModalLabel">
                  Seleccionar fecha
                </h2>
                <button class="close"
                  data-dismiss="modal"
                  type="button"
                  aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="{{ route('home.pdf') }}"
                method="GET"
                target="_blank">
                <div class="modal-body py-0 my-0">
                  <div class="input-daterange datepicker row align-items-center">
                    <div class="col">
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                          </div>
                          <input class="form-control"
                            name="start_date"
                            type="text"
                            placeholder="Fecha inicial">
                        </div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                          </div>
                          <input class="form-control"
                            name="end_date"
                            type="text"
                            placeholder="Fecha final">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer mt--4">
                  <button class="btn btn-dark"
                    data-dismiss="modal"
                    type="button">Cancelar</button>
                  <button class="btn btn-success"
                    type="submit">Generar</button>
              </form>
            </div>
            </form>
          </div>
        </div>
      </div>

    </div>
    @if ($visits->isEmpty())
      <div class="card px-4">
        <div class="alert alert-warning py-1"
          role="alert">
          <span class="alert-icon"><i class="fas fa-exclamation-triangle"></i></span>
          <span class="font-weight-bold">No se encontraron resultados</span>
        </div>
      </div>
    @else
      <div class="table-responsive">
        <!-- Projects table -->
        <table class="table align-items-center table-flush">
          <thead class="thead-light">
            <tr>
              <th scope="col">Asunto</th>
              @auth()
                <th scope="col">Estado</th>
              @endauth
              <th scope="col">Nombre del visitante</th>
              <th scope="col">Fecha</th>
              <th class="text-center"
                scope="col">Hora de inicio y<br>Hora final</th>
              @auth()
                <th scope="col">Opciones</th>
              @endauth
            </tr>
          </thead>
          <tbody>
            @auth()
              @push('script')
                <script>
                  function storeStatus(id, status) {
                    $.ajaxSetup({
                      headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                      },
                    })

                    $.ajax({
                      url: "{{ route('visits.status') }}",
                      method: 'PATCH',
                      data: JSON.stringify({
                        id,
                        status
                      }),
                      success: function(response) {
                        console.log(response.message);
                      },

                      error: function(response) {
                        console.log(`Error: ${response.responseJSON.error}`);
                      }
                    });
                  }
                </script>
              @endpush
            @endauth
            @foreach ($visits as $visit)
              <tr>
                <td scope="row">{{ $visit->subject }}</td>
                @auth()
                  <td>
                    <div x-data="{
                        badges: [
                            { status: 'Pendiente', color: 'badge-primary' },
                            { status: 'Confirmado', color: 'badge-success' },
                            { status: 'Cancelado', color: 'badge-danger' }
                        ],
                        currentIndex: 0,
                        visitId: '{{ $visit->id }}',
                        get status() { return this.badges[this.currentIndex].status; },
                    }"
                      x-init="currentIndex = badges.findIndex(badge => badge.status === '{{ $visit->status }}');">
                      <button type="button"
                        x-cloak
                        x-on:click="currentIndex = (currentIndex + 1) % badges.length; storeStatus(visitId, status);"
                        :class="['btn', 'btn-sm', 'badge-pill', 'badge', badges[currentIndex].color]">
                        <span x-text="status"></span>
                      </button>
                    </div>
                  </td>
                @endauth
                <td>{{ $visit->visitor->name }}</td>
                <td>{{ Carbon\Carbon::parse($visit->start_date)->format('d/m') }}</td>
                <td class="text-center">{{ Carbon\Carbon::parse($visit->start_date)->format('H:i') }} -
                  {{ Carbon\Carbon::parse($visit->end_date)->format('H:i') }}</td>
                @auth()
                  <td>
                    <a class="btn btn-sm btn-primary"
                      href="{{ route('visits.edit', $visit) }}">Editar</a>

                    <!-- Button trigger modal -->
                    <button class="btn btn-sm btn-danger"
                      data-toggle="modal"
                      data-target="#deleteModal{{ $visit->id }}"
                      type="button">Eliminar</button>
                  </td>
                @endauth
              </tr>

              <!-- Modal -->
              <div class="modal fade"
                id="deleteModal{{ $visit->id }}"
                role="dialog"
                aria-labelledby="deleteModalLabel"
                aria-hidden="true"
                tabindex="-1">
                <div class="modal-dialog modal-dialog-centered"
                  role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h3 class="modal-title"
                        id="deleteModalLabel">
                        Confirmar acción
                      </h3>
                      <button class="close"
                        data-dismiss="modal"
                        type="button"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body py-0 my-0">
                      ¿Está seguro(a) que desea <span class="text-dark">eliminar</span> la visita?
                    </div>
                    <div class="modal-footer pt-3">
                      <form action="{{ route('visits.destroy', $visit) }}"
                        method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-secondary"
                          data-dismiss="modal"
                          type="button">Cancelar</button>
                        <button class="btn btn-danger"
                          type="submit">Confirmar</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </tbody>
        </table>

        @if ($visits->hasPages())
          <hr class="mt-1 mb-3">
          <div class="card-body d-sm-flex justify-content-center py-0">
            {{ $visits->links() }}
          </div>
        @endif
      </div>
    @endif
  </div>
@endsection
