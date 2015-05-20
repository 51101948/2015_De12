<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showHome()
	{
		//var_dump(Session::get('user_id'));
		if( null == (Session::get('user_id'))){
			return Redirect::to('login');
		}
		else{
			return View::make('home');
		}
	}

	public function showLogin()
	{
	    // show the form
	    if( null != (Session::get('user_id'))){
			return Redirect::to('/');
		}
		else {
	    	return View::make('login');
	    }
	}

	public function doLogin()
	{
	// validate the info, create rules for the inputs
	$rules = array(
	    'email'    => 'required|email', // make sure the email is an actual email
	    'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
	);



	// run the validation rules on the inputs from the form
	$validator = Validator::make(Input::all(), $rules);

	// if the validator fails, redirect back to the form
	if ($validator->fails()) {
	    return Redirect::to('login')
	        ->withErrors($validator) // send back all errors to the login form
	        ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
	} else {

	    // create our user data for the authentication
	    $userdata = array(
	        'email'     => Input::get('email'),
	        'password'  => Input::get('password')
	    );
	    // attempt to do the login
	    if (Auth::attempt($userdata)) {
	       	$user = User::where('email',$userdata['email'])->get()->first();
	       	$id=$user->user_id;
	       	Session::put('user_id', $id);
	    	// validation successful!
	        // redirect them to the secure section or whatever
	        // return Redirect::to('secure');
	        // for now we'll just echo success (even though echoing in a controller is bad)
	        return Redirect::to('/DAuthStart')->with('message', 'Login Success');

	    } else {        
	    	//var_dump(Auth::attempt($userdata));
	        // validation not successful, send back to form 
	        return Redirect::to('login')->with('message', 'Login Failed');

	    }

	}
	}

	public function doLogout()
	{
		Session::forget('user_id');
	    Auth::logout(); // log the user out of our application
	    return Redirect::to('login'); // redirect the user to the login screen
	}

	public function doSignup() {
	   return View::make('signup');
	}
}
