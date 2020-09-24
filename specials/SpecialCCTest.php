<?php
/**
 * Test SpecialPage for CoordinateConversion extension
 *
 * @file
 * @ingroup Extensions
 */

class SpecialCCTest extends SpecialPage {
	public function __construct() {
		parent::__construct( 'CCTest' );
	}

	/**
	 * Show the page to the user
	 *
	 * @param string $sub The subpage string argument (if any).
	 *  [[Special:CCTest/subpage]].
	 */
	public function execute( $sub ) {
		$out = $this->getOutput();

		$out->setPageTitle( $this->msg( 'coordinateconversion-test' ) );

		$out->addHelpLink( 'How to become a MediaWiki hacker' );

		$out->addWikiMsg( 'coordinateconversion-test-intro' );



		# Do stuff
		# ...
		$wikitext = '
{|class="wikitable" style="width:100%"
!colspan=4| RD (The Netherlands)
|-
|<nowiki>{{#wgs84_2rd: | }} </nowiki>
|colspan=3|https://media.thomasv.nl/2015/07/Transformatieformules.pdf
|-
|Amsterdam (Westertoren)||52.37453253,4.88352559||x = 120700.723 m y = 487525.501 m||{{#wgs84_2rd:52.37453253|4.88352559}}
|-
|Groningen (Martinitoren)||53.21938317,6.56820053||x = 233883.131 m y = 582065.167 m||{{#wgs84_2rd:53.21938317|6.56820053}}
|-
!colspan=4| LB08 (Belgium)
|-
|<nowiki>{{#wgs84_2lb08: | }} </nowiki>
|colspan=3|http://www.ngi.be/Common/Lambert2008/Transformation_Geographic_Lambert_NL.pdf
|-
|Brussel (Paleizenplein)||50.842442,4.3643||x = 649686.07 m y = 670226.23 m ||{{#wgs84_2lb08:50.842442|4.3643}}
|-
|Arlon (Butte Saint-Donat)||49.685034,5.816257||x = 754469.25 m y = 542520.00 m||{{#wgs84_2lb08:49.685034|5.816257}}
|-
!colspan=4| CH03 (Switzerland)
|-
|<nowiki>{{#wgs84_2ch03: | | }} </nowiki>
|colspan=3|LV03 [https://www.swisstopo.admin.ch/content/swisstopo-internet/en/topics/survey/reference-systems/switzerland/_jcr_content/contentPar/tabs/items/dokumente_publikatio/tabPar/downloadlist/downloadItems/517_1459343190376.download/refsys_e.pdf https://www.swisstopo.admin.ch]
|-
|Genève||46.20580, 6.14243||y = 499959.81 m, x = 117977.95 m||{{#wgs84_2ch03:	46.20580| 6.14243}}
|-
|Bern||46.951082877, 7.438632495||y= 600000.000 m, x= 200000.000 m||{{#wgs84_2ch03:	46.951082877| 7.438632495}}
|-
|Reference||46.044120951, 8.730497384 650.60||y= 700000.000 m, x= 100000.000 m, h= 600 m||{{#wgs84_2ch03:	46.044120951| 8.730497384|650.60}}
|-
|Zimmerwald||46.877095, 7.465273 947.149||y= 602030.680 m, x= 191775.030 m, h=897.915 m||{{#wgs84_2ch03:46.877095|7.465273|947.149}}
|-
|Chrischona||47.567051, 7.668606 504.935||y= 617306.300 m, x= 268507.300 m, h=456.064 m||{{#wgs84_2ch03:47.567051|7.668606|504.935}}
|-
|Pfaender||47.515326, 9.78436 1042.624||y= 776668.105 m, x= 265372.68 m, h= 1042.624 m||{{#wgs84_2ch03:47.515326|9.78436|1089.372}}
|-
|La Givrine||46.454081, 6.102035, 1258.274||y= 497313.292 m, x= 145625.438 m, h= 1207.434 m||{{#wgs84_2ch03:46.454081|6.102035|1258.274}}
|-
|Monte Generoso||45.929288, 9.021219 1685.027||y= 722758.810 m, x= 87649.670 m, h= 1636.600 m||{{#wgs84_2ch03:45.929288|9.021219|1685.027}}
|-
!colspan=4| CH03+ (Switzerland)
|-
|<nowiki>{{#wgs84_2ch03p: | | }} </nowiki>
|colspan=3|LV95 [https://www.swisstopo.admin.ch/content/swisstopo-internet/en/topics/survey/reference-systems/switzerland/_jcr_content/contentPar/tabs/items/dokumente_publikatio/tabPar/downloadlist/downloadItems/517_1459343190376.download/refsys_e.pdf https://www.swisstopo.admin.ch]
|-
|Genève||46.20580, 6.14243||E= 	2499959.81 m, N= 1117977.95 m||{{#wgs84_2ch03p:	46.20580| 6.14243}}
|-
|Bern||46.951082877, 7.438632495||E= 2600000.000 m, N= 1200000.000 m||{{#wgs84_2ch03p:	46.951082877| 7.438632495}}
|-
|Reference||46.044120951, 8.730497384 650.60||E= 2700000.000 m, N= 1100000.000 m, h= 600 m||{{#wgs84_2ch03p:	46.044120951| 8.730497384|650.60}}
|-
|Zimmerwald||46.877095, 7.465273 947.149||E=2602030.680 m, N=1191775.030 m, h= 897.915 m||{{#wgs84_2ch03p:46.877095|7.465273|947.149}}
|-
|Chrischona||47.567051, 7.668606 504.935||E= 2617306.300 m, N=1268507.300 m, h= 456.064 m||{{#wgs84_2ch03p:47.567051|7.668606|504.935}}
|-
|Pfaender||47.515326, 9.78436 1042.624||E= 776668.105 m, N=2265372.681 m, h= 11042.624 m||{{#wgs84_2ch03p:47.515326|9.78436|1089.372}}
|-
|La Givrine||46.454081, 6.102035, 1258.274||E= 2497313.292 m, N=1145625.438 m, h= 1207.434 m||{{#wgs84_2ch03p:46.454081|6.102035|1258.274}}
|-
|Monte Generoso||45.929288, 9.021219 1685.027||E= 2722758.810 m, N=1087649.670 m, h= 1636.600 m||{{#wgs84_2ch03p:45.929288|9.021219|1685.027}}
|-
!colspan=4|LB93 (France)
|-
|<nowiki>{{#wgs84_2lb93: | }} </nowiki>
|colspan=3|http://rgp.ign.fr/STATIONS/liste.php
|-
| AGDE - Cap d&acute;Agde || 43.296379, 3.466423 65.811 m ||E= 737871.670 m, N= 6244246.501 m, h= 16.43 m ||{{#wgs84_2lb93:43.296379| 3.466423}}
|-
| DUNQ - Dunkerque ||51.048064, 2.366693 51.103 m ||E= 655489.210 m, N= 7106002.116 m, h= 7.55 m||{{#wgs84_2lb93:	   51.048064| 2.366693}}
|-
|CHBS - Chabris	||47.250571, 1.656437 162.366 m	||E= 598385.841 m, N= 6684227.337 m, h= 116.41 m||{{#wgs84_2lb93:	   47.250571| 1.656437}}
|-
|LPPZ - Lampaul Plouarzel ||48.446257, -4.760399 98.548 m||E= 127030.386 m, N= 6844398.552 m, h= 47.75 m||{{#wgs84_2lb93:	   48.446257| -4.760399}}
|-
|LUCI - Santa Lucia Di Moriani ||42.386281, 9.53086 63.720 m||E= 1238040.178 m, N= 6165186.725 m, h= 15.40 m||{{#wgs84_2lb93:42.386281| 9.53086}}
|-
|PICO - Pianottolli Caldarello||41.47275, 9.064618 59.406 m||E= 1207509.989 m, N= 6060734.081 m, h= 11.77 m||{{#wgs84_2lb93:41.47275| 9.064618}}
|-
|PIMI - Bareges La Mongie ||42.936428, 0.142646 2923.432 m||E= 466595.572 m, N= 6208338.322 m, h= 2870.30 m||{{#wgs84_2lb93:42.936428| 0.142646}}
|-
!colspan=4|ETRS-TM35FIN (Finland)
|-
|<nowiki>{{#wgs84_2tm35fin: | }} </nowiki>
|colspan=3|https://www.nationalparks.fi/en/
|-
|Boskär|| 60.033821.770773||N: 6666699 E: 208826||{{#wgs84_2tm35fin:60.0338|21.770773}}
|-
|Kuohkimajärvi||69.06069,20.557305 ||N: 7674619 E: 243443||{{#wgs84_2tm35fin:69.06069|20.557305}}
|-
|Lastaaja ||65.27244, 25.211477||N: 7240001 E: 416528||{{#wgs84_2tm35fin:65.27244| 25.211477}}
|-
|Neitikoski||63.38805,30.459202 ||N: 7033492 E: 672825||{{#wgs84_2tm35fin:63.38805|30.459202}}
|-
|Raappana||68.220863, 28.046485 || N: 7567856 E: 543329||{{#wgs84_2tm35fin:68.220863| 28.046485}}
|-
|Ruktajärvi||69.45614,26.294053|| N: 7705384 E: 472352||{{#wgs84_2tm35fin:69.45614|26.294053}}
|-
!colspan=4|MTM (Canada)
|-
|<nowiki>{{#wgs84_2mtm: | }} </nowiki>
|colspan=3|https://webapp.geod.nrcan.gc.ca/geod/tools-outils/trx.php
|-
|NF Goose Bay||  53.29806,-60.35889||4 380873.367m E 5907806.476m N||{{#wgs84_2mtm:  53.29806|-60.35889}}
|-
|QC Iles De La Madeleine||  47.45409,-61.75415||4 285636.712m E 5257234.893m N||{{#wgs84_2mtm:  47.45409|-61.75415}}
|-
|QC Natashquan||  50.17866,-61.81183||4 282528.390m E 556020.8728m N||{{#wgs84_2mtm:  50.17866|-61.81183}}
|-
|PE East most||  46.43786,-62.00684||4 265853.306m E 5144365.654m N||{{#wgs84_2mtm:  46.43786|-62.00684}}
|-
|NS Halifax||  44.64521,-63.58887||5 377074.587m E 4945425.288m N||{{#wgs84_2mtm:  44.64521|-63.58887}}
|-
|PE West most||  46.69467,-64.41284||5 31146.6162m E 5172789.284m N||{{#wgs84_2mtm:  46.69467|-64.41284}}
|-
|QC Gaspe||  48.82857,-64.47327||5 306762.527m E 5410021.281m N||{{#wgs84_2mtm:  48.82857|-64.47327}}
|-
|NB Moncton||  46.10371,-64.77539||5 283509.524m E 5107138.457m N||{{#wgs84_2mtm:  46.10371|-64.77539}}
|-
|NS Yarmouth (bug2)||  43.82660,-66.12671||5 173960.852m E 485535.5569m N||{{#wgs84_2mtm:  43.82660|-66.12671}}
|-
|NB Atholville||  47.99521,-66.71310||6 363522.269m E 5317661.655m N||{{#wgs84_2mtm:  47.99521|-66.71310}}
|-
|QC Restigouche||  48.01955,-66.72512||6 362598.085m E 5320358.650m N||{{#wgs84_2mtm:  48.01955|-66.72512}}
|-
|NB Edmundston||  47.36487,-68.32947||6 242151.252m E 5247618.878m N||{{#wgs84_2mtm:  47.36487|-68.32947}}
|-
|QC Mont-Joli||  48.53116,-68.35144||6 241922.756m E 5377301.323m N||{{#wgs84_2mtm:  48.53116|-68.35144}}
|-
|QC Kuujjuaq||  58.09984,-68.40569||6 251399.731m E 6442115.443m N||{{#wgs84_2mtm:  58.09984|-68.40569}}
|-
|NW Iqaluit||  63.75126,-68.52456||6 254228.356m E 7071822.644m N||{{#wgs84_2mtm:  63.75126|-68.52456}}
|-
|QC St-Fabien||  48.30877,-68.85132||6 204571.800m E 5353106.965m N||{{#wgs84_2mtm:  48.30877|-68.85132}}
|-
|QC Chicoutimi||  48.42191,-71.06506||7m E m N||{{#wgs84_2mtm:  48.42191|-71.06506}}
|-
|QC Quebec||  46.81510,-71.23810||7m E m N||{{#wgs84_2mtm:  46.81510|-71.23810}}
|-
|QC Longueuil||  45.53088,-73.51158||8 303895.875m E 5043439.340m N||{{#wgs84_2mtm:  45.53088|-73.51158}}
|-
|QC Dalhousie||  45.30109,-74.45881||8 229605.778m E 5018350.240m N||{{#wgs84_2mtm:  45.30109|-74.45881}}
|-
|ON Dalhousie Mills (east most)||  45.31643,-74.47117||8 228656.991m E 5020066.527m N||{{#wgs84_2mtm:  45.31643|-74.47117}}
|-
|ON Cornwall||  45.01919,-74.73450||8 20750.6176m E 498731.8671m N||{{#wgs84_2mtm:  45.01919|-74.73450}}
|-
|ON Ottawa||  45.41846,-75.70026||9 367390.432m E 5031257.210m N||{{#wgs84_2mtm:  45.41846|-75.70026}}
|-
|QC Gatineau||  45.45724,-75.72876||9 36511.8607m E 5035545.014m N||{{#wgs84_2mtm:  45.45724|-75.72876}}
|-
|ON Kingston||  44.22946,-76.48682||9 305853.362m E 4898827.806m N||{{#wgs84_2mtm:  44.22946|-76.48682}}
|-
|QC Rouyn-Noranda||  48.23839,-79.02260||10 340258.642m E 5344509.417m N||{{#wgs84_2mtm:  48.23839|-79.02260}}
|-
|ON Toronto||  43.67184,-79.39270||10 313453.058m E 4836881.682m N||{{#wgs84_2mtm:  43.67184|-79.39270}}
|-
|ON North Bay||  46.31658,-79.47510||10 30671.8138m E 5130761.310m N||{{#wgs84_2mtm:  46.31658|-79.47510}}
|-
|QC La Reine (west most)||  48.86686,-79.51080||12 41404.5576m E 5415348.191m N||{{#wgs84_2mtm:  48.86686|-79.51080}}
|-
|ON Sudbury (bug3)||  46.47948,-80.99327||12 305317.319m E 5148867.050m N||{{#wgs84_2mtm:  46.47948|-80.99327}}
|-
|ON Zone 11 (south of Sudbury)||  45.90000,-81.10000||11 413433.214m E 5085414.566m N||{{#wgs84_2mtm:  45.90000|-81.10000}}
|-
|ON Killarny (zone 11)||  45.97424,-81.50997||11 381519.361m E 5093188.946m N||{{#wgs84_2mtm:  45.97424|-81.50997}}
|-
|ON Timmins||  48.48749,-81.34277||12 279465.713m E 5372152.487m N||{{#wgs84_2mtm:  48.48749|-81.34277}}
|-
|ON Pelee (Canada south most)||  41.78463,-82.67040||11 290636.717m E 4627265.806m N||{{#wgs84_2mtm:  41.78463|-82.67040}}
|-
|ON Clearwater Bay (west most)||  49.71355,-94.80772||17 390779.537m E 550911.6916m N||{{#wgs84_2mtm:  49.71355|-94.80772}}
|-
|MB West Hawk-Lake (east most)||  49.73702,-95.21027||17 361723.467m E 5511343.994m N||{{#wgs84_2mtm:  49.73702|-95.21027}}
|-
|MB Winnipeg||  49.89817,-97.14661||17 222429.529m E 552959.7319m N||{{#wgs84_2mtm:  49.89817|-97.14661}}
|-
|SK Regine||  50.45750,-104.67773||21m E m N||{{#wgs84_2mtm:  50.45750|-104.67773}}
|-
|SK Saaskatoon||  52.13349,-106.65527||23m E m N||{{#wgs84_2mtm:  52.13349|-106.65527}}
|-
|AL Edmonton||  53.51418,-113.46680||26m E m N||{{#wgs84_2mtm:  53.51418|-113.46680}}
|-
|BC Vancouver||  49.29647,-123.17871||26m E m N||{{#wgs84_2mtm:  49.29647|-123.17871}}
|-
|BC Victoria||  48.40003,-123.39844||26m E m N||{{#wgs84_2mtm:  48.40003|-123.39844}}
|-
|YK Ivvavik National Park (bug1)||  68.94261,-139.92188||32m E m N||{{#wgs84_2mtm:  68.94261|-139.92188}}
|-
!colspan=4|OSGB36 (Engeland Schotland)
|-
|<nowiki>{{#wgs84_2osgb: | }} </nowiki>
|colspan=3|https://www.ordnancesurvey.co.uk/business-government/tools-support/os-net/transformation
|-
|BLAC||+53.77911024, -3.04045509, 64.92||331534.552m E 431920.792m N 12.636m||{{#wgs84_2osgb:+53.77911024|-3.04045509|64.92}}
|-
|BRIS||+51.42754741, -2.54407636, 104.00||362269.979m E 169978.688m N 54.467m||{{#wgs84_2osgb:+51.42754741|-2.54407636| 104.00}}
|-
|BUT1||+58.51560358, -6.26091474, 114.94||151968.641m E 966483.777m N 58.836m||{{#wgs84_2osgb:+58.51560358|-6.26091474| 114.94}}
|-
|CARL||+54.89542338, -2.93827760, 93.51||339921.133m E 556034.759m N 41.077m||{{#wgs84_2osgb:+54.89542338|-2.93827760| 93.51}}
|-
|CARM||+51.85890893, -4.30852493, 81.33||241124.573m E 220332.638m N 27.59m||{{#wgs84_2osgb:+51.85890893|-4.30852493| 81.33}}
|-
|COLC||+51.89436636, +0.89724309, 75.26||599445.578m E 225722.824m N 30.192m||{{#wgs84_2osgb:+51.89436636|+0.89724309| 75.26}}
|-
|DARE||+53.34480278, -2.64049339, 88.38||357455.831m E 383290.434m N 36.75m||{{#wgs84_2osgb:+53.34480278|-2.64049339|88.38}}
|-
|DROI||+52.25529380, -2.15458632, 101.50||389544.178m E 261912.151m N 51.977m||{{#wgs84_2osgb:+52.25529380|-2.15458632| 101.50}}
|-
|EDIN||+55.92478264, -3.29479237, 119.01||319188.423m E 670947.532m N 66.362m||{{#wgs84_2osgb:+55.92478264|-3.29479237| 119.01}}
|-
|FLA1||+54.11685142, -0.07773152, 86.76||525745.658m E 470703.211m N 41.217m||{{#wgs84_2osgb:+54.11685142|-0.07773152|86.76}}
|-
|GIR1||+57.13902517, -2.04856051, 108.58||397160.479m E 805349.734m N 58.902m||{{#wgs84_2osgb:+57.13902517|-2.04856051| 108.58}}
|-
|GLAS||+55.85399950, -4.29649034, 71.57||256340.914m E 664697.266m N 17.414m||{{#wgs84_2osgb:+55.85399950|-4.29649034|71.57}}
|-
|INVE||+57.48624998, -4.21926418, 66.15||267056.756m E 846176.969m N 13.23m||{{#wgs84_2osgb:+57.48624998|-4.21926418|66.15}}
|-
|IOMN||+54.32919538, -4.38849135, 94.50||244780.625m E 495254.884m N 39.891m||{{#wgs84_2osgb:+54.32919538|-4.38849135| 94.50}}
|-
|IOMS||+54.08666316, -4.63452186, 84.37||227778.318m E 468847.386m N 29.335m||{{#wgs84_2osgb:+54.08666316|-4.63452186| 84.37}}
|-
|KING||+52.75136686, +0.40153529, 66.41||562180.535m E 319784.993m N 20.89m||{{#wgs84_2osgb:+52.75136686|+0.40153529|66.41}}
|-
|LEED||+53.80021518, -1.66379186, 215.59||422242.174m E 433818.699m N 165.891m||{{#wgs84_2osgb:+53.80021518|-1.66379186| 215.59}}
|-
|LIZ1||+49.96006136, -5.20304627, 124.23||170370.706m E 11572.404m N 71.222m||{{#wgs84_2osgb:+49.96006136|-5.20304627|124.23}}
|-
|LOND||+51.48936563, -0.11992573, 66.03||530624.963m E 178388.461m N 20.518m||{{#wgs84_2osgb:+51.48936563|-0.11992573| 66.03}}
|-
|LYN1||+53.41628513, -4.28918088, 100.76||247958.959m E 393492.906m N 46.314m||{{#wgs84_2osgb:+53.41628513|-4.28918088| 100.76}}
|-
|LYN2||+53.41630922, -4.28917811, 100.83||247959.229m E 393.49558m N 46.393m||{{#wgs84_2osgb:+53.41630922|-4.28917811|100.83}}
|-
|MALA||+57.00606694, -5.82836711, 68.49||167.63419m E 797067.142m N 13.19m||{{#wgs84_2osgb:+57.00606694|-5.82836711|68.49}}
|-
|NAS1||+51.40078217, -3.55128366, 112.34||292184.858m E 168003.462m N 60.615m||{{#wgs84_2osgb:+51.40078217|-3.55128366|112.34}}
|-
|NEWC||+54.97912271, -1.61657704, 125.85||424639.343m E 565.0127m N 76.551m||{{#wgs84_2osgb:+54.97912271|-1.61657704|125.85}}
|-
|NFO1||+51.37447024, +1.44454713, 99.40||639821.823m E 169565.856m N 55.11m||{{#wgs84_2osgb:+51.37447024|+1.44454713| 99.40}}
|-
|NORT||+52.25160949, -0.91248975, 131.57||474335.957m E 262047.752m N 83.961m||{{#wgs84_2osgb:+52.25160949|-0.91248975| 131.57}}
|-
|NOTT||+52.96219108, -1.19747674, 93.80||454002.822m E 340834.941m N 45.253m||{{#wgs84_2osgb:+52.96219108|-1.19747674|93.80}}
|-
|OSHQ||+50.93127936, -1.45051451, 100.38||438710.908m E 114792.248m N 54.029m||{{#wgs84_2osgb:+50.93127936|-1.45051451| 100.38}}
|-
|PLYM||+50.43885823, -4.10864582, 215.24||250359.798m E 62016.567m N 16.3081m||{{#wgs84_2osgb:+50.43885823|-4.10864582| 215.24}}
|-
|SCP1||+50.57563663, -1.29782294, 94.67||449816.359m E 75335.859m N 48.571m||{{#wgs84_2osgb:+50.57563663|-1.29782294|94.67}}
|-
|SUM1||+59.85409911, -1.27486932, 149.89||440725.061m E 1107878.445m N 100.991m||{{#wgs84_2osgb:+59.85409911|-1.27486932| 149.89}}
|-
|THUR||+58.58120459, -3.72631043, 98.62||299721.879m E 967.20299m N 46.011m||{{#wgs84_2osgb:+58.58120459|-3.72631043|98.62}}
|-
|Scilly||+49.92226390, -6.29977767, 100.36||91492.135m E 11318.801m N 46.882m||{{#wgs84_2osgb:+49.92226390|-6.29977767| 100.36}}
|-
|StKilda||+57.81351831, -8.57854470, 101.41||9587.897m E 899448.993m N 43.424m||{{#wgs84_2osgb:+57.81351831|-8.57854470| 101.41}}
|-
|Flannan||+58.21262243, -7.59255579, 140.27||71.71312m E 938516.401m N 83.594m||{{#wgs84_2osgb:+58.21262243|-7.59255579| 140.27}}
|-
|NorthRona||+59.09671614, -5.82799360, 140.56||180862.449m E 1029604.111m N 85.197m||{{#wgs84_2osgb:+59.09671614|-5.82799360|140.56}}
|-
|SuleSkerry||+59.09335032, -4.41757694, 99.90||261596.767m E 1025447.599m N 46.347m||{{#wgs84_2osgb:+59.09335032|-4.41757694|99.90}}
|-
|Foula||+60.13308089, -2.07382844, 140.60||395999.656m E 1138728.948m N 89.901m||{{#wgs84_2osgb:+60.13308089|-2.07382844| 140.60}}
|-
|FairIsle||+59.53470792, -1.62516987, 99.90||421300.513m E 1072147.236m N 50.951m||{{#wgs84_2osgb:+59.53470792|-1.62516987| 99.90}}
|-
|Orkney||+59.03743868, -3.21454022, 100.02||330398.311m E 1017347.013m N 47.978m||{{#wgs84_2osgb:+59.03743868|-3.21454022|100.02}}
|-
|Ork_Main(Ork)||+58.71893716, -3.07392625, 100.07||337898.195m E 981746.359m N 48.631m||{{#wgs84_2osgb:+58.71893716|-3.07392625|100.07}}
|-
|Ork_Main(Main)||+58.72108283, -3.13788308, 100.01||334198.101m E 982046.419m N 48.439m||{{#wgs84_2osgb:+58.72108283|-3.13788308|100.01}}
|-
|Ork_Main(Main)||+58.72108283, -3.13788308, 100.01||334198.101m E 982046.419m N 48.439m||{{#wgs84_2epsg:-3.13788308,+58.72108283,100.01|27700}}
|}

*UTM (WGS84)
**<nowiki>{{#lat_long2utm: | }} </nowiki>
**{{#wgs84_2utm:52.371|4.897}} Amsterdam
**{{#wgs84_2utm:50.846667|4.3525}} Brussel
**{{#wgs84_2utm:48.866667|2.333056}}  Parijs
**{{#wgs84_2utm:51.477811|-0.001475}} Londen
**{{#wgs84_2utm:46.95|7.45}} Bern
**{{#wgs84_2utm:60.1666666666667|24.9333333333333}} Helsinki
**{{#wgs84_2utm:60.45|22.25}} Turku
**{{#wgs84_2utm:49.29647|-123.17871}} BC Vancouver
**<nowiki>{{#lat_long2utm: | | }} </nowiki>
**{{#wgs84_2utm:60.1666666666667|24.9333333333333|35}} Helsinki
**{{#wgs84_2utm:60.45|22.25|35}} Turku

*Irish Grid - ((Noord) Ierland)
**<nowiki>{{{{#wgs84_2ig: | }} </nowiki>
**{{#wgs84_2ig:53.347778| -6.259722}} Dublin
**{{#wgs84_2ig:51.897222| -8.47}} Cork
**{{#wgs84_2ig:52| -8}}
**{{#wgs84_2ig:53.485269|-6.920534661}}

*Irish Transverse Mercator  - ((Noord) Ierland)
**<nowiki>{{{{#wgs84_2itm: | }} </nowiki>
**{{#wgs84_2itm:53.347778| -6.259722}} Dublin
**{{#wgs84_2itm:51.897222| -8.47}} Cork
**{{#wgs84_2itm:52| -8}}
**{{#wgs84_2itm:53.485269|-6.920534661}}

*LUREF - Luxemburg
**<nowiki>{{{{#wgs84_2luref: | }} </nowiki>
**{{#wgs84_2luref:49.731866667|6.798698056}}
**{{#wgs84_2luref:49.571556353|5.930748119}}
**{{#wgs84_2luref:49.611667|6.13}} Luxemburg stad';
		$out->addWikiTextAsInterface( $wikitext );
	}


	protected function getGroupName() {
		return 'other';
	}
}
