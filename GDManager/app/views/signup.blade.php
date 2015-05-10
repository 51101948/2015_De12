<?php include (base_path('app/views/header.blade.php')) ?>
{{ Form::open(array('url'=>'signup', 'class'=>'form-signup')) }}
    <h2 class="form-signup-heading">Sign up</h2>

    <ul>
    @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
    </ul>

    <p>
    
   {{ Form::text('user_name', null, array('class'=>'form-control', 'placeholder'=>'User Name')) }}
   </p>
   <p>
    
   {{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Email Address')) }}
   </p>
   <p>
    
   {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password')) }}
   </p>
   <p>
   
   {{ Form::password('password_confirmation', array('class'=>'form-control', 'placeholder'=>'Confirm Password')) }}
   </p>
   <p>
     {{ Form::submit('Sign up', array('class'=>'btn btn-primary'))}}
{{ Form::close() }}
</p>
<?php include (base_path('app/views/footer.blade.php')) ?>