
<?php include (base_path('app/views/header.blade.php')); ?>
{{ Form::open(array('url' => 'login', 'class'=>'form-signin')) }}
<h1>Login</h1>

<!-- if there are login errors, show them here -->
<p>
    {{ $errors->first('email') }}
    {{ $errors->first('password') }}
</p>

<p>
    
    {{ Form::text('email', Input::old('email'), array('class'=>'form-control', 'placeholder' => 'Email address')) }}
</p>

<p>
    
    {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'Password')) }}
</p>

<p>{{ Form::submit('Log in!' , array('class'=>'btn btn-primary')) }}</p>
{{ Form::close() }}
<?php include (base_path('app/views/footer.blade.php')) ?>