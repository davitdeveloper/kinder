INSERT INTO `product_categories` (`id`, `parent_ids`, `child_ids`, `title`, `description`, `image`, `url`, `alias`, `status` , `size_type`) VALUES
(1, '[]', '[8,9]', 'Նորածիններ', 'Lorem ipsum description for category', 'image.jpg', NULL, 'noratsinner', 1 , 'Other'),
(2, '[]', '[10,11]', 'Փոքր երեխաներ', 'Lorem ipsum description for category', 'image.jpg', NULL, 'poqr_erexaner', 1 , 'Other'),
(3, '[]', '[12,13]', 'Պատանիներ', 'Lorem ipsum description for category', 'image.jpg', NULL, 'pataniner', 1 , 'Other'),
(4, '[]', '[106]', 'Մայրիկներին', 'Lorem ipsum description for category', 'image.jpg', NULL, 'mayriknerin', 1 , 'Other'),
(5, '[]', '[14,15]', 'Խնամք', 'Lorem ipsum description for category', 'image.jpg', NULL, 'khnamq', 1 , 'Other'),
(6, '[]', '[16,17]', 'Սնունդ', 'Lorem ipsum description for category', 'image.jpg', NULL, 'snund', 1 , 'Other'),
(7, '[]', '[18,19,20]', 'Աքսեսուարներ', 'Lorem ipsum description for category', 'image.jpg', NULL, 'aksesuarner', 1 , 'Other'),

(8, '[1]', '[21,22,23,24,25,26,27,28,29,30,32,33,35]', 'Նորածին Տղաներ(0M-24M)', 'Lorem ipsum description for category', 'image.jpg', NULL, 'noratsin_tghaner', 1 , 'Other'),
(9, '[1]', '[21,22,23,24,25,26,27,28,29,30,32,33,35]', 'Նորածին Աղջիկներ(0M-24M)', 'Lorem ipsum description for category', 'image.jpg', NULL, 'noratsin_aghjikner', 1 , 'Other'),
(10, '[2]', '[23,24,25,26,27,28,29,30,31,32,33,34]', 'Փոքրիկ Տղաներ(2Y-7Y)', 'Lorem ipsum description for category', 'image.jpg', NULL, 'poqr_tghaner', 1 , 'Other'),
(11, '[2]', '[23,24,25,26,27,28,29,30,31,32,33,34,35,36,37]', 'Փոքրիկ Աղջիկներ(2Y-7Y)', 'Lorem ipsum description for category', 'image.jpg', NULL, 'poqr_aghjikner', 1 , 'Other'),
(12, '[3]', '[23,24,25,26,27,28,29,30,31,32,33,34]', 'Պատանի Տղաներ(7Y-14Y)', 'Lorem ipsum description for category', 'image.jpg', NULL, 'patani_tghaner', 1 , 'Other'),
(13, '[3]', '[23,24,25,26,27,28,29,30,31,32,33,34,35,36,37]', 'Պատանի Աղջիկներ(7Y-14Y)', 'Lorem ipsum description for category', 'image.jpg', NULL, 'patani_aghjikner', 1 , 'Other'),
(14, '[5]', '[38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70]', 'Խնամք(0-2Y)', 'Lorem ipsum description for category', 'image.jpg', NULL, 'khnamq0_2', 1 , 'Other'),
(15, '[5]', '[38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70]', 'Խնամք(2Y+)', 'Lorem ipsum description for category', 'image.jpg', NULL, 'khnamq2+', 1 , 'Other'),
(16, '[6]', '[71,72,73,74,75,76,77]', 'Սնունդ(0-2Y)', 'Lorem ipsum description for category', 'image.jpg', NULL, 'snund0_2', 1 , 'Other'),
(17, '[6]', '[71,72,73,74,75,76,77]', 'Սնունդ(2Y+)', 'Lorem ipsum description for category', 'image.jpg', NULL, 'snund2+', 1 , 'Other'),
(18, '[7]', '[78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98]', 'Աքսեսուարներ(0-2Y)', 'Lorem ipsum description for category', 'image.jpg', NULL, 'aksesuarner0_2', 1 , 'Other'),
(19, '[7]', '[78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98]', 'Աքսեսուարներ(3Y+)', 'Lorem ipsum description for category', 'image.jpg', NULL, 'aksesuarner2+', 1 , 'Other'),
(20, '[7]', '[99,100,101]', 'Խաղալիքներ', 'Lorem ipsum description for category', 'image.jpg', NULL, 'khakhaliqner', 1 , 'Other'),




(21, '[8,9]', '[]', 'Բոդիներ', 'Բոդիներ', NULL, NULL, 'bodiner', 1 , 'Top'),
(22, '[8,9]', '[]', 'Միակտորներ', 'Միակտորներ', NULL, NULL, 'miaktorner', 1 , 'Top'),
(23, '[8,9,10,11,12,13]', '[]', 'Գիշերային հագուստ', 'Գիշերային հագուստ', NULL, NULL, 'gisherayin_hagust', 1 , 'Top'),
(24, '[8,9,10,11,12,13]', '[]', 'Հավաքածուներ', 'Հավաքածուներ', NULL, NULL, 'havaqatsuner', 1 , 'Top'),
(25, '[106,8,9,10,11,12,13]', '[]', 'Տոպեր', 'Տոպեր', NULL, NULL, 'toper', 1 , 'Top'),
(26, '[106,8,9,10,11,12,13]', '[]', 'Շապիկներ', 'Շապիկներ', NULL, NULL, 'shapikner', 1 , 'Top'),
(27, '[106,8,9,10,11,12,13]', '[]', 'Տաբատներ', 'Տաբատներ', NULL, NULL, 'tabatner', 1 , 'Pant'),
(28, '[106,8,9,10,11,12,13]', '[]', 'Շորտեր', 'Շորտեր', NULL, NULL, 'shorter', 1 , 'Pant'),
(29, '[106,8,9,10,11,12,13]', '[]', 'Սվիտերներ և կապյուշոնով սվիտերներ', 'Սվիտերներ և կապյուշոնով սվիտերներ', NULL, NULL, 'sviterner_kapyushonov_sviterner', 1 , 'Top'),
(30, '[8,9,10,11,12,13]', '[]', 'Դրսի հագուստ և բաճկոններ', 'Դրսի հագուստ և բաճկոններ', NULL, NULL, 'drsi_hagust_ev_batchkonner', 1 , 'Top'),
(31, '[106,10,11,12,13]', '[]', 'Լողազգեստ', 'Լողազգեստ', NULL, NULL, 'logazgest', 1 , 'Pant'),
(32, '[106,8,9,10,11,12,13]', '[]', 'Կոշիկներ', 'Կոշիկներ', NULL, NULL, 'koshikner', 1 , 'Shoe'),
(33, '[8,9,10,11,12,13]', '[]', 'Գուլպաներ և ներքնազգեստ', 'Գուլպաներ և ներքնազգեստ', NULL, NULL, 'gulpaner_nerqnazgest', 1 , 'Accessory'),
(34, '[106,10,11,12,13]', '[]', 'Աքսեսուարներ', 'Աքսեսուարներ', NULL, NULL, 'aqsesuarner', 1 , 'Accessory'),
(35, '[106,8,9,11,13]', '[]', 'Տրիկոներ', 'Տրիկոներ', NULL, NULL, 'trikoner', 1 , 'Pant'),
(36, '[106,11,13]', '[]', 'Կիսաշրջազգեստներ', 'Կիսաշրջազգեստներ', NULL, NULL, 'kisashrjazgestner', 1 , 'Top'),
(37, '[106,11,13]', '[]', 'Շրջազգեստներ և կոմբինեզոններ', 'Շրջազգեստներ և կոմբինեզոններ', NULL, NULL, 'shrjazgestner_ev_kombinizonner', 1 , 'Top'),


(38, '[14,15]', '[]', 'Մանկական օճառ', 'Մանկական օճառ', NULL, NULL, 'otchar', 1 , 'Other'),
(39, '[14,15]', '[]', 'Մանկական շամպուն', 'Մանկական շամպուն', NULL, NULL, 'shampun', 1 , 'Other'),
(40, '[14,15]', '[]', 'Մանկական լոգանքի գել', 'Մանկական լոգանքի գել', NULL, NULL, 'loganqi_gel', 1 , 'Other'),
(41, '[14,15]', '[]', 'Լոգանքի ձեռնոցներ', 'Լոգանքի ձեռնոցներ', NULL, NULL, 'loganqi_dzernocner', 1 , 'Other'),
(42, '[14,15]', '[]', 'Ջրի ջերմաչափեր', 'Ջրի ջերմաչափեր', NULL, NULL, 'jri_jermachapher', 1 , 'Other'),
(43, '[14,15]', '[]', 'Մանկական սրբիչներ', 'Մանկական սրբիչներ', NULL, NULL, 'srbichner', 1 , 'Other'),
(44, '[14,15]', '[]', 'Մանկական ատամի խոզանակներ', 'Մանկական ատամի խոզանակներ', NULL, NULL, 'atami_khozanakner', 1 , 'Other'),
(45, '[14,15]', '[]', 'Մանկական ատամի մածուկ', 'Մանկական ատամի մածուկ', NULL, NULL, 'atami_matcuk', 1 , 'Other'),
(46, '[14,15]', '[]', 'Փոշիներ', 'Փոշիներ', NULL, NULL, 'phoshiner', 1 , 'Other'),
(47, '[14,15]', '[]', 'Յուղեր', 'Յուղեր', NULL, NULL, 'yugher', 1 , 'Other'),
(48, '[14,15]', '[]', 'Տակդիրի կրեմ', 'Տակդիրի կրեմ', NULL, NULL, 'takdiri_krem', 1 , 'Other'),
(49, '[14,15]', '[]', 'Արևապաշտպան միջոցներ', 'Արևապաշտպան միջոցներ', NULL, NULL, 'arevapashtpan_mijocner', 1 , 'Other'),
(50, '[14,15]', '[]', 'Ասպիրատորներ', 'Ասպիրատորներ', NULL, NULL, 'aspiratorner', 1 , 'Other'),
(51, '[14,15]', '[]', 'Ականջի փայտիկներ', 'Ականջի փայտիկներ', NULL, NULL, 'akanji_phaytikner', 1 , 'Other'),
(52, '[14,15]', '[]', 'Եղունգների խնամք', 'Եղունգների խնամք', NULL, NULL, 'eghungneri_khnamq', 1 , 'Other'),
(53, '[14,15]', '[]', 'Լվացող միջոցներ', 'Լվացող միջոցներ', NULL, NULL, 'lvacogh_mijocner', 1 , 'Other'),
(54, '[14,15]', '[]', 'Տակդիրներ', 'Տակդիրներ', NULL, NULL, 'takdirner', 1 , 'Other'),
(55, '[14,15]', '[]', 'Խոնավ անձեռոցիկեր', 'Խոնավ անձեռոցիկեր', NULL, NULL, 'khonav_andzerocikner', 1 , 'Other'),
(56, '[14,15]', '[]', 'Վարտիքներ', 'Վարտիքներ', NULL, NULL, 'vartiqner', 1 , 'Other'),
(57, '[14,15]', '[]', 'Կթիչներ', 'Կթիչներ', NULL, NULL, 'kthichner', 1 , 'Other'),
(58, '[14,15]', '[]', 'Կրծքի խնամքի միջոցներ', 'Կրծքի խնամքի միջոցներ', NULL, NULL, 'krtcqi_khnamqi_mijocner', 1 , 'Other'),
(59, '[14,15]', '[]', 'Կերակրման բարձեր', 'Կերակրման բարձեր', NULL, NULL, 'kerakrman_bardzer', 1 , 'Other'),
(60, '[14,15]', '[]', 'Կրծքի կաթի պահպանման տարաներ', 'Կրծքի կաթի պահպանման տարաներ', NULL, NULL, 'krtcqi_kathi_pahpanman_taraner', 1 , 'Other'),
(61, '[14,15]', '[]', 'Կրծքկալի ներդիր', 'Կրծքկալի ներդիր', NULL, NULL, 'krtckali_nerdir', 1 , 'Other'),
(62, '[14,15]', '[]', 'Շշի ծծակներ', 'Շշի ծծակներ', NULL, NULL, 'shshi_tctcakner', 1 , 'Other'),
(63, '[14,15]', '[]', 'Ծծակներ', 'Ծծակներ', NULL, NULL, 'tctcakner', 1 , 'Other'),
(64, '[14,15]', '[]', 'Շշեր', 'Շշեր', NULL, NULL, 'shsher', 1 , 'Other'),
(65, '[14,15]', '[]', 'Ստերիլիզատորներ', 'Ստերիլիզատորներ', NULL, NULL, 'sterilizatorner', 1 , 'Other'),
(66, '[14,15]', '[]', 'Շշի և ծծակի խոզանակներ', 'Շշի և ծծակի խոզանակներ', NULL, NULL, 'shshi_v_tctcaki_khozanakner', 1 , 'Other'),
(67, '[14,15]', '[]', 'Մանկական բաժակներ', 'Մանկական բաժակներ', NULL, NULL, 'bazhakner', 1 , 'Other'),
(68, '[14,15]', '[]', 'Մանկական ափսեներ', 'Մանկական ափսեներ', NULL, NULL, 'aphsener', 1 , 'Other'),
(69, '[14,15]', '[]', 'Մանկական գդալներ', 'Մանկական գդալներ', NULL, NULL, 'gdalner', 1 , 'Other'),
(70, '[14,15]', '[]', 'Գոգնոցներ', 'Գոգնոցներ', NULL, NULL, 'gognocner', 1 , 'Other'),


(71, '[16,17]', '[]', 'Շիլաներ', 'Շիլաներ', NULL, NULL, 'shilaner', 1 , 'Other'),
(72, '[16,17]', '[]', 'Կաթնախառնուրդներ', 'Կաթնախառնուրդներ', NULL, NULL, 'kathnakharnurdner', 1 , 'Other'),
(73, '[16,17]', '[]', 'Մանկական թխվածքաբլիթներ', 'Մանկական թխվածքաբլիթներ', NULL, NULL, 'mankakan_thkhvatsqablithner', 1 , 'Other'),
(74, '[16,17]', '[]', 'Պյուրեներ', 'Պյուրեներ', NULL, NULL, 'pyurener', 1 , 'Other'),
(75, '[16,17]', '[]', 'Հյութեր', 'Հյութեր', NULL, NULL, 'hyuther', 1 , 'Other'),
(76, '[16,17]', '[]', 'Կոմպոտներ', 'Կոմպոտներ', NULL, NULL, 'kompotner', 1 , 'Other'),
(77, '[16,17]', '[]', 'Մանկական ջուր', 'Մանկական ջուր', NULL, NULL, 'manakakn_jur', 1 , 'Other'),

(78, '[18,19]', '[]', 'Մանկական գիշերանոթ', 'Մանկական գիշերանոթ', NULL, NULL, 'gisheranoth', 1 , 'Other'),
(79, '[18,19]', '[]', 'Մանկական զուգարանակոնք', 'Մանկական զուգարանակոնք', NULL, NULL, 'zugaranakonq', 1 , 'Other'),
(80, '[18,19]', '[]', 'Մանկական լոգարաններ', 'Մանկական լոգարաններ', NULL, NULL, 'logaranner', 1 , 'Other'),
(81, '[18,19]', '[]', 'Կանգնակներ', 'Կանգնակներ', NULL, NULL, 'kangnakner', 1 , 'Other'),
(82, '[18,19]', '[]', 'Մեքենայի նստատեղեր', 'Մեքենայի նստատեղեր', NULL, NULL, 'meqenayi_nstategh', 1 , 'Other'),
(83, '[18,19]', '[]', 'Մանկասայլակներ', 'Մանկասայլակներ', NULL, NULL, 'mankasaylakner', 1 , 'Other'),
(84, '[18,19]', '[]', 'Ճոճաթոռներ', 'Ճոճաթոռներ', NULL, NULL, 'tchotchathorner', 1 , 'Other'),
(85, '[18,19]', '[]', 'Մանեժներ', 'Մանեժներ', NULL, NULL, 'manezhner', 1 , 'Other'),
(86, '[18,19]', '[]', 'Քայլակներ', 'Քայլակներ', NULL, NULL, 'qaylakner', 1 , 'Other'),
(87, '[18,19]', '[]', 'Կենգուրուներ', 'Կենգուրուներ', NULL, NULL, 'kenguruner', 1 , 'Other'),
(88, '[18,19]', '[]', 'Երեխային քայլեցնելու հարմարանքներ', 'Երեխային քայլեցնելու հարմարանքներ', NULL, NULL, 'qaylecnelu_harmaranq', 1 , 'Other'),
(89, '[18,19]', '[]', 'Մանկական անկողիններ', 'Մանկական անկողիններ', NULL, NULL, 'ankoxinner', 1 , 'Other'),
(90, '[18,19]', '[]', 'Թվային ռադիո դայակ', 'Թվային ռադիո դայակ', NULL, NULL, 'radio_dayak', 1 , 'Other'),
(91, '[18,19]', '[]', 'Տակդիրները փոխելու սեղան', 'Տակդիրները փոխելու սեղան', NULL, NULL, 'takdirner_poxelu_seghan', 1 , 'Other'),
(92, '[18,19]', '[]', 'Կերակրման աթոռներ', 'Կերակրման աթոռներ', NULL, NULL, 'kerakrman_athorner', 1 , 'Other'),
(93, '[18,19]', '[]', 'Վերմակներ', 'Վերմակներ', NULL, NULL, 'vermakner', 1 , 'Other'),
(94, '[18,19]', '[]', 'Ծրարներ', 'Ծրարներ', NULL, NULL, 'tcrarner', 1 , 'Other'),
(95, '[18,19]', '[]', 'Քնապարկեր', 'Քնապարկեր', NULL, NULL, 'qnaparker', 1 , 'Other'),
(96, '[18,19]', '[]', 'Սավաններ', 'Սավաններ', NULL, NULL, 'savanner', 1 , 'Other'),
(97, '[18,19]', '[]', 'Բարձեր և բարձի երեսներ', 'Բարձեր և բարձի երեսներ', NULL, NULL, 'bardzer_bazrdzi_yeresner', 1 , 'Other'),
(98, '[18,19]', '[]', 'Ներքնակներ', 'Ներքնակներ', NULL, NULL, 'nerqnakner', 1 , 'Other'),

(99, '[20]', '[]', '0-6', '0-6', NULL, NULL, 'khaghaliqner0-6', 1 , 'Other'),
(100, '[20]', '[]', '6-12', '6-12', NULL, NULL, 'khaghaliqner6-12', 1 , 'Other'),
(101, '[20]', '[]', '12+', '12+', NULL, NULL, 'khaghaliqner12+', 1 , 'Other'),


(102, '[106]', '[]', 'Ջինսեր', 'Ջինսեր', NULL, NULL, 'mayriknerin_jinser', 1 , 'Pant'),
(103, '[106]', '[]', 'Վերնազգեստ', 'Վերնազգեստ', NULL, NULL, 'mayriknerin_vernazgest', 1 , 'Top'),
(104, '[106]', '[]', 'Սպորտային հագուստ', 'Սպորտային հագուստ', NULL, NULL, 'mayriknerin_sportajin_hagust', 1 , 'Top'),
(105, '[106]', '[]', 'Զուգագուլպաներ', 'Զուգագուլպաներ', NULL, NULL, 'mayriknerin_zugagulpaner', 1 , 'Accessory'),
(106, '[4]', '[25,26,27,28,29,31,32,34,35,36,37,102,103,104,105]', 'Մայրիկներ', 'Մայրիկներ', NULL, NULL, 'mayrikner', 1 , 'Other');
