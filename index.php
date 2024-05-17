<?php
header('Content-Type: text/html; charset=UTF-8');
include_once 'modules/conexion.php';
include_once 'modules/funciones/contadores.php';
include_once 'contenido/cabeza.php';
?>
<title><?php echo $pageprincipal; ?></title>

<!-- Categories Section Begin -->
<section class="categories">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 p-0">
                <div class="categories__item categories__large__item set-bg" data-setbg="img/categories/category-1.jpg">
                    <div class="categories__text">
                        <h1>Women’s fashion</h1>
                        <p>Una Linea Exclusiva para Mujeres.<br><?php echo "Items: " . $itemswomen[0]; ?></p>
                        <a href="articulos.php?modulo=2">Shop now</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                        <div class="categories__item set-bg" data-setbg="img/categories/category-2.jpg">
                            <div class="categories__text">
                                <h4>Men’s fashion</h4>
                                <p><?php echo "Items: " . $itemsmen[0]; ?></p>
                                <a href="articulos.php?modulo=1">Shop now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                        <div class="categories__item set-bg" data-setbg="img/categories/category-3.jpg">
                            <div class="categories__text">
                                <h4>Kid’s fashion</h4>
                                <p><?php echo "Items: " . $itemskids[0]; ?></p>
                                <a href="articulos.php?modulo=3">Shop now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                        <div class="categories__item set-bg" data-setbg="img/categories/category-4.jpg">
                            <div class="categories__text">
                                <h4>Cosmetics</h4>
                                <p><?php echo "Items: " . $itemscosmetics[0]; ?></p>
                                <a href="articulos.php?modulo=5">Shop now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                        <div class="categories__item set-bg" data-setbg="img/categories/category-5.jpg">
                            <div class="categories__text">
                                <h4>Accessories</h4>
                                <p><?php echo "Items: " . $itemsaccessories[0]; ?></p>
                                <a href="articulos.php?modulo=4">Shop now</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- Categories Section End -->

<!-- Banner Section Begin -->
<section class="banner set-bg" data-setbg="img/banner/banner.jpg">
    <div class="container">
        <div class="row">
            <div class="col-xl-7 col-lg-8 m-auto">
                <div class="banner__slider owl-carousel">
                    <?php
                    include 'modules/conexion.php';

                    // Consulta para obtener las colecciones
                    $sql = "SELECT * FROM colecciones";
                    $resultado = $conn->query($sql);

                    while ($fila = $resultado->fetch_assoc()) {
                        $idColeccion = $fila['id_coleccion'];
                        $nombreColeccion = $fila['nombre_coleccion'];
                    ?>
                        <div class="banner__item">
                            <div class="banner__text">
                                <span>Colección</span>
                                <h1><?php echo htmlspecialchars($nombreColeccion); ?></h1>
                                <a href="shopcoleccion.php?coleccion=<?php echo htmlspecialchars($idColeccion); ?>">Shop now</a>
                            </div>
                        </div>

                    <?php
                    }
                    ?>
                </div>

            </div>

        </div>
    </div>
</section>

<!-- Banner Section End -->


<?php include_once 'contenido/pie.php'; ?>