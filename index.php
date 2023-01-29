<?php 

    // start session
    session_start();

    // require all the classes & functions files
    require "includes/class-product.php";
    require "includes/class-db.php";
    require "includes/class-user.php";
    require "includes/class-authentication.php";
    require "includes/class-form-validation.php";
    require "includes/class-csrf.php";
    require "includes/class-cart.php";
    require "includes/class-orders.php";
    require "config.php";

    // get route
    $path = trim( $_SERVER["REQUEST_URI"], '/' );

    // remove query string
    $path = parse_url( $path, PHP_URL_PATH );


  // var_dump( $path );

  switch( $path ) {
    case 'login':
      require "pages/login.php";
      break;
    case 'signup':
      require "pages/signup.php";
      break;
    case 'logout':
      require 'pages/logout.php';
      break;
    case 'product':
      require "pages/product.php";
      break;
    case 'dashboard':
      require "pages/dashboard.php";
      break;
    case 'manage-products':
      require "pages/manage-products.php";
      break;
    case 'manage-products-add':
      require "pages/manage-products-add.php";
      break;
    case 'manage-products-edit':
      require "pages/manage-products-edit.php";
      break;
    case 'manage-users':
      require "pages/manage-users.php";
      break;
    case 'manage-users-add':
      require "pages/manage-users-add.php";
      break;
    case 'manage-users-edit':
      require "pages/manage-users-edit.php";
      break;
    case 'cart':
      require "pages/cart.php";
      break;
    case 'checkout':
      require "pages/checkout.php";
      break;
    case 'payment-verification':
      require "pages/payment-verification.php";
      break;
    case 'orders':
      require "pages/orders.php";
      break;
    default:
      require "pages/home.php";
      break;
  }