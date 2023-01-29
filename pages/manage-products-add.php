<?php
// step 1: set CSRF token
CSRF::generateToken( 'add_product_form' );
// step 2: make sure post request
if ( $_SERVER["REQUEST_METHOD"] === 'POST' ) {
  // step 3: do error check
  $rules = [
    'name' => 'required',
    'price' => 'required',
    'image_url' => 'required',
    'csrf_token' => 'add_post_form_csrf_token'
  ];
  $error = FormValidation::validate(
    $_POST,
    $rules
  );
  // make sure there is no error
  if ( !$error ) {
    // step 4 = add new user
    Product::add(
      $_POST['name'],
      $_POST['price'],
      $_POST['image_url'],
      $_SESSION['user']['id']
    );
    // step 5: remove the CSRF token
    CSRF::removeToken( 'add_products_form' );
    // step 6: redirect to manage users page
    header("Location: /manage-products");
    exit;
  }
}
require dirname(__DIR__) . "/parts/header.php";
?>
  <body>
    <div class="container mx-auto my-5" style="max-width: 700px;">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h1">Add New Product</h1>
      </div>
      <div class="card mb-2 p-4">
      <?php require dirname( __DIR__ ) . '/parts/error_box.php'; ?>
        <form
          method="POST"
          action="<?php echo $_SERVER["REQUEST_URI"]; ?>"
        >
          <div class="mb-3">
            <label for="product-name" class="form-label">Name</label>
            <input
              type="text"
              class="form-control"
              id="post-title"
              name="name"
            />
          </div>
          <div class="mb-3">
            <label for="product-price" class="form-label">Price</label>
            <input
              type="text"
              class="form-control"
              id="post-title"
              name="price"
            />
          </div>
          <div class="mb-3">
            <label for="product-image_url" class="form-label">Image_url</label>
            <textarea
              class="form-control"
              id="post-content"
              name="image_url"
            ></textarea>
            <input type="hidden" name="user_id" value="<?=$_SESSION['user']['id']?>">
          </div>
          <div class="text-end">
            <button type="submit" class="btn btn-primary">Add</button>
            <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('add_post_form')?>">
          </div>
          <input
            type="hidden"
            name="csrf_token"
            value="<?php echo CSRF::getToken( 'add_product_form' ); ?>"
            />
        </form>
      </div>
      <div class="text-center">
        <a href="/manage-products" class="btn btn-link btn-sm"
          ><i class="bi bi-arrow-left"></i> Back to Products</a
        >
      </div>
    </div>
    <?php require dirname(__DIR__) . "/parts/footer.php"; ?>