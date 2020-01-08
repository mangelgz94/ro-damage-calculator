<?php
/**
 * This file is designed to accurately replicate damage calculations used in Ragnarok Online.
 *
 * @package		DamageCALC
 * @author		Michael McStay <XYZ>
 * @license		https://opensource.org/licenses/GPL-3.0 GNU General Public License 3
 * @version		1.0
 * @since		1.0
 */
// add the mobiledatabase to calculator
require_once('mobiledatabase.php');
// get the url used as the default link
// echo $_SERVER['QUERY_STRING'];

/**
 * CALCULATOR -----------------------------------------------------//
 */

if(!isset($_GET['b1']))
{
	header('Location: ' . APP_PATH . '?a1=2413&a2=0&a3=0&a4=0&a5=0&a6=0&a7=0&a8=0&a9=0&a10=0&a11=0&a12=0&a13=0&a14=0&l1=0&l2=1&l3=0&l4=0&l5=0&l6=0&l7=0&l8=0&l9=0&y1=0&z1=&b1=1&b2=1&b3=1&b4=1&b5=1&b6=1&b7=1&b8=1&c1=0&c2=0&c3=0&c4=1&c5=0&d1=0&d2=0&d3=0&d4=0&e1=0&e3=0&e4=0&e5=0&e6=0&e7=0&e8=0&e9=0&e10=0&e11=0&e12=0&e13=0&f1=0&f2=0&f3=0&f4=0&f5=0&f6=0&f7=0&f8=0&f9=0&f10=0&f11=0&f12=0&i1=0&i2=0&i3=0&i4=0&j1=0&j2=0&j3=0&j4=0&k1=0&k2=0&k3=0&k4=0&k5=0&k6=0&k7=0');
}
else
{
	/**
	 * LOCAL VARIABLES ------------------------------------------------//
	 */
	// Target
	$TargetId = $a1 = (int)$_GET['a1'];
	$TargetCustomProperty = $a2 = (int)$_GET['a2'];
	$isPlayer = $a3 = (int)$_GET['a3'];
	$isDoram = $a4 = (int)$_GET['a4'];
	$TargetCustomHardDef = $a5 = (int)$_GET['a5'];
	$TargetCustomSoftDef = $a6 = (int)$_GET['a6'];
	$TargetCustomHardMdef = $a7 = (int)$_GET['a7'];
	$TargetCustomSoftMdef = $a8 = (int)$_GET['a8'];
	$SizeReduction = $a9 = (int)$_GET['a9'];
	$RaceReduction = $a10 = (int)$_GET['a10'];
	$PropertyReduction = $a11 = (int)$_GET['a11'];
	$TargetPropertyReduction = $a12 = (int)$_GET['a12'];
	$RangedDamageReduction = $a13 = (int)$_GET['a13'];
	$TotalDamageReduction = $a14 = (int)$_GET['a14'];

	// Player
	$BaseLevel = $b1 = (int)$_GET['b1'];
	$JobLevel = $b2 = (int)$_GET['b2'];
	$STR = $b3 = (int)$_GET['b3'];
	$AGI = $b4 = (int)$_GET['b4'];
	$VIT = $b5 = (int)$_GET['b5'];
	$INT = $b6 = (int)$_GET['b6'];
	$DEX = $b7 = (int)$_GET['b7'];
	$LUK = $b8 = (int)$_GET['b8'];

	$WeaponType = $c1 = (int)$_GET['c1'];
	$WeaponBaseDamage = $c2 = (int)$_GET['c2'];
	$WeaponBaseMagicDamage = $c3 = (int)$_GET['c3'];
	$WeaponLevel = $c4 = (int)$_GET['c4'];
	$WeaponRefinement = $c5 = (int)$_GET['c5'];

	$AttackingProperty = $d1 = (int)$_GET['d1'];
	$StatusAttackProperty = $d2 = (int)$_GET['d2'];
	$ResistDrop = $d3 = (int)$_GET['d3'];
	$ElementalDamageBoost = $d4 = (int)$_GET['d4'];

	$EquipATK = $e1 = (int)$_GET['e1'];
	$AmmunitionATK = $AmmunitionATK2 = $e3 = (int)$_GET['e3'];
	$PseudoAttack = $e4 = (int)$_GET['e4'];
	$PureAttackMultiplier = $e5 = (int)$_GET['e5'];
	$RaceMultiplier = $e6 = (int)$_GET['e6'];
	$SizeMultiplier = $e7 = (int)$_GET['e7'];
	$TargetPropertyMultiplier = $e8 = (int)$_GET['e8'];
	$MonsterFamilyMultiplier = $e9 = (int)$_GET['e9'];
	$AttackMultiplier = $e10 = (int)$_GET['e10'];
	$BossAttackMultiplier = $e11 = (int)$_GET['e11'];
	$MasteryAttack = $e12 = (int)$_GET['e12'];
	$BuffAttack = $e13 = (int)$_GET['e13'];

	$EquipMATK = $f1 = (int)$_GET['f1'];
	$PseudoMATK = $f2 = (int)$_GET['f2'];
	$PureMagicAttackMultiplier = $f3 = (int)$_GET['f3'];
	$RaceMagicMultiplier = $f4 = (int)$_GET['f4'];
	$SizeMagicMultiplier = $f5 = (int)$_GET['f5'];
	$TargetPropertyMagicMultiplier = $f6 = (int)$_GET['f6'];
	$MonsterFamilyMagicMultiplier = $f7 = (int)$_GET['f7'];
	$MagicAttackMultiplier = $f8 = (int)$_GET['f8'];
	$BossMagicAttackMultiplier = $f9 = (int)$_GET['f9'];
	$MagicElementMultiplier = $f10 = (int)$_GET['f10'];
	$MasteryMagicAttack = $f11 = (int)$_GET['f11'];
	$BuffMagicAttack = $f12 = (int)$_GET['f12'];

	$CriticalMultiplier = $i1 = (int)$_GET['i1'];
	$RangedMultiplier = $i2 = (int)$_GET['i2'];
	$AdditionalSkillDamage = $i3 = (int)$_GET['i3'];
	$TotalDamageMultiplier = $i4 = (int)$_GET['i4'];

	$HardDefReduction = $j1 = (int)$_GET['j1'];
	$SoftDefReduction = $j2 = (int)$_GET['j2'];
	$HardMdefReduction = $j3 = (int)$_GET['j3'];
	$SoftMdefReduction = $j4 = (int)$_GET['j4'];

	$isOccultImpaction = $k1 = (int)$_GET['k1'];
	$isFrenzy = $k2 = (int)$_GET['k2'];
	$EnchantDeadlyPoison = $k3 = (int)$_GET['k3'];
	$isWeaponPerfection = $k4 = (int)$_GET['k4'];
	$isPowerMaximize = $k5 = (int)$_GET['k5'];
	$isRecognizedSpell = $k6 = (int)$_GET['k6'];
	$isMagnumBreak = $k7 = (int)$_GET['k7'];

	// Skills
	$SkillName = $l1 = (int)$_GET['l1'];
	$SkillLevel = $l2 = (int)$_GET['l2'];
	$SkillDamageBonus = $l3 = (int)$_GET['l3'];
	$Extra1 = $l4 = (int)$_GET['l4'];
	$Extra2 = $l5 = (int)$_GET['l5'];
	$Extra3 = $l6 = (int)$_GET['l6'];
	$Extra4 = $l7 = (int)$_GET['l7'];
	$Extra5 = $l8 = (int)$_GET['l8'];
	$Extra6 = $l9 = (int)$_GET['l9'];

	// reset all of the skill parameters if the skill has changed, default skill level to 1
	if($l1 !== (int)$_GET['y1'])
	{
		$SkillDamageBonus = $l3 = $Extra = $l4 = $Extra2 = $l5 = $Extra3 = $l6 = $Extra4 = $l7 = $Extra5 = $l8 = $Extra6 = $l9 = 0;
		$SkillLevel = $l2 = 1;
	}

	/**
	 * TARGET ---------------------------------------------------------//
	 */
	/**
	 * LOCAL VARIABLES ------------------------------------------------//
	 */
	// sets an offline target
	$TargetName = 'Test Egg (Offline Mode)';
	$TargetLevel = 10;
	$TargetAgi = 0;
	$TargetVit = 0;
	$TargetInt = 0;
	$TargetDex = 0;
	$TargetHardDef = 0;
	$TargetSoftDef = Helper::TrueFloor(($TargetLevel / 2) + ($TargetVit / 2));
	$TargetHardMdef = 0;
	$TargetSoftMdef = $TargetInt + Helper::TrueFloor($TargetVit / 5) + Helper::TrueFloor($TargetDex / 5) + Helper::TrueFloor($TargetLevel / 4);
	$TargetDefendingProperty = !$TargetCustomProperty ? 23 : $TargetCustomProperty;
	$TargetSize = 1;
	$TargetRace = 0;
	$isBoss = 1;
	// attempts to obtain monster data from divine pride
	$obj = @file_get_contents('http://www.divine-pride.net/api/database/Monster/' . $TargetId . '?apiKey=YOUR_PERSONAL_DP_API_KEY');
	$obj = json_decode($obj);
	// checks to see if any data was returned from divine pride
	if(!is_null($obj))
	{
		$TargetName = $obj->name;
		$TargetLevel = $obj->stats->level;
		$TargetAgi = $obj->stats->agi;
		$TargetVit = $obj->stats->vit;
		$TargetInt = $obj->stats->int;
		$TargetDex = $obj->stats->dex;
		$TargetHardDef = $obj->stats->defense;
		$TargetSoftDef = Helper::TrueFloor(($TargetLevel / 2) + ($TargetVit / 2));
		$TargetHardMdef = $obj->stats->magicDefense;
		$TargetSoftMdef = Helper::TrueFloor(($TargetLevel / 4) + ($TargetInt / 4));
		$TargetDefendingProperty = !$TargetCustomProperty ? $obj->stats->element : $TargetCustomProperty;
		$TargetSize = $obj->stats->scale;
		$TargetRace = $obj->stats->race;
		$isBoss = $obj->stats->mvp || $obj->stats->class ? 1 : 0;
	}
	// overrides divine pride data with custom data for pvp scenarios
	if($isPlayer)
	{
		$TargetName = 'Player';
		$TargetHardDef = $TargetCustomHardDef;
		$TargetSoftDef = $TargetCustomSoftDef;
		$TargetHardMdef = $TargetCustomHardMdef;
		$TargetSoftMdef = $TargetCustomSoftMdef;
		$TargetDefendingProperty = !$TargetCustomProperty ? 20 : $TargetCustomProperty;
		$TargetSize = !$isDoram ? 1 : 0;
		$TargetRace = !$isDoram ? 7 : 2;
		$isBoss = 0;
	}
	$TargetDefendingProperty = Helper::GetProperty($TargetDefendingProperty);

	/**
	 * STATUS ATTACK --------------------------------------------------//
	 */
	if(!Helper::RangedWeapon($WeaponType))
	{
		// calculates the status attack for short-ranged damage
		$StatusATK = Helper::TrueFloor(($BaseLevel / 4) + $STR + ($DEX / 5) + ($LUK / 3));
	}
	else
	{
		// calculates the status attack for long-ranged damage
		$StatusATK = Helper::TrueFloor(($BaseLevel / 4) + ($STR / 5) + $DEX + ($LUK / 3));
	}
	// calculates the status attack for magical damage
	$StatusMATK = Helper::TrueFloor(Helper::TrueFloor($BaseLevel / 4) + $INT + Helper::TrueFloor($INT / 2) + Helper::TrueFloor($DEX / 5) + Helper::TrueFloor($LUK / 3));

	/**
	 * WEAPON DETAILS -------------------------------------------------//
	 */
	// obtains the weapon upgrade bonuses
	$RefinementBonus = Helper::GetRefinementBonus($WeaponLevel, $WeaponRefinement);
	// calculates the short and long ranged damage variance
	$Variance = 0.05 * $WeaponLevel * $WeaponBaseDamage;
	$VarianceLow = $isPowerMaximize == 1 ? $Variance : (-1 * abs($Variance));
	// calculates the stat bonus for short or long-ranged damage
	$StatBonus = !Helper::RangedWeapon($WeaponType) ? $WeaponBaseDamage * $STR / 200 : $WeaponBaseDamage * $DEX / 200;
	// this bonus is not applicable to ranged weapons due to a bug
	$OverUpgradeBonus = !Helper::RangedWeapon($WeaponType) ? $RefinementBonus['overupgrade'] : 0;
	// adds a minimum of 1 extra damage to the lower end spectrum of damage if there is any upgrade to the weapon whatsoever
	$OverUpgradeBonusLow = !Helper::RangedWeapon($WeaponType) && $WeaponRefinement > $RefinementBonusList[$WeaponLevel - 1]['limit'] ? 1 : 0;
	// obtains the weapon size penalty
	$WeaponSizeModifier = explode(',', $WeaponSizeModifierList[$WeaponType]['damage']);
	$SizePenaltyMultiplier = $isWeaponPerfection == 1 ? 1 : $WeaponSizeModifier[$TargetSize] / 100;
	// obtains the variables required for the enchant deadly poison calculation
	$EDPBonus = Helper::EDPBonus($EnchantDeadlyPoison);
	// calculates the short and long ranged weapon attack
	$WeaponATK = Helper::TrueFloor($WeaponBaseDamage + $RefinementBonus['bonus'] + $Variance + $StatBonus + $OverUpgradeBonus);
	$WeaponATKLow = Helper::TrueFloor($WeaponBaseDamage + $RefinementBonus['bonus'] + $VarianceLow + $StatBonus + $OverUpgradeBonusLow);
	$WeaponATKLowCritical = Helper::TrueFloor($WeaponBaseDamage + $RefinementBonus['bonus'] + $Variance + $StatBonus + $OverUpgradeBonusLow);

	// calculates the magical damage variance
	// uses different formulas depending on whether or not the weapon has base magical damage (includes bare handed)
	if($WeaponBaseMagicDamage <= 0)
	{
		$Variance = 0.1 * $WeaponLevel * ($WeaponBaseMagicDamage + ($WeaponRefinement * 2.5));
	}
	else
	{
		$Variance = 0.1 * $WeaponLevel * ($WeaponBaseMagicDamage + Helper::TrueFloor($RefinementBonus['bonus'] / 2) + ($WeaponRefinement * 2.5));
	}
	$VarianceLow = $isRecognizedSpell == 1 ? $Variance : (-1 * abs($Variance));
	// calculates the magical weapon attack
	$WeaponMATK = $WeaponBaseMagicDamage + $RefinementBonus['bonus'] + $Variance + $OverUpgradeBonus;
	$WeaponMATKLow = $WeaponBaseMagicDamage + $RefinementBonus['bonus'] + $VarianceLow + $OverUpgradeBonusLow;

	/**
	 * PROPERTY -------------------------------------------------------//
	 */
	// obtain the defending property's damage scale index
	$DamageScale = explode(',', $TargetDefendingProperty['damagescale']);
	$ResistDrop = 1 + ($ResistDrop / 100);
	// calculates the property Multiplier
	$PropertyMultiplier = ($DamageScale[$AttackingProperty] / 100) * $ResistDrop;
	$PropertyMultiplierStatusATK = ($DamageScale[$StatusAttackProperty] / 100);
	$PropertyMultiplierMagnumBreak = $DamageScale[3] / 100;
	// adds additional property damage
	$PropertyMultiplier = Helper::ElementalDamageBoost($PropertyMultiplier);
	$PropertyMultiplierStatusATK = Helper::ElementalDamageBoost($PropertyMultiplierStatusATK);
	// the default should be neutral, other cases mean that Mild Wind has been activated
	if($PropertyMultiplierStatusATK >= 1)
	{
		$StatusATK = Helper::TrueFloor($StatusATK * $PropertyMultiplierStatusATK);
	}
	else
	{
		$StatusATK = ceil($StatusATK * $PropertyMultiplierStatusATK);
	}

	/**
	 * DEFENSE MODIFIERS ----------------------------------------------//
	 */
	// calculates the defense
	$HardDef = ceil($TargetHardDef * (1 - ($HardDefReduction / 100)));
	$SoftDef = ceil($TargetSoftDef * (1 - ($SoftDefReduction / 100)));
	// calculates the attack generated from the occult impaction effect
	$PseudoAttack += $isOccultImpaction == 1 ? Helper::TrueFloor($HardDef / 2) : 0;
	// set defenses to 0 when occult impaction effect is in play
	$HardDef = $isOccultImpaction == 1 ? 0 : $HardDef;
	$SoftDef = $isOccultImpaction == 1 ? 0 : $SoftDef;
	$HardDefReduction = (4000 + $HardDef) / (4000 + ($HardDef * 10));
	// calculates the magical defense
	$HardMdef = ceil($TargetHardMdef * (1 - ($HardMdefReduction / 100)));
	$SoftMdef = ceil($TargetSoftMdef * (1 - ($SoftMdefReduction / 100)));
	$HardMdefReduction = (1000 + $HardMdef) / (1000 + ($HardMdef * 10));

	/**
	 * ATTACK ---------------------------------------------------------//
	 */
	// sets regular ammunition attack to zero if cart cannon is being used
	$AmmunitionATK = $l1 == 2477 ? 0 : $AmmunitionATK;
	// obtains the sum of the additional short and long ranged attack
	$ExtraATK = $EquipATK + $AmmunitionATK + $PseudoAttack;
	// calculates the various attack Multipliers
	$PureAttackMultiplier = 1 + ($PureAttackMultiplier / 100);
	$PureMagicAttackMultiplier = 1 + ($PureMagicAttackMultiplier / 100);
	$RaceMultiplier = 1 + ($RaceMultiplier / 100);
	$SizeMultiplier = 1 + ($SizeMultiplier / 100);
	$TargetPropertyMultiplier = 1 + ($TargetPropertyMultiplier / 100);
	$MonsterFamilyMultiplier = 1 + ($MonsterFamilyMultiplier / 100);
	$AttackMultiplier = $isBoss ? 1 + (($AttackMultiplier + $BossAttackMultiplier) / 100) : 1 + ($AttackMultiplier / 100);
	// obtains the sum of the additional magical attack
	$ExtraMATK = $EquipMATK + $PseudoMATK;
	// calculates the various attack Multipliers
	$RaceMagicMultiplier = 1 + ($RaceMagicMultiplier / 100);
	$SizeMagicMultiplier = 1 + ($SizeMagicMultiplier / 100);
	$TargetPropertyMagicMultiplier = 1 + ($TargetPropertyMagicMultiplier / 100);
	$MonsterFamilyMagicMultiplier = 1 + ($MonsterFamilyMagicMultiplier / 100);
	$MagicAttackMultiplier = $isBoss ? 1 + (($MagicAttackMultiplier + $BossMagicAttackMultiplier) / 100) : 1 + ($MagicAttackMultiplier / 100);
	$MagicElementMultiplier = 1 + ($MagicElementMultiplier / 100);
	// calculates the various attack Reductions
	$RaceReduction = 1 - ($RaceReduction / 100);
	$SizeReduction = 1 - ($SizeReduction / 100);
	$PropertyReduction = 1 - ($PropertyReduction / 100);
	$TargetPropertyReduction = 1 - ($TargetPropertyReduction / 100);

	/**
	 * CALCULATE ATTACK -----------------------------------------------//
	 */
	// final physical attack
	$ATK = Helper::CalculateATK($WeaponATK);
	$ATKLow = Helper::CalculateATK($WeaponATKLow);
	$ATKLowCritical = Helper::CalculateATK($WeaponATKLowCritical);
	// final magical attack
	$MATK = Helper::CalculateMATK($WeaponMATK);
	$MATKLow = Helper::CalculateMATK($WeaponMATKLow);
	// final warg attack
	if($l1 == 2243 || $l1 == 2244)
	{
		$WargATK = Helper::RangedWeapon($WeaponType) ? ($StatusATK * 2) + Helper::TrueFloor($WeaponATK * $SizePenaltyMultiplier) + $AmmunitionATK + ($Extra1 * 30) : ($StatusATK * 2) + Helper::TrueFloor(($WeaponATK + $OverUpgradeBonus) * $SizePenaltyMultiplier) + ($Extra1 * 30);
		$WargATKLow = Helper::RangedWeapon($WeaponType) ? ($StatusATK * 2) + Helper::TrueFloor($WeaponATKLow * $SizePenaltyMultiplier) + $AmmunitionATK + ($Extra1 * 30) : ($StatusATK * 2) + Helper::TrueFloor(($WeaponATKLow + $OverUpgradeBonusLow) * $SizePenaltyMultiplier) + ($Extra1 * 30);
	}

	/**
	 * DAMAGE MODIFIERS -----------------------------------------------//
	 */
	$CriticalMultiplier = 1 + ($CriticalMultiplier / 100);
	$RangedMultiplier = 1 + ($RangedMultiplier / 100);
	$RangedDamageReduction = $isPlayer ? 1 - ($RangedDamageReduction / 100) : 1;
	$BaseCriticalMultiplier = 1.4;
	$AdditionalSkillDamage = $isFrenzy ? 200 + $AdditionalSkillDamage : $AdditionalSkillDamage;
	$AdditionalSkillDamage = $isFrenzy ? 3 + ($AdditionalSkillDamage / 100) : 1 + ($AdditionalSkillDamage / 100);
	$TotalDamageMultiplier = 1 + ($TotalDamageMultiplier / 100);
	$TotalDamageReduction = $isPlayer ? 1 - ($TotalDamageReduction / 100) : 1;

	/**
	 * FINISHING TOUCHES ----------------------------------------------//
	 */
	$Parameters = array(
		'BaseLevel' => $BaseLevel,
		'JobLevel' => $JobLevel,
		'ATK' => $ATK,
		'ATKLow' => $ATKLow,
		'ATKLowCritical' => $ATKLowCritical,
		'MATK' => $MATK,
		'MATKLow' => $MATKLow,
		'CriticalMultiplier' => $CriticalMultiplier,
		'RangedMultiplier' => $RangedMultiplier,
		'RangedDamageReduction' => $RangedDamageReduction,
		'BaseCriticalMultiplier' => $BaseCriticalMultiplier,
		'AdditionalSkillDamage' => $AdditionalSkillDamage,
		'AdditionalSkillDamage' => $AdditionalSkillDamage,
		'TotalDamageMultiplier' => $TotalDamageMultiplier,
		'TotalDamageReduction' => $TotalDamageReduction,
		'HardDef' => $HardDef,
		'SoftDef' => $SoftDef,
		'HardDefReduction' => $HardDefReduction,
		'HardMdef' => $HardMdef,
		'SoftMdef' => $SoftMdef,
		'HardMdefReduction' => $HardMdefReduction,
		'SkillLevel' => $SkillLevel,
		'SkillDamageBonus' => $SkillDamageBonus,
		'Extra1' => $Extra1,
		'Extra2' => $Extra2,
		'Extra3' => $Extra3,
		'Extra4' => $Extra4,
		'Extra5' => $Extra5,
		'Extra6' => $Extra6
	);

	$SkillFunction = 'Skill' . $SkillName;
	$SkillDetails = Skill::$SkillFunction($Parameters);
	$SimulationResult = $SkillDetails['PublicHTML'];

	if(isset($_GET['x1']))
	{
		header('Content-type: application/json');
		// calculates the average damage
		$AverageDamage = Helper::TrueFloor(($SkillDetails['API']['Min'] + $SkillDetails['API']['Max']) / 2);
		$APIOutput = array('Average Damage' => $AverageDamage);
		if(isset($SkillDetails['API']['MinCrit']))
		{
			// calculates the average critical damage if it exists for this scenario
			$AverageCriticalDamage = Helper::TrueFloor(($SkillDetails['API']['MinCrit'] + $SkillDetails['API']['MaxCrit']) / 2);
			$APIOutput = array('Average Damage' => $AverageDamage, 'Average Critical Damage' => $AverageCriticalDamage);
		}
		echo json_encode($APIOutput);
		die();
	}
}
?>
<!doctype html>
<html class="no-js" lang="">
<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title><?php echo TITLE; ?></title>
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo APP_PATH; ?>images/favicon-16x16.png?<?php echo CACHE; ?>">
	<!-- Place favicon.ico in the root directory -->

	<link rel="stylesheet" href="<?php echo APP_PATH; ?>css/bootstrap.min.css?<?php echo CACHE; ?>">
	<link rel="stylesheet" href="<?php echo APP_PATH; ?>css/bootstrap-theme.min.css?<?php echo CACHE; ?>">
	<link rel="stylesheet" href="<?php echo APP_PATH; ?>css/style.css?<?php echo CACHE; ?>">
	<link href="https://fonts.googleapis.com/css?family=Bree+Serif" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="<?php echo APP_PATH; ?>js/bootstrap.min.js?<?php echo CACHE; ?>"></script>
	<script src="<?php echo APP_PATH; ?>js/custom.min.js?<?php echo CACHE; ?>"></script>
	<script src="<?php echo APP_PATH; ?>js/copy.min.js?<?php echo CACHE; ?>"></script>
</head>
	<body>
		<!--[if lt IE 8]>
		<p class="bros_wserupgrade">You are using an <Strong>outdated</Strong> browser. Please <a href="http://bros_wsehappy.com/">upgrade your bros_wser</a> to improve your experience.</p>
		<![endif]-->

		<!-- Add your site or application content here -->
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<form class="form">
						<fieldset>
							<?php
								function build_sorter($key) {
									return function ($a, $b) use ($key) {
										return strnatcmp($a[$key], $b[$key]);
									};
								}

								usort($SkillList, build_sorter('name'));

								$SkillInputs = '';
								$SkillInputs .= Helper::CreateSelectArrayAssociative('Skill Name', 'l1', $l1, $SkillList);
								foreach($SkillList as $SelectedSkill)
								{
									if($l1 == $SelectedSkill['value'])
									{
										$SelectedSkillName = $SelectedSkill['name'];
										$SkillInputs .= Helper::CreateSelectCounter('Skill Level', 'l2', $l2, $SelectedSkill['from'], $SelectedSkill['to']);
										$SkillInputs .= $SkillName !== 0 ? Helper::CreateAppendedTextInput('Skill Damage', 'l3', $l3, '%') : Helper::CreateHiddenTextInput('Skill Damage', 'l3', $l3);
										$SkillInputs .= !empty($SelectedSkill['extra1']) ? Helper::CreateTextInput($SelectedSkill['extra1'], 'l4', $l4) : Helper::CreateHiddenTextInput('Extra1', 'l4', $l4);
										$SkillInputs .= !empty($SelectedSkill['extra2']) ? Helper::CreateTextInput($SelectedSkill['extra2'], 'l5', $l5) : Helper::CreateHiddenTextInput('Extra2', 'l5', $l5);
										$SkillInputs .= !empty($SelectedSkill['extra3']) ? Helper::CreateTextInput($SelectedSkill['extra3'], 'l6', $l6) : Helper::CreateHiddenTextInput('Extra3', 'l6', $l6);
										$SkillInputs .= !empty($SelectedSkill['extra4']) ? Helper::CreateTextInput($SelectedSkill['extra4'], 'l7', $l7) : Helper::CreateHiddenTextInput('Extra4', 'l7', $l7);
										$SkillInputs .= !empty($SelectedSkill['extra5']) ? Helper::CreateTextInput($SelectedSkill['extra5'], 'l8', $l8) : Helper::CreateHiddenTextInput('Extra5', 'l8', $l8);
										$SkillInputs .= !empty($SelectedSkill['extra6']) ? Helper::CreateTextInput($SelectedSkill['extra6'], 'l9', $l9) : Helper::CreateHiddenTextInput('Extra6', 'l9', $l9);
										break;
									}
								}
							?>
							<!-- Form Name -->
							<legend>Combat Results</legend>

							<div class="row">
								<div class="col-md-12">
									<div class="page-header">
										<h1><?php echo $SelectedSkillName; ?> <small><?php echo ucfirst($TargetName); ?> Simulation</small></h1>
									</div>
									<div class="col-md-12">
										<p>
											Size: <cite class="text-danger"><?php echo $SizeList[$TargetSize]; ?></cite>&nbsp;&nbsp;
											Race: <cite class="text-danger"><?php echo $RaceList[$TargetRace]; ?></cite>&nbsp;&nbsp;
											Property: <cite class="text-danger"><?php echo $TargetDefendingProperty['name']; ?></cite>&nbsp;&nbsp;
											Boss: <cite class="text-danger"><?php echo $BooleanList[$isBoss]; ?></cite>&nbsp;&nbsp;
											Hard Def: <cite class="text-danger"><?php echo $TargetHardDef . ' &rarr; ' . $HardDef; ?></cite>&nbsp;&nbsp;
											Soft Def: <cite class="text-danger"><?php echo $TargetSoftDef . ' &rarr; ' . $SoftDef; ?></cite>&nbsp;&nbsp;
											Hard Mdef: <cite class="text-danger"><?php echo $TargetHardMdef . ' &rarr; ' . $HardMdef; ?></cite>&nbsp;&nbsp;
											Soft Mdef: <cite class="text-danger"><?php echo $TargetSoftMdef . ' &rarr; ' . $SoftMdef; ?></cite>
										</p>
									</div>
									<div class="col-md-12">
										<dl>
											<?php echo $SimulationResult; ?>
										</dl>
									</div>
								</div>
							</div>

							<legend>Target Information</legend>
							<div class="row">
								<div>
									<!-- TARGET BASICS -->
									<?php echo Helper::CreateTextInput('Target Id', 'a1', $a1); ?>
									<?php echo Helper::CreateSelectArrayAssociative('Property', 'a2', $a2, $ChangePropertyList); ?>
									<?php echo Helper::CreateSelectBoolean('Player?', 'a3', $a3); ?>
									<?php echo Helper::CreateTextInputCopyMode('Shortened URL', 'N/A', 'Simply click inside the field to automatically copy the link.'); ?>
								</div>
							</div>

							<div class="row" id="hidden">
								<!-- TARGET CUSTOM INPUTS -->
								<?php echo Helper::CreateSelectBoolean('Doram?', 'a4', $a4); ?>
								<?php echo Helper::CreateTextInput('Hard Def', 'a5', $a5); ?>
								<?php echo Helper::CreateTextInput('Soft Def', 'a6', $a6); ?>
								<?php echo Helper::CreateTextInput('Hard Mdef', 'a7', $a7); ?>
								<?php echo Helper::CreateTextInput('Soft Mdef', 'a8', $a8); ?>
								<?php echo Helper::CreateAppendedTextInput('Size Reduction', 'a9', $a9, '%'); ?>
								<?php echo Helper::CreateAppendedTextInput('Race Reduction', 'a10', $a10, '%'); ?>
								<?php echo Helper::CreateAppendedTextInput('Property Reduction', 'a11', $a11, '%'); ?>
								<?php echo Helper::CreateAppendedTextInput('Target Property Reduction', 'a12', $a12, '%'); ?>
								<?php echo Helper::CreateAppendedTextInput('Ranged Damage Reduction', 'a13', $a13, '%'); ?>
								<?php echo Helper::CreateAppendedTextInput('Total Damage Reduction', 'a14', $a14, '%'); ?>
							</div>

							<div class="row">
								<?php
									// return all the skill elements, hidden or otherwise
									echo $SkillInputs;
								?>
							</div>

							<div class="col-md-2 sr-only">
								<!-- Text Input Appended -->
								<div class="form-group">
									<label class="control-label" for="y1">Old Class Selection</label>
									<div class="input-group">
										<input id="y1" name="y1" placeholder="Old Class Selection" class="form-control input-md" type="text" value="<?php echo $_GET['l1']; ?>">
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-2">
									<!-- Button -->
									<div class="form-group">
										<label class="control-label sr-only" for="z1">Single Button</label>
										<div>
											<button id="z1" name="z1" class="btn btn-primary">Submit</button>
										</div>
									</div>
								</div>
							</div>
						</fieldset>

						<fieldset>
							<!-- Form Name -->
							<legend>Stats</legend>

							<div class="row">
								<!-- PLAYER BASICS -->
								<?php echo Helper::CreateSelectCounter('Base Level', 'b1', $b1, 1, 175); ?>
								<?php echo Helper::CreateSelectCounter('Job Level', 'b2', $b2, 1, 70); ?>
							</div>

							<div class="row">
								<!-- PLAYER BASE STATS -->
								<?php echo Helper::CreateTextInput('Str', 'b3', $b3); ?>
								<?php echo Helper::CreateTextInput('Agi', 'b4', $b4); ?>
								<?php echo Helper::CreateTextInput('Vit', 'b5', $b5); ?>
								<?php echo Helper::CreateTextInput('Int', 'b6', $b6); ?>
								<?php echo Helper::CreateTextInput('Dex', 'b7', $b7); ?>
								<?php echo Helper::CreateTextInput('Luk', 'b8', $b8); ?>
							</div>
						</fieldset>

						<fieldset>
							<!-- Form Name -->
							<legend>Weapon</legend>

							<div class="row">
								<!-- WEAPON -->
								<?php echo Helper::CreateSelectArrayAssociative('Type', 'c1', $c1, $WeaponSizeModifierList); ?>
								<?php echo Helper::CreateTextInput('Base ATK', 'c2', $c2, 'Weapon Attack'); ?>
								<?php echo Helper::CreateTextInput('Base MATK', 'c3', $c3, 'Weapon Magic Attack'); ?>
								<?php echo Helper::CreateSelectCounter('Level', 'c4', $c4, 1, 4); ?>
								<?php echo Helper::CreateSelectCounter('Refinement', 'c5', $c5, 0, 20); ?>
							</div>
						</fieldset>

						<fieldset>
							<!-- Form Name -->
							<legend>Attacking Property</legend>

							<div class="row">
								<!-- PROPERTY -->
								<?php echo Helper::CreateSelectArrayAssociative('Property', 'd1', $d1, $AttackingPropertyList, 'Weapon, Ammunition, Endow or Converter'); ?>
								<?php echo Helper::CreateSelectArrayAssociative('Status Attack', 'd2', $d2, $AttackingPropertyList, 'Mild Wind'); ?>
								<?php echo Helper::CreateAppendedTextInput('Resist Drop', 'd3', $d3, '%', 'Venom Impression'); ?>
								<?php echo Helper::CreateAppendedTextInput('Elemental Damage Boost', 'd4', $d4, '%', 'Deluge, Volcano, Whirlwind'); ?>
							</div>
						</fieldset>

						<fieldset>
							<!-- Form Name -->
							<legend>Attack Modifiers</legend>

							<div class="row">
								<!-- ATTACK -->
								<?php echo Helper::CreateTextInput('Equipment', 'e1', $e1, 'Andre Card, Citizen Oda\'s Miracle Elixir, Striking'); ?>
								<?php echo Helper::CreateTextInput('Ammunition', 'e3', $e3); ?>
								<?php echo Helper::CreateTextInput('Pseudo', 'e4', $e4, 'Poring Pretzel/Takoyaki'); ?>
							</div>

							<div class="row">
								<!-- ATTACK MODIFIERS -->
								<?php echo Helper::CreateAppendedTextInput('Weapon', 'e5', $e5, '%', 'Megingjard'); ?>
								<?php echo Helper::CreateAppendedTextInput('Race', 'e6', $e6, '%', 'Hydra Card'); ?>
								<?php echo Helper::CreateAppendedTextInput('Size', 'e7', $e7, '%', 'Skel Worker Card'); ?>
								<?php echo Helper::CreateAppendedTextInput('Property', 'e8', $e8, '%', 'Vadon Card'); ?>
								<?php echo Helper::CreateAppendedTextInput('Monster', 'e9', $e9, '%', 'Pale Moon Hat'); ?>
								<?php echo Helper::CreateAppendedTextInput('Attack', 'e10', $e10, '%', 'Bakonawa Agimat Tattoo'); ?>
								<?php echo Helper::CreateAppendedTextInput('Boss', 'e11', $e11, '%', 'Abysmal Knight Card'); ?>
							</div>

							<div class="row">
								<!-- MASTERY ATTACK -->
								<?php echo Helper::CreateTextInput('Mastery', 'e12', $e12); ?>
								<?php echo Helper::CreateTextInput('Buff', 'e13', $e13, 'Impositio Manus, Odin\'s Power'); ?>
							</div>
						</fieldset>
						<fieldset>
							<!-- Form Name -->
							<legend>Magic Attack Modifiers</legend>

							<div class="row">
								<!-- ATTACK -->
								<?php echo Helper::CreateTextInput('Equipment', 'f1', $f1, 'Scaraba Card, Citizen Oda\'s Miracle Elixir'); ?>
								<?php echo Helper::CreateTextInput('Pseudo', 'f2', $f2, 'Poring Pretzel/Takoyaki'); ?>
							</div>

							<div class="row">
								<!-- ATTACK MODIFIERS -->
								<?php echo Helper::CreateAppendedTextInput('Weapon', 'f3', $f3, '%', 'Mystic Amplification'); ?>
								<?php echo Helper::CreateAppendedTextInput('Race', 'f4', $f4, '%', 'Cobalt Mineral Card'); ?>
								<?php echo Helper::CreateAppendedTextInput('Size', 'f5', $f5, '%', 'Valkyrie Drop'); ?>
								<?php echo Helper::CreateAppendedTextInput('Property', 'f6', $f6, '%', 'Jungle Mandragora Card'); ?>
								<?php echo Helper::CreateAppendedTextInput('Monster', 'f7', $f7, '%', 'Pale Moon Hat'); ?>
								<?php echo Helper::CreateAppendedTextInput('Attack', 'f8', $f8, '%', 'Timeholder Card'); ?>
								<?php echo Helper::CreateAppendedTextInput('Boss', 'f9', $f9, '%', 'Sea Dragon Armor'); ?>
								<?php echo Helper::CreateAppendedTextInput('Magic Element', 'f10', $f10, '%', 'Elvira Card'); ?>
							</div>

							<div class="row">
								<!-- MASTERY ATTACK -->
								<?php echo Helper::CreateTextInput('Mastery', 'f11', $f11); ?>
								<?php echo Helper::CreateTextInput('Buff', 'f12', $f12, 'Chattering, Odin\'s Power'); ?>
							</div>
						</fieldset>

						<fieldset>
							<!-- Form Name -->
							<legend>Damage Modifiers</legend>

							<div class="row">
								<!-- DAMAGE MODIFIERS -->
								<?php echo Helper::CreateAppendedTextInput('Critical', 'i1', $i1, '%', 'Aunoe Card'); ?>
								<?php echo Helper::CreateAppendedTextInput('Ranged', 'i2', $i2, '%', 'Archer Skeleton Card'); ?>
								<?php echo Helper::CreateAppendedTextInput('Additional Skill Damage', 'i3', $i3, '%', 'Falcon Eyes, Hit Barrel'); ?>
								<?php echo Helper::CreateAppendedTextInput('Total Damage Multiplier', 'i4', $i4, '%', 'Dark Claw, Elemental Insignia, Intensification'); ?>
							</div>

							<div class="row">
								<!-- DEFENSE MODIFIERS -->
								<?php echo Helper::CreateAppendedTextInput('Hard Def Reduction', 'j1', $j1, '%'); ?>
								<?php echo Helper::CreateAppendedTextInput('Soft Def Reduction', 'j2', $j2, '%'); ?>
							</div>

							<div class="row">
								<!-- MAGIC DEFENSE MODIFIERS -->
								<?php echo Helper::CreateAppendedTextInput('Hard Mdef Reduction', 'j3', $j3, '%'); ?>
								<?php echo Helper::CreateAppendedTextInput('Soft Mdef Reduction', 'j4', $j4, '%'); ?>
							</div>
						</fieldset>

						<fieldset>
							<!-- Form Name -->
							<legend>Other Factors</legend>

							<div class="row">
								<!-- OTHER OPTIONS -->
								<?php echo Helper::CreateSelectBoolean('Occult Impaction', 'k1', $k1, 'Memory of Thanatos Card, Ice Pick'); ?>
								<?php echo Helper::CreateSelectBoolean('Frenzy', 'k2', $k2); ?>
								<?php echo Helper::CreateSelectCounter('Enchant Deadly Poison', 'k3', $k3, 0, 5); ?>
								<?php echo Helper::CreateSelectBoolean('Weapon Perfection', 'k4', $k4); ?>
								<?php echo Helper::CreateSelectBoolean('Power Maximize', 'k5', $k5); ?>
								<?php echo Helper::CreateSelectBoolean('Recognized Spell', 'k6', $k6); ?>
								<?php echo Helper::CreateSelectBoolean('Magnum Break', 'k7', $k7); ?>
							</div>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>