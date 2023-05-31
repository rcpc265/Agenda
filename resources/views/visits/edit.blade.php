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

    {{-- @if ($errors->any())
      <div class="alert alert-danger" role="alert">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif --}}

    <div class="card-body">
      <form action="{{ route('visits.store') }}" method="POST">
        @csrf
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
        <label class="form-label" for="modal_visitor_id">Visitante:</label>
        <div class="form-group row">
          <div class="col pr-0">
            <select id="visitor_id" name="visitor_id" class="form-control">
              <option value="" disabled selected>Seleccione un visitante</option>
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
        </div>
        @error('visitor_id')
          <div class="mt--3 py-1 pl-2 alert alert-danger error-alert" role="alert">
            <i class="fas fa-exclamation-circle mr-1"></i>
            <strong>{{ $message }}</strong>
          </div>
        @enderror
        <input id="start_date" type="datetime-local" name="start_date" class="form-control"
          value="{{ old('start_date') }}" hidden>
        <input id="end_date" type="datetime-local" name="end_date" class="form-control" value="{{ old('end_date') }}"
          hidden>
        <div class="form-group">
          <label class="form-label mb--1">
            Seleccionar horario:
            <span id="datepicker-btn" class="ml-1 badge-pill btn badge-info py-1">
              <i class="far fa-calendar-alt"></i>&nbsp;&nbsp;Fecha
            </span>
          </label>
          <div class="button-radio d-flex justify-content-between flex-wrap flex-column flex-sm-row mr--2">
            <button type="button"
              class="badge-pill btn btn-outline-primary mt-3 py-2 px-md-4 px-lg-3 flex-lg-fill text-center mr-2 mr-lg-3">10:00
              -
              11:00</button>
            <button type="button"
              class="badge-pill btn btn-outline-primary mt-3 py-2 px-md-4 px-lg-3 flex-lg-fill text-center mr-2 mr-lg-3"
              disabled>11:00 - 12:00</button>
            <button type="button"
              class="badge-pill btn btn-outline-primary mt-3 py-2 px-md-4 px-lg-3 flex-lg-fill text-center mr-2 mr-lg-3">12:00
              -
              13:00</button>
            <button type="button"
              class="badge-pill btn btn-outline-primary mt-3 py-2 px-md-4 px-lg-3 flex-lg-fill text-center mr-2 mr-lg-3">13:00
              -
              14:00</button>
            <button type="button"
              class="badge-pill btn btn-outline-primary mt-3 py-2 px-md-4 px-lg-3 flex-lg-fill text-center mr-2 mr-lg-3">14:00
              -
              15:00</button>
          </div>
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
              <label class="form-label" form="modal_entity">Seleccionar entidad:</label>
              <select class="form-control" name="modal_entity" title="Seleccionar entidad" id="modal_entity">
                @foreach ($entities as $entity)
                  <option value="{{ $entity }}" {{ old('entity') === $entity ? 'selected' : '' }}>
                    {{ $entity }}
                  </option>
                @endforeach
              </select>
              <div class="d-none" id="modal_error_entity">
                <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
                  <i class="fas fa-exclamation-circle mr-1"></i>
                  <strong id="modal_error_message_entity"></strong>
                </div>
              </div>
            </div>
            <div class="form-group d-none" id="modal_ruc_display">
              <label class="form-label" for="modal_ruc">RUC:</label>
              <input type="text" name="modal_ruc" id="modal_ruc" class="form-control">
              <div class="d-none" id="modal_error_ruc">
                <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
                  <i class="fas fa-exclamation-circle mr-1"></i>
                  <strong id="modal_error_message_ruc"></strong>
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
              <label class="form-label" for="modal_phone_number">Número de celular (opcional):</label>
              <input type="text" id="modal_phone_number" name="modal_phone_number" class="form-control">
              <div class="d-none" id="modal_error_phone_number">
                <div class="mt-2 py-1 pl-2 alert alert-danger error-alert" role="alert">
                  <i class="fas fa-exclamation-circle mr-1"></i>
                  <strong id="modal_error_message_phone_number"></strong>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label" for="modal_email">Correo electrónico (opcional):</label>
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
            <button type="button" class="discard-product btn btn-danger mr-2" data-dismiss="modal"
              id="cancel-btn">Cancelar</button>
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

    const fields = ['name', 'entity', 'ruc', 'dni', 'phone_number', 'email'];
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
      // Select personas naturales by default
      $('#modal_entity').val('Persona natural');
      $('#modal_ruc_display').addClass('d-none');
      $('#modal_ruc_display input').prop('disabled', true);

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

@push('script')
  <script>
    // Show or hide RUC input
    $('#modal_entity').on('change', function() {
      if (this.value === 'Persona jurídica') {
        $('#modal_ruc_display').removeClass('d-none');
        $('#modal_ruc_display input').prop('disabled', false);
      } else {
        $('#modal_ruc_display').addClass('d-none');
        $('#modal_ruc_display input').prop('disabled', true);
      }
    });

    // Execute at least once
    $('#entity').trigger('change');
  </script>
@endpush

@push('script')
  <script>
    $(document).ready(function() {
      // Give the date a more verbose format
      function formatDate(dateStr) {
        const date = moment(dateStr, 'DD/MM/YYYY').locale('es');
        const formattedDate = date.format('dddd, D [de] MMMM [de] YYYY');
        return formattedDate;
      }

      // Get selected range
      function getSelectedHour() {
        const activeButton = $('.button-radio .btn.active');
        const buttonText = activeButton.text();
        const hourStr = buttonText.split(/\s-\s/)[0];
        return !hourStr ? null : hourStr;
      }

      // Get selected date
      function getSelectedDate() {
        const selectedDate = $('#datepicker-btn').datepicker('getFormattedDate');
        return selectedDate;
      }

      // Get full date
      function getFullDate() {
        const selectedDate = getSelectedDate();
        const selectedHour = getSelectedHour();
        if (!selectedHour || !selectedDate) {
          return null;
        }
        const fullDate = moment(`${selectedDate} ${selectedHour}`, 'DD/MM/YYYY HH:mm');
        // Return a valid string that can be saved inside a date input
        return fullDate;
      }

      // Fill form start date and end date
      function fillFormDates() {
        const fullDate = getFullDate();
        if (!fullDate) {
          return
        }
        $('#start_date').val(fullDate.format('YYYY-MM-DD HH:mm'));
        // The end date must be an hour after the full date
        $('#end_date').val(moment(fullDate).add(1, 'hour').format('YYYY-MM-DD HH:mm'));
        console.log($('#start_date').val());
        console.log($('#end_date').val());
      }

      // Translate into spanish
      $.fn.datepicker.dates['es'] = {
        days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sabado"],
        daysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
        daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
        months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
          "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
        ],
        monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        today: "Hoy",
        clear: "Limpiar",
        format: "dd/mm/yyyy",
        titleFormat: "MM yyyy",
        /* Leverages same syntax as 'format' */
        weekStart: 0
      };

      // Initialize datepicker
      $('#datepicker-btn').datepicker({
        language: 'es',
        format: 'dd/mm/yyyy',
        startDate: new Date(),
        todayBtn: 'linked',
        todayHighlight: true,
        toggleActive: true,
      });

      // Update button text when date changes
      $('#datepicker-btn').on('changeDate', function() {
        const isSelected = $(this).datepicker('getDate');
        if (isSelected !== null) {
          const selectedDate = getSelectedDate();
          const formattedDate = formatDate(selectedDate);
          $('#datepicker-btn').html(
            `<i class="far fa-calendar-alt"></i>&nbsp;&nbsp;${formattedDate}`
          );

          fillFormDates();
        } else {
          $('#datepicker-btn').html(
            `<i class="far fa-calendar-alt"></i>&nbsp;&nbsp;Fecha`
          );
          return
        }
      });

      // Turn everything that has the class "button-radio" into an advanced button radio group
      $('.button-radio button').click(function() {
        if (!$(this).is(':disabled') && !$(this).hasClass('active')) {
          // The button is selected
          $(this).parent().find('.active').removeClass('active');
          $(this).addClass('active');

          fillFormDates();
        } else if ($(this).hasClass('active')) {
          $(this).removeClass('active');
        }
      });


      // Restore previous date
      let oldStartDate = "{{ old('start_date') }}";
      if (oldStartDate) {
        console.log(oldStartDate)
        // oldStartDate = moment(oldStartDate, 'DD/MM/YYYY HH:mm');
        // turn old start date into a date object
        oldStartDate = new Date(oldStartDate);
        console.log(oldStartDate)
        $('#datepicker-btn').datepicker('setDate', oldStartDate);
        $('#datepicker-btn').trigger('changeDate');
        // get the hour from the oldStartDate
        // const startHour = oldStartDate.format('HH:mm');
        // console.log(startHour)
        // // click the button group that starts with the startHour
        // $(`.button-radio .btn:contains("${startHour}")`).click();
      }
    });
  </script>
@endpush

<!-- Error handling script -->
@include('includes.form.error')
