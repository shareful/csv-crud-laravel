<!-- create.blade.php -->

@extends('layout.mainlayout')
@section('content')
<div class="container">
  <div class="page-header">
    <h1>List of clients</h1>  
  </div>
  
  <div class="row">
    <div class="col-xs-12">
      <div class="table-responsive">
        <table summary="This table shows how to create responsive tables using Bootstrap's default functionality" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Name</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Contact Mode</th>
            </tr>
          </thead>
          <tbody>
            @foreach($clients as $client)
            <tr>
              <td><a href="{{ route('clients.show', $client->offset ) }}">{{ $client->name }}</a></td>
              <td>{{ $client->phone }}</td>
              <td>{{ $client->email }}</td>
              <td>{{ $client->contactMode }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div><!--end of .table-responsive-->
    </div>
  </div>

  {{ $paginator->links() }}


</div>
@endsection