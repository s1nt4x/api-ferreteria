<?php
header("Content-Type: application/json");

require_once 'config/conexion.php';
require_once 'controller/categoriacontroller.php';
require_once 'controller/clientecontroller.php';
require_once 'controller/personacontroller.php';
require_once 'controller/productocontroller.php';
require_once 'controller/proveedorcontroller.php';
require_once 'controller/rolcontroller.php';
require_once 'controller/usuariocontroller.php';
require_once 'controller/ingresocontroller.php';
require_once 'controller/unidadmedidacontroller.php';
require_once 'controller/ventacontroller.php';

$database = new Conexion();
$db = $database->getConnection();

$requestMethod = $_SERVER["REQUEST_METHOD"];
$uri = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));

if (isset($uri[3])) {
    switch ($uri[3]) {
        case 'categorias':
            $categoriaController = new CategoriaController($db);
            switch ($requestMethod) {
                case 'GET':
                    $categoriaController->getCategorias();
                    break;
                case 'POST':
                    $categoriaController->crearCategoria();
                    break;
                case 'PUT':
                    $categoriaController->editarCategoria();
                    break;
                case 'DELETE':
                    $categoriaController->eliminarCategoria();
                    break;
                default:
                    http_response_code(405);
                    echo json_encode(["message" => "Método no permitido"]);
            }
            break;

        case 'clientes':
            $clienteController = new ClienteController($db);

            switch ($requestMethod) {
                case 'GET':
                    $clienteController->getClientes();
                    break;
                case 'POST':
                    $clienteController->crearCliente();
                    break;
                case 'PUT':
                    $clienteController->editarCliente();
                    break;
                default:
                    http_response_code(405);
                    echo json_encode(["message" => "Método no permitido"]);
            }
            break;

        case 'personas':
            $personaController = new PersonaController($db);

            switch ($requestMethod) {
                case 'GET':
                    $personaController->getPersonas();
                    break;
                case 'POST':
                    $personaController->crearPersona();
                    break;
                case 'PUT':
                    $personaController->editarPersona();
                    break;
                default:
                    http_response_code(405);
                    echo json_encode(["message" => "Método no permitido"]);
            }
            break;
        case 'productos':
            $productoController = new ProductoController($db);

            switch ($requestMethod) {
                case 'GET':
                    if (isset($uri[4])) {
                        switch ($uri[4]) {
                            case 'combo_categoria':
                                $productoController->getComboCategoria();
                                break;
                            case 'combo_unidad':
                                $productoController->getComboUnidad();
                                break;
                            default:
                                http_response_code(400);
                                echo json_encode(["message" => "Método GET no permitido"]);
                                break;
                        }
                    } else {
                        $productoController->getProductos();
                    }
                    break;
                case 'POST':
                    $productoController->crearProducto();
                    break;
                case 'PUT':
                    $productoController->editarFotoProducto();
                    break;
                default:
                    http_response_code(405);
                    echo json_encode(["message" => "Método no permitido"]);
            }
            break;
        case 'proveedores':
            $proveedorController = new ProveedorController($db);

            switch ($requestMethod) {
                case 'GET':
                    $proveedorController->getProveedores();
                    break;
                case 'POST':
                    $proveedorController->crearProveedor();
                    break;
                case 'PUT':
                    $proveedorController->editarProveedor();
                    break;
                case 'PATCH':
                    $proveedorController->modificarEstatusProveedor();
                    break;
                default:
                    http_response_code(405);
                    echo json_encode(["message" => "Método no permitido"]);
            }
            break;
        case 'roles':
            $rolController = new RolController($db);

            switch ($requestMethod) {
                case 'GET':
                    $rolController->getRoles();
                    break;
                case 'POST':
                    $rolController->crearRol();
                    break;
                case 'PUT':
                    $rolController->editarRol();
                    break;
                default:
                    http_response_code(405);
                    echo json_encode(["message" => "Método no permitido"]);
            }
            break;
        case 'usuarios':
            $usuarioController = new UsuarioController($db);
            switch ($requestMethod) {
                case 'GET':
                    if (isset($uri[4])) {
                        switch ($uri[4]) {
                            case 'listarcombopersona':
                                $usuarioController->listarComboPersona();
                                break;
                            case 'listarcomborol':
                                $usuarioController->listarComboRol();
                                break;
                            case 'traerdatosusuario':
                                $usuarioController->traerDatosUsuario();
                                break;
                            case 'traerdatoswidget':
                                $usuarioController->traerDatosWidget();
                                break;
                            case 'traerdatosgraficoventawidget':
                                $usuarioController->traerDatosGraficoVentaWidget();
                                break;
                            case 'traerdatosgraficoingresowidget':
                                $usuarioController->traerDatosGraficoIngresoWidget();
                                break;
                            default:
                                http_response_code(400);
                                echo json_encode(["message" => "Método GET no permitido"]);
                                break;
                        }
                    } else {
                        $usuarioController->getUsuarios();
                    }
                    break;

                case 'POST':
                    if (isset($uri[4]) && $uri[4] === 'verificar') {
                        $usuarioController->verificarUsuario();
                    } else {
                        $usuarioController->crearUsuario();
                    }
                    break;

                case 'PUT':
                    if (isset($uri[4]) && $uri[4] === 'actualizardatosprofile') {
                        $usuarioController->actualizarDatosProfile();
                    } else {
                        $usuarioController->editarUsuario();
                    }

                    break;
                case 'PATCH':
                    if (isset($uri[3])) {
                        switch ($uri[3]) {
                            case 'actualizarcontra':
                                $usuarioController->actualizarContra();
                                break;
                            case 'editarfoto':
                                $usuarioController->editarFoto();
                                break;
                            default:
                                http_response_code(400);
                                echo json_encode(["message" => "Método PATCH no permitido"]);
                        }
                    } else {
                        http_response_code(400);
                        echo json_encode(["message" => "Método PATCH no permitido"]);
                    }
                    break;

                default:
                    http_response_code(405);
                    echo json_encode(["message" => "Método no permitido"]);
            }
            break;
        case 'ingresos':
            $ingresosController = new IngresoController($db);

            switch ($requestMethod) {
                case 'GET':
                    if (isset($uri[4])) {
                        switch ($uri[4]) {
                            case 'listarComboProveedor':
                                $ingresosController->listarComboProveedor();
                                break;
                            case 'listarComboProducto':
                                $ingresosController->listarComboProducto();
                                break;
                            default:
                                http_response_code(400);
                                echo json_encode(["message" => "Método GET no permitido"]);
                        }
                    } else {
                        http_response_code(400);
                        echo json_encode(["message" => "Método GET no permitido"]);
                    }
                    break;
                case 'POST':
                    if (isset($uri[4])) {
                        switch ($uri[4]) {
                            case 'listarIngresos':
                                $ingresosController->listarIngresos();
                                break;
                            case 'registrarIngresoDetalle':
                                $ingresosController->registrarIngresoDetalle();
                                break;
                            default:
                                http_response_code(400);
                                echo json_encode(["message" => "Método POST no permitido"]);
                        }
                    } else {
                        $ingresosController->crearIngreso();
                    }
                    break;
                case 'PUT':
                    $ingresosController->anularIngreso();
                    break;
                default:
                    http_response_code(405);
                    echo json_encode(["message" => "Método no permitido"]);
            }
            break;
        case 'unidadmedida':
            $unidadMedidaController = new UnidadMedidaController($db);
            switch ($requestMethod) {
                case 'GET':
                    $unidadMedidaController->getUnidadesMedida();
                    break;
                case 'POST':
                    $unidadMedidaController->crearUnidadMedida();
                    break;
                case 'PUT':
                    $unidadMedidaController->editarUnidadMedida();
                    break;
                default:
                    http_response_code(405);
                    echo json_encode(["message" => "Método no permitido"]);
            }
            break;
        case 'ventas':
            $ventasController = new VentaController($db);
            switch ($requestMethod) {
                case 'GET':
                    if (isset($uri[4])) {
                        switch ($uri[4]) {
                            case 'listarComboCliente':
                                $ventasController->listarComboCliente();
                                break;
                            case 'listarComboProducto':
                                $ventasController->listarComboProducto();
                                break;
                            case 'cantidadVentas':
                                $ventasController->numVentas();
                                break;
                            default:
                                http_response_code(400);
                                echo json_encode(["message" => "Método GET no permitido"]);
                        }
                    } else {
                        http_response_code(400);
                        echo json_encode(["message" => "Método GET no permitido"]);
                    }
                    break;
                case 'POST':
                    if (isset($uri[4])) {
                        switch ($uri[4]) {
                            case 'listarVentas':
                                $ventasController->listarVentas();
                                break;
                            case 'registrarVentaDetalle':
                                $ventasController->registrarVentaDetalle();
                                break;
                            default:
                                http_response_code(400);
                                echo json_encode(["message" => "Método POST no permitido"]);
                        }
                    } else {
                        $ventasController->crearVenta();
                    }
                    break;
                case 'DELETE':
                    $ventasController->anularVenta();
                    break;
                default:
                    http_response_code(405);
                    echo json_encode(["message" => "Método no permitido"]);
            }
            break;
        default:
            http_response_code(404);
            echo json_encode(["message" => "Endpoint no encontrado"]);
    }
} else {
    http_response_code(404);
    echo json_encode(["message" => "Endpoint no encontrado"]);
}
