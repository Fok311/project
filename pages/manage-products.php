<?php
// Step 1: generate CSRF token
CSRF::generateToken( 'delete_product_form' );
// Step 2: make sure it's POST request
if ($_SERVER["REQUEST_METHOD"] === 'POST') {
  // step 3: do error check
  $error = FormValidation::validate(
    $_POST,
    [
      'csrf_token' => 'delete_product_form_csrf_token'
    ]
  );
  // make sure there is no error
  if (!$error) {
    // step 4: delete user
    Product::delete($_POST['product_id']);
    // step 5: remove CSRF token
    CSRF::removeToken('delete_product_form');
    // step 6: redirect back to the same page
    header("Location: /manage-products");
    exit;
  }
}
require dirname(__DIR__) . "/parts/header.php";
?>
  <body>
    <div class="container mx-auto my-5" style="max-width: 700px;">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h1 class="h1">Manage Products</h1>
        <div class="text-end">
          <a href="/manage-products-add" class="btn btn-primary btn-sm"
            >Add New Product</a
          >
        </div>
      </div>
      <div class="card mb-2 p-4">
        <?php require dirname( __DIR__ ) . '/parts/error_box.php'; ?>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col" style="width: 40%;">Name</th>
              <th scope="col">Price</th>
              <th scope="col" class="text-end">Status</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach( Product::getAllProducts() as $product ): ?>
            <tr>
              <th scope="row"><?php echo $product['id']; ?></th>
              <td><?php echo $product['name']; ?></td>
              <td><?php echo $product['price']; ?></td>
              <td>
                <?php
                  switch( $product['status'] ) {
                    case 'pending':
                      echo '<span class="badge bg-warning">' . $product['status'] .'</span>';
                      break;
                    case 'publish':
                      echo '<span class="badge bg-success">' . $product['status'] .'</span>';
                      break;
                  }
                ?>
              </td>
              <td class="text-end">
                <div class="buttons">
                <!-- <?php
                  switch( $product['status'] ) {
                    case 'pending':
                      echo '<a
                              href="/product"
                              target="_blank"
                              class="btn btn-primary btn-sm me-2 disabled"
                            >
                              <i class="bi bi-eye"></i>
                            </a>';
                      break;
                    case 'publish':
                      echo '<a
                              href="/product"
                              target="_blank"
                              class="btn btn-primary btn-sm me-2"
                            >
                              <i class="bi bi-eye"></i>
                            </a>';
                      break;
                  }
                ?> -->
                  <a
                    href="/manage-products-edit?id=<?php echo $product['id']; ?>"
                    class="btn btn-secondary btn-sm me-2"
                    ><i class="bi bi-pencil"></i
                  ></a>
                  <!-- Delete button Start -->
                  <!-- Button trigger modal -->
                  <button
                    type="button"
                    class="btn btn-danger btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#post-<?php echo $product['id']; ?>">
                    <i class="bi bi-trash"></i>
                  </button>
                  <!-- Modal -->
                  <div class="modal fade" id="post-<?php echo $product['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Delete User</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-start">
                          Are you sure you want to delete this product (<?php echo $product['name']; ?>)
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <form
                            method="POST"
                            action="<?php echo $_SERVER["REQUEST_URI"]; ?>"
                          >
                            <input 
                              type="hidden" 
                              name="product_id" 
                              value="<?php echo $product['id']; ?>" 
                            />
                            <input 
                              type="hidden" 
                              name="csrf_token" 
                              value="<?php echo CSRF::getToken( 'delete_product_form' ); ?>"
                            />
                            <button type="submit" class="btn btn-danger">Delete</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="text-center">
        <a href="/dashboard" class="btn btn-link btn-sm"
          ><i class="bi bi-arrow-left"></i> Back to Dashboard</a
        >
      </div>
    </div>
    <?php require dirname(__DIR__) . "/parts/footer.php"; ?>