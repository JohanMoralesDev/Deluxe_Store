CREATE DATABASE IF NOT EXISTS deluxe_store
CHARACTER SET utf8mb4
COLLATE utf8mb4_0900_ai_ci;

USE deluxe_store;

-- USUARIOS Y ROLES

CREATE TABLE usuarios (
    id_usuario BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    correo VARCHAR(150) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    telefono VARCHAR(25) NULL,
    direccion VARCHAR(255) NULL,
    ciudad VARCHAR(100) NULL,
    departamento VARCHAR(100) NULL,
    esta_activo BOOLEAN NOT NULL DEFAULT TRUE,
    correo_verificado_en TIMESTAMP NULL,
    token_recordatorio VARCHAR(100) NULL,
    creado_en TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE roles (
    id_rol BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    descripcion VARCHAR(255) NULL,
    creado_en TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE usuario_rol (
    id_usuario BIGINT UNSIGNED NOT NULL,
    id_rol BIGINT UNSIGNED NOT NULL,
    creado_en TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (id_usuario, id_rol),

    CONSTRAINT fk_usuario_rol_usuario
        FOREIGN KEY (id_usuario)
        REFERENCES usuarios(id_usuario)
        ON DELETE CASCADE,

    CONSTRAINT fk_usuario_rol_rol
        FOREIGN KEY (id_rol)
        REFERENCES roles(id_rol)
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- CATEGORIAS Y PRODUCTOS

CREATE TABLE categorias (
    id_categoria BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT NULL,
    esta_activa BOOLEAN NOT NULL DEFAULT TRUE,
    creado_en TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE productos (
    id_producto BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_categoria BIGINT UNSIGNED NOT NULL,
    nombre VARCHAR(150) NOT NULL,
    codigo_sku VARCHAR(80) NOT NULL UNIQUE,
    descripcion TEXT NULL,
    precio DECIMAL(12,2) NOT NULL,
    precio_oferta DECIMAL(12,2) NULL,
    color VARCHAR(50) NULL,
    url_imagen VARCHAR(500) NULL,
    esta_activo BOOLEAN NOT NULL DEFAULT TRUE,
    creado_en TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_productos_categoria
        FOREIGN KEY (id_categoria)
        REFERENCES categorias(id_categoria)
        ON DELETE RESTRICT,

    CONSTRAINT chk_productos_precio
        CHECK (precio >= 0),

    CONSTRAINT chk_productos_oferta
        CHECK (
            precio_oferta IS NULL
            OR (precio_oferta >= 0 AND precio_oferta <= precio)
        ),

    INDEX idx_productos_categoria (id_categoria),
    INDEX idx_productos_nombre (nombre),
    INDEX idx_productos_activo (esta_activo)
) ENGINE=InnoDB;

-- INVENTARIO Y MOVIMIENTOS

CREATE TABLE inventarios (
    id_inventario BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_producto BIGINT UNSIGNED NOT NULL UNIQUE,
    cantidad INT UNSIGNED NOT NULL DEFAULT 0,
    stock_minimo INT UNSIGNED NOT NULL DEFAULT 5,
    actualizado_en TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_inventarios_producto
        FOREIGN KEY (id_producto)
        REFERENCES productos(id_producto)
        ON DELETE RESTRICT
) ENGINE=InnoDB;

--  PROVEEDORES Y ABASTECIMIENTO

CREATE TABLE proveedores (
    id_proveedor BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    correo VARCHAR(150) NULL,
    telefono VARCHAR(25) NULL,
    direccion VARCHAR(255) NULL,
    persona_contacto VARCHAR(150) NULL,
    esta_activo BOOLEAN NOT NULL DEFAULT TRUE,
    creado_en TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE recepciones_proveedor (
    id_recepcion_proveedor BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_proveedor BIGINT UNSIGNED NOT NULL,
    id_usuario BIGINT UNSIGNED NULL,
    numero_recepcion VARCHAR(100) NOT NULL UNIQUE,
    fecha_recepcion DATETIME NOT NULL,
    costo_total DECIMAL(14,2) NOT NULL DEFAULT 0,
    observaciones TEXT NULL,
    creado_en TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_recepciones_proveedor
        FOREIGN KEY (id_proveedor)
        REFERENCES proveedores(id_proveedor)
        ON DELETE RESTRICT,

    CONSTRAINT fk_recepciones_usuario
        FOREIGN KEY (id_usuario)
        REFERENCES usuarios(id_usuario)
        ON DELETE SET NULL,

    CONSTRAINT chk_recepciones_total
        CHECK (costo_total >= 0)
) ENGINE=InnoDB;

CREATE TABLE detalle_recepcion_proveedor (
    id_detalle_recepcion BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_recepcion_proveedor BIGINT UNSIGNED NOT NULL,
    id_producto BIGINT UNSIGNED NOT NULL,
    cantidad INT UNSIGNED NOT NULL,
    costo_unitario DECIMAL(12,2) NOT NULL,
    subtotal DECIMAL(14,2) NOT NULL,

    CONSTRAINT fk_detalle_recepcion_recepcion
        FOREIGN KEY (id_recepcion_proveedor)
        REFERENCES recepciones_proveedor(id_recepcion_proveedor)
        ON DELETE RESTRICT,

    CONSTRAINT fk_detalle_recepcion_producto
        FOREIGN KEY (id_producto)
        REFERENCES productos(id_producto)
        ON DELETE RESTRICT,

    CONSTRAINT chk_detalle_recepcion_cantidad
        CHECK (cantidad > 0),

    CONSTRAINT chk_detalle_recepcion_costo
        CHECK (costo_unitario >= 0 AND subtotal >= 0),

    INDEX idx_detalle_recepcion_producto (id_producto)
) ENGINE=InnoDB;

--  PEDIDOS Y DETALLES

CREATE TABLE pedidos (
    id_pedido BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_usuario BIGINT UNSIGNED NOT NULL,
    numero_pedido VARCHAR(50) NOT NULL UNIQUE,
    estado VARCHAR(30) NOT NULL DEFAULT 'PENDIENTE',
    estado_pago VARCHAR(30) NOT NULL DEFAULT 'PENDIENTE',
    metodo_pago VARCHAR(50) NULL,

    subtotal DECIMAL(14,2) NOT NULL DEFAULT 0,
    costo_envio DECIMAL(12,2) NOT NULL DEFAULT 0,
    descuento DECIMAL(12,2) NOT NULL DEFAULT 0,
    total DECIMAL(14,2) NOT NULL DEFAULT 0,

    nombre_destinatario VARCHAR(150) NOT NULL,
    telefono_destinatario VARCHAR(25) NOT NULL,
    direccion_envio VARCHAR(255) NOT NULL,
    ciudad_envio VARCHAR(100) NOT NULL,
    departamento_envio VARCHAR(100) NOT NULL,

    observaciones TEXT NULL,
    fecha_pedido DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    creado_en TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_pedidos_usuario
        FOREIGN KEY (id_usuario)
        REFERENCES usuarios(id_usuario)
        ON DELETE RESTRICT,

    CONSTRAINT chk_pedidos_valores
        CHECK (
            subtotal >= 0
            AND costo_envio >= 0
            AND descuento >= 0
            AND total >= 0
        ),

    INDEX idx_pedidos_usuario (id_usuario),
    INDEX idx_pedidos_estado (estado),
    INDEX idx_pedidos_estado_pago (estado_pago),
    INDEX idx_pedidos_fecha (fecha_pedido)
) ENGINE=InnoDB;

CREATE TABLE detalle_pedido (
    id_detalle BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_pedido BIGINT UNSIGNED NOT NULL,
    id_producto BIGINT UNSIGNED NOT NULL,

    nombre_producto VARCHAR(150) NOT NULL,
    codigo_sku VARCHAR(80) NOT NULL,

    cantidad INT UNSIGNED NOT NULL,
    precio_unitario DECIMAL(12,2) NOT NULL,
    subtotal DECIMAL(14,2) NOT NULL,

    creado_en TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_detalle_pedido_pedido
        FOREIGN KEY (id_pedido)
        REFERENCES pedidos(id_pedido)
        ON DELETE RESTRICT,

    CONSTRAINT fk_detalle_pedido_producto
        FOREIGN KEY (id_producto)
        REFERENCES productos(id_producto)
        ON DELETE RESTRICT,

    CONSTRAINT chk_detalle_pedido_cantidad
        CHECK (cantidad > 0),

    CONSTRAINT chk_detalle_pedido_precios
        CHECK (precio_unitario >= 0 AND subtotal >= 0),

    UNIQUE KEY uq_pedido_producto (id_pedido, id_producto),
    INDEX idx_detalle_pedido_producto (id_producto)
) ENGINE=InnoDB;

-- HISTORIAL DE ESTADOS DE PEDIDOS

CREATE TABLE historial_estados_pedido (
    id_historial_pedido BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_pedido BIGINT UNSIGNED NOT NULL,
    id_usuario BIGINT UNSIGNED NULL,
    estado_anterior VARCHAR(30) NULL,
    estado_nuevo VARCHAR(30) NOT NULL,
    comentario VARCHAR(500) NULL,
    fecha_cambio TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_historial_pedido
        FOREIGN KEY (id_pedido)
        REFERENCES pedidos(id_pedido)
        ON DELETE RESTRICT,

    CONSTRAINT fk_historial_usuario
        FOREIGN KEY (id_usuario)
        REFERENCES usuarios(id_usuario)
        ON DELETE SET NULL,

    INDEX idx_historial_pedido (id_pedido),
    INDEX idx_historial_fecha (fecha_cambio)
) ENGINE=InnoDB;

-- HISTORIAL DE MOVIMIENTOS DE INVENTARIO

CREATE TABLE movimientos_inventario (
    id_movimiento_inventario BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_producto BIGINT UNSIGNED NOT NULL,
    id_usuario BIGINT UNSIGNED NULL,

    id_pedido BIGINT UNSIGNED NULL,
    id_recepcion_proveedor BIGINT UNSIGNED NULL,

    tipo_movimiento VARCHAR(20) NOT NULL,
    cantidad INT UNSIGNED NOT NULL,

    stock_anterior INT UNSIGNED NOT NULL,
    stock_nuevo INT UNSIGNED NOT NULL,

    descripcion VARCHAR(500) NULL,
    fecha_movimiento TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_movimientos_producto
        FOREIGN KEY (id_producto)
        REFERENCES productos(id_producto)
        ON DELETE RESTRICT,

    CONSTRAINT fk_movimientos_usuario
        FOREIGN KEY (id_usuario)
        REFERENCES usuarios(id_usuario)
        ON DELETE SET NULL,

    CONSTRAINT fk_movimientos_pedido
        FOREIGN KEY (id_pedido)
        REFERENCES pedidos(id_pedido)
        ON DELETE RESTRICT,

    CONSTRAINT fk_movimientos_recepcion
        FOREIGN KEY (id_recepcion_proveedor)
        REFERENCES recepciones_proveedor(id_recepcion_proveedor)
        ON DELETE RESTRICT,

    CONSTRAINT chk_tipo_movimiento
        CHECK (
            tipo_movimiento IN (
                'ENTRADA',
                'SALIDA',
                'AJUSTE',
                'DEVOLUCION'
            )
        ),

    CONSTRAINT chk_movimiento_cantidad
        CHECK (cantidad > 0),

    INDEX idx_movimientos_producto (id_producto),
    INDEX idx_movimientos_usuario (id_usuario),
    INDEX idx_movimientos_fecha (fecha_movimiento),
    INDEX idx_movimientos_tipo (tipo_movimiento),
    INDEX idx_movimientos_pedido (id_pedido)
) ENGINE=InnoDB;

SELECT
    TABLE_NAME AS tabla,
    COLUMN_NAME AS columna,
    REFERENCED_TABLE_NAME AS tabla_relacionada,
    REFERENCED_COLUMN_NAME AS columna_relacionada
FROM information_schema.KEY_COLUMN_USAGE
WHERE TABLE_SCHEMA = 'deluxe_store'
AND REFERENCED_TABLE_NAME IS NOT NULL
ORDER BY TABLE_NAME;


-- ROLES DEL SISTEMA

INSERT INTO roles (nombre, descripcion)
VALUES
('ADMINISTRADOR', 'Acceso completo al sistema y gestión administrativa.'),
('CLIENTE', 'Usuario que puede consultar productos y realizar pedidos.'),
('EMPLEADO', 'Usuario autorizado para gestionar operaciones de la tienda.')
ON DUPLICATE KEY UPDATE
descripcion = VALUES(descripcion);


-- CATEGORÍAS

INSERT INTO categorias (
    id_categoria,
    nombre,
    descripcion,
    esta_activa
)
VALUES
(1, 'Relojes de Hombre',
 'Relojes masculinos analógicos, cronógrafos y deportivos Curren.', TRUE),

(2, 'Relojes de Mujer',
 'Relojes femeninos elegantes y de malla Curren.', TRUE),

(3, 'Accesorios y Estuches',
 'Complementos, estuches y bolsas de regalo para relojes.', TRUE)

ON DUPLICATE KEY UPDATE
nombre = VALUES(nombre),
descripcion = VALUES(descripcion),
esta_activa = VALUES(esta_activa);


-- PRODUCTOS

INSERT INTO productos (
    id_producto,
    id_categoria,
    nombre,
    codigo_sku,
    descripcion,
    precio,
    precio_oferta,
    color,
    url_imagen,
    esta_activo
)
VALUES

(8225, 1,
 'Reloj de Hombre Curren 8225 + Esfero + Bolsa de Regalo',
 'CUR-8225',
 'Diseño casual elegante con pulso en cuero sintético resistente.',
 175000.00, 120000.00, 'Marrón Claro',
 'https://www.currencolombia.com/cdn/shop/files/8225.jpg', TRUE),

(8329, 1,
 'Reloj de Hombre Curren 8329 + Esfero + Bolsa de Regalo',
 'CUR-8329',
 'Reloj analógico deportivo con cronógrafo funcional y correa de cuero.',
 200000.00, 160000.00, 'Marrón / Negro',
 'https://www.currencolombia.com/cdn/shop/files/8329.jpg', TRUE),

(8355, 1,
 'Reloj de Hombre Curren 8355 + Esfero + Bolsa de Regalo',
 'CUR-8355',
 'Reloj imponente de acero inoxidable con tres subesferas funcionales.',
 195000.00, 160000.00, 'Plateado / Azul',
 'https://www.currencolombia.com/cdn/shop/files/8355.jpg', TRUE),

(8473, 1,
 'Reloj de Hombre Curren 8473 + Esfero + Bolsa de Regalo',
 'CUR-8473',
 'Reloj deportivo moderno resistente al agua casual.',
 165000.00, 140000.00, 'Negro Mate',
 'https://www.currencolombia.com/cdn/shop/files/8473.jpg', TRUE),

(9007, 2,
 'Reloj de Dama Curren Malla Metálica',
 'CUR-9007',
 'Reloj femenino ultra delgado con tejido tipo malla de acero.',
 150000.00, 110000.00, 'Oro Rosa',
 'https://www.currencolombia.com/cdn/shop/files/9007.jpg', TRUE)

ON DUPLICATE KEY UPDATE
id_categoria = VALUES(id_categoria),
nombre = VALUES(nombre),
descripcion = VALUES(descripcion),
precio = VALUES(precio),
precio_oferta = VALUES(precio_oferta),
color = VALUES(color),
url_imagen = VALUES(url_imagen),
esta_activo = VALUES(esta_activo);


-- INVENTARIO INICIAL

INSERT INTO inventarios (
    id_producto,
    cantidad,
    stock_minimo
)
VALUES
(8225, 20, 5),
(8329, 15, 5),
(8355, 10, 5),
(8473, 12, 5),
(9007, 18, 5)

ON DUPLICATE KEY UPDATE
cantidad = VALUES(cantidad),
stock_minimo = VALUES(stock_minimo);

-- PROVEEDOR DE PRUEBA

INSERT INTO proveedores (
    nombre,
    correo,
    telefono,
    direccion,
    persona_contacto,
    esta_activo
)
VALUES
(
 'Proveedor de Prueba Curren',
 'proveedor.prueba@ejemplo.com',
 '3000000000',
 'Dirección de prueba',
 'Contacto de prueba',
 TRUE
);

COMMIT;