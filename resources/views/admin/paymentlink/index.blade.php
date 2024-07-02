@extends('admin.layouts.app')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{$title}}s
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">{{$title}}s</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    @if(session()->get('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div><br/>
                    @endif

                </div>
            </div>
            <style>
                .speciald{
                    display: inline-block;
                    width: 25%;
                }
                .left{
                    text-align: left !important;
                }
            </style>
            <div class="row">
                <div class="col-md-12">
                    <section class="content" style="min-height: 167px;">
                        @if($show_links == 1)

                            <label>Payer Name:</label> <label><?php echo $name; ?></label>
                            <span style="margin-left: 35px;"><label>Amount:</label> <label><?php echo $amount; ?></label></span>
                            <hr>
                            <a  class="btn" target="_blank" href="<?php echo $paypal; ?>">Pay by PayPal</a>
                            <a  style="margin-left: 60px;" class="btn" target="_blank" href="<?php echo $WP_P; ?>">Pay by WorldPay</a>

                        @else

                            <form class="form-horizontal" method="post" action="{{ route('paymentlink.store') }}">
                                @csrf
                                <input type="hidden" name="option_name[counter]" value="<?php echo $counter; ?>">
                                <label>Payer Name:</label>
                                <input size="35" type="text" name="p_name" required>
                                <label>Amount:</label>
                                <input size="15" type="text" name="amount" required>
                                <br>
                                <br><br>
                                <input type="submit" value="Generate Payment Link" class="button" name="save_eden_dpl">
                            </form>


                        @endif

                    </section>
                </div>

            </div>


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
