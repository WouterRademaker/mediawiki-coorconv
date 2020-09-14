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
!colspan=4| RD (Nederland)
|-
|<nowiki>{{#wgs84_2rd: | }} </nowiki>
|colspan=3|https://media.thomasv.nl/2015/07/Transformatieformules.pdf
|-
| Amsterdam (Westertoren)||52.37453253,4.88352559||x = 120700,723 m y = 487525,501 m||{{#wgs84_2rd:52.37453253|4.88352559}}
|-
|  Groningen (Martinitoren)||53.21938317,6.56820053||x = 233883,131 m y = 582065,167 m||{{#wgs84_2rd:53.21938317|6.56820053}}
|-
!colspan=4| LB08 (België)
|-
|<nowiki>{{#wgs84_2lb08: | }} </nowiki>
|colspan=3|http://www.ngi.be/Common/Lambert2008/Transformation_Geographic_Lambert_NL.pdf
|-
|Brussel (Paleizenplein)||50.842442,4.3643||x = 649686.07 m y = 670226.23 m ||{{#wgs84_2lb08:50.842442|4.3643}}
|-
|Arlon (Butte Saint-Donat)||49.685034,5.816257||x = 754469.25 m y = 542520.00 m||{{#wgs84_2lb08:49.685034|5.816257}}
|-
!colspan=4| CH03 (Suisse)
|-
|<nowiki>{{#wgs84_2ch03: | }} </nowiki>
|colspan=3|LV03
|-
|Genève||46.20580, 6.14243, 425.015||y = 	499959.81 m, x = 117977.95 m, z= 375.2||{{#wgs84_2ch03:	46.20580| 6.14243|425.015}}
|-
|Bern||46.951082877, 7.438632495||y= 600000.000 m, x= 200000.000||{{#wgs84_2ch03:	46.951082877| 7.438632495}}
|-
|Reference||46.044120951, 8.730497384, 650.60||y= 700000.000 m, x= 100000.000, z= 600||{{#wgs84_2ch03:	46.044120951| 8.730497384|650.60}}
|-
|<nowiki>{{#wgs84_2ch03p: | }} </nowiki>
|colspan=3|LV95
|-
|Genève||46.20580, 6.14243, 425.015||y = 	2499959.81 m, x = 1117977.95 m, z= 375.2||{{#wgs84_2ch03p:	46.20580| 6.14243|425.015}}
|-
|Bern||46.951082877, 7.438632495||y= 2600000.000 m, x= 1200000.000||{{#wgs84_2ch03p:	46.951082877| 7.438632495}}
|-
|Reference||46.044120951, 8.730497384, 650.60||y= 2700000.000 m, x= 1100000.000, z= 600||{{#wgs84_2ch03p:	46.044120951| 8.730497384|650.60}}
|-
!colspan=4| LB93 (France)
|-
|<nowiki>{{{{#wgs84_2lb93: | }} </nowiki>
|colspan=3|
|-
|Paris||48.866667,2.333056||x =  m y =  m ||{{#wgs84_2lb08:48.866667|2.333056}}
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

*ETRS-TM35FIN (Finland)
**<nowiki>{{#wgs84_2tm35fin: | }} </nowiki>
**{{#wgs84_2tm35fin:60.1666666666667|24.9333333333333}} Helsinki
**{{#wgs84_2tm35fin:60.45|22.25}} Turku

*mtm / SCOPQ (Canada)
**<nowiki>{{#wgs84_2mtm: | }} </nowiki>
**{{#wgs84_2mtm:47.53204|-52.80029}} NF Mt Pearl
**{{#wgs84_2mtm:48.96579|-54.62402}} NF Gander
**{{#wgs84_2mtm:51.42961|-57.05956}} NF L&apos;Anse Au Clair
**{{#wgs84_2mtm:51.42768|-57.15363}} QC Blanc Sablon (east most)
**{{#wgs84_2mtm:48.95137|-57.96387}} NF Corner Brook
**{{#wgs84_2mtm:46.19504|-59.96338}} NS Glace Bay
**{{#wgs84_2mtm:53.29806|-60.35889}} NF Goose Bay
**{{#wgs84_2mtm:47.45409|-61.75415}} QC Iles De La Madeleine
**{{#wgs84_2mtm:50.17866|-61.81183}} QC Natashquan
**{{#wgs84_2mtm:46.43786|-62.00684}} PE East most
**{{#wgs84_2mtm:44.64521|-63.58887}} NS Halifax
**{{#wgs84_2mtm:46.69467|-64.41284}} PE West most
**{{#wgs84_2mtm:48.82857|-64.47327}} QC Gaspe
**{{#wgs84_2mtm:46.10371|-64.77539}} NB Moncton
**{{#wgs84_2mtm:43.82660|-66.12671}} NS Yarmouth (bug2)
**{{#wgs84_2mtm:47.99521|-66.71310}} NB Atholville
**{{#wgs84_2mtm:48.01955|-66.72512}} QC Restigouche
**{{#wgs84_2mtm:47.36487|-68.32947}} NB Edmundston
**{{#wgs84_2mtm:48.53116|-68.35144}} QC Mont-Joli
**{{#wgs84_2mtm:58.09984|-68.40569}} QC Kuujjuaq
**{{#wgs84_2mtm:63.75126|-68.52456}} NW Iqaluit
**{{#wgs84_2mtm:48.30877|-68.85132}} QC St-Fabien
**{{#wgs84_2mtm:48.42191|-71.06506}} QC Chicoutimi
**{{#wgs84_2mtm:46.81510|-71.23810}} QC Quebec
**{{#wgs84_2mtm:45.53088|-73.51158}} QC Longueuil
**{{#wgs84_2mtm:45.30109|-74.45881}} QC Dalhousie
**{{#wgs84_2mtm:45.31643|-74.47117}} ON Dalhousie Mills (east most)
**{{#wgs84_2mtm:45.01919|-74.73450}} ON Cornwall
**{{#wgs84_2mtm:45.41846|-75.70026}} ON Ottawa
**{{#wgs84_2mtm:45.45724|-75.72876}} QC Gatineau
**{{#wgs84_2mtm:44.22946|-76.48682}} ON Kingston
**{{#wgs84_2mtm:48.23839|-79.02260}} QC Rouyn-Noranda
**{{#wgs84_2mtm:43.67184|-79.39270}} ON Toronto
**{{#wgs84_2mtm:46.31658|-79.47510}} ON North Bay
**{{#wgs84_2mtm:48.86686|-79.51080}} QC La Reine (west most)
**{{#wgs84_2mtm:46.47948|-80.99327}} ON Sudbury (bug3)
**{{#wgs84_2mtm:45.90000|-81.10000}} ON Zone 11 (south of Sudbury)
**{{#wgs84_2mtm:45.97424|-81.50997}} ON Killarny (zone 11)
**{{#wgs84_2mtm:48.48749|-81.34277}} ON Timmins
**{{#wgs84_2mtm:41.78463|-82.67040}} ON Pelee (Canada south most)
**{{#wgs84_2mtm:49.71355|-94.80772}} ON Clearwater Bay (west most)
**{{#wgs84_2mtm:49.73702|-95.21027}} MB West Hawk-Lake (east most)
**{{#wgs84_2mtm:49.89817|-97.14661}} MB Winnipeg
**{{#wgs84_2mtm:50.45750|-104.67773}} SK Regine
**{{#wgs84_2mtm:52.13349|-106.65527}} SK Saaskatoon
**{{#wgs84_2mtm:53.51418|-113.46680}} AL Edmonton
**{{#wgs84_2mtm:49.29647|-123.17871}} BC Vancouver
**{{#wgs84_2mtm:48.40003|-123.39844}} BC Victoria
**{{#wgs84_2mtm:68.94261|-139.92188}} YK Ivvavik National Park (bug1)

*OSGB36 (Engeland Schotland)
**<nowiki>{{#wgs84_2osgb: | }} </nowiki>
**{{#wgs84_2osgb:51.477811|-0.001475}} Londen
**{{#wgs84_2osgb:50.75|-2.75}}
**{{#wgs84_2osgb:57.474497|-4.224243}} Inverness
**{{#wgs84_2osgb:60.5|-9.2}} test

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
