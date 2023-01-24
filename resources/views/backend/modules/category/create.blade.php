@extends('backend.layouts.master')
@section('page_title', 'Category')
@section('page_sub_title', 'Create')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Create Category</h4>
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


                    {{-- <form>
                        <div class="row justify-content-center" id="form_area">

                        </div>
                        <button type="button" id="add_form" class="btn btn-info btn-sm">Add</button>

                        <button id="create_categories" type="button" class="btn btn-success">Submit</button>
                    </form> --}}

                    {!! Form::open(['method'=>'post', 'route'=>'category.store']) !!}
                    @include('backend.modules.category.form')
                    {!! Form::button('Create Category', ['type'=>'submit', 'class'=>'btn btn-success mt-2']) !!}
                    {!! Form::close() !!}
                    <a href="{{route('category.index')}}">
                        <button class="btn btn-success btn-sm mt-2">Back</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>


            let input = [{name: 'naim'}, {name: 'mustafiz'}, {name: 'sujon'}]
            const handleInput = (name, id) => {
                let value = $(`#${name}_${id}`).val()
                input = {...input, [id]:{...input[id],  [name]:value}}
            }


            let form_count = 1
            let form

            const generate_form = () => {
                for (let i = 1; i <= form_count; i++) {
                    form += `<div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <input onchange="handleInput('name', ${i})" id="name_${i}" type="text" class="form-control mb-3" name="name" placeholder="Name">
                                        <input onchange="handleInput('slug', ${i})" id="slug_${i}" type="text" class="form-control mb-3" name="slug" placeholder="Slug">
                                        <input onchange="handleInput('status', ${i})" id="status_${i}" type="text" class="form-control mb-3" name="status" placeholder="Status">
                                        <input onchange="handleInput('order_by', ${i})" id="order_by_${i}" type="text" class="form-control mb-3" name="order_by" placeholder="Order By">
                                    </div>
                                </div>
                            </div>`
                }
            }

            const track_form = () => {
                form = ''
                generate_form()
                $('#form_area').html(form)
                form_count++
            }

            $('#add_form').on('click', function () {
                track_form()
            })

            track_form()



            $('#create_categories').on('click', function () {
                axios.post(window.location.origin + '/dashboard/category', input).then(res => {

                })
            })


            $('#name').on('input', function () {
                let name = $(this).val()
                let slug = name.replaceAll(' ', '-')
                $('#slug').val(slug.toLowerCase());
            })
        </script>
    @endpush

@endsection
