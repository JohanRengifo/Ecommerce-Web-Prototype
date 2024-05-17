<?php
include_once 'contenido/cabeza.php';
include 'modules/conexion.php';

$id = $_GET['id'];

// Prevenir inyección SQL escapando el ID
$id = $conn->real_escape_string($id);

$sql = "SELECT * FROM productos WHERE id = '$id'";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $numeroAleatorio = rand(450, 999);
?>
    <title><?php echo $pagedetallesproduct; ?></title>

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="./index.php"><i class="fa fa-home"></i> Home</a>
                        <a href="#"><?php echo $fila['modulo'] ?></a>
                        <span><?php echo $fila['nombre'] ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Product Details Section Begin -->
    <section class="product-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product__details__pic">
                        <div class="product__details__slider__content">
                            <div class="product__details__pic__slider owl-carousel">
                                <img class="product__big__img" src="data:image/jpg;base64,<?php echo base64_encode($fila['imagen']) ?>" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product__details__text">
                        <h3><?php echo $fila['nombre'] ?><span>Colección: <?php echo $fila['coleccion']; ?></span></h3>
                        <div class="rating">
                            <?php for ($i = 0; $i < 4; $i++) { ?>
                                <i class="fa fa-star"></i>
                            <?php } ?>
                            <span>( <?php echo $numeroAleatorio; ?> reviews )</span>
                        </div>
                        <div class="product__details__price">$ <?php echo $fila['precio']; ?></div>
                        <p><?php echo $fila['caracteristicas']; ?></p>
                        <div class="product__details__button">
                            <div class="quantity">
                                <span>Quantity:</span>
                                <div class="pro-qty">
                                    <input type="text" value="1">
                                </div>
                            </div>
                            <a href="#" class="cart-btn"><span class="icon_bag_alt"></span> Add to cart</a>
                        </div>
                        <div class="product__details__widget">
                            <ul>
                                <li>
                                    <span>Availability:</span>
                                    <div class="stock__checkbox">
                                        <label for="stockin">
                                            In Stock
                                            <input type="checkbox" id="stockin" checked disabled>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <span>Available color:</span>
                                    <div class="color__checkbox">
                                        <label for="red">
                                            <input type="radio" name="color__radio" id="red" checked>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label for="black">
                                            <input type="radio" name="color__radio" id="black">
                                            <span class="checkmark black-bg"></span>
                                        </label>
                                        <label for="grey">
                                            <input type="radio" name="color__radio" id="grey">
                                            <span class="checkmark grey-bg"></span>
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <span>Available size:</span>
                                    <div>
                                        <?php
                                        $tallas = explode(',', $fila['tallas']);
                                        $sizes = array("XS", "S", "M", "L", "XL", "Talla-Unica");
                                        foreach ($sizes as $size) {
                                            $checked = in_array($size, $tallas) ? "checked disabled" : "";
                                            $disabled = !in_array($size, $tallas) ? "disabled" : "";
                                        ?>
                                            <label>
                                                <input type="checkbox" name="tallas[]" value="<?php echo $size; ?>" <?php echo $checked . " " . $disabled; ?>>
                                                <?php echo $size; ?>
                                            </label>
                                        <?php } ?>
                                    </div>
                                </li>
                                <li>
                                    <span>Promotions:</span>
                                    <p><b>Nueva Compra</b></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-9 col-md-9">
                    <div class="row">
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM productos ORDER BY RAND() LIMIT 3";
                            $resultado = $conn->query($sql);

                            while ($fila = $resultado->fetch_assoc()) {
                            ?>
                                <div class="col-lg-4 col-md-6">
                                    <div class="product__item">
                                        <div class="product__item__pic set-bg" data-setbg="data:image/jpg;base64,<?php echo base64_encode($fila['imagen']) ?>">
                                            <div class="label new">New</div>
                                            <ul class="product__hover">
                                                <li><a href="data:image/jpg;base64,<?php echo base64_encode($fila['imagen']) ?>" class="image-popup"><span class="arrow_expand"></span></a></li>
                                                <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                                <li><a href="product-details.php?id=<?php echo $fila["id"] ?>"><span class="icon_bag_alt"></span></a></li>
                                            </ul>
                                        </div>
                                        <div class="product__item__text">
                                            <h6><a href="#"><?php echo $fila['nombre']; ?></a></h6>
                                            <div class="product__price">$<?php echo $fila['precio']; ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </tbody>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Details Section End -->

<?php
} else {
    echo "No se encontró el producto";
}
include_once 'contenido/pie.php';
?>
