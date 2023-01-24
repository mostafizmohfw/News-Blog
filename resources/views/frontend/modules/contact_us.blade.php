@extends('frontend.layouts.master')
@section('page_title', 'Contact')
@section('banner')
    <div class="heading-page header-text">
        <section class="page-heading">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-content">
                            <h4>Feel free to contact us</h4>
                            <h2>Contact Us</h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4>Contact us</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                {!! Form::open(['method'=>'post', 'route'=>'contact.store']) !!}
                {!! Form::text('name', null, ['class'=>'form-control mt-3', 'placeholder'=>'Enter your Name']) !!}
                {!! Form::email('email', null, ['class'=>'form-control mt-3', 'placeholder'=>'Enter your email address']) !!}
                {!! Form::text('phone', null, ['class'=>'form-control mt-3', 'placeholder'=>'Enter your phone number']) !!}
                {!! Form::text('subject', null, ['class'=>'form-control mt-3', 'placeholder'=>'Enter subject']) !!}
                {!! Form::textarea('message', null, ['class'=>'form-control mt-3', 'placeholder'=>'Enter message', 'rows'=>5]) !!}
                {!! Form::button('Send Message', ['class'=>'btn btn-success mt-3', 'type'=>'submit']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>


    @if(session('msg'))
        @push('js')
            <script>
                Swal.fire({
                    position: 'top-end',
                    icon: '{{session('cls')}}',
                    toast: true,
                    title: '{{session('msg')}}',
                    showConfirmButton: false,
                    timer: 3000
                })
            </script>
        @endpush
    @endif
@endsection
