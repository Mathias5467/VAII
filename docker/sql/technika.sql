CREATE TABLE IF NOT EXISTS `equipment` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `serial_number` VARCHAR(50) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `category` VARCHAR(50) NOT NULL,
    `box` VARCHAR(50) NOT NULL,
    `status` VARCHAR(20) NOT NULL
);

INSERT INTO `equipment` (`serial_number`, `name`, `category`, `box`, `status`) VALUES
('#0812', 'Shure SM58', 'Mikrofóny', 'BOX-A1', 'Dostupná'),
('#0441', 'Soundcraft Si', 'Mixpulty', 'Sklad', 'V servise'),
('#1092', 'XLR Kábel 10m', 'Kabeláž', 'BOX-C3', 'Poškodená');