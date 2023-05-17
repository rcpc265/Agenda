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
          <label class="form-label" for="modal_name">Nombre de la visita:</label>
          <input type="text" name="name" class="form-control" value="{{ old('name') }}">
          @error('name')
            <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
              <i class="fas fa-exclamation-circle mr-1"></i>
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="modal_subject">Asunto</label>
          <input type="text" id="subject" name="subject" class="form-control" value="{{ old('subject') }}" autofocus>
          @error('subject')
            <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
              <i class="fas fa-exclamation-circle mr-1"></i>
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="modal_start_date">Fecha inicial:</label>
          <input type="datetime-local" name="start_date" class="form-control" value="{{ old('start_date') }}">
          @error('start_date')
            <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
              <i class="fas fa-exclamation-circle mr-1"></i>
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="modal_end_date">Fecha final:</label>
          <input type="datetime-local" name="end_date" class="form-control" value="{{ old('end_date') }}">
          @error('end_date')
            <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
              <i class="fas fa-exclamation-circle mr-1"></i>
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="modal_code">Cargo:</label>
          <input type="text" name="code" class="form-control" value="{{ old('code') }}">
          @error('code')
            <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
              <i class="fas fa-exclamation-circle mr-1"></i>
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <div class="form-group">
          <label class="form-label" for="modal_status">Seleccionar estado:</label>
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
          <label class="form-label" for="modal_office_name">Nombre de la oficina:</label>
          <input type="text" name="office_name" class="form-control" value="{{ old('office_name') }}">
          @error('office_name')
            <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
              <i class="fas fa-exclamation-circle mr-1"></i>
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        <label class="form-label" for="modal_visitor_id">Seleccionar visitante:</label>
        <div class="form-group row">
          <div class="col pr-0">
            <select id="visitor_id" name="visitor_id" class="form-control">
              @foreach ($visitors as $visitor)
                <option value="{{ $visitor->id }}" {{ old('visitor_id') == $visitor->id ? 'selected' : '' }}>
                  {{ $visitor->name }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-auto">
            <button type="button" class="btn btn-success form-control" modal-launcher data-toggle="modal"
              data-target="#add-new-visitor" id="modal-launcher">
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

  <div class="modal fade" tabindex="-1" role="dialog" id="add-new-visitor">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3>Añadir nuevo visitante:</h3>
          <button type="button" class="discard-product close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="modal_form">
          <div class="modal-body pb-0 pt-0">
            <div class="form-group">
              <label class="form-label" for="modal_name">Nombre del visitante:</label>
              <input type="text" id="modal_name" name="modal_name" class="form-control">
              <div class="d-none" id="modal_error_name">
                <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
                  <i class="fas fa-exclamation-circle mr-1"></i>
                  <strong id="modal_error_message_name"></strong>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label" for="modal_entity">Entidad:</label>
              <input type="text" id="modal_entity" name="modal_entity" class="form-control">
              <div class="d-none" id="modal_error_entity">
                <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
                  <i class="fas fa-exclamation-circle mr-1"></i>
                  <strong id="modal_error_message_entity"></strong>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label" for="modal_dni">DNI:</label>
              <input type="text" id="modal_dni" name="modal_dni" class="form-control">
              <div class="d-none" id="modal_error_dni">
                <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
                  <i class="fas fa-exclamation-circle mr-1"></i>
                  <strong id="modal_error_message_dni"></strong>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label" for="modal_phone_number">Número de celular:</label>
              <input type="text" id="modal_phone_number" name="modal_phone_number" class="form-control">
              <div class="d-none" id="modal_error_phone_number">
                <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
                  <i class="fas fa-exclamation-circle mr-1"></i>
                  <strong id="modal_error_message_phone_number"></strong>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label" for="modal_email">Correo electrónico:</label>
              <input type="text" id="modal_email" name="modal_email" class="form-control">
              <div class="d-none" id="modal_error_email">
                <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
                  <i class="fas fa-exclamation-circle mr-1"></i>
                  <strong id="modal_error_message_email"></strong>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer pt-2">
            <button type="button" class="discard-product btn btn-danger mr-2" data-dismiss="modal" id="cancel-btn">Cancelar</button>
            <button id="add-visitor" type="submit" class="btn btn-md btn-success">Crear visitante</button>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection

@push('script')
  <script>
    console.clear();
    // Get all the form-control selectors
    const formControls = document.querySelectorAll('select.form-control');
    const visitor_choices = new Choices('#visitor_id');

    const fields = ['name', 'entity', 'dni', 'phone_number', 'email'];
    const fieldValues = {};

    const fieldErrors = {};
    for (const field of fields) {
      fieldErrors[field] = {
        box: $(`#modal_error_${field}`),
        message: $(`#modal_error_message_${field}`)
      };
    }

    $("#cancel-btn").click(function(event) {
      $('#modal_form').trigger('reset');

      // Hide all the error boxes
      for (const field in fieldErrors) {
        fieldErrors[field].box.addClass('d-none');
      }
    });

    $("#add-visitor").click(function(event) {
      event.preventDefault();
      for (const field of fields) {
        fieldValues[field] = $(`#modal_${field}`).val();
      };

      $.ajax({
        url: '{{ route('visitors.store') }}',
        type: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        data: JSON.stringify(fieldValues),

        success: function(response) {
          console.log(response.message);
          $('#add-new-visitor').modal('hide');
          $('#cancel-btn').click();

          // Add the new visitor to the select
          visitor_choices.setChoices([{
            value: response.id,
            label: response.name,
            selected: true
          }], 'value', 'label', false)
        },

        error: function(response) {
          if (response.responseJSON) {
            console.log(response.responseJSON.message);
            const errors = response.responseJSON.errors;

            for (const field in fieldErrors) {
              const box = fieldErrors[field].box;
              const message = fieldErrors[field].message;

              if (errors[field]) {
                box.removeClass('d-none');
                message.text(errors[field]);
              } else {
                box.addClass('d-none');
              }
            }
          }
        }
      })
    })
  </script>
@endpush

<!-- Error handling script -->
@include('includes.form.error')
