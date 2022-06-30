-- phpMyAdmin SQL Dump
-- version 5.1.4
-- https://www.phpmyadmin.net/
--
-- Хост: demaslo.mysql.ukraine.com.ua
-- Час створення: Чрв 30 2022 р., 23:29
-- Версія сервера: 5.7.33-36-log
-- Версія PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `demaslo_kovalenko`
--

-- --------------------------------------------------------

--
-- Структура таблиці `located_city`
--

CREATE TABLE `located_city` (
  `id` int(11) NOT NULL,
  `region_id` varchar(2) NOT NULL,
  `city` varchar(30) NOT NULL,
  `city_slug` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `located_city`
--

INSERT INTO `located_city` (`id`, `region_id`, `city`, `city_slug`, `is_active`) VALUES
(1, '5', 'Авдіївка', 'avdiivka', 1),
(2, '13', 'Алмазна', 'almazna', 0),
(3, '1', 'Алупка', 'alupka', 1),
(4, '1', 'Алушта', 'alushta', 1),
(5, '13', 'Алчевськ', 'alchevsk', 0),
(6, '5', 'Амвросіївка', 'amvrosiivka', 0),
(7, '16', 'Ананьїв', 'ananiv', 0),
(8, '6', 'Андрушівка', 'andrushivka', 0),
(9, '13', 'Антрацит', 'antratsyt', 0),
(10, '4', 'Апостолове', 'apostolove', 0),
(11, '1', 'Армянськ', 'armyansk', 1),
(12, '16', 'Арциз', 'artsyz', 0),
(13, '22', 'Балаклія', 'balakliya', 0),
(14, '16', 'Балта', 'balta', 0),
(15, '2', 'Бар', 'bar', 0),
(16, '6', 'Баранівка', 'baranivka', 0),
(17, '22', 'Барвінкове', 'barvinkove', 0),
(18, '27', 'Батурин', 'baturyn', 0),
(19, '27', 'Бахмач', 'bahmach', 0),
(20, '5', 'Бахмут', 'bahmut', 0),
(21, '1', 'Бахчисарай', 'bahchysaray', 0),
(22, '15', 'Баштанка', 'bashtanka', 0),
(23, '14', 'Белз', 'belz', 0),
(24, '6', 'Бердичів', 'berdychiv', 0),
(25, '8', 'Бердянськ', 'berdyansk', 0),
(26, '7', 'Берегове', 'beregove', 0),
(27, '21', 'Бережани', 'berezhany', 0),
(28, '12', 'Березань', 'berezan', 0),
(29, '16', 'Березівка', 'berezivka', 0),
(30, '18', 'Березне', 'berezne', 0),
(31, '3', 'Берестечко', 'berestechko', 0),
(32, '23', 'Берислав', 'beryslav', 0),
(33, '2', 'Бершадь', 'bershad', 0),
(34, '14', 'Бібрка', 'bibrka', 0),
(35, '12', 'Біла Церква', 'bila_tserkva', 0),
(36, '16', 'Білгород-Дністровський', 'bilgorod_dnistrovskyy', 0),
(37, '5', 'Білицьке', 'bilytske', 0),
(38, '1', 'Білогірськ', 'bilogirsk', 0),
(39, '5', 'Білозерське', 'bilozerske', 0),
(40, '20', 'Білопілля', 'bilopillya', 0),
(41, '16', 'Біляївка', 'bilyaivka', 0),
(42, '10', 'Благовіщенське', 'blagovishchenske', 0),
(43, '10', 'Бобринець', 'bobrynets', 0),
(44, '27', 'Бобровиця', 'bobrovytsya', 0),
(45, '22', 'Богодухів', 'bogoduhiv', 0),
(46, '12', 'Богуслав', 'boguslav', 0),
(47, '13', 'Боково-Хрустальне', 'bokovo_hrustalne', 0),
(48, '16', 'Болград', 'bolgrad', 0),
(49, '9', 'Болехів', 'bolehiv', 0),
(50, '27', 'Борзна', 'borzna', 0),
(51, '14', 'Борислав', 'boryslav', 0),
(52, '12', 'Бориспіль', 'boryspil', 0),
(53, '21', 'Борщів', 'borshchiv', 0),
(54, '12', 'Боярка', 'boyarka', 0),
(55, '12', 'Бровари', 'brovary', 0),
(56, '14', 'Броди', 'brody', 0),
(57, '13', 'Брянка', 'bryanka', 0),
(58, '5', 'Бунге', 'bunge', 0),
(59, '20', 'Буринь', 'buryn', 0),
(60, '9', 'Бурштин', 'burshtyn', 0),
(61, '14', 'Буськ', 'busk', 0),
(62, '12', 'Буча', 'bucha', 0),
(63, '21', 'Бучач', 'buchach', 0),
(64, '22', 'Валки', 'valky', 0),
(65, '18', 'Вараш', 'varash', 0),
(66, '8', 'Василівка', 'vasylivka', 0),
(67, '12', 'Васильків', 'vasylkiv', 0),
(68, '25', 'Ватутіне', 'vatutine', 0),
(69, '26', 'Вашківці', 'vashkivtsi', 0),
(70, '14', 'Великі Мости', 'velyki_mosty', 0),
(71, '4', 'Верхівцеве', 'verhivtseve', 0),
(72, '4', 'Верхньодніпровськ', 'verhnodniprovsk', 0),
(73, '26', 'Вижниця', 'vyzhnytsya', 0),
(74, '16', 'Вилкове', 'vylkove', 0),
(75, '14', 'Винники', 'vynnyky', 0),
(76, '7', 'Виноградів', 'vynogradiv', 0),
(77, '12', 'Вишгород', 'vyshgorod', 0),
(78, '12', 'Вишневе', 'vyshneve', 0),
(79, '4', 'Вільногірськ', 'vilnogirsk', 0),
(80, '8', 'Вільнянськ', 'vilnyansk', 0),
(81, '2', 'Вінниця', 'vinnytsya', 0),
(82, '22', 'Вовчанськ', 'vovchansk', 0),
(83, '13', 'Вознесенівка', 'voznesenivka', 0),
(84, '15', 'Вознесенськ', 'voznesensk', 0),
(85, '5', 'Волноваха', 'volnovaha', 0),
(86, '3', 'Володимир', 'volodymyr', 0),
(87, '24', 'Волочиськ', 'volochysk', 0),
(88, '20', 'Ворожба', 'vorozhba', 0),
(89, '5', 'Вуглегірськ', 'vuglegirsk', 0),
(90, '5', 'Вугледар', 'vugledar', 0),
(91, '17', 'Гадяч', 'gadyach', 0),
(92, '10', 'Гайворон', 'gayvoron', 0),
(93, '2', 'Гайсин', 'gaysyn', 0),
(94, '9', 'Галич', 'galych', 0),
(95, '23', 'Генічеськ', 'genichesk', 0),
(96, '26', 'Герца', 'gertsa', 0),
(97, '5', 'Гірник', 'girnyk', 0),
(98, '13', 'Гірське', 'girske', 0),
(99, '14', 'Глиняни', 'glynyany', 0),
(100, '17', 'Глобине', 'globyne', 0),
(101, '20', 'Глухів', 'gluhiv', 0),
(102, '2', 'Гнівань', 'gnivan', 0),
(103, '23', 'Гола Пристань', 'gola_prystan', 0),
(104, '13', 'Голубівка', 'golubivka', 0),
(105, '17', 'Горішні Плавні', 'gorishni_plavni', 0),
(106, '5', 'Горлівка', 'gorlivka', 0),
(107, '9', 'Городенка', 'gorodenka', 0),
(108, '25', 'Городище', 'gorodyshche', 0),
(109, '27', 'Городня', 'gorodnya', 0),
(110, '14', 'Городок', 'gorodok', 0),
(111, '14', 'Городок1', 'gorodok1', 0),
(112, '3', 'Горохів', 'gorohiv', 0),
(113, '17', 'Гребінка', 'grebinka', 0),
(114, '8', 'Гуляйполе', 'gulyaypole', 0),
(115, '5', 'Дебальцеве', 'debaltseve', 0),
(116, '24', 'Деражня', 'derazhnya', 0),
(117, '22', 'Дергачі', 'dergachi', 0),
(118, '1', 'Джанкой', 'dzhankoy', 0),
(119, '4', 'Дніпро', 'dnipro', 0),
(120, '8', 'Дніпрорудне', 'dniprorudne', 0),
(121, '14', 'Добромиль', 'dobromyl', 0),
(122, '5', 'Добропілля', 'dobropillya', 0),
(123, '13', 'Довжанськ', 'dovzhansk', 0),
(124, '5', 'Докучаєвськ', 'dokuchavsk', 0),
(125, '9', 'Долина', 'dolyna', 0),
(126, '10', 'Долинська', 'dolynska', 0),
(127, '5', 'Донецьк', 'donetsk', 0),
(128, '14', 'Дрогобич', 'drogobych', 0),
(129, '20', 'Дружба', 'druzhba', 0),
(130, '5', 'Дружківка', 'druzhkivka', 0),
(131, '14', 'Дубляни', 'dublyany', 0),
(132, '18', 'Дубно', 'dubno', 0),
(133, '18', 'Дубровиця', 'dubrovytsya', 0),
(134, '24', 'Дунаївці', 'dunaivtsi', 0),
(135, '8', 'Енергодар', 'energodar', 0),
(136, '1', 'Євпаторія', 'vpatoriya', 0),
(137, '5', 'Єнакієве', 'nakive', 0),
(138, '25', 'Жашків', 'zhashkiv', 0),
(139, '5', 'Жданівка', 'zhdanivka', 0),
(140, '14', 'Жидачів', 'zhydachiv', 0),
(141, '6', 'Житомир', 'zhytomyr', 0),
(142, '2', 'Жмеринка', 'zhmerynka', 0),
(143, '14', 'Жовква', 'zhovkva', 0),
(144, '4', 'Жовті Води', 'zhovti_vody', 0),
(145, '17', 'Заводське', 'zavodske', 0),
(146, '5', 'Залізне', 'zalizne', 0),
(147, '21', 'Заліщики', 'zalishchyky', 0),
(148, '8', 'Запоріжжя', 'zaporizhzhya', 0),
(149, '26', 'Заставна', 'zastavna', 0),
(150, '21', 'Збараж', 'zbarazh', 0),
(151, '21', 'Зборів', 'zboriv', 0),
(152, '25', 'Звенигородка', 'zvenygorodka', 0),
(153, '18', 'Здолбунів', 'zdolbuniv', 0),
(154, '4', 'Зеленодольськ', 'zelenodolsk', 0),
(155, '13', 'Зимогір\'я', 'zymogir_ya', 0),
(156, '17', 'Зіньків', 'zinkiv', 0),
(157, '22', 'Зміїв', 'zmiiv', 0),
(158, '10', 'Знам\'янка', 'znam_yanka', 0),
(159, '13', 'Золоте', 'zolote', 0),
(160, '25', 'Золотоноша', 'zolotonosha', 0),
(161, '14', 'Золочів', 'zolochiv', 0),
(162, '13', 'Зоринськ', 'zorynsk', 0),
(163, '5', 'Зугрес', 'zugres', 0),
(164, '9', 'Івано-Франківськ', 'ivano_frankivsk', 0),
(165, '16', 'Ізмаїл', 'izmail', 0),
(166, '22', 'Ізюм', 'izyum', 0),
(167, '24', 'Ізяслав', 'izyaslav', 0),
(168, '2', 'Іллінці', 'illintsi', 0),
(169, '5', 'Іловайськ', 'ilovaysk', 0),
(170, '19', 'Інкерман', 'inkerman', 0),
(171, '13', 'Ірміно', 'irmino', 0),
(172, '12', 'Ірпінь', 'irpin', 0),
(173, '7', 'Іршава', 'irshava', 0),
(174, '27', 'Ічня', 'ichnya', 0),
(175, '12', 'Кагарлик', 'kagarlyk', 0),
(176, '13', 'Кадіївка', 'kadiivka', 0),
(177, '2', 'Калинівка', 'kalynivka', 0),
(178, '9', 'Калуш', 'kalush', 0),
(179, '5', 'Кальміуське', 'kalmiuske', 0),
(180, '3', 'Камінь-Каширський', 'kamin_kashyrskyy', 0),
(181, '24', 'Кам\'янець-Подільський', 'kam_yanets_podilskyy', 0),
(182, '25', 'Кам\'янка', 'kam_yanka', 0),
(183, '14', 'Кам\'янка-Бузька', 'kam_yanka_buzka', 0),
(184, '8', 'Кам\'янка-Дніпровська', 'kam_yanka_dniprovska', 0),
(185, '4', 'Кам\'янське', 'kam_yanske', 0),
(186, '25', 'Канів', 'kaniv', 0),
(187, '17', 'Карлівка', 'karlivka', 0),
(188, '23', 'Каховка', 'kahovka', 0),
(189, '1', 'Керч', 'kerch', 0),
(190, '11', 'Київ', 'kyiv', 0),
(191, '13', 'Кипуче', 'kypuche', 0),
(192, '3', 'Ківерці', 'kivertsi', 0),
(193, '16', 'Кілія', 'kiliya', 0),
(194, '26', 'Кіцмань', 'kitsman', 0),
(195, '17', 'Кобеляки', 'kobelyaky', 0),
(196, '3', 'Ковель', 'kovel', 0),
(197, '16', 'Кодима', 'kodyma', 0),
(198, '2', 'Козятин', 'kozyatyn', 0),
(199, '9', 'Коломия', 'kolomyya', 0),
(200, '14', 'Комарно', 'komarno', 0),
(201, '20', 'Конотоп', 'konotop', 0),
(202, '21', 'Копичинці', 'kopychyntsi', 0),
(203, '18', 'Корець', 'korets', 0),
(204, '6', 'Коростень', 'korosten', 0),
(205, '6', 'Коростишів', 'korostyshiv', 0),
(206, '25', 'Корсунь-Шевченківський', 'korsun_shevchenkivskyy', 0),
(207, '27', 'Корюківка', 'koryukivka', 0),
(208, '9', 'Косів', 'kosiv', 0),
(209, '18', 'Костопіль', 'kostopil', 0),
(210, '5', 'Костянтинівка', 'kostyantynivka', 0),
(211, '5', 'Краматорськ', 'kramatorsk', 0),
(212, '24', 'Красилів', 'krasyliv', 0),
(213, '5', 'Красногорівка', 'krasnogorivka', 0),
(214, '22', 'Красноград', 'krasnograd', 0),
(215, '1', 'Красноперекопськ (Яни Капу)', 'krasnoperekopsk_yany_kapu', 0),
(216, '21', 'Кременець', 'kremenets', 0),
(217, '17', 'Кременчук', 'kremenchuk', 0),
(218, '13', 'Кремінна', 'kreminna', 0),
(219, '4', 'Кривий Ріг', 'kryvyy_rig', 0),
(220, '20', 'Кролевець', 'krolevets', 0),
(221, '10', 'Кропивницький', 'kropyvnytskyy', 0),
(222, '22', 'Куп\'янськ', 'kup_yansk', 0),
(223, '5', 'Курахове', 'kurahove', 0),
(224, '2', 'Ладижин', 'ladyzhyn', 0),
(225, '21', 'Ланівці', 'lanivtsi', 0),
(226, '20', 'Лебедин', 'lebedyn', 0),
(227, '5', 'Лиман', 'lyman', 0),
(228, '2', 'Липовець', 'lypovets', 0),
(229, '13', 'Лисичанськ', 'lysychansk', 0),
(230, '22', 'Лозова', 'lozova', 0),
(231, '17', 'Лохвиця', 'lohvytsya', 0),
(232, '17', 'Лубни', 'lubny', 0),
(233, '13', 'Луганськ', 'lugansk', 0),
(234, '13', 'Лутугине', 'lutugyne', 0),
(235, '3', 'Луцьк', 'lutsk', 0),
(236, '14', 'Львів', 'lviv', 0),
(237, '3', 'Любомль', 'lyuboml', 0),
(238, '22', 'Люботин', 'lyubotyn', 0),
(239, '5', 'Макіївка', 'makiivka', 0),
(240, '10', 'Мала Виска', 'mala_vyska', 0),
(241, '6', 'Малин', 'malyn', 0),
(242, '4', 'Марганець', 'marganets', 0),
(243, '5', 'Маріуполь', 'mariupol', 0),
(244, '5', 'Мар\'їнка', 'mar_inka', 0),
(245, '8', 'Мелітополь', 'melitopol', 0),
(246, '27', 'Мена', 'mena', 0),
(247, '22', 'Мерефа', 'merefa', 0),
(248, '14', 'Миколаїв', 'mykolaiv', 0),
(249, '14', 'Миколаїв1', 'mykolaiv1', 0),
(250, '5', 'Миколаївка', 'mykolaivka', 0),
(251, '17', 'Миргород', 'myrgorod', 0),
(252, '5', 'Мирноград', 'myrnograd', 0),
(253, '12', 'Миронівка', 'myronivka', 0),
(254, '13', 'Міусинськ', 'miusynsk', 0),
(255, '2', 'Могилів-Подільський', 'mogyliv_podilskyy', 0),
(256, '13', 'Молодогвардійськ', 'molodogvardiysk', 0),
(257, '8', 'Молочанськ', 'molochansk', 0),
(258, '21', 'Монастириська', 'monastyryska', 0),
(259, '25', 'Монастирище', 'monastyryshche', 0),
(260, '14', 'Моршин', 'morshyn', 0),
(261, '5', 'Моспине', 'mospyne', 0),
(262, '14', 'Мостиська', 'mostyska', 0),
(263, '7', 'Мукачево', 'mukachevo', 0),
(264, '9', 'Надвірна', 'nadvirna', 0),
(265, '2', 'Немирів', 'nemyriv', 0),
(266, '24', 'Нетішин', 'netishyn', 0),
(267, '27', 'Ніжин', 'nizhyn', 0),
(268, '4', 'Нікополь', 'nikopol', 0),
(269, '23', 'Нова Каховка', 'nova_kahovka', 0),
(270, '15', 'Нова Одеса', 'nova_odesa', 0),
(271, '27', 'Новгород-Сіверський', 'novgorod_siverskyy', 0),
(272, '15', 'Новий Буг', 'novyy_bug', 0),
(273, '14', 'Новий Калинів', 'novyy_kalyniv', 0),
(274, '14', 'Новий Розділ', 'novyy_rozdil', 0),
(275, '5', 'Новоазовськ', 'novoazovsk', 0),
(276, '3', 'Нововолинськ', 'novovolynsk', 0),
(277, '6', 'Новоград-Волинський', 'novograd_volynskyy', 0),
(278, '5', 'Новогродівка', 'novogrodivka', 0),
(279, '26', 'Новодністровськ', 'novodnistrovsk', 0),
(280, '13', 'Новодружеськ', 'novodruzhesk', 0),
(281, '10', 'Новомиргород', 'novomyrgorod', 0),
(282, '4', 'Новомосковськ', 'novomoskovsk', 0),
(283, '26', 'Новоселиця', 'novoselytsya', 0),
(284, '10', 'Новоукраїнка', 'novoukrainka', 0),
(285, '14', 'Новояворівськ', 'novoyavorivsk', 0),
(286, '27', 'Носівка', 'nosivka', 0),
(287, '12', 'Обухів', 'obuhiv', 0),
(288, '6', 'Овруч', 'ovruch', 0),
(289, '16', 'Одеса', 'odesa', 0),
(290, '6', 'Олевськ', 'olevsk', 0),
(291, '13', 'Олександрівськ', 'oleksandrivsk', 0),
(292, '10', 'Олександрія', 'oleksandriya', 0),
(293, '23', 'Олешки', 'oleshky', 0),
(294, '8', 'Оріхів', 'orihiv', 0),
(295, '27', 'Остер', 'oster', 0),
(296, '18', 'Острог', 'ostrog', 0),
(297, '20', 'Охтирка', 'ohtyrka', 0),
(298, '15', 'Очаків', 'ochakiv', 0),
(299, '4', 'Павлоград', 'pavlograd', 0),
(300, '13', 'Первомайськ', 'pervomaysk', 0),
(301, '13', 'Первомайськ1', 'pervomaysk1', 0),
(302, '22', 'Первомайський', 'pervomayskyy', 0),
(303, '13', 'Перевальськ', 'perevalsk', 0),
(304, '14', 'Перемишляни', 'peremyshlyany', 0),
(305, '7', 'Перечин', 'perechyn', 0),
(306, '4', 'Перещепине', 'pereshchepyne', 0),
(307, '12', 'Переяслав', 'pereyaslav', 0),
(308, '4', 'Першотравенськ', 'pershotravensk', 0),
(309, '13', 'Петрово-Красносілля', 'petrovo_krasnosillya', 0),
(310, '17', 'Пирятин', 'pyryatyn', 0),
(311, '22', 'Південне', 'pivdenne', 0),
(312, '21', 'Підгайці', 'pidgaytsi', 0),
(313, '4', 'Підгородне', 'pidgorodne', 0),
(314, '2', 'Погребище', 'pogrebyshche', 0),
(315, '16', 'Подільськ', 'podilsk', 0),
(316, '4', 'Покров', 'pokrov', 0),
(317, '5', 'Покровськ', 'pokrovsk', 0),
(318, '8', 'Пологи', 'pology', 0),
(319, '24', 'Полонне', 'polonne', 0),
(320, '17', 'Полтава', 'poltava', 0),
(321, '10', 'Помічна', 'pomichna', 0),
(322, '13', 'Попасна', 'popasna', 0),
(323, '21', 'Почаїв', 'pochaiv', 0),
(324, '13', 'Привілля', 'pryvillya', 0),
(325, '27', 'Прилуки', 'pryluky', 0),
(326, '8', 'Приморськ', 'prymorsk', 0),
(327, '12', 'Прип\'ять', 'pryp_yat', 0),
(328, '14', 'Пустомити', 'pustomyty', 0),
(329, '20', 'Путивль', 'putyvl', 0),
(330, '4', 'П\'ятихатки', 'p_yatyhatky', 0),
(331, '14', 'Рава-Руська', 'rava_ruska', 0),
(332, '14', 'Радехів', 'radehiv', 0),
(333, '18', 'Радивилів', 'radyvyliv', 0),
(334, '6', 'Радомишль', 'radomyshl', 0),
(335, '7', 'Рахів', 'rahiv', 0),
(336, '16', 'Рені', 'reni', 0),
(337, '17', 'Решетилівка', 'reshetylivka', 0),
(338, '12', 'Ржищів', 'rzhyshchiv', 0),
(339, '18', 'Рівне', 'rivne', 0),
(340, '13', 'Ровеньки', 'rovenky', 0),
(341, '9', 'Рогатин', 'rogatyn', 0),
(342, '5', 'Родинське', 'rodynske', 0),
(343, '3', 'Рожище', 'rozhyshche', 0),
(344, '16', 'Роздільна', 'rozdilna', 0),
(345, '20', 'Ромни', 'romny', 0),
(346, '13', 'Рубіжне', 'rubizhne', 0),
(347, '14', 'Рудки', 'rudky', 0),
(348, '1', 'Саки', 'saky', 0),
(349, '14', 'Самбір', 'sambir', 0),
(350, '18', 'Сарни', 'sarny', 0),
(351, '7', 'Свалява', 'svalyava', 0),
(352, '13', 'Сватове', 'svatove', 0),
(353, '10', 'Світловодськ', 'svitlovodsk', 0),
(354, '5', 'Світлодарськ', 'svitlodarsk', 0),
(355, '5', 'Святогірськ', 'svyatogirsk', 0),
(356, '19', 'Севастополь', 'sevastopol', 0),
(357, '5', 'Селидове', 'selydove', 0),
(358, '27', 'Семенівка', 'semenivka', 0),
(359, '20', 'Середина-Буда', 'seredyna_buda', 0),
(360, '13', 'Сєвєродонецьк', 'svrodonetsk', 0),
(361, '4', 'Синельникове', 'synelnykove', 0),
(362, '5', 'Сіверськ', 'siversk', 0),
(363, '1', 'Сімферополь', 'simferopol', 0),
(364, '23', 'Скадовськ', 'skadovsk', 0),
(365, '21', 'Скалат', 'skalat', 0),
(366, '12', 'Сквира', 'skvyra', 0),
(367, '14', 'Сколе', 'skole', 0),
(368, '24', 'Славута', 'slavuta', 0),
(369, '12', 'Славутич', 'slavutych', 0),
(370, '5', 'Слов\'янськ', 'slov_yansk', 0),
(371, '25', 'Сміла', 'smila', 0),
(372, '15', 'Снігурівка', 'snigurivka', 0),
(373, '5', 'Сніжне', 'snizhne', 0),
(374, '27', 'Сновськ', 'snovsk', 0),
(375, '9', 'Снятин', 'snyatyn', 0),
(376, '14', 'Сокаль', 'sokal', 0),
(377, '26', 'Сокиряни', 'sokyryany', 0),
(378, '5', 'Соледар', 'soledar', 0),
(379, '13', 'Сорокине', 'sorokyne', 0),
(380, '14', 'Соснівка', 'sosnivka', 0),
(381, '1', 'Старий Крим', 'staryy_krym', 0),
(382, '14', 'Старий Самбір', 'staryy_sambir', 0),
(383, '13', 'Старобільськ', 'starobilsk', 0),
(384, '24', 'Старокостянтинів', 'starokostyantyniv', 0),
(385, '14', 'Стебник', 'stebnyk', 0),
(386, '26', 'Сторожинець', 'storozhynets', 0),
(387, '14', 'Стрий', 'stryy', 0),
(388, '1', 'Судак', 'sudak', 0),
(389, '14', 'Судова Вишня', 'sudova_vyshnya', 0),
(390, '20', 'Суми', 'sumy', 1),
(391, '13', 'Суходільськ', 'suhodilsk', 0),
(392, '23', 'Таврійськ', 'tavriysk', 0),
(393, '25', 'Тальне', 'talne', 0),
(394, '12', 'Тараща', 'tarashcha', 0),
(395, '16', 'Татарбунари', 'tatarbunary', 0),
(396, '16', 'Теплодар', 'teplodar', 0),
(397, '21', 'Теребовля', 'terebovlya', 0),
(398, '4', 'Тернівка', 'ternivka', 0),
(399, '21', 'Тернопіль', 'ternopil', 0),
(400, '12', 'Тетіїв', 'tetiiv', 0),
(401, '9', 'Тисмениця', 'tysmenytsya', 0),
(402, '9', 'Тлумач', 'tlumach', 0),
(403, '8', 'Токмак', 'tokmak', 0),
(404, '5', 'Торецьк', 'toretsk', 0),
(405, '20', 'Тростянець', 'trostyanets', 0),
(406, '14', 'Трускавець', 'truskavets', 0),
(407, '2', 'Тульчин', 'tulchyn', 0),
(408, '14', 'Турка', 'turka', 0),
(409, '7', 'Тячів', 'tyachiv', 0),
(410, '14', 'Угнів', 'ugniv', 0),
(411, '7', 'Ужгород', 'uzhgorod', 0),
(412, '12', 'Узин', 'uzyn', 0),
(413, '12', 'Українка', 'ukrainka', 0),
(414, '5', 'Українськ', 'ukrainsk', 0),
(415, '25', 'Умань', 'uman', 0),
(416, '3', 'Устилуг', 'ustylug', 0),
(417, '12', 'Фастів', 'fastiv', 0),
(418, '1', 'Феодосія', 'feodosiya', 0),
(419, '22', 'Харків', 'harkiv', 0),
(420, '5', 'Харцизьк', 'hartsyzk', 0),
(421, '23', 'Херсон', 'herson', 0),
(422, '14', 'Хирів', 'hyriv', 0),
(423, '24', 'Хмельницький', 'hmelnytskyy', 0),
(424, '2', 'Хмільник', 'hmilnyk', 0),
(425, '14', 'Ходорів', 'hodoriv', 0),
(426, '17', 'Хорол', 'horol', 0),
(427, '21', 'Хоростків', 'horostkiv', 0),
(428, '26', 'Хотин', 'hotyn', 0),
(429, '5', 'Хрестівка', 'hrestivka', 0),
(430, '25', 'Христинівка', 'hrystynivka', 0),
(431, '13', 'Хрустальний', 'hrustalnyy', 0),
(432, '7', 'Хуст', 'hust', 0),
(433, '5', 'Часів Яр', 'chasiv_yar', 0),
(434, '14', 'Червоноград', 'chervonograd', 0),
(435, '25', 'Черкаси', 'cherkasy', 0),
(436, '26', 'Чернівці', 'chernivtsi', 0),
(437, '27', 'Чернігів', 'chernigiv', 0),
(438, '25', 'Чигирин', 'chygyryn', 0),
(439, '5', 'Чистякове', 'chystyakove', 0),
(440, '7', 'Чоп', 'chop', 0),
(441, '12', 'Чорнобиль', 'chornobyl', 0),
(442, '16', 'Чорноморськ', 'chornomorsk', 0),
(443, '21', 'Чортків', 'chortkiv', 0),
(444, '22', 'Чугуїв', 'chuguiv', 0),
(445, '6', 'Чуднів', 'chudniv', 0),
(446, '2', 'Шаргород', 'shargorod', 0),
(447, '5', 'Шахтарськ', 'shahtarsk', 0),
(448, '24', 'Шепетівка', 'shepetivka', 0),
(449, '20', 'Шостка', 'shostka', 0),
(450, '25', 'Шпола', 'shpola', 0),
(451, '21', 'Шумськ', 'shumsk', 0),
(452, '13', 'Щастя', 'shchastya', 0),
(453, '1', 'Щолкіне', 'shcholkine', 0),
(454, '16', 'Южне', 'yuzhne', 0),
(455, '15', 'Южноукраїнськ', 'yuzhnoukrainsk', 0),
(456, '14', 'Яворів', 'yavoriv', 0),
(457, '12', 'Яготин', 'yagotyn', 0),
(458, '1', 'Ялта', 'yalta', 0),
(459, '2', 'Ямпіль', 'yampil', 0),
(460, '9', 'Яремче', 'yaremche', 0),
(461, '5', 'Ясинувата', 'yasynuvata', 0);

-- --------------------------------------------------------

--
-- Структура таблиці `located_region`
--

CREATE TABLE `located_region` (
  `id` int(11) NOT NULL,
  `region` varchar(150) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `region_slug` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `located_region`
--

INSERT INTO `located_region` (`id`, `region`, `img`, `region_slug`, `is_active`) VALUES
(1, 'АР Крим', NULL, 'ar_krym', 1),
(2, 'Вінницька', NULL, 'vinnytska', 0),
(3, 'Волинська', NULL, 'volynska', 0),
(4, 'Дніпропетровська', NULL, 'dnipropetrovska', 0),
(5, 'Донецька', NULL, 'donetska', 0),
(6, 'Житомирська', NULL, 'zhytomyrska', 0),
(7, 'Закарпатська', NULL, 'zakarpatska', 0),
(8, 'Запорізька', NULL, 'zaporizka', 0),
(9, 'Івано-Франківська', NULL, 'ivano_frankivska', 0),
(10, 'Кіровоградська', NULL, 'kirovogradska', 0),
(11, 'Київ, міськрада', NULL, 'kyiv_miskrada', 0),
(12, 'Київська', NULL, 'kyivska', 0),
(13, 'Луганська', NULL, 'luganska', 0),
(14, 'Львівська', NULL, 'lvivska', 0),
(15, 'Миколаївська', NULL, 'mykolaivska', 0),
(16, 'Одеська', NULL, 'odeska', 0),
(17, 'Полтавська', NULL, 'poltavska', 0),
(18, 'Рівненська', NULL, 'rivnenska', 0),
(19, 'Севастополь, міськрада', NULL, 'sevastopol_miskrada', 0),
(20, 'Сумська', NULL, 'sumska', 1),
(21, 'Тернопільська', NULL, 'ternopilska', 0),
(22, 'Харківська', NULL, 'harkivska', 0),
(23, 'Херсонська', NULL, 'hersonska', 0),
(24, 'Хмельницька', NULL, 'hmelnytska', 0),
(25, 'Черкаська', NULL, 'cherkaska', 0),
(26, 'Чернівецька', NULL, 'chernivetska', 0),
(27, 'Чернігівська', NULL, 'chernigivska', 0);

-- --------------------------------------------------------

--
-- Структура таблиці `session`
--

CREATE TABLE `session` (
  `id` int(10) UNSIGNED NOT NULL,
  `telegram_id` bigint(30) UNSIGNED NOT NULL,
  `last_activity` varchar(20) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `session`
--

INSERT INTO `session` (`id`, `telegram_id`, `last_activity`, `updated_at`) VALUES
(1, 339929885, 'my_profile', '2022-06-30 20:19:36');

-- --------------------------------------------------------

--
-- Структура таблиці `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `telegram_id` bigint(30) UNSIGNED NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `language_code` varchar(5) DEFAULT NULL,
  `located_city_id` int(5) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `user`
--

INSERT INTO `user` (`id`, `telegram_id`, `username`, `first_name`, `last_name`, `phone`, `language_code`, `located_city_id`, `is_active`) VALUES
(1, 33399298855, 'my_username', 'my_fistname', NULL, NULL, 'uk', 390, 1);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `located_city`
--
ALTER TABLE `located_city`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `city_slug` (`city_slug`),
  ADD KEY `city_is_active` (`is_active`,`region_id`);

--
-- Індекси таблиці `located_region`
--
ALTER TABLE `located_region`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `region_slug` (`region_slug`),
  ADD KEY `region_name` (`region`),
  ADD KEY `region_is_active` (`is_active`);

--
-- Індекси таблиці `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `telegram_id` (`telegram_id`);

--
-- Індекси таблиці `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `telegram_id` (`telegram_id`),
  ADD KEY `phone` (`phone`),
  ADD KEY `located_city_id` (`located_city_id`) USING BTREE;

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `located_city`
--
ALTER TABLE `located_city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=462;

--
-- AUTO_INCREMENT для таблиці `located_region`
--
ALTER TABLE `located_region`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT для таблиці `session`
--
ALTER TABLE `session`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблиці `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
