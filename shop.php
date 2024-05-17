<?php
session_start();
include_once 'contenido/cabeza.php';
include 'modules/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comprar'])) {
    $producto_id = $_POST['producto_id'];
    $producto_nombre = $_POST['producto_nombre'];
    $producto_precio = $_POST['producto_precio'];
    $producto_cantidad = $_POST['producto_cantidad'];

    // Agregar el producto al carrito
    $producto = array(
        'id' => $producto_id,
        'nombre' => $producto_nombre,
        'precio' => $producto_precio,
        'cantidad' => $producto_cantidad
    );

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    }

    $_SESSION['carrito'][] = $producto;

    // Redireccionar a la página de carrito de compras
    header('Location: /shop-cart.php');
    exit();
}
?>

<title><?php echo htmlspecialchars($pagecompras); ?></title>
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="./index.html"><i class="fa fa-home"></i> Home</a>
                    <span>Shop</span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End -->

<section class="shop spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-9">
                <div class="row">
                    <?php
                    $sql = "SELECT * FROM productos";
                    $resultado = $conn->query($sql);
                    while ($fila = $resultado->fetch_assoc()) {
                        $productoNombre = htmlspecialchars($fila['nombre']);
                        $productoPrecio = htmlspecialchars($fila['precio']);
                        $productoId = $fila['id'];
                    ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="data:image/jpg;base64,<?php echo base64_encode($fila['imagen']); ?>">
                                    <div class="label new">New</div>
                                    <ul class="product__hover">
                                        <li><a href="product-details.php?id=<?php echo htmlspecialchars($productoId); ?>"><span class="icon_table"></span></a></li>
                                        <li>
                                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="add-to-cart-form">
                                                <input type="hidden" name="producto_id" value="<?php echo $productoId; ?>">
                                                <input type="hidden" name="producto_nombre" value="<?php echo $productoNombre; ?>">
                                                <input type="hidden" name="producto_precio" value="<?php echo $productoPrecio; ?>">
                                                <input type="hidden" name="producto_cantidad" value="1">
                                                <button type="submit" name="comprar" class="icon_bag_alt"></button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="#"><?php echo $productoNombre; ?></a></h6>
                                    <div class="product__price">$<?php echo $productoPrecio; ?></div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shop Section End -->

<?php include_once 'contenido/pie.php'; ?>
