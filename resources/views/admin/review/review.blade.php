@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{$title}}
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">{{$title}}</li>
            </ol>
            <!--<form method="post" action="{{ action('Admin\ReviewController@import') }}">
                @csrf
                <div class="form-group col-sm-2 topmargin20">
                    <button type="submit" class="btn btn-primary">Import Review</button>
                </div>
            </form>-->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- left column -->
                @foreach($reviews as $key=>$reviews_list)
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title"> {{$key}} Reviews</h3>
                        </div>
                        <!-- /.box-header -->
                        {{--<div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>--}}

                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Website</th>
                                    <th>Name</th>
                                    <th>Surname</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Booking Refrence</th>
                                    <th>Rate</th>
                                    <th>Review</th>
                                    <th>Enable</th>
                                    <th></th>
                                </tr>
                                @foreach($reviews_list as $review)
                                    <tr id="row-{{$review->id}}">
                                        <td>{{$loop->iteration}}</td>
                                        <td>
                                            <a class="testEdit" data-type="select" data-column="website_id"
                                               data-source='{{$websites_json}}'
                                               data-url="{{route('reviews/updateinline', ['id'=>$review->id])}}"
                                               data-pk="{{$review->id}}" data-title="change"
                                               data-name="website_id">{{$review->website_name}}
                                            </a>
                                        </td>

                                        <td>
                                            <a class="testEdit" data-type="text" data-column="fname"
                                               data-url="{{route('reviews/updateinline', ['id'=>$review->id])}}"
                                               data-pk="{{$review->id}}" data-title="change"
                                               data-name="fname">{{$review->fname}}
                                            </a>
                                        </td>

                                        <td>
                                            <a class="testEdit" data-type="text" data-column="surname"
                                               data-url="{{route('reviews/updateinline', ['id'=>$review->id])}}"
                                               data-pk="{{$review->id}}" data-title="change"
                                               data-name="surname">{{$review->surname}}
                                            </a>
                                        </td>

                                        <td>
                                            <a class="testEdit" data-type="text" data-column="email"
                                               data-url="{{route('reviews/updateinline', ['id'=>$review->id])}}"
                                               data-pk="{{$review->id}}" data-title="change"
                                               data-name="email">{{$review->email}}
                                            </a>
                                        </td>

                                        <td>
                                            <a class="testEdit" data-type="text" data-column="mobile"
                                               data-url="{{route('reviews/updateinline', ['id'=>$review->id])}}"
                                               data-pk="{{$review->id}}" data-title="change"
                                               data-name="mobile">{{$review->mobile}}
                                            </a>
                                        </td>

                                        <td>
                                            <a class="testEdit" data-type="text" data-column="booking_refrence"
                                               data-url="{{route('reviews/updateinline', ['id'=>$review->id])}}"
                                               data-pk="{{$review->id}}" data-title="change"
                                               data-name="booking_refrence">{{$review->booking_refrence}}
                                            </a>
                                        </td>

                                        <td>
                                            <a class="testEdit" data-type="text" data-column="rate"
                                               data-url="{{route('reviews/updateinline', ['id'=>$review->id])}}"
                                               data-pk="{{$review->id}}" data-title="change"
                                               data-name="rate">{{$review->rate}}
                                            </a>
                                        </td>

                                        <td>
                                            <a class="testEdit" data-type="textarea" data-column="review"
                                               data-url="{{route('reviews/updateinline', ['id'=>$review->id])}}"
                                               data-pk="{{$review->id}}" data-title="change"
                                               data-name="review">{{$review->review}}
                                            </a>
                                        </td>


                                        <td>
                                            @if($review->disable == 1)
                                                  <a class="testEdit" data-type="select"
                                                     data-source='[{"value":1,"text":"disable"},{"value":0,"text":"enable"}]' data-column="disable"
                                                     data-url="{{route('reviews/updateinline', ['id'=>$review->id])}}" data-pk="{{$review->id}}"
                                                     data-title="change" data-name="disable">disabled
                                                  </a>
                                            @else
                                                 <a class="testEdit" data-type="select"
                                                 data-source='[{"value":0,"text":"enable"},{"value":1,"text":"disable"}]' data-column="disable"
                                                 data-url="{{route('reviews/updateinline', ['id'=>$review->id])}}" data-pk="{{$review->id}}"
                                                 data-title="change" data-name="disable">enabled
                                                 </a>
                                            @endif
                                        </td>

                                        <td>
{{--                                            <button class="deleteRecord btn btn-danger btn-flat" data-url="{{route('reviews/delete', ['id'=>$review->id])}}" data-id="{{ $review->id }}" >Delete</button>--}}
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- /.box-body -->
                    </div>
                </div>
                @endforeach
            </div>


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
