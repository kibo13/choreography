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

 Date: 02/05/2022 15:25:22
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for applications
-- ----------------------------
DROP TABLE IF EXISTS `applications`;
CREATE TABLE `applications`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `num` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `topic` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `note` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `applications_num_unique`(`num`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sign` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES (1, 'Младшая', 'Мл', 'Младшая', '2022-04-26 05:31:39', '2022-04-26 05:33:59');
INSERT INTO `categories` VALUES (2, 'Средняя', 'Ср', 'Средняя', '2022-04-26 05:31:54', '2022-04-26 05:34:06');
INSERT INTO `categories` VALUES (3, 'Старшая', 'Ст', 'Старшая', '2022-04-26 05:32:21', '2022-04-26 05:34:11');
INSERT INTO `categories` VALUES (4, '-', NULL, 'Категория не имеет деления на младшие, средние и старшие', '2022-04-27 09:14:12', '2022-04-27 09:14:13');

-- ----------------------------
-- Table structure for discounts
-- ----------------------------
DROP TABLE IF EXISTS `discounts`;
CREATE TABLE `discounts`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` tinyint(4) NOT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of discounts
-- ----------------------------
INSERT INTO `discounts` VALUES (1, 'Дети из многодетных семей', 50, NULL, '2022-04-30 14:07:42', '2022-04-30 17:03:10');
INSERT INTO `discounts` VALUES (2, 'Дети малообеспеченных семей', 50, NULL, '2022-04-30 17:04:50', '2022-04-30 17:04:50');
INSERT INTO `discounts` VALUES (3, 'Дети военнослужащих', 50, NULL, '2022-04-30 17:05:10', '2022-04-30 17:05:10');
INSERT INTO `discounts` VALUES (4, 'Дети из неполных семей', 30, NULL, '2022-04-30 17:05:33', '2022-04-30 17:05:33');

-- ----------------------------
-- Table structure for group_worker
-- ----------------------------
DROP TABLE IF EXISTS `group_worker`;
CREATE TABLE `group_worker`  (
  `group_id` bigint(20) UNSIGNED NOT NULL,
  `worker_id` bigint(20) UNSIGNED NOT NULL,
  INDEX `group_worker_group_id_foreign`(`group_id`) USING BTREE,
  INDEX `group_worker_worker_id_foreign`(`worker_id`) USING BTREE,
  CONSTRAINT `group_worker_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `group_worker_worker_id_foreign` FOREIGN KEY (`worker_id`) REFERENCES `workers` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of group_worker
-- ----------------------------
INSERT INTO `group_worker` VALUES (1, 2);
INSERT INTO `group_worker` VALUES (2, 2);
INSERT INTO `group_worker` VALUES (3, 2);

-- ----------------------------
-- Table structure for groups
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `basic_seats` tinyint(4) NOT NULL,
  `extra_seats` tinyint(4) NULL DEFAULT NULL,
  `age_from` tinyint(4) NOT NULL,
  `age_till` tinyint(4) NOT NULL,
  `price` double NULL DEFAULT NULL,
  `lessons` tinyint(4) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of groups
-- ----------------------------
INSERT INTO `groups` VALUES (1, 2, 1, 10, 2, 7, 10, 2000, 8, '2022-04-27 04:57:59', '2022-04-27 04:57:59');
INSERT INTO `groups` VALUES (2, 2, 2, 15, 2, 11, 14, 3000, 12, '2022-04-27 05:01:21', '2022-04-27 05:01:21');
INSERT INTO `groups` VALUES (3, 2, 3, 15, 2, 15, 18, 3000, 12, '2022-04-27 05:04:19', '2022-04-27 05:04:19');
INSERT INTO `groups` VALUES (4, 1, 1, 15, 3, 7, 8, 2000, 8, '2022-04-27 05:09:00', '2022-04-27 05:09:00');
INSERT INTO `groups` VALUES (5, 1, 2, 15, 1, 9, 11, 3000, 12, '2022-04-27 05:09:00', '2022-04-27 05:09:00');
INSERT INTO `groups` VALUES (6, 1, 3, 10, 2, 12, 16, 3000, 12, '2022-04-27 05:09:00', '2022-04-27 05:09:00');
INSERT INTO `groups` VALUES (7, 3, 1, 15, 1, 7, 10, 2000, 8, '2022-04-27 05:35:42', '2022-04-27 05:35:42');
INSERT INTO `groups` VALUES (8, 3, 2, 10, 3, 11, 14, 3000, 12, '2022-04-27 05:35:42', '2022-04-27 05:35:42');
INSERT INTO `groups` VALUES (9, 3, 3, 15, 2, 15, 70, 3000, 12, '2022-04-27 05:35:42', '2022-04-27 05:35:42');
INSERT INTO `groups` VALUES (11, 4, 1, 15, 0, 5, 9, 2000, 8, '2022-04-27 05:40:32', '2022-04-27 05:40:32');
INSERT INTO `groups` VALUES (12, 4, 2, 15, 0, 10, 13, 3000, 12, '2022-04-27 05:40:53', '2022-04-27 05:40:53');
INSERT INTO `groups` VALUES (13, 4, 3, 10, 0, 14, 17, 3000, 12, '2022-04-27 05:41:25', '2022-04-27 05:41:25');
INSERT INTO `groups` VALUES (14, 5, 4, 16, 0, 18, 70, 0, 0, '2022-04-27 05:44:13', '2022-04-27 05:44:13');

-- ----------------------------
-- Table structure for lessons
-- ----------------------------
DROP TABLE IF EXISTS `lessons`;
CREATE TABLE `lessons`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sign` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of lessons
-- ----------------------------
INSERT INTO `lessons` VALUES (1, 'Практика', 'П', 'Практическое занятие', '2022-04-26 06:33:46', '2022-04-26 06:34:20');
INSERT INTO `lessons` VALUES (2, 'Теория', 'Т', 'Теоретическое занятие', '2022-04-26 06:34:08', '2022-04-26 06:34:25');

-- ----------------------------
-- Table structure for members
-- ----------------------------
DROP TABLE IF EXISTS `members`;
CREATE TABLE `members`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `doc_type` tinyint(4) NOT NULL,
  `doc_num` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `doc_date` date NOT NULL,
  `birthday` date NOT NULL,
  `age` tinyint(4) NOT NULL,
  `address_doc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `address_note` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `address_fact` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `activity` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `members_doc_num_unique`(`doc_num`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of members
-- ----------------------------
INSERT INTO `members` VALUES (4, 9, 'Антонина', 'Мороз', 'Юрьевна', 0, '047587964', '2019-05-10', '2004-04-22', 18, '', '', 'Максимова 20-13', NULL, '+7 777 878 46 48', NULL, '2022-05-01 17:58:14', '2022-05-01 18:03:12');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (2, '2022_04_21_065611_create_roles_table', 1);
INSERT INTO `migrations` VALUES (3, '2022_04_21_065626_create_users_table', 1);
INSERT INTO `migrations` VALUES (4, '2022_04_22_174939_create_permissions_table', 1);
INSERT INTO `migrations` VALUES (5, '2022_04_22_174952_create_permission_user_table', 1);
INSERT INTO `migrations` VALUES (6, '2022_05_01_164538_create_members_table', 2);
INSERT INTO `migrations` VALUES (7, '2022_05_01_190758_create_lessons_table', 3);
INSERT INTO `migrations` VALUES (8, '2022_05_01_190808_create_categories_table', 3);
INSERT INTO `migrations` VALUES (9, '2022_05_02_023240_create_rooms_table', 4);
INSERT INTO `migrations` VALUES (10, '2022_05_02_024123_create_specialties_table', 5);
INSERT INTO `migrations` VALUES (11, '2022_05_02_025302_create_discounts_table', 6);
INSERT INTO `migrations` VALUES (12, '2022_05_02_025434_create_titles_table', 6);
INSERT INTO `migrations` VALUES (14, '2022_05_02_030729_create_groups_table', 7);
INSERT INTO `migrations` VALUES (15, '2022_05_02_065446_create_workers_table', 8);
INSERT INTO `migrations` VALUES (17, '2022_05_02_070507_create_group_worker_table', 9);
INSERT INTO `migrations` VALUES (18, '2022_05_02_091927_create_applications_table', 10);

-- ----------------------------
-- Table structure for permission_user
-- ----------------------------
DROP TABLE IF EXISTS `permission_user`;
CREATE TABLE `permission_user`  (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  INDEX `permission_user_permission_id_foreign`(`permission_id`) USING BTREE,
  INDEX `permission_user_user_id_foreign`(`user_id`) USING BTREE,
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
INSERT INTO `permission_user` VALUES (11, 2);
INSERT INTO `permission_user` VALUES (12, 2);
INSERT INTO `permission_user` VALUES (13, 2);
INSERT INTO `permission_user` VALUES (14, 2);
INSERT INTO `permission_user` VALUES (15, 2);
INSERT INTO `permission_user` VALUES (16, 2);
INSERT INTO `permission_user` VALUES (17, 2);
INSERT INTO `permission_user` VALUES (18, 2);
INSERT INTO `permission_user` VALUES (19, 2);
INSERT INTO `permission_user` VALUES (20, 2);
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
INSERT INTO `permission_user` VALUES (11, 1);
INSERT INTO `permission_user` VALUES (12, 1);
INSERT INTO `permission_user` VALUES (13, 1);
INSERT INTO `permission_user` VALUES (14, 1);
INSERT INTO `permission_user` VALUES (15, 1);
INSERT INTO `permission_user` VALUES (16, 1);
INSERT INTO `permission_user` VALUES (17, 1);
INSERT INTO `permission_user` VALUES (18, 1);
INSERT INTO `permission_user` VALUES (19, 1);
INSERT INTO `permission_user` VALUES (20, 1);
INSERT INTO `permission_user` VALUES (3, 11);
INSERT INTO `permission_user` VALUES (4, 11);
INSERT INTO `permission_user` VALUES (11, 11);
INSERT INTO `permission_user` VALUES (13, 11);
INSERT INTO `permission_user` VALUES (14, 11);
INSERT INTO `permission_user` VALUES (17, 11);
INSERT INTO `permission_user` VALUES (18, 11);
INSERT INTO `permission_user` VALUES (19, 9);
INSERT INTO `permission_user` VALUES (20, 9);

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_setting` tinyint(4) NOT NULL DEFAULT 0,
  `note` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 'Пользователи', 'user_read', 0, 'Просмотр', '2022-04-26 09:49:51', '2022-04-26 09:49:59');
INSERT INTO `permissions` VALUES (2, 'Пользователи', 'user_full', 0, 'Редактирование', '2022-04-26 09:49:52', '2022-04-26 09:49:59');
INSERT INTO `permissions` VALUES (3, 'Участники', 'member_read', 0, 'Просмотр', '2022-05-01 22:52:54', '2022-05-01 22:52:56');
INSERT INTO `permissions` VALUES (4, 'Участники', 'member_full', 0, 'Редактирование', '2022-05-01 22:53:16', '2022-05-01 22:53:19');
INSERT INTO `permissions` VALUES (5, 'Сотрудники', 'worker_read', 1, 'Просмотр', '2022-05-02 01:19:19', '2022-05-02 01:19:22');
INSERT INTO `permissions` VALUES (6, 'Сотрудники', 'worker_full', 1, 'Редактирование', '2022-05-02 01:19:48', '2022-05-02 01:19:51');
INSERT INTO `permissions` VALUES (7, 'Специализации', 'specialty_read', 1, 'Просмотр', '2022-05-02 01:20:20', '2022-05-02 01:20:22');
INSERT INTO `permissions` VALUES (8, 'Специализации', 'specialty_full', 1, 'Редактирование', '2022-05-02 01:20:45', '2022-05-02 01:20:47');
INSERT INTO `permissions` VALUES (9, 'Названия групп', 'title_read', 1, 'Просмотр', '2022-05-02 01:21:58', '2022-05-02 01:22:01');
INSERT INTO `permissions` VALUES (10, 'Названия групп', 'title_full', 1, 'Редактирование', '2022-05-02 01:22:16', '2022-05-02 01:22:18');
INSERT INTO `permissions` VALUES (11, 'Группы', 'group_read', 1, 'Просмотр', '2022-05-02 01:22:47', '2022-05-02 01:22:50');
INSERT INTO `permissions` VALUES (12, 'Группы', 'group_full', 1, 'Редактирование', '2022-05-02 01:23:03', '2022-05-02 01:23:05');
INSERT INTO `permissions` VALUES (13, 'Скидки', 'discount_read', 1, 'Просмотр', '2022-05-02 01:23:41', '2022-05-02 01:23:43');
INSERT INTO `permissions` VALUES (14, 'Скидки', 'discount_full', 1, 'Редактирование', '2022-05-02 01:23:59', '2022-05-02 01:24:01');
INSERT INTO `permissions` VALUES (15, 'Помещения', 'room_read', 1, 'Просмотр', '2022-05-02 01:24:34', '2022-05-02 01:24:35');
INSERT INTO `permissions` VALUES (16, 'Помещения', 'room_full', 1, 'Редактирование', '2022-05-02 01:24:48', '2022-05-02 01:24:50');
INSERT INTO `permissions` VALUES (17, 'Заявки', 'app_read', 0, 'Просмотр', '2022-05-02 01:25:31', '2022-05-02 01:25:33');
INSERT INTO `permissions` VALUES (18, 'Заявки', 'app_full', 0, 'Редактирование', '2022-05-02 01:25:47', '2022-05-02 01:25:48');
INSERT INTO `permissions` VALUES (19, 'Поддержка', 'help_read', 0, 'Просмотр', '2022-05-02 01:26:12', '2022-05-02 01:26:14');
INSERT INTO `permissions` VALUES (20, 'Поддержка', 'help_full', 0, 'Редактирование', '2022-05-02 01:26:31', '2022-05-02 01:26:32');

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'Автор', 'sa', '2022-04-15 13:46:01', '2022-04-15 13:46:01');
INSERT INTO `roles` VALUES (2, 'Админ', 'admin', '2022-04-15 13:46:01', '2022-04-15 13:46:01');
INSERT INTO `roles` VALUES (3, 'Руководитель', 'head', '2022-04-15 13:47:52', '2022-04-15 13:47:52');
INSERT INTO `roles` VALUES (4, 'Заведующий', 'manager', '2022-04-15 13:50:16', '2022-04-15 13:50:16');
INSERT INTO `roles` VALUES (5, 'Пользователь', 'client', '2022-04-15 13:51:27', '2022-04-15 13:51:28');

-- ----------------------------
-- Table structure for rooms
-- ----------------------------
DROP TABLE IF EXISTS `rooms`;
CREATE TABLE `rooms`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `num` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `floor` tinyint(4) NOT NULL,
  `area` double NULL DEFAULT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `rooms_num_unique`(`num`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of rooms
-- ----------------------------
INSERT INTO `rooms` VALUES (1, '201', 2, 57.3, NULL, '2022-04-30 11:38:25', '2022-05-02 02:40:19');
INSERT INTO `rooms` VALUES (2, '202', 2, 55.5, NULL, '2022-04-30 11:51:37', '2022-05-02 02:40:27');
INSERT INTO `rooms` VALUES (3, '203', 2, 60.1, NULL, '2022-04-30 11:51:46', '2022-05-02 02:40:31');

-- ----------------------------
-- Table structure for specialties
-- ----------------------------
DROP TABLE IF EXISTS `specialties`;
CREATE TABLE `specialties`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sign` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of specialties
-- ----------------------------
INSERT INTO `specialties` VALUES (1, 'Народно-сценический танец', 'НСТ', 'Народно-сценический танец', '2022-04-26 09:13:14', '2022-04-26 09:13:23');
INSERT INTO `specialties` VALUES (2, 'Современный танец', 'СТ', 'Современный танец', '2022-04-26 09:13:39', '2022-04-26 09:13:39');
INSERT INTO `specialties` VALUES (3, 'Спортивно-бальный танец', 'СБТ', 'Спортивно-бальный танец', '2022-04-26 09:14:00', '2022-04-26 09:14:00');
INSERT INTO `specialties` VALUES (5, 'Эстрадный танец', 'ЭТ', 'Эстрадный танец', '2022-04-27 05:39:51', '2022-04-27 05:39:51');

-- ----------------------------
-- Table structure for titles
-- ----------------------------
DROP TABLE IF EXISTS `titles`;
CREATE TABLE `titles`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `specialty_id` bigint(20) UNSIGNED NOT NULL,
  `is_paid` tinyint(4) NOT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of titles
-- ----------------------------
INSERT INTO `titles` VALUES (1, 'A\'DIVAS', 1, 0, 'Народно-сценические, эстрадные, классические и современные танцы.', '2022-04-26 05:42:52', '2022-05-01 07:44:00');
INSERT INTO `titles` VALUES (2, 'Престо', 2, 0, 'Большую часть концертного репертуара коллектива составляют стилизованные казахские народные танцы, а также танцы народов мира, отражающие быт и культуру наций.', '2022-04-26 05:43:21', '2022-05-01 07:48:25');
INSERT INTO `titles` VALUES (3, 'VIVA', 2, 0, 'Направление деятельности: современные танцы', '2022-04-26 05:43:32', '2022-04-27 06:35:23');
INSERT INTO `titles` VALUES (4, 'Блюз', 5, 1, 'В репертуаре – эстрадные, стилизованные, народные и бальные танцы.', '2022-04-26 05:43:44', '2022-05-01 07:46:51');
INSERT INTO `titles` VALUES (5, 'Русские самоцветы', 1, 0, 'Основа репертуара – русский народный танец, его изучение и популяризация.', '2022-04-26 05:44:05', '2022-04-26 06:35:09');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_username_unique`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'kibo', '$2y$10$YvJseII.olTCmMYL65Za/.B0vhv9uTEvtjeaJBhOD56hotXboxGDq', 1, NULL, '2022-02-24 03:20:28', '2022-04-23 16:31:30');
INSERT INTO `users` VALUES (2, 'admin', '$2y$10$30tSowWWPez.E/OrmU0fs.slDDKCHGdwot5gr.95te9D.giMxyEo.', 2, NULL, '2022-05-01 16:16:56', '2022-05-01 16:21:52');
INSERT INTO `users` VALUES (9, 'Мороз-26479', '$2y$10$rvx4eXcLfsaYiLMAMR0KJO6XhW53Ym9H7.H7YJggN7ncb5e7aIlh.', 5, NULL, '2022-05-01 17:58:14', '2022-05-01 18:57:35');
INSERT INTO `users` VALUES (11, 'Иванова-37628', '$2y$10$jByiIcWFn7dr41zV/BqEFuQIK6XpSYhXolbd2ek77cpEd0XmxfMpC', 3, NULL, '2022-05-02 07:56:17', '2022-05-02 07:56:17');

-- ----------------------------
-- Table structure for workers
-- ----------------------------
DROP TABLE IF EXISTS `workers`;
CREATE TABLE `workers`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `birthday` date NOT NULL,
  `age` tinyint(4) NOT NULL,
  `address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of workers
-- ----------------------------
INSERT INTO `workers` VALUES (2, 11, 'Марина', 'Иванова', 'Михайловна', '1988-01-16', 34, NULL, '+7 777 123 71 24', NULL, '2022-05-02 07:56:17', '2022-05-02 09:13:21');

SET FOREIGN_KEY_CHECKS = 1;
