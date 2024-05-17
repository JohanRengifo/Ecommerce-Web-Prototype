<?php
session_start();
include_once 'contenido/cabeza.php';

if (isset($_GET['coleccion'])) {
    $idColeccion = $_GET['coleccion'];

    // ID de la colección para realizar consultas y mostrar los artículos correspondientes.
    $coleccion = $_GET['coleccion'];

    // Realizar acciones basadas en el valor de "coleccion"
    if ($coleccion == $idColeccion) {
        // Mostrar productos relacionados con la colección que se seleccionó anteriormente
        include 'modules/conexion.php';
        $sql = "SELECT * FROM productos WHERE coleccion = '$idColeccion'";
        $resultado = $conn->query($sql);
?>
        <section class="shop spad">
            <title><?php echo $pagecoleccion; ?></title>
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 col-md-9">
                        <div class="row">
                            <?php
                            while ($fila = $resultado->fetch_assoc()) {
                            ?>
                                <div class="col-lg-4 col-md-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="data:image/jpg;base64,<?php echo base64_encode($fila['imagen']); ?>">
                                    <div class="label new">New</div>
                                    <ul class="product__hover">
                                        <li><a href="product-details.php?id=<?php echo htmlspecialchars($productoId); ?>"><span class="icon_table"></span></a></li>
                                        <li>
                                            <form method="post" action="shop-cart.php" class="add-to-cart-form">
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
<?php
    } else {
        // No se seleccionó ninguna colección válida, redirigir a una página de error.
        header("Location: /404.php");
        exit;
    }
}

include_once 'contenido/pie.php';
?>
