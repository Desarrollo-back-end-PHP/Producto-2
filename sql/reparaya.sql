CREATE DATABASE IF NOT EXISTS reparaya;
USE reparaya;

CREATE TABLE IF NOT EXISTS usuarios (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nombre     VARCHAR(100) NOT NULL,
    email      VARCHAR(150) NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,
    rol        ENUM('admin','tecnico','cliente') DEFAULT 'cliente',
    created_at DATETIME DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS tecnicos (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    nombre       VARCHAR(100) NOT NULL,
    email        VARCHAR(150),
    especialidad VARCHAR(100),
    telefono     VARCHAR(20),
    activo       TINYINT DEFAULT 1
);

CREATE TABLE IF NOT EXISTS tipos_servicio (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nombre      VARCHAR(100) NOT NULL,
    descripcion TEXT
);

CREATE TABLE IF NOT EXISTS avisos (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    codigo         VARCHAR(50) NOT NULL UNIQUE,
    usuario_id     INT,
    tecnico_id     INT,
    tipo_servicio  VARCHAR(100),
    urgencia       ENUM('estandar','urgente') DEFAULT 'estandar',
    fecha          DATETIME,
    franja         VARCHAR(50),
    descripcion    TEXT,
    direccion      VARCHAR(255),
    telefono       VARCHAR(20),
    estado         ENUM('pendiente','asignada','completada','cancelada') DEFAULT 'pendiente',
    created_at     DATETIME DEFAULT NOW(),
    FOREIGN KEY (usuario_id)  REFERENCES usuarios(id) ON DELETE SET NULL,
    FOREIGN KEY (tecnico_id)  REFERENCES tecnicos(id) ON DELETE SET NULL
);

-- Usuario admin por defecto (password: admin)
INSERT INTO usuarios (nombre, email, password, rol)
VALUES ('Administrador', 'admin@reparaya.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Tipos de servicio base
INSERT INTO tipos_servicio (nombre) VALUES ('Fontaneria'),('Electricidad'),('Carpinteria'),('Pintura'),('Climatizacion');
