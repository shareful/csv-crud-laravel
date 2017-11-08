<!-- create.blade.php -->

@extends('layout.mainlayout')
@section('content')
<div class="container">
  <div class="page-header">
    <h1>Create New Client</h1>  
  </div>
  
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif

  <form action="{{ route('clients.store') }}" method="post" data-toggle="validator" role="form">
    {{ csrf_field() }}
    <div class="form-group row">
      <label for="inputName" class="col-sm-2 col-form-label col-form-label-lg">Name</label>
      <div class="col-sm-10">
        <input type="text" class="form-control form-control-lg" id="inputName" placeholder="Name" name="name" required>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label col-form-label-lg">Gender</label>
      <div class="col-sm-10">
        <div class="radio">
          <label>
            <input type="radio" name="gender" value="male" required>
            Male
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="gender" value="female" required>
            Female
          </label>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPhone" class="col-sm-2 col-form-label col-form-label-lg">Phone</label>
      <div class="col-sm-10">
        <input type="text" class="form-control form-control-lg" id="inputPhone" placeholder="Phone" name="phone" required>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputEmail" class="col-sm-2 col-form-label col-form-label-lg">Email</label>
      <div class="col-sm-10">
        <input type="email" class="form-control form-control-lg" id="inputEmail" placeholder="Email" name="email" data-error="That email address is invalid" required>
        <div class="help-block with-errors"></div>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputAddress" class="col-sm-2 col-form-label col-form-label-lg">Address</label>
      <div class="col-sm-10">
        <input type="text" class="form-control form-control-lg" id="inputAddress" placeholder="Address" name="address" required>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputNationality" class="col-sm-2 col-form-label col-form-label-lg">Nationality</label>
      <div class="col-sm-10">
        <input type="text" class="form-control form-control-lg" id="inputNationality" placeholder="Nationality" name="nationality" required>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputBirthDate" class="col-sm-2 col-form-label col-form-label-lg">Date of birth</label>
      <div class="col-sm-10">
        <input type="text" class="form-control form-control-lg" id="inputBirthDate" placeholder="MM/DD/YYYY" name="birthDate" class="datepicker" data-provide="datepicker" required
          data-date-autoclose="true"
          data-date-clear-btn="true"
          data-date-format="mm/dd/yyyy"
          data-date-language="{{ config('app.locale') }}"
          data-date-today-highlight="true">
      </div>
    </div>
    <div class="form-group row">
      <label for="inputEducation" class="col-sm-2 col-form-label col-form-label-sm">Education Background</label>
      <div class="col-sm-10">
        <textarea name="education" id="inputEducation" class="form-control form-control-lg"></textarea>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label col-form-label-lg">Preferred​ ​mode​ of​ contact</label>
      <div class="col-sm-10">
        <div class="radio">
          <label>
            <input type="radio" name="contactMode" value="email" required>
            Email
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="contactMode" value="phone" required>
            Phone
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="contactMode" value="none" required>
            None
          </label>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <div class="col-sm-2"></div>
      <div class="col-sm-10">        
        <input type="submit" class="btn btn-primary" value="Save">
      </div>
    </div>
  </form>
</div>
@endsection