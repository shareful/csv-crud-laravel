<!-- create.blade.php -->

@extends('layout.mainlayout')
@section('content')
<div class="container">
  <div class="page-header">
    <h1>Client Details</h1>  
  </div>
  
  <form>
    <div class="form-group row">
      <label for="inputName" class="col-sm-2 col-form-label col-form-label-lg">Name</label>
      <div class="col-sm-10">
        <input type="text" class="form-control form-control-lg" id="inputName" placeholder="Name" name="name" value="{{ $client->name }}" readonly>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label col-form-label-lg">Gender</label>
      <div class="col-sm-10">
        <div class="radio">
          <label>
            <input type="radio" name="gender" value="male" readonly {{ $client->gender == 'male' ? 'checked' : '' }}>
            Male
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="gender" value="female" readonly {{ $client->gender == 'female' ? 'checked' : '' }}>
            Female
          </label>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputPhone" class="col-sm-2 col-form-label col-form-label-lg">Phone</label>
      <div class="col-sm-10">
        <input type="text" class="form-control form-control-lg" id="inputPhone" placeholder="Phone" name="phone" value="{{ $client->phone }}" readonly>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputEmail" class="col-sm-2 col-form-label col-form-label-lg">Email</label>
      <div class="col-sm-10">
        <input type="email" class="form-control form-control-lg" id="inputEmail" placeholder="Email" name="email" data-error="That email address is invalid" value="{{ $client->email }}" readonly>
        <div class="help-block with-errors"></div>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputAddress" class="col-sm-2 col-form-label col-form-label-lg">Address</label>
      <div class="col-sm-10">
        <input type="text" class="form-control form-control-lg" id="inputAddress" placeholder="Address" name="address" value="{{ $client->address }}" readonly>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputNationality" class="col-sm-2 col-form-label col-form-label-lg">Nationality</label>
      <div class="col-sm-10">
        <input type="text" class="form-control form-control-lg" id="inputNationality" placeholder="Nationality" name="nationality" value="{{ $client->nationality }}" readonly>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputBirthDate" class="col-sm-2 col-form-label col-form-label-lg">Date of birth</label>
      <div class="col-sm-10">
        <input type="text" class="form-control form-control-lg" id="inputBirthDate" placeholder="MM/DD/YYYY" name="birthDate" class="datepicker" data-provide="datepicker" value="{{ $client->birthDate }}" readonly>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputEducation" class="col-sm-2 col-form-label col-form-label-sm">Education Background</label>
      <div class="col-sm-10">
        <textarea name="education" id="inputEducation" class="form-control form-control-lg" readonly>{{ $client->education }}</textarea>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-sm-2 col-form-label col-form-label-lg">Preferred​ ​mode​ of​ contact</label>
      <div class="col-sm-10">
        <div class="radio">
          <label>
            <input type="radio" name="contactMode" value="email" readonly {{ $client->contactMode == 'email' ? 'checked' : '' }}>
            Email
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="contactMode" value="phone" readonly {{ $client->contactMode == 'phone' ? 'checked' : '' }}>
            Phone
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="contactMode" value="none" readonly {{ $client->contactMode == 'none' ? 'checked' : '' }}>
            None
          </label>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <div class="col-sm-2"></div>
      <div class="col-sm-10">        
        <a href="{{ route('clients.index') }}" class="btn btn-cancel">Back</a>
      </div>
    </div>
  </form>
</div>
@endsection