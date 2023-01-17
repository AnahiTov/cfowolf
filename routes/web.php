<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('index');
Route::get('login', 'HomeController@login')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::get('logout', 'HomeController@logout')->name('logout');
Route::resource('registro', 'Auth\RegisterController');
Route::get('register/verify/{code}', 'Auth\RegisterController@verify')->name('verificacion');
Route::get('/encuesta-prospecto', 'ProspectoController@loginCliente')->name('loginCliente'); // primera vista que verá el cliente al hacer la encuesta
Route::post('/encuesta-prospecto', 'ProspectoController@listadoEncuestas')->name('listadoEncuestas');

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', 'HomeController@index')->name('index');


    Route::resource('solicitud', 'SolicitudAdminController')->middleware('permiso');
    Route::resource('usuario', 'UserAdminController')->middleware('permiso');
    Route::resource('rol', 'RolController')->middleware('permiso');
    Route::resource('empresa', 'EmpresaController')->middleware('permiso');
    Route::resource('area', 'AreaController')->middleware('permiso');
    Route::resource('articulo', 'ArticuloController')->middleware('permiso');
    Route::resource('producto', 'ProductoController')->middleware('permiso');
    Route::resource('puesto', 'PuestoAdminController')->middleware('permiso');
    Route::resource('personal', 'PersonalAdminController')->middleware('permiso');
    Route::resource('asociado', 'AsociadoAdminController')->middleware('permiso');
    Route::resource('cliente', 'ClienteAdminController')->middleware('permiso');
    Route::resource('cuenta', 'CuentaController')->middleware('permiso');
    Route::resource('proveedor', 'ProveedorController')->middleware('permiso');
    Route::resource('analisis_credito', 'AnalisisCreditoController')->middleware('permiso');
    Route::resource('desembolso', 'DesembolsoController')->middleware('permiso');
    Route::resource('cartera_vigente', 'CarteraVigenteController')->middleware('permiso');
    Route::resource('reporte', 'ReporteController')->middleware('permiso');
    Route::resource('gasto', 'GastoController')->middleware('permiso');
    Route::resource('activo', 'ActivoController')->middleware('permiso');
    Route::resource('movimiento', 'MovimientoGastoController')->middleware('permiso');
    Route::resource('pago', 'PagoController')->middleware('permiso');
    Route::resource('aval', 'AvalController')->middleware('permiso');
    Route::resource('banco', 'BancoController')->middleware('permiso');
    Route::resource('caja', 'CajaController')->middleware('permiso');
    Route::resource('sucursal_ruta', 'SucursalRutaController')->middleware('permiso');
    Route::resource('capital', 'CapitalController')->middleware('permiso');
    Route::resource('cobro', 'CobroController')->middleware('permiso');
    Route::resource('noDeducible', 'NoDeducibleController')->middleware('permiso');
    Route::resource('nomina', 'NominaController')->middleware('permiso');
    Route::resource('concepto', 'ConceptoNominaController');
    Route::resource('movNomina', 'MovimientoNominaController');
    Route::resource('prestamoP', 'PrestamoPersonalController')->middleware('permiso');
    Route::resource('vencimiento', 'VencimientoController')->middleware('permiso');
    Route::resource('asignacion', 'AsignacionController')->middleware('permiso');
    Route::resource('prospecto', 'ProspectoController')->middleware('permiso');
    Route::resource('bono', 'BonoController')->middleware('permiso');
    Route::resource('detalleBono', 'DetalleBonoController');
    Route::resource('colocacion', 'ColocacionController')->middleware('permiso');



    // Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');


    Route::get('usuarios/addusuarios', 'UserAdminController@create')->name('addusuario');
    Route::post('usuarios/addusuarios', 'UserAdminController@store')->name('addUsuarios');
    Route::put('usuarios/{id}', 'UserAdminController@actualizarEstadoUser');

    Route::post('empresas/addempresas', 'EmpresaController@store')->name('addEmpresas');


    Route::get('areas/addareas', 'AreaController@create')->name('addarea');
    Route::post('areas/addareas', 'AreaController@store')->name('addAreas');
    Route::delete('areas/deleteArea/{id}', 'AreaController@destroy')->name('deleteArea');



    Route::get('puestos/addpuestos', 'PuestoAdminController@create')->name('addpuesto');
    Route::post('puestos/addpuestos', 'PuestoAdminController@store')->name('addPuestos');
    Route::delete('puestos/deletePuesto/{id}', 'PuestoAdminController@destroy')->name('deletePuesto');

    Route::get('personales/addpersonal', 'PersonalAdminController@create')->name('addpersona');
    Route::post('personales/addpersonal', 'PersonalAdminController@store')->name('addpersonal');
    Route::delete('personales/deletePersonal/{id}', 'PersonalAdminController@destroy')->name('deletePersonal');
    Route::post('personales/detalleTablaEmpleados/', 'PersonalAdminController@tablaEmpleados')->name('tablaEmpleados');
    Route::post('personales/bajaPersonal', 'PersonalAdminController@baja')->name('bajaEmpleado');
    Route::get('personales/datosPersonal/{idEmpleado}', 'PersonalAdminController@verDetalleEmpleado')->name('verDetalleEmpleado');
    


    Route::post('sucursal_ruta/reporteSuc/','SucursalRutaController@reporteSucursales')->name('reporteSucursales');


    Route::get('asociados/addasociados', 'AsociadoAdminController@create')->name('addasociado');
    Route::post('asociados/addasociados', 'AsociadoAdminController@store')->name('addAsociados');
    Route::delete('asociados/deleteAsociado/{id}', 'AsociadoAdminController@destroy')->name('deleteAsociado');
    Route::post('asociados/reporteAsoc/','AsociadoAdminController@reporteAsociados')->name('reporteAsociados');
    Route::put('asociados/{id}', 'AsociadoAdminController@actualizarEstadoAsociado');



    Route::get('clientes/addclientes', 'ClienteAdminController@create')->name('addcliente');
    Route::post('clientes/addclientes', 'ClienteAdminController@store')->name('addClientes');
    Route::delete('clientes/deleteCliente/{id}', 'ClienteAdminController@destroy')->name('deleteCliente');
    Route::get('clientes/validarClaveElector/{id}', 'ClienteAdminController@existeCliente');
    Route::get('clientes/cargaProspecto/{id}', 'ClienteAdminController@verProspecto')->name('verProspecto');
    Route::get('clientes/cargaCliente/{id}', 'ClienteAdminController@verCliente')->name('verCliente');
    Route::put('clientes/{id}', 'ClienteAdminController@actualizarEstadoCliente');
    Route::post('clientes/addreferencias/{id}', 'ClienteAdminController@guardarReferencias')->name('addreferencias');
    Route::post('clientes/editRefer/{id}', 'ClienteAdminController@editarReferencias')->name('editRefer');
    Route::get('clientes/datosReferencia/{id}', 'ClienteAdminController@verReferencia')->name('verReferencia');
    Route::post('clientes/clientesimport', 'ClienteAdminController@import')->name('importClients');






    Route::get('aval/validarClave/{id}', 'AvalController@existeCliente');
    Route::put('avales/{id}', 'AvalController@actualizarEstadoAval');
    Route::post('avales/reporteAval/','AvalController@reporteAvales')->name('reporteAvales');




    Route::get('solicitud/detalleClienteSolicitud/{id}', 'SolicitudAdminController@obtenerDetallesCliente');
    Route::post('solicitud/detalleTablaAmortizacion/', 'SolicitudAdminController@tablaAmortizacion')->name('tablaAmortizacion');
    Route::get('solicitud/productos/{id}', 'SolicitudAdminController@verProductos')->name('verProductos');
    Route::get('solicitud/pdf/solicitudCredito/{id}','SolicitudAdminController@pdfSolicitud')->name('solicitudCredito');
    Route::get('solicitud/pdf/tablaPagos/{id}','SolicitudAdminController@pdfTablePagos')->name('tablaPagos');


    Route::get('cuentas/addcuentas', 'CuentaController@create')->name('addcuenta');
    Route::post('cuentas/addcuentas', 'CuentaController@store')->name('addCuentas');
    Route::delete('cuentas/deleteCuenta/{id}', 'CuentaController@destroy')->name('deleteCuenta');
    Route::post('cuentas/reporteCuenta/','CuentaController@reporteCuentas')->name('reporteCuentas');


    Route::get('proveedores/addproveedores', 'ProveedorController@create')->name('addproveedor');
    Route::post('proveedores/addproveedores', 'ProveedorController@store')->name('addProveedores');
    Route::delete('proveedores/deleteProveedor/{id}', 'ProveedorController@destroy')->name('deleteProveedor');

    Route::get('analisis_credito/detalleCliente/{id}', 'AnalisisCreditoController@obtenerDetalles');
    Route::post('analisis_credito/detalleTablaAmortizacion/', 'AnalisisCreditoController@tablaAmortizacionRiesgo')->name('tablaAmortizacionRiesgo');
    Route::post('analisis_credito/variableRiesgo/', 'AnalisisCreditoController@tablaRiesgo')->name('tablaRiesgo');
    Route::post('analisis_credito/reporteColocacion/','AnalisisCreditoController@colocacionClientes')->name('colocacionClientes');


    Route::get('productos/addproductos', 'ProductoController@create')->name('addproducto');
    Route::post('productos/addproductos', 'ProductoController@store')->name('addProductos');
    Route::delete('productos/deleteProducto/{id}', 'ProductoController@destroy')->name('deleteProducto');
    Route::get('productos/numCuenta/{id}', 'ProductoController@verNumCuenta')->name('verNumCuenta');
    Route::post('productos/reporteSuc/','ProductoController@reporteSucursales')->name('reporteSucursales');


    Route::get('articulos/addarticulos', 'ArticuloController@create')->name('addarticulo');
    Route::get('articulos/clasificacion/{id}', 'ArticuloController@verClasificacion')->name('verClasificacion');
    Route::post('articulos/addarticulos', 'ArticuloController@store')->name('addArticulos');
    Route::delete('articulos/deleteArticulo/{id}', 'ArticuloController@destroy')->name('deleteArticulo');

    Route::post('reportes/reporteCliente/','ReporteController@reporteClientes')->name('reporteClientes');

    Route::get('gasto/articulos/{id}', 'GastoController@verArticulo')->name('verArticulo');
    Route::post('gastos/addSolicitud', 'GastoController@store')->name('addNuevaSolicitud');
    Route::delete('gastos/deleteProductoGasto/{idProducto}/{idCompra}', 'GastoController@destroy')->name('deleteProductoGasto');
    Route::get('gasto/rfcProveedor/{id}', 'GastoController@verRfc')->name('verRfc');
    Route::get('gasto/areaPersonals/{id}', 'GastoController@verArea')->name('verArea');
    Route::post('gasto/reporteGasto/','GastoController@reporteGastos')->name('reporteGastos');
    Route::post('gasto/reporteArticulo/','GastoController@reporteArticulos')->name('reporteArticulos');
    Route::post('gasto/reporteGlobal/','GastoController@reporteGastosGlobal')->name('reporteGastosGlobal');


    Route::post('activos/addSolicitudActivo', 'ActivoController@store')->name('addNuevoActivo');
    Route::get('activo/articulosActivo/{id}', 'ActivoController@verArticuloactivo')->name('verArticuloactivo');
    Route::get('activo/rfcProveedorActivo/{id}', 'ActivoController@verRfcActivo')->name('verRfcActivo');
    Route::get('activo/areaPersonalsActivo/{id}', 'ActivoController@verAreaActivo')->name('verAreaActivo');
    Route::delete('activo/deleteProductoActivo/{idProducto}/{idCompra}', 'ActivoController@destroy')->name('deleteProductoActivo');



    Route::get('banco/addbancos', 'BancoController@create')->name('addbanco');
    Route::get('banco/puestoPersonals/{idEmpleado}', 'BancoController@verPuesto')->name('verPuesto');
    Route::post('banco/addbancos', 'BancoController@store')->name('addBancos');
    Route::delete('banco/deleteBanco/{id}', 'BancoController@destroy')->name('deleteBanco');

    Route::get('cajas/addcajas', 'CajaController@create')->name('addcaja');
    Route::get('cajas/puestoPers/{idEmpleado}', 'CajaController@verPuesto')->name('verPuesto');
    Route::post('cajas/addcajas', 'CajaController@store')->name('addCajas');
    Route::delete('cajas/deleteCaja/{id}', 'CajaController@destroy')->name('deleteCaja');

    Route::get('sucursales/addsucursales', 'SucursalRutaController@create')->name('addSucursales');
    Route::put('sucursales/{id}', 'SucursalRutaController@actualizarEstadoSuc');

    // Route::post('pagos/addpagos', 'PagoController@store')->name('addPagos');
    Route::get('pagos/verContabilidad', 'PagoController@verContabilidad')->name('verContabilidad');

    Route::get('capital/detallesPersonals/{id}', 'CapitalController@verDetallesPersonal')->name('verDetallesPersonal');
    Route::post('capital/addSolicitud', 'CapitalController@store')->name('addSolicitudCapital');

    Route::post('noDeducible/addNodeducible', 'NoDeducibleController@store')->name('addNodeducible');
    Route::get('noDeducible/articulosNoDeducible/{id}', 'NoDeducibleController@verArticuloNoDeducible')->name('verArticuloNoDeducible');
    Route::get('noDeducible/rfcProveedorNoDeducible/{id}', 'NoDeducibleController@verRfcNoDeducible')->name('verRfcNoDeducible');
    Route::get('noDeducible/areaPersonalsNoDeducible/{id}', 'NoDeducibleController@verAreaNoDeducible')->name('verAreaNoDeducible');
    
    Route::get('nomina/allDetallesPersonals/{id}', 'NominaController@detallesPersonal')->name('detallesPersonal');
    Route::get('nomina/pdf/reciboNomina/{idEmpleado}','NominaController@pdfRecibo')->name('reciboNomina');
    Route::post('nominas/updateNom/{id}', 'NominaController@autorizarNomina')->name('updateNomina');
    Route::delete('nominas/deleteEmpleadoNom/{idNomina}/{idDetalle}', 'NominaController@destroy')->name('deleteEmpleadoNom');

    Route::post('movNomina/verificarPrestamos/', 'MovimientoNominaController@detallesPrestamoP')->name('detallesPrestamoP');
    Route::get('concepto/detalleConcepto/{id}', 'ConceptoNominaController@verDetallesConcepto')->name('verDetallesConcepto');

    Route::post('prestamoP/reportePrestamo/','PrestamoPersonalController@reportePrestamos')->name('reportePrestamos');
    Route::get('detallesPrestamos/{id}', 'PrestamoPersonalController@show');

    Route::get('asignacion/detalleActivo/{id}', 'AsignacionController@verDetalleCompraActivo')->name('verDetalleCompraActivo');

    Route::get('detalleBono/verDetalleBono/{id}', 'DetalleBonoController@verDetallesBono')->name('verDetallesBono');

    Route::get('colocacion/detalleClienteSeg/{curp}', 'ColocacionController@obtenerDetallesCliente');
    Route::get('colocacion/periodoSeg/{idProducto}', 'ColocacionController@verPeriodo')->name('verPeriodo');
    Route::post('colocacion/verMontosProducto/', 'ColocacionController@detallesMontoSeg')->name('detallesMontoSeg');
    Route::get('colocacion/montoSumaAseg/{idPrima}', 'ColocacionController@obtenerMonto');
    Route::post('colocacion/addBeneficiarios/{id}', 'ColocacionController@guardarReferencias')->name('addBeneficiarios');


    Route::post('colocacion/cargarPoliza', 'ColocacionController@guardarPoliza')->name('cargarPoliza');











    // Route::get('analisis_credito/addanalisis/{id}', 'AnalisisCreditoController@create')->name('addanalisis');
    // Route::post('analisis_credito/{id}', 'AnalisisCreditoController@analisisCredito')->name('addanalisis');









});
/*

php artisan make:controller UserController
php artisan make:controller UserAdminController --resource
php artisan make:seeder UserTableSeeder

php artisan make:controller PuestoAdminController --resource
php artisan make:controller PuestoController --resource

php artisan make:model Puesto -mfc
php artisan make:seeder PuestosTableSeeder

php artisan make:controller AsociadoAdminController --resource
php artisan make:model Asociado -mfc
php artisan make:seeder AsociadosTableSeeder

php artisan make:controller ClienteAdminController --resource
php artisan make:model Cliente -mfc
php artisan make:seeder ClientesTableSeeder

php artisan make:controller SolicitudAdminController --resource
php artisan make:model Solicitud -mfc
php artisan make:seeder SolicitudesTableSeeder

*/