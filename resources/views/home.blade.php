<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SSLCOMMERZ is the first pay</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/small-business.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">SSLCOMMERZ</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">

    <!-- Heading Row -->
    <div class="row align-items-center my-5">
      <div class="col-lg-7">
        <img class="img-fluid rounded mb-4 mb-lg-0" src="https://www.sslcommerz.com/images/slide2_bg.jpg" alt="">
      </div>
      <!-- /.col-lg-8 -->
     
      <!-- /.col-md-4 -->
    </div>
    <!-- /.row -->


    <div class="row">
      <div class="col-md-4 mb-5">
        <div class="card h-100">
        <form class="form-horizontal" action="{{url('pay')}}" method="post">
                                @csrf
                                <input type="hidden" value="1", name="subscription_id">
                                <input type="hidden" value="2", name="user_id">
                                <input type="hidden" value="10", name="amount">
                                <input type="hidden" value="BDT", name="currency">
          <div class="card-body">
            <h2 class="card-title">Click For Pay</h2>
            <p class="card-text">SLCOMMERZ is the first payment gateway in Bangladesh opening doors for merchants to receive payments on the internet via their online stores. Customers are able to buy products online using their credit cards as well as bank accounts. If you are a merchant,
             you have come to the right place! Enhance your business by integrating SSLCOMMERZ to your online store and facilitating online payment in Bangladeshi Taka.</p>
          </div>
          <div class="card-footer">
            <a href="https://developer.sslcommerz.com/doc/v4/" class="btn btn-primary btn-sm">More Info</a>
            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-envelope"></i> Pay Now</button>

          </div>
        </div>
        </form>
      </div>
      <!-- /.col-md-4 -->
    
      <!-- /.col-md-4 -->

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Your Website 2019</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
