<?php
    //Modulos
    $router->setRoute("modulos/","Modulos/Modulos",false);
    $router->setRoute("modulos/secciones/","Modulos/Secciones",false);
    $router->setRoute("modulos/opciones/","Modulos/Opciones",false);

    //Dashboard
    $router->setRoute("dashboard/","Dashboard/Dashboard",false);

    //Sistema
    $router->setRoute("sistema/roles/","Sistema/Roles",false);
    $router->setRoute("sistema/usuarios/","Sistema/Usuarios",false);
    $router->setRoute("profile/","Sistema/Usuarios/perfil",false);
    

    //Clientes
    $router->setRoute("clientes/","Clientes/Clientes",false);

    //Productos
    $router->setRoute("productos/categorias/","Productos/ProductosCategorias/categorias",false);
    $router->setRoute("productos/subcategorias/","Productos/ProductosCategorias/subcategorias",false);
    $router->setRoute("productos/creacion-edicion-masiva/","Productos/ProductosMasivos/productos",false);
    $router->setRoute("productos/","Productos/Productos",false);
    $router->setRoute("productos/variantes/","Productos/ProductosOpciones/variantes",false);
    $router->setRoute("productos/unidades-medida/","Productos/ProductosOpciones/unidades",false);
    $router->setRoute("productos/caracteristicas/","Productos/ProductosOpciones/caracteristicas",false);

    //Servicios
    $router->setRoute("servicios/","Servicios/Servicios/servicios",false);
    $router->setRoute("servicios/citas/","Servicios/Citas/citas",false);

    //Pedidos
    $router->setRoute("pedidos/cotizaciones/","Pedidos/Cotizaciones/cotizaciones",false);
    $router->setRoute("pedidos/","Pedidos/Pedidos",false);
    $router->setRoute("pedidos/pedidos-credito/","Pedidos/Pedidos/creditos",false);
    $router->setRoute("pedidos/pedidos-detalle/","Pedidos/Pedidos/detalle",false);
    $router->setRoute("pedidos/punto-venta/","Pedidos/PedidosPos/venta",false);
    $router->setRoute("pedidos/transaccion/","Pedidos/Pedidos/transaccion");
    $router->setRoute("pedidos/factura/","Pedidos/Pedidos/pdf");


    //Configuracion
    $router->setRoute("configuracion/parametros/","Configuracion/Empresa/empresa",false);
    $router->setRoute("configuracion/envios/","Configuracion/Administracion/envios",false);
    $router->setRoute("configuracion/paginas/","Configuracion/Paginas/paginas",false);
    $router->setRoute("configuracion/banners/","Configuracion/Banners/banners",false);

    //Web
    $router->setRoute("about/","Nosotros",false);
    $router->setRoute("shop/","Tienda",false);
    $router->setRoute("shop/search/","Tienda/buscar");
    $router->setRoute("shop/product/","Tienda/producto");
    $router->setRoute("shop/category/","Tienda/categoria");
    $router->setRoute("shop/service/","Tienda/servicio");
    $router->setRoute("cart/","Carrito",false);
    $router->setRoute("checkout/","Pago/pago",false);
    $router->setRoute("checkout/approved/","Pago/confirmar",false);
    $router->setRoute("checkout/error/","Pago/error",false);
    $router->setRoute("checkout/service/","Pago/servicio");
?>