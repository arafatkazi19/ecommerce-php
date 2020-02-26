<?php
  session_start();
	require_once '../config/connect.php';
	if (!isset($_SESSION['email']) & empty($_SESSION['email'])) {
		header('location: login.php');
	}
  if(isset($_GET) & !empty($_GET)){
    $id = $_GET['id'];}
    else {
      header('location: products.php');
    }

    if(isset($_POST) & !empty($_POST)){
     $name = mysqli_real_escape_string($connection, $_POST['productname']);
     $description = mysqli_real_escape_string($connection, $_POST['productdescription']);
     $category = mysqli_real_escape_string($connection, $_POST['productcategory']);
     $price = mysqli_real_escape_string($connection, $_POST['productprice']);



    $sql = "UPDATE products SET name='$name', description='$description' , catid='$category' , price='$price' WHERE id=$id";
     $res = mysqli_query($connection, $sql);
     if ($res) {
       $smsg =  "Product Updated";
     }
     else {
        $fmsg =  "Failed to update Product";
     }

   }
	?>
<?php include 'inc/header.php'; ?>
<?php include 'inc/nav.php'; ?>

<section id="content">
  <div class="content-blog">
    <div class="container">
      <?php if(isset($fmsg)){ ?><div class="alert alert-danger" role="alert">
      <?php echo $fmsg; ?></div><?php } ?>
      <?php if(isset($smsg)){ ?><div class="alert alert-success" role="alert">
      <?php echo $smsg; ?></div><?php } ?>
      <?php
           $sql = "SELECT * FROM products WHERE id=$id";
           $res = mysqli_query($connection, $sql);
           $r = mysqli_fetch_assoc($res) ;
      ?>

      <form method="post" enctype="multipart/form-data">

        <div class="form-group">
          <label for="Productname">Product Name</label>
          <input type="text" class="form-control" name="productname" id="Productname" placeholder=
          "Product Name" value="<?php echo $r['name']; ?>">
        </div>

        <div class="form-group">
          <label for="productdescription">Product Description</label>
          <textarea class="form-control" name="productdescription" rows="3"><?php echo $r['description'];?> </textarea>
        </div>

        <div class="form-group">
          <label for="prodctcategory">Product Category</label>
          <select class="form-control" id="productcategory" name="productcategory">
            <?php
                 $catsql = "SELECT * FROM category";
                 $catres = mysqli_query($connection, $catsql);
                 while ($catr = mysqli_fetch_assoc($catres)) {
            ?>
        <option value="<?php echo $catr['id']; ?>">
          <?php
        /*if ($catr['id'] == $r['catid']) {
            echo "selected";
          }*/
          ?>
          <?php echo $catr['name'];?></option>
          <?php } ?>

          </select>
        </div>

        <div class="form-group">
          <label for="productprice">Product Price</label>
          <input type="text" class="form-control" name="productprice" id="productprice" placeholder="Product Price"
          value="<?php echo $r['price']; ?>">
        </div>

        <div class="form-group">
          <label for="productimage">Product Image</label>
          <?php if(isset($r['thumb']) & !empty($r['thumb'])){ ?>
            <br>
          <img src="<?php echo $r['thumb'] ?>" width="100px" height="100px">

        <?php }
        else{ ?>
          <input type="file" name="productimage" id="productimage">
          <p class="help-block">Only jpg/png are allowed.</p>
        <?php } ?>
        </div>

        <button type="submit" class="btn btn-default">Submit</button>

      </form>

    </div>
  </div>
</section>
  <?php include 'inc/footer.php'; ?>
