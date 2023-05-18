@extends('layouts.panel')
@section('title', 'Inicio')
@section('content')

  <div class="row">
    <div class="col-md-12 mb-4">
      <div class="card">
        <div class="card-header">{{ __('Dashboard') }}</div>

        <div class="card-body">
          @if (session('status'))
            <div class="alert alert-success" role="alert">
              {{ session('status') }}
            </div>
          @endif

          {{ __('You are logged in!') }}
        </div>
      </div>
    </div>
    <div class="col-xl-7">
      <div class="card bg-gradient-default shadow">
        <div class="card-header bg-transparent">
          <div class="row">
            
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
