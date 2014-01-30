<!DOCTYPE html>
<html lang="en">
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/bootstrap.min.css" rel="stylesheet">  
  <link href="css/signin.css" rel="stylesheet">  

</head>

<body>


	<div class="container">

        <?php 

          if($message = Session::get('password')){

          echo '<div class="alert alert-danger alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
          echo "<strong>Error</strong> : $message";
              
          echo '</div>';

          }


          if($errors->count()>0){

            echo '<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
            

            foreach($errors->all() as $message){

              echo "<strong>Error</strong> : $message";

            }

            echo "</div>";
          }


        
       ?>

      <form class="form-signin" role="form" method="post">
        <h2 class="form-signin-heading">Sign in</h2>
        <input name="phone" type="text" class="form-control" placeholder="Phone number" required autofocus>
        <input name="password" type="password" class="form-control" placeholder="Password" required>
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div> 



    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>	
</body>
</html>