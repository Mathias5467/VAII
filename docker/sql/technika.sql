
CREATE TABLE IF NOT EXISTS `boxes` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `code` VARCHAR(50) NOT NULL UNIQUE,
    `description` VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS `equipment` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `serial_number` VARCHAR(50) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `category` VARCHAR(50) NOT NULL,
    `box_id` INT NULL,
    `status` VARCHAR(20) NOT NULL,
    CONSTRAINT `fk_equipment_box` FOREIGN KEY (`box_id`) REFERENCES `boxes`(`id`) ON DELETE SET NULL
);

INSERT INTO `boxes` (`id`, `code`, `description`) VALUES
(1, 'BOX-A1', 'Hlavný mikrofónový case'),
(2, 'BOX-C3', 'Kabeláž XLR dlhá'),
(3, 'RACK-01', 'Zosilňovače a DSP');

INSERT INTO `equipment` (`serial_number`, `name`, `category`, `box_id`, `status`) VALUES
('#0812', 'Shure SM58', 'Mikrofóny', 1, 'Dostupná'),
('#0441', 'Soundcraft Si', 'Mixpulty', NULL, 'V servise'),
('#1092', 'XLR Kábel 10m', 'Kabeláž', 2, 'Poškodená'),
('#0221', 'Shure Beta 58A', 'Mikrofóny', 1, 'Dostupná');