# Alojamiento CRUD

## Descripción

Este proyecto es una aplicación web para la gestión de alojamientos. Permite a los administradores agregar, editar, actualizar y eliminar alojamientos, así como gestionar usuarios y reservas. Los usuarios pueden ver los alojamientos disponibles y realizar reservas.

## Instalación

1. Clona el repositorio desde GitHub:
    ```sh
    git clone https://github.com/tu-usuario/alojamiento-crud.git
    ```

2. Navega al directorio del proyecto:
    ```sh
    cd alojamiento-crud
    ```

3. Configura la base de datos:
    - Crea una base de datos en MySQL.
    - Ejecuta el siguiente script SQL para crear las tablas necesarias:

    ```sql
    CREATE DATABASE alojamiento_crud;

    USE alojamiento_crud;

    CREATE TABLE `users` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `username` varchar(255) NOT NULL,
      `password` varchar(255) NOT NULL,
      `email` varchar(255) NOT NULL,
      `balance` decimal(10,2) DEFAULT 0.00,
      `role` enum('admin','user') DEFAULT 'user',
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    CREATE TABLE `alojamientos` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `user_id` int(11) NOT NULL,
      `name` varchar(255) NOT NULL,
      `description` text NOT NULL,
      `location` varchar(255) NOT NULL,
      `price` decimal(10,2) NOT NULL,
      `rooms` int(11) DEFAULT 1,
      `availability` tinyint(1) DEFAULT 1,
      `image` varchar(255) DEFAULT NULL,
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `user_id` (`user_id`),
      CONSTRAINT `alojamientos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    CREATE TABLE `reservations` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `alojamiento_id` int(11) NOT NULL,
      `user_id` int(11) NOT NULL,
      `checkin` date NOT NULL,
      `checkout` date NOT NULL,
      `price` decimal(10,2) NOT NULL,
      `total_amount` decimal(10,2) NOT NULL,
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `alojamiento_id` (`alojamiento_id`),
      KEY `user_id` (`user_id`),
      CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`alojamiento_id`) REFERENCES `alojamientos` (`id`) ON DELETE CASCADE,
      CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ```

4. Configura el archivo de conexión a la base de datos:
    - Edita el archivo `config/database.php` con tus credenciales de MySQL.

5. Inicia el servidor web:
    - Si estás utilizando XAMPP, coloca el proyecto en el directorio `htdocs` y navega a `http://localhost/alojamiento-crud`.

## Autor

- **Nombre del Autor**: [Grupo 6:
Melvin Alexander González Ramos
Luis Rolando Tobar
Jose Adalid Jimenez Alas]
- **Correo Electrónico**: [tu-email@example.com]

## Información Adicional

Este proyecto utiliza el patrón de diseño MVC (Modelo-Vista-Controlador) para organizar el código y facilitar el mantenimiento.
