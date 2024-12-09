CREATE TABLE `users` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT, 
  `username` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `address` TEXT NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tạo bảng db_products (Sản phẩm)
CREATE TABLE `products` (
  `product_id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(40) NOT NULL,
  `price` INT(11) NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tạo bảng comments (Bình luận)
CREATE TABLE `comments` (
  `comment_id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `product_id` INT(11) NOT NULL,
  `date` DATETIME NOT NULL,  -- Đổi tên từ `date` thành `comment_date`
  `content` TEXT NOT NULL,
  PRIMARY KEY (`comment_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE,  -- Tham chiếu đến bảng users
  FOREIGN KEY (`product_id`) REFERENCES `products`(`product_id`) ON DELETE CASCADE  -- Tham chiếu đến bảng products
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tạo bảng orders (Đơn hàng)
CREATE TABLE `orders` (
  `order_id` INT(11) NOT NULL AUTO_INCREMENT,  -- Đổi tên từ `id` thành `order_id`
  `customer_id` INT(11) NOT NULL,
  `order_date` DATETIME NOT NULL,
  `status` VARCHAR(50) NOT NULL DEFAULT 'Đang xử lí',
  `total_price` INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`order_id`),
  FOREIGN KEY (`customer_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE  -- Tham chiếu đến bảng users
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tạo bảng order_items (Chi tiết đơn hàng)
CREATE TABLE `order_items` (
  `order_item_id` INT(11) NOT NULL AUTO_INCREMENT,
  `order_id` INT(11) NOT NULL,
  `product_id` INT(11) NOT NULL,
  `quantity` INT(11) NOT NULL,
  `price` INT(11) NOT NULL,
  `size` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`order_item_id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders`(`order_id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products`(`product_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`username`, `email`, `password`, `name`, `address`) VALUES
('nguyenvanan', 'nguyenan@gmail.com', 'hashedpassword1', 'Nguyễn Văn An', '123 Đường A, TP.HCM'),
('lethihong', 'hongle@yahoo.com', 'hashedpassword2', 'Lê Thị Hồng', '456 Đường B, Hà Nội'),
('hoangminh', 'hoangminh@gmail.com', 'hashedpassword3', 'Hoàng Minh', '789 Đường C, Đà Nẵng');
-- Chèn dữ liệu vào bảng db_products
INSERT INTO `products` (`name`, `price`, `image`, `description`) VALUES
('Áo Thun Tết Form Boxy', 199000, 'image/sp1.png', 'Áo thun Tết Snake túi hộp, thiết kế form boxy, chất liệu cotton thoáng mát, thích hợp cho mùa Tết 2025.'),
('Áo Sơ Mi Tết', 189000, 'image/sp2.png', 'Áo sơ mi Tết thiết kế tinh tế, chất liệu vải mềm mại, phù hợp cho không khí Tết 2025.'),
('Áo Thun Tết Snake Form Oversize', 249000, 'image/sp3.png', 'Áo thun oversize với thiết kế Snake, mang đến sự thoải mái và phong cách cho dịp Tết 2025.'),
('Áo Polo Tết', 259000, 'image/sp4.png', 'Áo polo Tết với chất liệu cao cấp, cổ áo thêu tinh tế, dành riêng cho dịp Tết 2025.'),
('Áo Thun Streetwear Basketball', 231000, 'image/sp5.png', 'Áo thun streetwear thiết kế bóng rổ, phù hợp cho những ai yêu thích phong cách thể thao.'),
('Áo Polo Local Brand Karants', 168000, 'image/sp6.png', 'Áo polo Local Brand Karants, chất liệu vải cao cấp, phù hợp với phong cách năng động.'),
('Áo Thun Form Rộng Tay Lỡ Oversize', 281000, 'image/sp7.png', 'Áo thun oversize với form rộng tay lỡ, dễ phối đồ và phù hợp cho nhiều phong cách khác nhau.'),
('Áo Thun Local Brand Karants', 200000, 'image/sp8.png', 'Áo thun Local Brand Karants, thiết kế đơn giản nhưng tinh tế, chất liệu mềm mại, dễ mặc trong mọi dịp.');
-- Chèn dữ liệu vào bảng comments
INSERT INTO `comments` (`user_id`, `product_id`, `date`, `content`) VALUES
(1, 1, '2024-12-08 10:30:00', 'Áo thun Tết Snake rất đẹp, chất liệu thoáng mát, mặc rất thoải mái trong dịp Tết.'),
(2, 2, '2024-12-08 11:00:00', 'Áo sơ mi Tết rất tinh tế, chất liệu vải mềm mại và dễ chịu.'),
(3, 3, '2024-12-08 12:15:00', 'Áo thun oversize rất thoải mái, thiết kế Snake độc đáo, rất hợp cho dịp Tết.'),
(1, 4, '2024-12-08 13:00:00', 'Áo polo Tết với chất liệu cao cấp, rất phù hợp cho không khí Tết.'),
(2, 5, '2024-12-08 14:30:00', 'Áo thun streetwear thiết kế đẹp, phù hợp với phong cách thể thao.'),
(3, 6, '2024-12-08 15:00:00', 'Áo polo Local Brand Karants rất vừa vặn, chất liệu vải mát mẻ và thoải mái.'),
(1, 7, '2024-12-08 16:00:00', 'Áo thun form rộng tay lỡ oversize rất hợp với xu hướng thời trang hiện nay.'),
(2, 8, '2024-12-08 17:30:00', 'Áo thun Local Brand Karants thiết kế đơn giản nhưng tinh tế, dễ mặc trong mọi dịp.');
-- Chèn dữ liệu vào bảng orders
INSERT INTO `orders` (`customer_id`, `order_date`, `status`, `total_price`) VALUES
(1, '2024-12-08 15:00:00', 'Đang xử lí', 499000),
(2, '2024-12-08 15:30:00', 'Đã hoàn thành', 659000),
(3, '2024-12-08 16:00:00', 'Đang xử lí', 481000);
-- Chèn dữ liệu vào bảng order_items
INSERT INTO `order_items` (`order_id`, `product_id`, `quantity`, `price`, `size`) VALUES
(1, 1, 2, 199000, 'M'),
(1, 2, 1, 189000, 'L'),
(2, 3, 1, 249000, 'M'),
(2, 4, 1, 259000, 'L'),
(3, 5, 1, 231000, 'XL'),
(3, 6, 2, 168000, 'M');

