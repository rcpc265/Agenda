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
          <a class="btn btn-sm btn-success"
            href="{{ route('visits.index') }}">
            <i class="fas fa-chevron-left"></i>
            Regresar</a>
        </div>
      </div>
    </div>

    <div class="card-body">
      <form action="{{ route('visits.store') }}"
        method="POST">
        @csrf
        <div class="form-group">
          <label class="form-label"
            for="modal_subject">Asunto</label>
          <input class="form-control"
            id="subject"
            name="subject"
            type="text"
            value="{{ old('subject') }}"
            autofocus>
          @error('subject')
            <div class="mt-2 py-1 pl-2 alert alert-danger error-alert"
              role="alert">
              <i class="fas fa-exclamation-circle mr-1"></i>
              <strong>{{ $message }}</strong>
            </div>
          @enderror
        </div>
        @push('script')
          <script>
            $(document).ready(function() {
              const defaultRanges = {
                'lunes': [{
                    'type': 'Persona jurídica',
                    'start': '09:00'
                  },
                  {
                    'type': 'Persona jurídica',
                    'start': '10:00'
                  },
                  {
                    'type': 'Persona jurídica',
                    'start': '11:00'
                  },
                ],
                'martes': [{
                    'type': 'Persona natural',
                    'start': '09:00'
                  },
                  {
                    'type': 'Persona natural',
                    'start': '10:00'
                  },
                  {
                    'type': 'Persona natural',
                    'start': '11:00'
                  },
                ],
                'miércoles': [{
                    'type': 'Persona jurídica',
                    'start': '14:00'
                  },
                  {
                    'type': 'Persona jurídica',
                    'start': '15:00'
                  },
                ],
                'jueves': [{
                    'type': 'Persona natural',
                    'start': '14:00'
                  },
                  {
                    'type': 'Persona natural',
                    'start': '15:00'
                  },
                ],
                'viernes': [{
                    'type': 'Persona jurídica',
                    'start': '09:00'
                  },
                  {
                    'type': 'Persona jurídica',
                    'start': '10:00'
                  },
                  {
                    'type': 'Persona jurídica',
                    'start': '11:00'
                  },
                ],
              };

              function getRanges(date) {
                const weekday = getWeekday(date);
                return defaultRanges[weekday];
              }

              function getWeekday(selectedDate) {
                const date = moment(selectedDate, 'DD/MM/YYYY HH:mm');
                const weekday = date.format('dddd');
                return weekday;
              }

              function getPersonType(selectedDate) {
                const date = moment(selectedDate, 'DD/MM/YYYY HH:mm');
                const weekday = getWeekday(selectedDate);
                return defaultRanges[weekday][0]['type'];
              }

              // Format the date to be displayed
              function formatDate(dateStr) {
                const date = moment(dateStr, 'DD/MM/YYYY').locale('es');
                const formattedDate = date.format('dddd, D [de] MMMM [de] YYYY');
                const today = moment().locale('es');
                const tomorrow = moment().add(1, 'day').locale('es');
                const dayAfterTomorrow = moment().add(2, 'day').locale('es');
                if (date.isSame(today, 'day')) {
                  return `Hoy, ${formattedDate}`;
                } else if (date.isSame(tomorrow, 'day')) {
                  return `Mañana, ${formattedDate}`;
                } else if (date.isSame(dayAfterTomorrow, 'day')) {
                  return `Pasado mañana, ${formattedDate}`;
                } else {
                  // Capitalize first letter
                  return formattedDate.charAt(0).toUpperCase() + formattedDate.slice(1);
                }
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

              // Translate into spanish the date picker
              $.fn.datepicker.dates['es'] = {
                days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sabado"],
                daysShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
                  "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
                ],
                monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                today: "Hoy",
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
                daysOfWeekDisabled: [0, 6],
              });

              // Get the  visits that are in the database and share the same date
              function getVisits(selectedDate) {
                $.ajax({
                  url: '{{ route('visits.get') }}',
                  type: 'POST',
                  headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                  },
                  data: JSON.stringify({
                    date: selectedDate
                  }),

                  success: function(response) {
                    // Get the hours that are already taken
                    const visits = response.visits.map(visit => {
                      // Turn the date into a moment object
                      const date = moment(visit.start_date).format('DD/MM/YYYY HH:mm');
                      // Return the hour and the subject
                      return {
                        date: moment(date, 'DD/MM/YYYY HH:mm').format('HH:mm'),
                        subject: visit.subject,
                      };
                    });

                    // Enable all buttons
                    $('.button-radio button').prop('disabled', false);
                    // Remove any previous title
                    $('.button-radio button').removeAttr('title');

                    visits.forEach(visit => {
                      // Disable all buttons that start with the hour text and set the title attribute to the subject
                      $(`.button-radio button[value^="${visit.date}"]`)
                        .prop('disabled', true)
                        .attr('title', `Asunto: ${visit
                        .subject}`);
                    });
                  }
                });
              }

              $('#datepicker-btn').on('changeDate', function() {
                const isSelected = $(this).datepicker('getDate');
                if (isSelected !== null) {
                  const selectedDate = getSelectedDate();
                  getVisits(selectedDate);
                  const selectedPersonType = getPersonType(selectedDate);

                  // Select the person's entity according to the date
                  $('#modal_entity').val(selectedPersonType);
                  $('#modal_entity').trigger('change');

                  // Show or hide the buttons to select the range based on the date
                  //   const weekday = getWeekday(selectedDate);
                  //   console.clear();
                  //   console.log("Dia de la semana");
                  //   console.log(weekday)
                  //   console.log("\n");
                  //   console.log("Rangos del dia de hoy");
                  const todayRanges = getRanges(selectedDate);
                  //   todayRanges.forEach(range => {
                  //     console.log(range.start);
                  //   });
                  //   console.log("\n");
                  //   console.log("Range buttons innerTxt");
                  const rangeButtons = $('.button-radio button');
                  rangeButtons.each(function() {
                    const button = $(this);
                    const matchingRange = todayRanges.find(range => button.text().startsWith(range.start));
                    if (matchingRange) {
                      button.removeClass('d-none disabled');
                    } else {
                      button.addClass('d-none disabled');
                    }
                  });

                  // Set the datepicker button's text to the selected date in a human readable format
                  const formattedDate = formatDate(selectedDate);
                  $('#datepicker-btn').html(
                    `<i class="far fa-calendar-alt"></i>&nbsp;&nbsp;${formattedDate}`
                  );
                  $('#date').val(selectedDate);

                  // If the selected date is persona natural then
                  // Enable the natural visitor seleect
                  console.log("La persona seleccionada es:")
                  console.log(selectedPersonType)

                  // Display or hide the respective container and also enable or disable the respective select
                  if (selectedPersonType === "Persona natural") {
                    $('#naturalVisitorsContainer').removeClass('d-none');
                    $('#legalVisitorsContainer').addClass('d-none');
                    $('#naturalVisitorsSelect').prop('disabled', false);
                    $('#legalVisitorsSelect').prop('disabled', true);
                  } else if (selectedPersonType === "Persona jurídica") {
                    $('#legalVisitorsContainer').removeClass('d-none');
                    $('#naturalVisitorsContainer').addClass('d-none');
                    $('#naturalVisitorsSelect').prop('disabled', true);
                    $('#legalVisitorsSelect').prop('disabled', false);
                  }

                } else {
                  console.log("No date is selected");
                  // Disable the naturalVisitorsSelect and the legalVisitorsSelect
                  $('#naturalVisitorsSelect').prop('disabled', true);
                  $('#legalVisitorsSelect').prop('disabled', true);

                  // Set the datepicker button's text to the default
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

                  $('#start_hour').val(moment(getSelectedHour(), 'HH:mm').format('HH:mm'));
                } else if ($(this).hasClass('active')) {
                  $(this).removeClass('active');
                }
              });

              // Restore previous date
              let oldDate = "{{ old('date') }}";
              if (oldDate) {
                // convert the date to a valid JS Date object
                const date = moment(oldDate, 'DD/MM/YYYY').toDate();
                // set the datepicker to the new date
                $('#datepicker-btn').datepicker('setDate', oldDate);

                // Set the datepicker to today if today is not sunday or saturday
              } else if (moment().isoWeekday() !== 6 && moment().isoWeekday() !== 7) {
                // $('#datepicker-btn').datepicker('setDate', new Date());
              }

              // Restore previous hour
              let oldStartHour = "{{ old('start_hour') }}";
              if (oldStartHour) {
                const startHour = moment(oldStartHour, 'HH:mm').format('HH:mm');
                const button = $(`.button-radio button:contains(${startHour})`);
                button.trigger('click');
              }
            });
          </script>
        @endpush
        <div class="form-group">
          <label class="form-label mb--1">
            Seleccionar horario:
            <span class="ml-1 badge-pill btn badge-info py-1"
              id="datepicker-btn">
              <i class="far fa-calendar-alt"></i>&nbsp;&nbsp;Fecha
            </span>
          </label>
          <div class="button-radio d-flex flex-wrap flex-column flex-sm-row  mr--3 mt-2">
            <button class="badge-pill btn btn-outline-primary px-lg-5 px-md-4 mr-3 mt-2"
              type="button"
              value="09:00 - 10:00">09:00
              - 10:00</button>
            <button class="badge-pill btn btn-outline-primary px-lg-5 px-md-4 mr-3 mt-2"
              type="button"
              value="10:00 - 11:00">10:00
              - 11:00</button>
            <button class="badge-pill btn btn-outline-primary px-lg-5 px-md-4 mr-3 mt-2"
              type="button"
              value="11:00 - 12:00">11:00
              - 12:00</button>
            <button class="badge-pill btn btn-outline-primary px-lg-5 px-md-4 mr-3 mt-2"
              type="button"
              value="14:00 - 15:00">14:00
              - 15:00</button>
            <button class="badge-pill btn btn-outline-primary px-lg-5 px-md-4 mr-3 mt-2"
              type="button"
              value="15:00 - 16:00">15:00
              - 16:00</button>
          </div>
          @if ($errors->has('start_hour') || $errors->has('date'))
            <div class="mt-2 py-1 pl-2 alert alert-danger error-alert"
              role="alert">
              @error('date')
                <i class="fas fa-exclamation-circle mr-1"></i>
                <strong>{{ $message }}</strong><br>
              @enderror
              @error('start_hour')
                <i class="fas fa-exclamation-circle mr-1"></i>
                <strong>{{ $message }}</strong>
              @enderror
            </div>
          @endif
        </div>
        <label class="form-label"
          for="modal_visitor_id">Visitante:</label>
        <div class="form-group row"
          id="naturalVisitorsContainer">
          <div class="col pr-0"
            title="Seleccione una fecha primero">
            <select class="form-control"
              id="naturalVisitorsSelect"
              name="visitor_id"
              disabled>
              <option value=""
                disabled
                selected>Seleccione un visitante</option>
              @foreach ($naturalVisitors as $visitor)
                <option value="{{ $visitor->id }}"
                  {{ old('visitor_id') == $visitor->id ? 'selected' : '' }}>
                  {{ $visitor->name }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-auto">
            <button class="btn btn-success form-control"
              id="modal-launcher"
              data-toggle="modal"
              data-target="#add-new-visitor"
              type="button"
              modal-launcher>
              <i class="fas fa-plus"></i>
            </button>
          </div>
        </div>
        <div class="form-group row d-none"
          id="legalVisitorsContainer">
          <div class="col pr-0">
            <select class="form-control"
              id="visitor_id"
              name="visitor_id">
              <option id="legalVisitorsSelect"
                value=""
                disabled
                selected>Seleccione un visitante</option>
              @foreach ($legalVisitors as $visitor)
                <option value="{{ $visitor->id }}"
                  {{ old('visitor_id') == $visitor->id ? 'selected' : '' }}>
                  {{ $visitor->name }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-auto">
            <button class="btn btn-success form-control"
              id="modal-launcher"
              data-toggle="modal"
              data-target="#add-new-visitor"
              type="button"
              modal-launcher>
              <i class="fas fa-plus"></i>
            </button>
          </div>
        </div>
        @error('visitor_id')
          <div class="mt--3 py-1 pl-2 alert alert-danger error-alert mb-3"
            role="alert">
            <i class="fas fa-exclamation-circle mr-1"></i>
            <strong>{{ $message }}</strong>
          </div>
        @enderror
        <input class="form-control"
          id="date"
          name="date"
          value="{{ old('date') }}"
          hidden>
        <input class="form-control"
          id="start_hour"
          name="start_hour"
          type="text"
          value="{{ old('start_hour') }}"
          hidden>

        <div class="d-none">
          <input name="user_id"
            value="{{ auth()->user()->id }}">
        </div>
        <button class="btn btn-md btn-primary"
          type="submit">Crear visita</button>
      </form>
    </div>
  </div>

  <div class="modal fade"
    id="add-new-visitor"
    role="dialog"
    tabindex="-1">
    <div class="modal-dialog"
      role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3>Añadir nuevo visitante:</h3>
          <button class="discard-product close"
            data-dismiss="modal"
            type="button"
            aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="modal_form">
          <div class="modal-body pb-0 pt-0">
            <div class="form-group">
              <label class="form-label"
                for="modal_name">Nombre del visitante:</label>
              <input class="form-control"
                id="modal_name"
                name="modal_name"
                type="text">
              <div class="d-none"
                id="modal_error_name">
                <div class="mt-2 py-1 pl-2 alert alert-danger error-alert"
                  role="alert">
                  <i class="fas fa-exclamation-circle mr-1"></i>
                  <strong id="modal_error_message_name"></strong>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label"
                form="modal_entity">Seleccionar entidad:</label>
              <select class="form-control"
                id="modal_entity"
                name="modal_entity"
                title="Seleccionar entidad">
                @foreach ($entities as $entity)
                  <option value="{{ $entity }}"
                    {{ old('entity') === $entity ? 'selected' : '' }}>
                    {{ $entity }}
                  </option>
                @endforeach
              </select>
              <div class="d-none"
                id="modal_error_entity">
                <div class="mt-2 py-1 pl-2 alert alert-danger error-alert"
                  role="alert">
                  <i class="fas fa-exclamation-circle mr-1"></i>
                  <strong id="modal_error_message_entity"></strong>
                </div>
              </div>
            </div>
            <div class="form-group d-none"
              id="modal_ruc_display">
              <label class="form-label"
                for="modal_ruc">RUC:</label>
              <input class="form-control"
                id="modal_ruc"
                name="modal_ruc"
                type="text">
              <div class="d-none"
                id="modal_error_ruc">
                <div class="mt-2 py-1 pl-2 alert alert-danger error-alert"
                  role="alert">
                  <i class="fas fa-exclamation-circle mr-1"></i>
                  <strong id="modal_error_message_ruc"></strong>
                </div>
              </div>
            </div>
            <div class="form-group"
              id="modal_dni_display">
              <label class="form-label"
                for="modal_dni">DNI:</label>
              <input class="form-control"
                id="modal_dni"
                name="modal_dni"
                type="text">
              <div class="d-none"
                id="modal_error_dni">
                <div class="mt-2 py-1 pl-2 alert alert-danger error-alert"
                  role="alert">
                  <i class="fas fa-exclamation-circle mr-1"></i>
                  <strong id="modal_error_message_dni"></strong>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label"
                for="modal_phone_number">Número de celular (opcional):</label>
              <input class="form-control"
                id="modal_phone_number"
                name="modal_phone_number"
                type="text">
              <div class="d-none"
                id="modal_error_phone_number">
                <div class="mt-2 py-1 pl-2 alert alert-danger error-alert"
                  role="alert">
                  <i class="fas fa-exclamation-circle mr-1"></i>
                  <strong id="modal_error_message_phone_number"></strong>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="form-label"
                for="modal_email">Correo electrónico (opcional):</label>
              <input class="form-control"
                id="modal_email"
                name="modal_email"
                type="text">
              <div class="d-none"
                id="modal_error_email">
                <div class="mt-2 py-1 pl-2 alert alert-danger error-alert"
                  role="alert">
                  <i class="fas fa-exclamation-circle mr-1"></i>
                  <strong id="modal_error_message_email"></strong>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer pt-2">
            <button class="discard-product btn btn-danger mr-2"
              id="cancel-btn"
              data-dismiss="modal"
              type="button">Cancelar</button>
            <button class="btn btn-md btn-success"
              id="add-visitor"
              type="submit">Crear visitante</button>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection

@push('script')
  <script>
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
    $(document).ready(function() {
      // Show or hide RUC input
      $('#modal_entity').on('change', function() {
        if (this.value === 'Persona jurídica') {
          $('#modal_ruc_display').removeClass('d-none');
          $('#modal_ruc_display input').prop('disabled', false);
          $('#modal_dni_display').addClass('d-none');
          $('#modal_dni_display input').prop('disabled', true);
        } else {
          $('#modal_ruc_display').addClass('d-none');
          $('#modal_ruc_display input').prop('disabled', true);
          $('#modal_dni_display').removeClass('d-none');
          $('#modal_dni_display input').prop('disabled', false);
        }
      });

      // Execute at least once
      $('#entity').trigger('change');
    })
  </script>
@endpush

<!-- Error handling script -->
@include('includes.form.error')
