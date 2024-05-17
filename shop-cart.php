<?php
session_start();
include_once 'contenido/cabeza.php';

if (isset($_GET['eliminar'])) {
    $productoId = $_GET['eliminar'];

    if (isset($_SESSION['carrito'][$productoId])) {
        unset($_SESSION['carrito'][$productoId]);
    }
}
?>
<title><?php echo htmlspecialchars($pagecarrito); ?></title>

<!-- Shop Cart Section Begin -->
<section class="shop-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shop__cart__table">
                    <table>
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $subtotal = 0;
                            $total = 0;

                            if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
                                foreach ($_SESSION['carrito'] as $producto) {
                                    $subtotal += $producto['cantidad'] * $producto['precio'];
                                    $total += $producto['cantidad'] * $producto['precio'];
                            ?>
                                    <tr>
                                        <td class="cart__product__item">
                                            <div class="cart__product__item__title">
                                                <h6><?php echo htmlspecialchars($producto['nombre']); ?></h6>
                                            </div>
                                        </td>
                                        <td class="cart__price">$ <?php echo htmlspecialchars($producto['precio']); ?></td>
                                        <td class="cart__quantity"><?php echo htmlspecialchars($producto['cantidad']); ?></td>
                                        <td class="cart__total">$ <?php echo htmlspecialchars($producto['cantidad'] * $producto['precio']); ?></td>
                                        <td class="cart__close">
                                            <a href="shop-cart.php?eliminar=<?php echo htmlspecialchars($producto['id']); ?>" class="icon_close"></a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo '<tr><td colspan="5">El Carrito está Vacío.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="cart__btn">
                    <a href="shop.php">Seguir comprando</a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="cart__btn update__btn">
                    <a href="javascript:location.reload();"><span class="icon_loading"></span> Actualizar carrito</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="discount__content">
                    <h6>Códigos de descuento</h6>
                    <form action="#">
                        <input type="text" placeholder="Ingresa tu código de cupón">
                        <button type="submit" class="site-btn">Aplicar</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-4 offset-lg-2">
                <div class="cart__total__procced">
                    <h6>Total del carrito</h6>
                    <ul>
                        <li>Subtotal <span>$ <?php echo htmlspecialchars($subtotal); ?></span></li>
                        <li>Total <span>$ <?php echo htmlspecialchars($total); ?></span></li>
                    </ul>
                    <a href="#" class="primary-btn">Proceder al pago</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shop Cart Section End -->

<?php include_once 'contenido/pie.php'; ?>
