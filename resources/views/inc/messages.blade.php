@if(count($errors) >0)
    @foreach($errors->all() as $error)
        {{$error}}
    @endforeach
@endif

@if(session('success'))
    <div class='alert alert-success'>
        <div class='text-center'>{{session('success')}}</div>
    </div>
@endif

@if(session('error')) 
    <div class='alert alert-danger'>
        <div class='text-center'>{{session('error')}}</div>
    </div>
@endif