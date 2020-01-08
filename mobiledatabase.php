<?php
/**
 * This file contains contents that would otherwise be stored in a database, as well as, some global variables and definitions.
 *
 * @package		DamageCALC
 * @author		Michael McStay <XYZ>
 * @license		https://opensource.org/licenses/GPL-3.0 GNU General Public License 3
 * @version		1.0
 * @since		1.0
 */
/**
 * GLOBALS AND DEFINITIONS ----------------------------------------//
 */
// check to see if the protocol is secure or not
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
// check to see what domain the software is hosted on
$domain = $_SERVER['HTTP_HOST'];
// this establishes a reliable root path so that files in other folders can reliably access other files without the need for backtracking
define('APP_PATH', $protocol . $domain . '/');
// define the number required to resolving caching issues of external files
define('CACHE', 16);
// define the title of the web page
define('TITLE', 'Damage Calculator');
// add the helper class to mobiledatabase
require_once('controllers/Helper.php');
require_once('controllers/Skill.php');

/**
 * ATTACKING PROPERTY ---------------------------------------------//
 */
$AttackingPropertyList = array(
	array('value' => 0, 'name' => 'Neutral'),
	array('value' => 1, 'name' => 'Water'),
	array('value' => 2, 'name' => 'Earth'),
	array('value' => 3, 'name' => 'Fire'),
	array('value' => 4, 'name' => 'Wind'),
	array('value' => 5, 'name' => 'Poison'),
	array('value' => 6, 'name' => 'Holy'),
	array('value' => 7, 'name' => 'Shadow'),
	array('value' => 8, 'name' => 'Ghost'),
	array('value' => 9, 'name' => 'Undead')
);

/**
 * BOOLEAN --------------------------------------------------------//
 */
$BooleanList = array('No', 'Yes');

/**
 * CHANGE PROPERTY ------------------------------------------------//
 */
$ChangePropertyList = array(
	array('value' => 0, 'name' => 'N/A'),
	array('value' => 20, 'name' => 'Neutral'),
	array('value' => 21, 'name' => 'Water'),
	array('value' => 22, 'name' => 'Earth'),
	array('value' => 23, 'name' => 'Fire'),
	array('value' => 24, 'name' => 'Wind'),
	array('value' => 25, 'name' => 'Poison'),
	array('value' => 26, 'name' => 'Holy'),
	array('value' => 27, 'name' => 'Shadow'),
	array('value' => 28, 'name' => 'Ghost'),
	array('value' => 29, 'name' => 'Undead')
);

/**
 * PROPERTY -------------------------------------------------------//
 */
$PropertyList = array(
	array('id' => 0, 'name' => 'N/A', 'damagescale' => '100,100,100,100,100,100,100,100,100,100'),
	array('id' => 20, 'name' => 'Level 1 Neutral', 'damagescale' => '100,100,100,100,100,100,100,100,70,100'),
	array('id' => 21, 'name' => 'Level 1 Water', 'damagescale' => '100,25,100,90,175,100,100,100,100,100'),
	array('id' => 22, 'name' => 'Level 1 Earth', 'damagescale' => '100,100,25,150,90,125,100,100,100,100'),
	array('id' => 23, 'name' => 'Level 1 Fire', 'damagescale' => '100,150,90,25,100,125,100,100,100,100'),
	array('id' => 24, 'name' => 'Level 1 Wind', 'damagescale' => '100,90,150,100,25,125,100,100,100,100'),
	array('id' => 25, 'name' => 'Level 1 Poison', 'damagescale' => '100,100,100,100,100,0,100,50,100,50'),
	array('id' => 26, 'name' => 'Level 1 Holy', 'damagescale' => '100,75,75,75,75,75,0,125,75,100'),
	array('id' => 27, 'name' => 'Level 1 Shadow', 'damagescale' => '100,100,100,100,100,50,125,0,75,0'),
	array('id' => 28, 'name' => 'Level 1 Ghost', 'damagescale' => '70,100,100,100,100,100,100,100,125,100'),
	array('id' => 29, 'name' => 'Level 1 Undead', 'damagescale' => '100,100,100,125,100,-25,150,-25,100,0'),
	array('id' => 40, 'name' => 'Level 2 Neutral', 'damagescale' => '100,100,100,100,100,100,100,100,50,100'),
	array('id' => 41, 'name' => 'Level 2 Water', 'damagescale' => '100,0,100,80,175,75,100,100,75,75'),
	array('id' => 42, 'name' => 'Level 2 Earth', 'damagescale' => '100,100,0,175,80,125,100,100,75,75'),
	array('id' => 43, 'name' => 'Level 2 Fire', 'damagescale' => '100,175,90,0,100,125,100,100,75,75'),
	array('id' => 44, 'name' => 'Level 2 Wind', 'damagescale' => '100,80,175,100,0,125,100,100,75,75'),
	array('id' => 45, 'name' => 'Level 2 Poison', 'damagescale' => '100,100,100,100,100,0,100,25,75,25'),
	array('id' => 46, 'name' => 'Level 2 Holy', 'damagescale' => '100,50,50,50,50,50,-25,150,50,125'),
	array('id' => 47, 'name' => 'Level 2 Shadow', 'damagescale' => '100,75,75,75,75,25,150,-25,50,0'),
	array('id' => 48, 'name' => 'Level 2 Ghost', 'damagescale' => '50,100,100,100,100,75,100,100,150,100'),
	array('id' => 49, 'name' => 'Level 2 Undead', 'damagescale' => '100,100,100,150,100,-50,175,-50,125,0'),
	array('id' => 60, 'name' => 'Level 3 Neutral', 'damagescale' => '100,100,100,100,100,100,100,100,0,100'),
	array('id' => 61, 'name' => 'Level 3 Water', 'damagescale' => '100,-25,100,70,200,50,100,100,50,50'),
	array('id' => 62, 'name' => 'Level 3 Earth', 'damagescale' => '100,100,-25,200,70,100,100,100,50,50'),
	array('id' => 63, 'name' => 'Level 3 Fire', 'damagescale' => '100,200,70,-25,100,100,100,100,50,50'),
	array('id' => 64, 'name' => 'Level 3 Wind', 'damagescale' => '100,70,200,100,-25,100,100,100,50,50'),
	array('id' => 65, 'name' => 'Level 3 Poison', 'damagescale' => '100,100,100,100,100,0,125,0,50,0'),
	array('id' => 66, 'name' => 'Level 3 Holy', 'damagescale' => '100,25,25,25,25,25,-50,175,25,150'),
	array('id' => 67, 'name' => 'Level 3 Shadow', 'damagescale' => '100,50,50,50,50,0,175,-50,25,0'),
	array('id' => 68, 'name' => 'Level 3 Ghost', 'damagescale' => '0,100,100,100,100,50,100,100,175,100'),
	array('id' => 69, 'name' => 'Level 3 Undead', 'damagescale' => '100,125,100,175,100,-75,200,-75,150,0'),
	array('id' => 80, 'name' => 'Level 4 Neutral', 'damagescale' => '100,100,100,100,100,100,100,100,0,100'),
	array('id' => 81, 'name' => 'Level 4 Water', 'damagescale' => '100,-50,100,60,200,25,75,75,25,25'),
	array('id' => 82, 'name' => 'Level 4 Earth', 'damagescale' => '100,100,-50,200,60,75,75,75,25,25'),
	array('id' => 83, 'name' => 'Level 4 Fire', 'damagescale' => '100,200,60,-50,100,75,75,75,25,25'),
	array('id' => 84, 'name' => 'Level 4 Wind', 'damagescale' => '100,60,200,100,-50,75,75,75,25,25'),
	array('id' => 85, 'name' => 'Level 4 Poison', 'damagescale' => '100,75,75,75,75,0,125,-25,25,-25'),
	array('id' => 86, 'name' => 'Level 4 Holy', 'damagescale' => '100,0,0,0,0,0,-100,200,0,175'),
	array('id' => 87, 'name' => 'Level 4 Shadow', 'damagescale' => '100,25,25,25,25,-25,200,-100,0,0'),
	array('id' => 88, 'name' => 'Level 4 Ghost', 'damagescale' => '0,100,100,100,100,25,100,100,200,100'),
	array('id' => 89, 'name' => 'Level 4 Undead', 'damagescale' => '100,150,50,200,100,-100,200,-100,175,0')
);

/**
 * RACE -----------------------------------------------------------//
 */
$RaceList = array('Formless', 'Undead', 'Brute', 'Plant', 'Insect', 'Fish', 'Demon', 'Demi-Human', 'Angel', 'Dragon');

/**
 * REFINEMENT BONUS -----------------------------------------------//
 */
$RefinementBonusList = array(
	array('level' => 1, 'bonus' => 2, 'overupgrade' => 3, 'high' => 12, 'limit' => 7),
	array('level' => 2, 'bonus' => 3, 'overupgrade' => 5, 'high' => 24, 'limit' => 6),
	array('level' => 3, 'bonus' => 5, 'overupgrade' => 8, 'high' => 36, 'limit' => 5),
	array('level' => 4, 'bonus' => 7, 'overupgrade' => 14, 'high' => 48, 'limit' => 4)
);

/**
 * SIZE -----------------------------------------------------------//
 */
$SizeList = array('Small', 'Medium', 'Large');

/**
 * SKILL ----------------------------------------------------------//
 */
$SkillList = array(
	array('value' => 0, 'name' => 'Basic Attack', 'from' => 1, 'to' => 1, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 83, 'name' => 'Meteor Storm', 'from' => 1, 'to' => 10, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 86, 'name' => 'Water Ball', 'from' => 1, 'to' => 10, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 382, 'name' => 'Focused Arrow Strike', 'from' => 1, 'to' => 5, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 406, 'name' => 'Meteor Assault', 'from' => 1, 'to' => 10, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 490, 'name' => 'Acid Bomb', 'from' => 1, 'to' => 10, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2022, 'name' => 'Cross Impact', 'from' => 1, 'to' => 5, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2029, 'name' => 'Counter Slash', 'from' => 1, 'to' => 5, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2036, 'name' => 'Rolling Cutter', 'from' => 1, 'to' => 5, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2037, 'name' => 'Cross Ripper Slasher', 'from' => 1, 'to' => 5, 'extra1' => 'Rolling Cutter Count', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2202, 'name' => 'Soul Expansion', 'from' => 1, 'to' => 5, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2204, 'name' => 'Jack Frost', 'from' => 1, 'to' => 5, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2211, 'name' => 'Crimson Rock', 'from' => 1, 'to' => 5, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2214, 'name' => 'Chain Lightning', 'from' => 1, 'to' => 5, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2216, 'name' => 'Earth Strain', 'from' => 1, 'to' => 5, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2233, 'name' => 'Arrow Storm', 'from' => 1, 'to' => 10, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2236, 'name' => 'Aimed Bolt', 'from' => 1, 'to' => 10, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2239, 'name' => 'Bomb Cluster', 'from' => 1, 'to' => 5, 'extra1' => 'Trap Research Level', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2243, 'name' => 'Warg Strike', 'from' => 1, 'to' => 5, 'extra1' => 'Tooth of Warg Level', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2244, 'name' => 'Warg Bite', 'from' => 1, 'to' => 5, 'extra1' => 'Tooth of Warg Level', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2253, 'name' => 'Fire Trap', 'from' => 1, 'to' => 5, 'extra1' => 'Trap Research Level', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2254, 'name' => 'Ice Trap', 'from' => 1, 'to' => 5, 'extra1' => 'Trap Research Level', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2443, 'name' => 'Electric Walk', 'from' => 1, 'to' => 5, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2444, 'name' => 'Fire Walk', 'from' => 1, 'to' => 5, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2445, 'name' => 'Spell Fist', 'from' => 1, 'to' => 5, 'extra1' => 'Casted Bolt Level', 'extra2' => 'Bolt Damage Bonus', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2446, 'name' => 'Earth Grave', 'from' => 1, 'to' => 5, 'extra1' => 'Endow Quake Level', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2447, 'name' => 'Diamond Dust', 'from' => 1, 'to' => 5, 'extra1' => 'Endow Tsunami Level', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2448, 'name' => 'Poison Burst', 'from' => 1, 'to' => 5, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2449, 'name' => 'Psychic Wave', 'from' => 1, 'to' => 5, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2450, 'name' => 'Killing Cloud', 'from' => 1, 'to' => 5, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2454, 'name' => 'Varetyr Spear', 'from' => 1, 'to' => 5, 'extra1' => 'Striking Level', 'extra2' => 'Endow Tornado Level', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2477, 'name' => 'Cart Cannon', 'from' => 1, 'to' => 5, 'extra1' => 'Cart Remodeling Level', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2565, 'name' => 'Round Trip', 'from' => 1, 'to' => 5, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2567, 'name' => 'Fire Rain', 'from' => 1, 'to' => 5, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 2570, 'name' => 'Slug Shot', 'from' => 1, 'to' => 5, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 5026, 'name' => 'Silvervine Stem Spear', 'from' => 1, 'to' => 1, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 5028, 'name' => 'Catnip Meteor', 'from' => 1, 'to' => 5, 'extra1' => '', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 5033, 'name' => 'Picky Peck', 'from' => 1, 'to' => 5, 'extra1' => 'Remaining HP %', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 5036, 'name' => 'Lunatic Carrot Beat', 'from' => 1, 'to' => 5, 'extra1' => 'Remaining HP %', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
	array('value' => 5046, 'name' => 'Spirit of Savage', 'from' => 1, 'to' => 5, 'extra1' => 'Remaining HP %', 'extra2' => '', 'extra3' => '', 'extra4' => '', 'extra5' => '', 'extra6' => ''),
);

/**
 * WEAPON SIZE MODIFIER -------------------------------------------//
 */
$WeaponSizeModifierList = array(
	array('value' => 0, 'name' => 'Bare Handed', 'damage' => '100,100,100'),
	array('value' => 1, 'name' => 'Dagger', 'damage' => '100,75,50'),
	array('value' => 2, 'name' => 'One-Handed Sword', 'damage' => '75,100,75'),
	array('value' => 3, 'name' => 'Two-Handed Sword', 'damage' => '75,75,100'),
	array('value' => 4, 'name' => 'Spear', 'damage' => '75,75,100'),
	array('value' => 5, 'name' => 'Spear (Peco Peco/Gryphon Mounted)', 'damage' => '75,100,100'),
	array('value' => 6, 'name' => 'Spear (Dragon Mounted)', 'damage' => '100,100,100'),
	array('value' => 7, 'name' => 'Axe', 'damage' => '50,75,100'),
	array('value' => 8, 'name' => 'Mace', 'damage' => '75,100,100'),
	array('value' => 9, 'name' => 'Staff', 'damage' => '100,100,100'),
	array('value' => 10, 'name' => 'Bow', 'damage' => '100,100,75'),
	array('value' => 11, 'name' => 'Katar', 'damage' => '75,100,75'),
	array('value' => 12, 'name' => 'Book', 'damage' => '100,100,50'),
	array('value' => 13, 'name' => 'Knuckle', 'damage' => '100,75,50'),
	array('value' => 14, 'name' => 'Instrument', 'damage' => '75,100,75'),
	array('value' => 15, 'name' => 'Whip', 'damage' => '75,100,50'),
	array('value' => 16, 'name' => 'Gun', 'damage' => '100,100,100'),
	array('value' => 17, 'name' => 'Huuma Shuriken', 'damage' => '75,75,100'),
	array('value' => 18, 'name' => 'Summoner Staff', 'damage' => '100,100,100')
);
?>