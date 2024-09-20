@extends('admin.layouts.app')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ $title }}
                <small>Booking - {{ $title }}</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">{{ $title }}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="box-header with-border">
                        <h3 class="box-title">Filter By Website</h3>
                    </div>
                    <div class="box-header with-border">
                        <form role="form" action="{{ route('terminal-charges.index') }}" method="GET">
                            <div class="form-group">
                                <select name="filter_website" class="form-control" onchange="this.form.submit()">
                                    @foreach($websites as $website)
                                        <option value="{{ $website->id }}" {{ $filter_website == $website->id ? 'selected' : '' }}>
                                            {{ $website->website_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Website</th>
                                        <th>Airport</th>
                                        <th>Departure Terminal</th>
                                        <th>Arrival Terminal</th>
                                        <th>Terminal Switch Charge</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($combinations as $terminal)
                                        <tr id="row-{{ $terminal->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $terminal->website_name }}</td>
                                            <td>{{ $terminal->airport_name }}</td>
                                            <td>{{ $terminal->departure_terminal_name }}</td>
                                            <td>{{ $terminal->arrival_terminal_name }}</td>
                                            <td>
                                                <a class="testEdit" data-type="text" data-column="extra_charges"
                                                   data-url="{{ route('terminal-charges/updateinline', ['id' => $terminal->id]) }}"
                                                   data-pk="{{ $terminal->id }}" data-title="Change"
                                                   data-name="extra_charges">
                                                    {{ $terminal->extra_charges }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix"></div>
                    </div>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
