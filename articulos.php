<?php
session_start();
include_once 'contenido/cabeza.php';

// Obtener el valor del parámetro "modulo" de la URL
if (isset($_GET['modulo'])) {
    $modulo = $_GET['modulo'];

    // Definir variables para los títulos de las páginas
    $pageTitles = [
        '2' => $pagewomen,
        '1' => $pagemen,
        '3' => $pagekids,
        '4' => $pageaccessories,
        '5' => $pagecosmetics
    ];

    // Validar el valor de "modulo"
    if (array_key_exists($modulo, $pageTitles)) {
        include 'modules/conexion.php';
        $stmt = $conn->prepare("SELECT * FROM productos WHERE modulo = ?");
        $stmt->bind_param("i", $modulo);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $stmt->close();

        ob_start(); // Iniciar almacenamiento en búfer de salida

        if ($resultado->num_rows > 0) {
            ?>
            <section class="shop spad">
                <title><?php echo $pageTitles[$modulo]; ?></title>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9 col-md-9">
                            <div class="row">
                                <?php
                                while ($fila = $resultado->fetch_assoc()) {
                                    $productoId = $fila['id'];
                                    $productoNombre = $fila['nombre'];
                                    $productoPrecio = $fila['precio'];
                                ?>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="product__item">
                                            <div class="product__item__pic set-bg" data-setbg="data:image/jpg;base64,<?php echo base64_encode($fila['imagen']); ?>">
                                                <div class="label new">New</div>
                                                <ul class="product__hover">
                                                    <li><a href="data:image/jpg;base64,<?php echo base64_encode($fila['imagen']); ?>" class="image-popup"><span class="arrow_expand"></span></a></li>
                                                    <li><a href="product-details.php?id=<?php echo htmlspecialchars($productoId); ?>"><span class="icon_table"></span></a></li>
                                                    <li><a href="shop-cart.php?agregar=<?php echo htmlspecialchars($productoId); ?>"><span class="icon_bag_alt"></span></a></li>
                                                </ul>
                                            </div>
                                            <div class="product__item__text">
                                                <h6><a href="#"><?php echo $productoNombre; ?></a></h6>
                                                <div class="product__price"><?php echo $productoPrecio; ?></div>
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
            ?>
            <title><?php echo $pageTitles[$modulo]; ?></title>
            <section class="contact spad">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="contact__success">
                                <h2>Momentáneamente no contamos con estos productos</h2>
                                <p>Lo sentimos, momentáneamente no contamos con productos relacionados. Pronto tendremos lo que deseas.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <script>
                setTimeout(function() {
                    window.location.href = "index.php";
                }, 15000);
            </script>
        <?php
        }

        // Almacenar el contenido de salida en una variable
        $output = ob_get_clean();

        // Imprimir el contenido de salida
        echo $output;
    } else {
        ?>
        <title>Error - Módulos | Egocentricas Pop</title>
        <section class="contact spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="contact__success">
                            <h2>Módulo no válido</h2>
                            <p>Lo sentimos, no es tu culpa, somos nosotros.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script>
            setTimeout(function() {
                window.location.href = "index.php";
            }, 8000);
        </script>
    <?php
    }
} else {
    // No se proporcionó el parámetro "modulo" en la URL
    ?>
    <title>Error - Módulo no especificado | Egocentricas Pop</title>
    <section class="contact spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact__success">
                        <h2>Módulo no especificado</h2>
                        <p>Lo sentimos, error de datos.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        setTimeout(function() {
            window.location.href = "index.php";
        }, 3000);
    </script>
<?php
}

include_once 'contenido/pie.php';
?>