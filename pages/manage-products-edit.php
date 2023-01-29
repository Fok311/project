<?php


// load post data
$product = Product::getProductById($_GET['id']);

// step 1: set CSRF token
CSRF::generateToken('edit_product_form');

// step 2: make sure post request
if ( $_SERVER["REQUEST_METHOD"] === 'POST' ) {
  // step 3: do error check
  $rules = [
    'name' => 'required',
    'price' => 'required',
    'status' => 'required',
    'image_url' => 'required',
    'csrf_token' => 'edit_product_form_csrf_token'
  ];
  $error = FormValidation::validate(
    $_POST,
    $rules
  );
  // make sure there is no error
  if ( !$error ){
    // var_dump( $post['id'] );
    // var_dump( $_POST['title'] );
    // var_dump( $_POST['content'] );
    // var_dump( $_POST['status'] );
    // step 4: update post
    Product::update(
      $product['id'], // id
      $_POST['name'], // title
      $_POST['price'],
      $_POST['status'],
      $_POST['image_url']
    );
    // step 5: remove CSRF token
    CSRF::removeToken('edit_product_form');
    // step 6: redirect back to manage posts page
    header("Location: /manage-products");
    exit;
  }
}
require dirname(__DIR__) . "/parts/header.php";
?>
  <body>
    <div class="container mx-auto my-5" style="max-width: 700px;">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h1">Edit Product</h1>
      </div>
      <div class="card mb-2 p-4">
        <?php require dirname( __DIR__ ) . '/parts/error_box.php'; ?>
        <form
          method="POST"
          action="<?php echo $_SERVER['REQUEST_URI']; ?>"
        >
          <div class="mb-3">
            <label for="product-name" class="form-label">name</label>
            <input
              type="text"
              class="form-control"
              id="product-name"
              name="name"
              value="<?php echo $product['name']; ?>"
            />
          </div>
          <div class="mb-3">
            <label for="product-price" class="form-label">price</label>
            <input
              type="text"
              class="form-control"
              id="product-price"
              name="price"
              value="<?php echo $product['price']; ?>"
            />
          </div>
          <div class="mb-3">
            <label for="post-content" class="form-label">image_url</label>
            <textarea class="form-control" id="post-content" name="image_url" rows="10"><?php echo $product['image_url']; ?></textarea>
          </div>
          <div class="mb-3">
            <label for="post-content" class="form-label">Status</label>
            <select class="form-control" id="post-status" name="status">
            <?php if ( $_SESSION['user']['role'] == 'user' ) : ?>
              <option value="pending" <?php echo ( $product['status'] == 'pending' ? 'selected' : '' ); ?>>Pending for Review</option>
            <?php else: ?>
              <option value="pending" <?php echo ( $product['status'] == 'pending' ? 'selected' : '' ); ?>>Pending for Review</option>
              <option value="publish" <?php echo ( $product['status'] == 'publish' ? 'selected' : '' ); ?>>Publish</option>
            <?php endif; ?>
            </select>
          </div>
          <div class="text-end">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
          <input
            type="hidden"
            name="csrf_token"
            value="<?php echo CSRF::getToken('edit_product_form'); ?>"
            />
        </form>
      </div>
      <div class="text-center">
        <a href="/manage-products" class="btn btn-link btn-sm"
          ><i class="bi bi-arrow-left"></i> Back to Posts</a
        >
      </div>
    </div>
    <?php require dirname(__DIR__) . "/parts/footer.php"; ?>