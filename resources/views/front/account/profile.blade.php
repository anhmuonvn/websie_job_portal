@extends('front.layout.app')
@section('main')
    <section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('front.account.sidebar')
            </div>
            <div class="col-lg-9">
                @include('front.alert')
                <div class="card border-0 shadow mb-4">
                    <form action="" id="userForm" name="useForm" >
                        <div class="card-body  p-4">
                            <h3 class="fs-4 mb-1">My Profile</h3>
                            <div class="mb-4">
                                <label for="" class="mb-2">Name*</label>
                                <input type="text"  id="name" name="name" placeholder="Enter Name" class="form-control" value="{{ $user->name }}">
                                <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Email*</label>
                                <input type="text" id="email" name="email" placeholder="Enter Email" class="form-control" value="{{ $user->email }}">
                                <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Designation*</label>
                                <input type="text" id="designation" name="designation" placeholder="Designation" class="form-control"
                                value="{{ $user->designation}}">
                                <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Mobile*</label>
                                <input type="text" id="mobile" name="mobile" placeholder="Mobile" class="form-control"
                                value="{{ $user->mobile }}">
                                <p></p>
                            </div>                        
                        </div>
                        <div class="card-footer  p-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>

                <div class="card border-0 shadow mb-4">
                    <div class="card-body p-4">
                        <h3 class="fs-4 mb-1">Change Password</h3>
                        <div class="mb-4">
                            <label for="" class="mb-2">Old Password*</label>
                            <input type="password" placeholder="Old Password" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">New Password*</label>
                            <input type="password" placeholder="New Password" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Confirm Password*</label>
                            <input type="password" placeholder="Confirm Password" class="form-control">
                        </div>                        
                    </div>
                    <div class="card-footer  p-4">
                        <button type="button" class="btn btn-primary">Update</button>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</section>
@endsection
@section('customJs')
    <script type="text/javascript">
        $('#userForm').submit(function(e){
            e.preventDefault();
            $.ajax({
                url:'{{ route('account.updateProfile') }}',
                type:'put',
                data:$('#userForm').serializeArray(),
                dataType:'json',
                success:function(response)
                {
                    if(response.status==false)
                    {
                        var errors = response.errors;
                        if(errors.name)
                        {
                            $('#name').addClass('is-invalid')
                                      .siblings('p')
                                      .addClass('invalid-feedback')
                                      .html(errors.name)
                        }
                        else
                        {
                            $('#name').removeClass('is-invalid')
                                      .siblings('p')
                                      .removeClass('invalid-feedback')
                                      .html('')
                        }
                        if(errors.email)
                        {
                            $('#email').addClass('is-invalid')
                                      .siblings('p')
                                      .addClass('invalid-feedback')
                                      .html(errors.email)
                        }
                        else
                        {
                            $('#email').removeClass('is-invalid')
                                      .siblings('p')
                                      .removeClass('invalid-feedback')
                                      .html('')
                        }
                        if(errors.designation)
                        {
                            $('#designation').addClass('is-invalid')
                                      .siblings('p')
                                      .addClass('invalid-feedback')
                                      .html(errors.designation)
                        }
                        else
                        {
                            $('#designation').removeClass('is-invalid')
                                      .siblings('p')
                                      .removeClass('invalid-feedback')
                                      .html('')
                        }
                        if(errors.mobile)
                        {
                            $('#mobile').addClass('is-invalid')
                                      .siblings('p')
                                      .addClass('invalid-feedback')
                                      .html(errors.mobile)
                        }
                        else
                        {
                            $('#mobile').removeClass('is-invalid')
                                      .siblings('p')
                                      .removeClass('invalid-feedback')
                                      .html('')
                        }
                    }
                    else
                    {
                        $('#name').removeClass('is-invalid')
                                      .siblings('p')
                                      .removeClass('invalid-feedback')
                                      .html('')
                        $('#email').removeClass('is-invalid')
                                      .siblings('p')
                                      .removeClass('invalid-feedback')
                                      .html('')
                        $('#designation').removeClass('is-invalid')
                                      .siblings('p')
                                      .removeClass('invalid-feedback')
                                      .html('') 
                        $('#mobile').removeClass('is-invalid')
                                      .siblings('p')
                                      .removeClass('invalid-feedback')
                                      .html('')
                        window.location.href='{{ route('account.profile') }}';                                                       
                    }
                }
            })
        })
    </script>
@endsection