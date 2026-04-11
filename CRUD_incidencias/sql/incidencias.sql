CREATE DATABASE IF NOT EXISTS reparaya;
USE reparaya;

CREATE TABLE IF NOT EXISTS incidencias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(20) NOT NULL UNIQUE,         
    usuario_id INT NOT NULL,                     
    descripcion TEXT NOT NULL,                   
    tipo_servicio ENUM('estandar', 'urgente') NOT NULL DEFAULT 'estandar',
    estado ENUM('pendiente', 'asignada', 'en_proceso', 'completada', 'cancelada') NOT NULL DEFAULT 'pendiente',
    fecha_servicio DATETIME NOT NULL,            
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    tecnico_id INT DEFAULT NULL,                 
    CONSTRAINT chk_48h CHECK (
        tipo_servicio = 'urgente' OR 
        fecha_servicio >= DATE_ADD(fecha_creacion, INTERVAL 48 HOUR)
    )
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;