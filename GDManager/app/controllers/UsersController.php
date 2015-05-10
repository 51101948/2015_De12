<?php

class UsersController extends BaseController {


	public function userCreate() {
	    $validator = Validator::make(Input::all(), User::$rules);

	    if ($validator->passes()) {
	      // Dữ liệu hợp lệ, tạo user và lưu vào DB
	    	$user = new User;
		    $user->user_name = Input::get('user_name');
		    $user->email = Input::get('email');
		    $user->password = Hash::make(Input::get('password'));
		    $user->save();

		    return Redirect::to('login')->with('message', 'Thanks for registering!');
	    } else {
	      // Dữ liệu không hợp lệ, hiển thị lỗi
	    	return Redirect::to('signup')->with('message', 'The following errors occurred')->withErrors($validator)->withInput();
	    }
	}

	public function __construct() {
	    $this->beforeFilter('csrf', array('on'=>'post'));
	}
}
