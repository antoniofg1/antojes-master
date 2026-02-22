-- Script SQL para insertar usuarios de Valencia con geolocalización
-- Todos los usuarios tienen password: password123 (hash bcrypt)
-- Coordenadas reales de ubicaciones en Valencia, España

-- Primero asegurarse de que la tabla está vacía (opcional, comentar si no quieres borrar datos existentes)
-- TRUNCATE TABLE user;

-- Insertar usuarios de Valencia
INSERT INTO user (name, email, password, lat, lng, online, created_at) VALUES
('María García', 'maria.garcia@valencia.com', '$2y$13$ZqgPZ8H9qVVPxKJ3N2xVd.TQ7KqKfLGYG8qBwXQCLU9UJg8N8H9qV', 39.4699, -0.3763, 1, NOW()),
('Carlos Martínez', 'carlos.martinez@valencia.com', '$2y$13$ZqgPZ8H9qVVPxKJ3N2xVd.TQ7KqKfLGYG8qBwXQCLU9UJg8N8H9qV', 39.4702, -0.3768, 1, NOW()),
('Ana López', 'ana.lopez@valencia.com', '$2y$13$ZqgPZ8H9qVVPxKJ3N2xVd.TQ7KqKfLGYG8qBwXQCLU9UJg8N8H9qV', 39.4754, -0.3773, 1, NOW()),
('David Rodríguez', 'david.rodriguez@valencia.com', '$2y$13$ZqgPZ8H9qVVPxKJ3N2xVd.TQ7KqKfLGYG8qBwXQCLU9UJg8N8H9qV', 39.4845, -0.3472, 1, NOW()),
('Laura Fernández', 'laura.fernandez@valencia.com', '$2y$13$ZqgPZ8H9qVVPxKJ3N2xVd.TQ7KqKfLGYG8qBwXQCLU9UJg8N8H9qV', 39.4628, -0.3758, 1, NOW()),
('Javier Sánchez', 'javier.sanchez@valencia.com', '$2y$13$ZqgPZ8H9qVVPxKJ3N2xVd.TQ7KqKfLGYG8qBwXQCLU9UJg8N8H9qV', 39.4747, -0.3758, 1, NOW()),
('Elena Gómez', 'elena.gomez@valencia.com', '$2y$13$ZqgPZ8H9qVVPxKJ3N2xVd.TQ7KqKfLGYG8qBwXQCLU9UJg8N8H9qV', 39.4562, -0.3518, 1, NOW()),
('Miguel Díaz', 'miguel.diaz@valencia.com', '$2y$13$ZqgPZ8H9qVVPxKJ3N2xVd.TQ7KqKfLGYG8qBwXQCLU9UJg8N8H9qV', 39.4821, -0.3647, 1, NOW()),
('Isabel Ruiz', 'isabel.ruiz@valencia.com', '$2y$13$ZqgPZ8H9qVVPxKJ3N2xVd.TQ7KqKfLGYG8qBwXQCLU9UJg8N8H9qV', 39.4673, -0.3812, 1, NOW()),
('Antonio Moreno', 'antonio.moreno@valencia.com', '$2y$13$ZqgPZ8H9qVVPxKJ3N2xVd.TQ7KqKfLGYG8qBwXQCLU9UJg8N8H9qV', 39.4695, -0.3801, 1, NOW()),
('Carmen Jiménez', 'carmen.jimenez@valencia.com', '$2y$13$ZqgPZ8H9qVVPxKJ3N2xVd.TQ7KqKfLGYG8qBwXQCLU9UJg8N8H9qV', 39.4756, -0.3692, 1, NOW()),
('Francisco Álvarez', 'francisco.alvarez@valencia.com', '$2y$13$ZqgPZ8H9qVVPxKJ3N2xVd.TQ7KqKfLGYG8qBwXQCLU9UJg8N8H9qV', 39.4612, -0.3894, 1, NOW()),
('Lucía Romero', 'lucia.romero@valencia.com', '$2y$13$ZqgPZ8H9qVVPxKJ3N2xVd.TQ7KqKfLGYG8qBwXQCLU9UJg8N8H9qV', 39.4781, -0.3589, 1, NOW()),
('Pablo Torres', 'pablo.torres@valencia.com', '$2y$13$ZqgPZ8H9qVVPxKJ3N2xVd.TQ7KqKfLGYG8qBwXQCLU9UJg8N8H9qV', 39.4658, -0.3521, 1, NOW()),
('Marta Navarro', 'marta.navarro@valencia.com', '$2y$13$ZqgPZ8H9qVVPxKJ3N2xVd.TQ7KqKfLGYG8qBwXQCLU9UJg8N8H9qV', 39.4715, -0.3745, 1, NOW()),
('Raúl Domínguez', 'raul.dominguez@valencia.com', '$2y$13$ZqgPZ8H9qVVPxKJ3N2xVd.TQ7KqKfLGYG8qBwXQCLU9UJg8N8H9qV', 39.4692, -0.3623, 1, NOW()),
('Sara Vázquez', 'sara.vazquez@valencia.com', '$2y$13$ZqgPZ8H9qVVPxKJ3N2xVd.TQ7KqKfLGYG8qBwXQCLU9UJg8N8H9qV', 39.4835, -0.3512, 1, NOW()),
('Alberto Gil', 'alberto.gil@valencia.com', '$2y$13$ZqgPZ8H9qVVPxKJ3N2xVd.TQ7KqKfLGYG8qBwXQCLU9UJg8N8H9qV', 39.4643, -0.3682, 1, NOW()),
('Patricia Serrano', 'patricia.serrano@valencia.com', '$2y$13$ZqgPZ8H9qVVPxKJ3N2xVd.TQ7KqKfLGYG8qBwXQCLU9UJg8N8H9qV', 39.4598, -0.3612, 1, NOW()),
('Daniel Castro', 'daniel.castro@valencia.com', '$2y$13$ZqgPZ8H9qVVPxKJ3N2xVd.TQ7KqKfLGYG8qBwXQCLU9UJg8N8H9qV', 39.4776, -0.3721, 1, NOW()),
('Test User', 'test@example.com', '$2y$13$ZqgPZ8H9qVVPxKJ3N2xVd.TQ7KqKfLGYG8qBwXQCLU9UJg8N8H9qV', 39.4699, -0.3763, 1, NOW());

-- Crear el chat general (si no existe)
INSERT INTO chat (id, type, is_active) VALUES (1, 'general', 1) 
ON DUPLICATE KEY UPDATE type = 'general';

-- Verificar que los usuarios se insertaron correctamente
SELECT COUNT(*) as total_usuarios FROM user;
SELECT name, email, lat, lng, online FROM user;

-- Información útil:
-- Todos los usuarios tienen la contraseña: password123
-- Todos están marcados como online (1)
-- Las coordenadas corresponden a ubicaciones reales en Valencia:
-- - Plaza del Ayuntamiento: 39.4699, -0.3763
-- - Torres de Serranos: 39.4754, -0.3773
-- - Ciudad de las Artes: 39.4845, -0.3472
-- - Estación del Norte: 39.4628, -0.3758
-- - Barrio del Carmen: 39.4747, -0.3758
-- - Malvarrosa: 39.4562, -0.3518
-- - Y más ubicaciones en Valencia...
