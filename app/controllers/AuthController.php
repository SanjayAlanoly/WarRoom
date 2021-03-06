<?php

class AuthController extends BaseController {

    public function showLogin()
    {
        // Check if we already logged in
        if (Auth::check())
        {
            // Redirect to homepage
            return Redirect::to('')->with('name',Auth::user()->name);
        }

        // Show the login page
        return View::make('auth/login');
    }



    public function postLogin()
    {
        // Get all the inputs
        // id is used for login, username is used for validation to return correct error-strings
        $userdata = array(
            'phone_no' => Input::get('phone'),
            'password' => Input::get('password')
        );



        // Declare the rules for the form validation.

        $rules = array(
            'phone_no'  => 'Required|digits:10',
            'password'  => 'Required'
        );

        // Validate the inputs.
        $validator = Validator::make($userdata, $rules);

        // Check if the form validates with success.
        if ($validator->passes())
        {
            

            // Try to log the user in.
            if (Auth::attempt(($userdata),true))
            {
                // Redirect to homepage

                // return Redirect::to('/WarRoom')->with('success', 'You have logged in successfully');
                $now = new DateTime();
                DB::connection('WarRoom')->insert('INSERT INTO volunteer_login (volunteer_id,login_time) VALUES (?,?)',
                                                array(Auth::user()->id,$now));
                return Redirect::to('/')->with('success', 'You have logged in successfully');
            }
            else
            {
                // Redirect to the login page.
                
                return Redirect::to('login')->with('password', 'Wrong password/phone nubmer')->withInput(Input::except('password'));
            }
        }

        // Something went wrong.
      
        return Redirect::to('login')->withErrors($validator)->withInput(Input::except('password'));

        
    }


    public function getLogout()
    {

        
        
        // Log out
        Auth::logout();

        // Redirect to homepage
        return Redirect::to('/login')->with('success', 'You are logged out');
    }

}