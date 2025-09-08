<?php
    //Modulos
    $router->setRoute("modulos/","Modulos/Modulos",false);
    $router->setRoute("modulos/secciones/","Modulos/Secciones",false);
    $router->setRoute("modulos/opciones/","Modulos/Opciones",false);

    //Dashboard
    $router->setRoute("dashboard/","Dashboard/Dashboard",false);

    //Sistema
    $router->setRoute("system/roles/","Sistema/Roles",false);
    $router->setRoute("system/users/","Sistema/Usuarios",false);
    $router->setRoute("profile/","Sistema/Usuarios/perfil",false);
    

    //Clientes
    $router->setRoute("customers/","Clientes/Clientes",false);

    //Productos
    $router->setRoute("products/categories/","Productos/ProductosCategorias/categorias",false);
    $router->setRoute("products/subcategories/","Productos/ProductosCategorias/subcategorias",false);
    $router->setRoute("products/masive-creation/","Productos/ProductosMasivos/productos",false);
    $router->setRoute("products/","Productos/Productos",false);
    $router->setRoute("products/variants/","Productos/ProductosOpciones/variantes",false);
    $router->setRoute("products/units/","Productos/ProductosOpciones/unidades",false);
    $router->setRoute("products/features/","Productos/ProductosOpciones/caracteristicas",false);
    $router->setRoute("products/services/","Servicios/Servicios/servicios",false);

    //Pedidos
    $router->setRoute("orders/appointments/","Servicios/Citas/citas",false);
    $router->setRoute("orders/","Pedidos/Pedidos",false);
    $router->setRoute("orders/detailed/","Pedidos/Pedidos/detalle",false);
    $router->setRoute("orders/pos/","Pedidos/PedidosPos/venta",false);


    //Configuracion
    $router->setRoute("settings/parameters/","Configuracion/Empresa/empresa",false);
    $router->setRoute("settings/shippment/","Configuracion/Administracion/envios",false);

    $router->setRoute("sections/pages/","Configuracion/Secciones/paginas",false);
    $router->setRoute("sections/banners/","Configuracion/Banners/banners",false);
    $router->setRoute("sections/gallery/","Configuracion/Gallery/gallery",false);
    $router->setRoute("sections/faq/","Configuracion/Secciones/faq",false);
    $router->setRoute("email/","Configuracion/Administracion/mensajes",false);
    $router->setRoute("email/message/","Configuracion/Administracion/message");
    $router->setRoute("email/sent/","Configuracion/Administracion/sent");

    //Web
    $router->setRoute("terms/","Politicas/terminos",false);
    $router->setRoute("privacy/","Politicas/privacidad",false);
    $router->setRoute("gallery/","Tienda/galeria",false);
    $router->setRoute("about/","Nosotros",false);
    $router->setRoute("contact/","Contacto",false);
    $router->setRoute("shop/","Tienda",false);
    $router->setRoute("shop/search/","Tienda/buscar");
    $router->setRoute("shop/product/","Tienda/producto");
    $router->setRoute("shop/category/","Tienda/categoria");
    $router->setRoute("shop/service/","Tienda/servicio");
    $router->setRoute("shop/services/","Tienda/servicios");
    $router->setRoute("cart/","Carrito",false);
    $router->setRoute("checkout/","Pago/pago",false);
    $router->setRoute("checkout/approved/","Pago/confirmar",false);
    $router->setRoute("checkout/error/","Pago/error",false);
    $router->setRoute("checkout/service/","Pago/servicio");
    $router->setRoute("recovery/","Login/confirmUser");
    $router->setRoute("checkout/service-approved/","Pago/serviceConfirmed");
?>