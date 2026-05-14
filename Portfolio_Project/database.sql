SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `demo_link` varchar(255) DEFAULT NULL,
  `repo_link` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `projects` (`id`, `title`, `description`, `image_url`, `demo_link`, `repo_link`, `created_at`) VALUES
(1, 'Musichool', 'An online music education platform I contributed to as a Frontend Developer. Built a responsive, user-friendly interface enabling students to discover and book music lessons across Turkey.', 'https://images.unsplash.com/photo-1511379938547-c1f69419868d?q=80&w=1000&auto=format&fit=crop', 'https://musichool.co/tr/', NULL, '2024-06-01 10:00:00'),
(2, 'GameGuru — Game Development Internship', 'Completed a game development internship at GameGuru, a leading game studio. Worked with Unity and C# to design and implement game mechanics, prototype gameplay systems, and optimize real-time performance for mobile and PC titles.', 'https://images.unsplash.com/photo-1535016120720-40c646be5580?q=80&w=1000&auto=format&fit=crop', 'https://gameguru.net/', NULL, '2023-09-01 10:00:00');

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `username`, `password_hash`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

ALTER TABLE `messages` ADD PRIMARY KEY (`id`);
ALTER TABLE `projects` ADD PRIMARY KEY (`id`);
ALTER TABLE `users` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`);

ALTER TABLE `messages` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
ALTER TABLE `projects` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
ALTER TABLE `users` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;
