/*
 Navicat Premium Data Transfer

 Source Server         : openserver
 Source Server Type    : MySQL
 Source Server Version : 50733
 Source Host           : localhost:3306
 Source Schema         : db_choreography

 Target Server Type    : MySQL
 Target Server Version : 50733
 File Encoding         : 65001

 Date: 25/04/2022 02:01:28
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for applications
-- ----------------------------
DROP TABLE IF EXISTS `applications`;
CREATE TABLE `applications`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `num` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `topic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `applications_num_unique`(`num`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of applications
-- ----------------------------
INSERT INTO `applications` VALUES (10, '4618073925', 1, 'Смена адреса проживания', 'Можете поменять адрес проживания на 6А мкр 34-31', NULL, NULL, 0, '2022-04-24 09:49:23', '2022-04-24 09:49:23');
INSERT INTO `applications` VALUES (11, '4178253906', 1, 'Адресная справка', 'Высылаю скан-копию адресной справки', 'applications/cKGmFYxhVyzgThwMuo7H9apfMEKUSagf7Px1FS4p.jpg', 'test.jpg', 1, '2022-04-24 10:03:35', '2022-04-24 10:03:35');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 72 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (62, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (63, '2022_04_21_065611_create_roles_table', 1);
INSERT INTO `migrations` VALUES (64, '2022_04_21_065626_create_users_table', 1);
INSERT INTO `migrations` VALUES (68, '2022_04_22_174939_create_permissions_table', 2);
INSERT INTO `migrations` VALUES (69, '2022_04_22_174952_create_permission_user_table', 2);
INSERT INTO `migrations` VALUES (71, '2022_04_23_200421_create_applications_table', 3);

-- ----------------------------
-- Table structure for permission_user
-- ----------------------------
DROP TABLE IF EXISTS `permission_user`;
CREATE TABLE `permission_user`  (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  INDEX `permission_user_user_id_foreign`(`user_id`) USING BTREE,
  INDEX `permission_user_permission_id_foreign`(`permission_id`) USING BTREE,
  CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `permission_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permission_user
-- ----------------------------
INSERT INTO `permission_user` VALUES (1, 2);
INSERT INTO `permission_user` VALUES (2, 2);
INSERT INTO `permission_user` VALUES (3, 2);
INSERT INTO `permission_user` VALUES (4, 2);
INSERT INTO `permission_user` VALUES (5, 2);
INSERT INTO `permission_user` VALUES (6, 2);
INSERT INTO `permission_user` VALUES (7, 2);
INSERT INTO `permission_user` VALUES (8, 2);
INSERT INTO `permission_user` VALUES (9, 2);
INSERT INTO `permission_user` VALUES (10, 2);
INSERT INTO `permission_user` VALUES (1, 16);
INSERT INTO `permission_user` VALUES (2, 16);
INSERT INTO `permission_user` VALUES (5, 16);
INSERT INTO `permission_user` VALUES (6, 16);
INSERT INTO `permission_user` VALUES (7, 16);
INSERT INTO `permission_user` VALUES (8, 16);
INSERT INTO `permission_user` VALUES (1, 17);
INSERT INTO `permission_user` VALUES (2, 17);
INSERT INTO `permission_user` VALUES (1, 18);
INSERT INTO `permission_user` VALUES (2, 18);
INSERT INTO `permission_user` VALUES (9, 18);
INSERT INTO `permission_user` VALUES (10, 18);
INSERT INTO `permission_user` VALUES (1, 1);
INSERT INTO `permission_user` VALUES (2, 1);
INSERT INTO `permission_user` VALUES (3, 1);
INSERT INTO `permission_user` VALUES (4, 1);
INSERT INTO `permission_user` VALUES (5, 1);
INSERT INTO `permission_user` VALUES (6, 1);
INSERT INTO `permission_user` VALUES (7, 1);
INSERT INTO `permission_user` VALUES (8, 1);
INSERT INTO `permission_user` VALUES (9, 1);
INSERT INTO `permission_user` VALUES (10, 1);

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `info` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `desc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 'Главная', 'home', '0', 'Просмотр', NULL, NULL);
INSERT INTO `permissions` VALUES (2, 'Профиль', 'profile', '0', 'Просмотр', NULL, NULL);
INSERT INTO `permissions` VALUES (3, 'Пользователи', 'user_read', '0', 'Просмотр', NULL, NULL);
INSERT INTO `permissions` VALUES (4, 'Пользователи', 'user_full', '0', 'Редактирование', NULL, NULL);
INSERT INTO `permissions` VALUES (5, 'Участники', 'member_read', '0', 'Просмотр', NULL, NULL);
INSERT INTO `permissions` VALUES (6, 'Участники', 'member_full', '0', 'Редактирование', NULL, NULL);
INSERT INTO `permissions` VALUES (7, 'Заявки', 'app_read', '0', 'Просмотр', NULL, NULL);
INSERT INTO `permissions` VALUES (8, 'Заявки', 'app_full', '0', 'Редактирование', NULL, NULL);
INSERT INTO `permissions` VALUES (9, 'Поддержка', 'help_read', '0', 'Просмотр', NULL, NULL);
INSERT INTO `permissions` VALUES (10, 'Поддержка', 'help_full', '0', 'Редактирование', NULL, NULL);

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token`) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type`, `tokenable_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'Админ', 'admin', '2022-04-15 13:46:01', '2022-04-15 13:46:01');
INSERT INTO `roles` VALUES (2, 'Руководитель', 'head', '2022-04-15 13:47:52', '2022-04-15 13:47:52');
INSERT INTO `roles` VALUES (3, 'Заведующий', 'manager', '2022-04-15 13:50:16', '2022-04-15 13:50:16');
INSERT INTO `roles` VALUES (4, 'Пользователь', 'client', '2022-04-15 13:51:27', '2022-04-15 13:51:28');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `doc_type` tinyint(4) NULL DEFAULT NULL,
  `doc_num` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `doc_date` date NULL DEFAULT NULL,
  `birthday` date NULL DEFAULT NULL,
  `age` tinyint(4) NULL DEFAULT NULL,
  `address_doc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `address_note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `address_fact` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `activity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `email_verified_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_username_unique`(`username`) USING BTREE,
  UNIQUE INDEX `users_doc_num_unique`(`doc_num`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'kibo', '$2y$10$YvJseII.olTCmMYL65Za/.B0vhv9uTEvtjeaJBhOD56hotXboxGDq', 1, NULL, 'Борис', 'Ким', NULL, NULL, NULL, NULL, '1990-10-13', 31, NULL, NULL, 'Горького 26-9', NULL, '+7 771 340 40 56', 'admin@kibo.com', NULL, '2022-02-24 03:20:28', '2022-04-23 16:31:30');
INSERT INTO `users` VALUES (2, 'admin', '$2y$10$30tSowWWPez.E/OrmU0fs.slDDKCHGdwot5gr.95te9D.giMxyEo.', 1, NULL, 'Карина', 'Жолмурзаева', NULL, NULL, NULL, NULL, '2002-05-11', 19, NULL, NULL, NULL, NULL, '+7 705 906 37 46', NULL, NULL, '2022-04-19 16:11:24', '2022-04-23 19:51:49');
INSERT INTO `users` VALUES (16, 'Иванова-79302', '$2y$10$IFnHOhPJSx7RmruwBTIIpexfFubZM.LGvgcW3BYHeUm7ZbemPMvtG', 2, NULL, 'Марина', 'Иванова', 'Валерьевна', NULL, NULL, NULL, '1993-04-01', 29, NULL, NULL, 'Глушко 5-41', NULL, '+7 776 598 64 54', 'marisha.val@mail.ru', NULL, '2022-04-23 16:37:57', '2022-04-23 19:45:16');
INSERT INTO `users` VALUES (17, 'Ткаченко-84320', '$2y$10$VbY/dK05LpzSJS86AtK.Z.AsqVcpJjyAIGcEX4RiHzLEG4PhCJ2qG', 3, NULL, 'Ирина', 'Ткаченко', 'Олеговна', NULL, NULL, NULL, '1989-07-05', 32, NULL, NULL, 'Шубникова 4-11', NULL, '+7 776 878 53 47', 'tkachenko.irina@mail.ru', NULL, '2022-04-23 16:40:39', '2022-04-23 19:43:27');
INSERT INTO `users` VALUES (18, 'Громова-85964', '$2y$10$odZpGrwLL00bCN6HsXOQlehxSm5KekDcqsVEqDm7boyQX4ZXnSoI6', 4, NULL, 'Елена', 'Громова', 'Борисовна', NULL, NULL, NULL, '2002-09-06', 19, NULL, NULL, '7 мкр. 9-37', NULL, '+7 771 301 05 17', 'gromova.elena@mail.ru', NULL, '2022-04-23 16:42:07', '2022-04-23 19:50:22');

SET FOREIGN_KEY_CHECKS = 1;
