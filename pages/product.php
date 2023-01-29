<?php

$product = Product::getProductById($_GET['id']);

if ( !Authentication::isLoggedIn() )
{
  header('Location: /login');
  exit;
}



    // require header
    require dirname(__DIR__) . '/parts/header.php';

?>
    <div class="container mx-auto my-5" style="max-width: 500px;">
      <h1 class="h1 mb-4 text-center">Post 1</h1>
      <h3 class="title">Name : <?php echo $product['name']; ?></h3>
                <br>
                <h4 class="text">Price : $<?php echo $product['price']; ?></h4>
                <br>
                <h5 class="developer">image_url : <?php echo $product['image_url']; ?></h5>
                <br>
      <div class="text-center mt-3">
        <a href="/home" class="btn btn-link btn-sm"
          ><i class="bi bi-arrow-left"></i> Back</a
        >
      </div>
    </div>

<?php

require dirname(__DIR__) . '/parts/footer.php';
