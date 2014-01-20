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
            'phone' => Input::get('phone'),
            'password' => Input::get('password')
        );



        // Declare the rules for the form validation.

        $rules = array(
            'phone'  => 'Required',
            'password'  => 'Required'
        );

        // Validate the inputs.
        $validator = Validator::make($userdata, $rules);

        // Check if the form validates with success.
        if ($validator->passes())
        {
            

            // Try to log the user in.
            if (Auth::attempt($userdata))
            {
                // Redirect to homepage

                //session_start();
                //$_SESSION['nick'] = Auth::user()->name;
                


                //View::make('hello')->with('name',Auth::user()->name);
                // return Redirect::to('/WarRoom')->with('success', 'You have logged in successfully');
                return Redirect::to('/')->with('name',Auth::user()->name);

            }
            else
            {
                // Redirect to the login page.
                
                return Redirect::to('login')->withErrors(array('password' => 'Password invalid'))->withInput(Input::except('password'));
            }
        }

        // Something went wrong.
      
        return Redirect::to('login')->withErrors($validator)->withInput(Input::except('password'));

        
    }
}