<?php
/**
 * This file contains skill based functions used to by the damage calculator.
 *
 * @package		DamageCALC
 * @author		Michael McStay <XYZ>
 * @license		https://opensource.org/licenses/GPL-3.0 GNU General Public License 3
 * @version		1.0
 * @since		1.0
 */
/**
 * Skill class
 *
 * The class is used to call skill based functions used to by the damage calculator.
 *
 * @package		DamageCALC
 * @author		Michael McStay <XYZ>
 * @version		1.0
 * @since		1.0
 */
class Skill {
	/**
		The contents of $Parameters
		BaseLevel: The base level of the character as decided by the user
		JobLevel: The job level of the character as decided by the user
		ATK: Maximum Attack
		ATKLow: Minimum Attack
		ATKLowCritical: Minimum Critical Attack
		MATK: Maximum Magical Attack
		MATKLow: Minimum Magical Attack
		CriticalMultiplier: Critical Damage %
		RangedMultiplier: Ranged Damage %
		RangedDamageReduction: Ranged Reduction %
		BaseCriticalMultiplier: Base Critical Multiplierplier (1.4)
		AdditionalSkillDamage: Additional Skill Damage
		AdditionalSkillDamage: Damage % (i.e. Falcon Eyes, Advanced Katar Mastery etc)
		TotalDamageMultiplier: Final Damage % (i.e. Dark Claw etc)
		TotalDamageReduction: Final Reduction % (i.e. Energy Coat etc)
		HardDef: Hard Defense Value
		SoftDef: Soft Defense Value
		HardDefReduction: Hard Defense Reduction %
		HardMdef: Hard Magical Defense Value
		SoftMdef: Soft Magical Defense Value
		HardMdefReduction: Hard Magical Defense Reduction %
		SkillLevel: Level of skill as decided by the user
		SkillDamageBonus: Skill Damage % as decided by the user
		Extra1~6: Extra skill factors or details
	 */
	/**
	 * Basic Attack
	 *
	 * @param	int $Parameters
	 * @return	int $SkillDetails
	 * @since	1.0
	 */
	public static function Skill0($Parameters)
	{
		// Preparation
		global $WeaponType;
		
		// Basic
		// Min Damage
		$SkillDamageMin = $Parameters['ATKLow'];
		// if using a ranged weapon or a summoner's stave then add ranged damage Multiplierpliers to the calculation
		if(Helper::RangedWeapon($WeaponType) || $WeaponType == 18)
		{
			$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['RangedMultiplier']);
			$SkillDamageMin = $Parameters['RangedDamageReduction'] < 1 ? Helper::TrueFloor($SkillDamageMin * $Parameters['RangedDamageReduction']) : $SkillDamageMin;
		}
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['AdditionalSkillDamage']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardDefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftDef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = $Parameters['ATK'];
		// if using a ranged weapon or a summoner's stave then add ranged damage Multiplierpliers to the calculation
		if(Helper::RangedWeapon($WeaponType) || $WeaponType == 18)
		{
			$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['RangedMultiplier']);
			$SkillDamageMax = $Parameters['RangedDamageReduction'] < 1 ? Helper::TrueFloor($SkillDamageMax * $Parameters['RangedDamageReduction']) : $SkillDamageMax;
		}
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['AdditionalSkillDamage']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardDefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftDef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Critical
		// Min Damage
		$SkillDamageMinCritical = Helper::TrueFloor($Parameters['ATKLowCritical'] * $Parameters['CriticalMultiplier']);
		// if using a ranged weapon or a summoner's stave then add ranged damage Multiplierpliers to the calculation
		if(Helper::RangedWeapon($WeaponType) || $WeaponType == 18)
		{
			$SkillDamageMinCritical = Helper::TrueFloor($SkillDamageMinCritical * $Parameters['RangedMultiplier']);
			$SkillDamageMinCritical = $Parameters['RangedDamageReduction'] < 1 ? Helper::TrueFloor($SkillDamageMinCritical * $Parameters['RangedDamageReduction']) : $SkillDamageMinCritical;
		}
		$SkillDamageMinCritical = Helper::TrueFloor($SkillDamageMinCritical * $Parameters['AdditionalSkillDamage']);
		$SkillDamageMinCritical = Helper::TrueFloor($SkillDamageMinCritical * $Parameters['HardDefReduction']);
		$SkillDamageMinCritical = Helper::TrueFloor($SkillDamageMinCritical - $Parameters['SoftDef']);
		$SkillDamageMinCritical = Helper::TrueFloor($SkillDamageMinCritical * $Parameters['BaseCriticalMultiplier']);
		$SkillDamageMinCritical = Helper::TrueFloor($SkillDamageMinCritical * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMinCritical = Helper::TrueFloor($SkillDamageMinCritical * $Parameters['TotalDamageReduction']);
		$SkillDamageMinCritical = Helper::PreventNegativeDamage($SkillDamageMinCritical);
		// Max Damage
		$SkillDamageMaxCritical = Helper::TrueFloor($Parameters['ATK'] * $Parameters['CriticalMultiplier']);
		// if using a ranged weapon or a summoner's stave then add ranged damage Multiplierpliers to the calculation
		if(Helper::RangedWeapon($WeaponType) || $WeaponType == 18)
		{
			$SkillDamageMaxCritical = Helper::TrueFloor($SkillDamageMaxCritical * $Parameters['RangedMultiplier']);
			$SkillDamageMaxCritical = $Parameters['RangedDamageReduction'] < 1 ? Helper::TrueFloor($SkillDamageMaxCritical * $Parameters['RangedDamageReduction']) : $SkillDamageMaxCritical;
		}
		$SkillDamageMaxCritical = Helper::TrueFloor($SkillDamageMaxCritical * $Parameters['AdditionalSkillDamage']);
		$SkillDamageMaxCritical = Helper::TrueFloor($SkillDamageMaxCritical * $Parameters['HardDefReduction']);
		$SkillDamageMaxCritical = Helper::TrueFloor($SkillDamageMaxCritical - $Parameters['SoftDef']);
		$SkillDamageMaxCritical = Helper::TrueFloor($SkillDamageMaxCritical * $Parameters['BaseCriticalMultiplier']);
		$SkillDamageMaxCritical = Helper::TrueFloor($SkillDamageMaxCritical * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMaxCritical = Helper::TrueFloor($SkillDamageMaxCritical * $Parameters['TotalDamageReduction']);
		$SkillDamageMaxCritical = Helper::PreventNegativeDamage($SkillDamageMaxCritical);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
			<dd>' . $SkillDamageMinCritical . ' &harr; ' . $SkillDamageMaxCritical . ' when dealing a critical strike.</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Meteor Storm
	 *
	 * @param	int $Parameters
	 * @return	int $Results
	 * @since	1.0
	 */
	public static function Skill83($Parameters)
	{
		// Preparation
		global $DamageScale;
		$SkillModifier = 125 / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$SkillProperty = $DamageScale[3] / 100;
		$SkillPropertyBoosted = Helper::ElementalDamageBoost($SkillProperty);
		$NumberOfHits = ceil($Parameters['SkillLevel'] / 2);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['MATKLow'] * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardMdefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftMdef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::SkillPropertyMultiplier($SkillDamageMin, $SkillPropertyBoosted);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $NumberOfHits);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['MATK'] * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardMdefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftMdef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::SkillPropertyMultiplier($SkillDamageMax, $SkillPropertyBoosted);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $NumberOfHits);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . ' per hit.</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Water Ball
	 *
	 * @param	int $Parameters
	 * @return	int $Results
	 * @since	1.0
	 */
	public static function Skill86($Parameters)
	{
		// Preparation
		global $DamageScale;
		$SkillModifier = Helper::TrueFloor(100 + ($Parameters['SkillLevel'] * 30)) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$SkillProperty = $DamageScale[1] / 100;
		$SkillPropertyBoosted = Helper::ElementalDamageBoost($SkillProperty);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['MATKLow'] * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardMdefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftMdef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::SkillPropertyMultiplier($SkillDamageMin, $SkillPropertyBoosted);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['MATK'] * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardMdefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftMdef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::SkillPropertyMultiplier($SkillDamageMax, $SkillPropertyBoosted);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . ' per hit.</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Focused Arrow Strike
	 *
	 * @param	int $Parameters
	 * @return	int $SkillDetails
	 * @since	1.0
	 */
	public static function Skill382($Parameters)
	{
		// Preparation
		$SkillModifier = ((200 + ($Parameters['SkillLevel'] * 50)) + $Parameters['AdditionalSkillDamage']) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['ATKLow'] * $Parameters['RangedMultiplier']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['RangedDamageReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardDefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftDef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['ATK'] * $Parameters['RangedMultiplier']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['RangedDamageReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardDefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftDef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		// Critical
		// Min Damage
		$SkillDamageMinCritical = Helper::TrueFloor($Parameters['ATKLowCritical'] * $Parameters['CriticalMultiplier']);
		$SkillDamageMinCritical = Helper::TrueFloor($SkillDamageMinCritical * $Parameters['RangedMultiplier']);
		$SkillDamageMinCritical = Helper::TrueFloor($SkillDamageMinCritical * $Parameters['RangedDamageReduction']);
		$SkillDamageMinCritical = Helper::TrueFloor($SkillDamageMinCritical * $SkillModifier);
		$SkillDamageMinCritical = Helper::TrueFloor($SkillDamageMinCritical * $Parameters['HardDefReduction']);
		$SkillDamageMinCritical = Helper::TrueFloor($SkillDamageMinCritical - $Parameters['SoftDef']);
		$SkillDamageMinCritical = Helper::TrueFloor($SkillDamageMinCritical * $SkillDamageMultiplier);
		$SkillDamageMinCritical = Helper::TrueFloor($SkillDamageMinCritical * $Parameters['BaseCriticalMultiplier']);
		$SkillDamageMinCritical = Helper::TrueFloor($SkillDamageMinCritical * $Parameters['TotalDamageReduction']);
		$SkillDamageMinCritical = Helper::PreventNegativeDamage($SkillDamageMinCritical);
		// Max Damage
		$SkillDamageMaxCritical = Helper::TrueFloor($Parameters['ATK'] * $Parameters['CriticalMultiplier']);
		$SkillDamageMaxCritical = Helper::TrueFloor($SkillDamageMaxCritical * $Parameters['RangedMultiplier']);
		$SkillDamageMaxCritical = Helper::TrueFloor($SkillDamageMaxCritical * $Parameters['RangedDamageReduction']);
		$SkillDamageMaxCritical = Helper::TrueFloor($SkillDamageMaxCritical * $SkillModifier);
		$SkillDamageMaxCritical = Helper::TrueFloor($SkillDamageMaxCritical * $Parameters['HardDefReduction']);
		$SkillDamageMaxCritical = Helper::TrueFloor($SkillDamageMaxCritical - $Parameters['SoftDef']);
		$SkillDamageMaxCritical = Helper::TrueFloor($SkillDamageMaxCritical * $SkillDamageMultiplier);
		$SkillDamageMaxCritical = Helper::TrueFloor($SkillDamageMaxCritical * $Parameters['BaseCriticalMultiplier']);
		$SkillDamageMaxCritical = Helper::TrueFloor($SkillDamageMaxCritical * $Parameters['TotalDamageReduction']);
		$SkillDamageMaxCritical = Helper::PreventNegativeDamage($SkillDamageMaxCritical);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
			<dd>' . $SkillDamageMinCritical . ' &harr; ' . $SkillDamageMaxCritical . ' when dealing a critical strike.</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Meteor Assault
	 *
	 * @param	int $Parameters
	 * @return	int $SkillDetails
	 * @since	1.0
	 */
	public static function Skill406($Parameters)
	{
		// Preparation
		$SkillModifier = Helper::TrueFloor(40 + ($Parameters['SkillLevel'] * 40)) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$AdvancedKatarMasteryBonus = 1 + ($Parameters['AdditionalSkillDamage'] / 100);
		
		// Min Damage
		$SkillDamageMin = $Parameters['ATKLow'] * $AdvancedKatarMasteryBonus;
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardDefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftDef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = $Parameters['ATK'] * $AdvancedKatarMasteryBonus;
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardDefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftDef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Acid Bomb
	 *
	 * @param	int $Parameters
	 * @return	int $Results
	 * @since	1.0
	 */
	public static function Skill490($Parameters)
	{
		// Preparation
		global $TargetVit;
		global $DamageScale;
		$SkillProperty = $DamageScale[0] / 100;
		$SkillPropertyBoosted = Helper::ElementalDamageBoost($SkillProperty);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor(($Parameters['ATKLow'] + $Parameters['MATKLow']) * $Parameters['RangedMultiplier']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['RangedDamageReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $TargetVit);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * 0.7);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - (Helper::TrueFloor($Parameters['HardDef'] / 2) + Helper::TrueFloor($Parameters['SoftDef'] / 2) + Helper::TrueFloor($Parameters['HardMdef'] / 2)));
		$SkillDamageMin = Helper::SkillPropertyMultiplier($SkillDamageMin, $SkillPropertyBoosted);
		$SkillDamageMin = Helper::SkillHitRounding($SkillDamageMin, 10);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor(($Parameters['ATK'] + $Parameters['MATK']) * $Parameters['RangedMultiplier']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['RangedDamageReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $TargetVit);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * 0.7);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - (Helper::TrueFloor($Parameters['HardDef'] / 2) + Helper::TrueFloor($Parameters['SoftDef'] / 2) + Helper::TrueFloor($Parameters['HardMdef'] / 2)));
		$SkillDamageMax = Helper::SkillPropertyMultiplier($SkillDamageMax, $SkillPropertyBoosted);
		$SkillDamageMax = Helper::SkillHitRounding($SkillDamageMax, 10);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMax, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Cross Impact
	 *
	 * @param	int $Parameters
	 * @return	int $SkillDetails
	 * @since	1.0
	 */
	public static function Skill2022($Parameters)
	{
		// Preparation
		global $EnchantDeadlyPoison;
		$SkillModifier = Helper::TrueFloor((1000 + ($Parameters['SkillLevel'] * 100)) * ($Parameters['BaseLevel'] / 120)) / 100;
		$SkillModifier = $EnchantDeadlyPoison > 0 ? $SkillModifier * 0.5 : $SkillModifier;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$AdvancedKatarMasteryBonus = 1 + ($Parameters['AdditionalSkillDamage'] / 100);
		
		// Min Damage
		$SkillDamageMin = $Parameters['ATKLow'] * $AdvancedKatarMasteryBonus;
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardDefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftDef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMin = Helper::SkillHitRounding($SkillDamageMin, 7);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = $Parameters['ATK'] * $AdvancedKatarMasteryBonus;
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardDefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftDef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMax = Helper::SkillHitRounding($SkillDamageMax, 7);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Counter Slash
	 *
	 * @param	int $Parameters
	 * @return	int $SkillDetails
	 * @since	1.0
	 */
	public static function Skill2029($Parameters)
	{
		// Preparation
		global $AGI;
		global $EnchantDeadlyPoison;
		$SkillModifier = Helper::TrueFloor(((300 + ($Parameters['SkillLevel'] * 100)) * ($Parameters['BaseLevel'] / 120)) + (($AGI * 2) + 240)) / 100;
		$SkillModifier = $EnchantDeadlyPoison > 0 ? $SkillModifier * 0.5 : $SkillModifier;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$AdvancedKatarMasteryBonus = 1 + ($Parameters['AdditionalSkillDamage'] / 100);
		
		// Min Damage
		$SkillDamageMin = $Parameters['ATKLow'] * $AdvancedKatarMasteryBonus;
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = $Parameters['ATK'] * $AdvancedKatarMasteryBonus;
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Rolling Cutter
	 *
	 * @param	int $Parameters
	 * @return	int $SkillDetails
	 * @since	1.0
	 */
	public static function Skill2036($Parameters)
	{
		// Preparation
		$SkillModifier = Helper::TrueFloor((50 + ($Parameters['SkillLevel'] * 50)) * ($Parameters['BaseLevel'] / 100)) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$AdvancedKatarMasteryBonus = 1 + ($Parameters['AdditionalSkillDamage'] / 100);
		
		// Min Damage
		$SkillDamageMin = $Parameters['ATKLow'] * $AdvancedKatarMasteryBonus;
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardDefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftDef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = $Parameters['ATK'] * $AdvancedKatarMasteryBonus;
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardDefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftDef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Cross Ripper Slasher
	 *
	 * @param	int $Parameters
	 * @return	int $SkillDetails
	 * @since	1.0
	 */
	public static function Skill2037($Parameters)
	{
		global $AGI;
		// Preparation
		$RollingCutterCountBonus = ($Parameters['Extra1'] * $AGI);
		$SkillModifier = ((Helper::TrueFloor(400 + ($Parameters['SkillLevel'] * 80)) * ($Parameters['BaseLevel'] / 100)) + $RollingCutterCountBonus) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$AdvancedKatarMasteryBonus = 1 + ($Parameters['AdditionalSkillDamage'] / 100);
		$SkillModifier = Helper::TrueFloor(($SkillModifier * $AdvancedKatarMasteryBonus) * 100) / 100;
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['ATKLow'] * $Parameters['RangedMultiplier']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['RangedDamageReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardDefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftDef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['ATK'] * $Parameters['RangedMultiplier']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['RangedDamageReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardDefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftDef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Soul Expansion
	 *
	 * @param	int $Parameters
	 * @return	int $Results
	 * @since	1.0
	 */
	public static function Skill2202($Parameters)
	{
		// Preparation
		global $DamageScale;
		global $INT;
		$SkillModifier = Helper::TrueFloor((400 + ($Parameters['SkillLevel'] * 100) + $INT) * ($Parameters['BaseLevel'] / 100)) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$SkillProperty = $DamageScale[8] / 100;
		$SkillPropertyBoosted = Helper::ElementalDamageBoost($SkillProperty);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['MATKLow'] * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardMdefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftMdef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::SkillPropertyMultiplier($SkillDamageMin, $SkillPropertyBoosted);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMin = Helper::SkillHitRounding($SkillDamageMin, 2);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['MATK'] * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardMdefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftMdef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = $SkillDamageMaxBounce = Helper::SkillPropertyMultiplier($SkillDamageMax, $SkillPropertyBoosted);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMax = Helper::SkillHitRounding($SkillDamageMax, 2);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Jack Frost
	 *
	 * @param	int $Parameters
	 * @return	int $Results
	 * @since	1.0
	 */
	public static function Skill2204($Parameters)
	{
		// Preparation
		global $DamageScale;
		$SkillModifier = Helper::TrueFloor((500 + ($Parameters['SkillLevel'] * 100)) * ($Parameters['BaseLevel'] / 150)) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$SkillProperty = $DamageScale[1] / 100;
		$SkillPropertyBoosted = Helper::ElementalDamageBoost($SkillProperty);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['MATKLow'] * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardMdefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftMdef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::SkillPropertyMultiplier($SkillDamageMin, $SkillPropertyBoosted);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMin = Helper::SkillHitRounding($SkillDamageMin, 5);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['MATK'] * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardMdefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftMdef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = $SkillDamageMaxBounce = Helper::SkillPropertyMultiplier($SkillDamageMax, $SkillPropertyBoosted);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMax = Helper::SkillHitRounding($SkillDamageMax, 5);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		// Min Damage (when the target is freezing)
		$SkillModifier = Helper::TrueFloor((1000 + ($Parameters['SkillLevel'] * 300)) * ($Parameters['BaseLevel'] / 100)) / 100;
		$SkillDamageMinFreezing = Helper::TrueFloor($Parameters['MATKLow'] * $SkillModifier);
		$SkillDamageMinFreezing = Helper::TrueFloor($SkillDamageMinFreezing * $Parameters['HardMdefReduction']);
		$SkillDamageMinFreezing = Helper::TrueFloor($SkillDamageMinFreezing - $Parameters['SoftMdef']);
		$SkillDamageMinFreezing = Helper::TrueFloor($SkillDamageMinFreezing * $SkillDamageMultiplier);
		$SkillDamageMinFreezing = Helper::SkillPropertyMultiplier($SkillDamageMinFreezing, $SkillPropertyBoosted);
		$SkillDamageMinFreezing = Helper::TrueFloor($SkillDamageMinFreezing * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMinFreezing = Helper::SkillHitRounding($SkillDamageMinFreezing, 5);
		$SkillDamageMinFreezing = Helper::TrueFloor($SkillDamageMinFreezing * $Parameters['TotalDamageReduction']);
		$SkillDamageMinFreezing = Helper::PreventNegativeDamage($SkillDamageMinFreezing);
		// Max Damage (when the target is freezing)
		$SkillDamageMaxFreezing = Helper::TrueFloor($Parameters['MATK'] * $SkillModifier);
		$SkillDamageMaxFreezing = Helper::TrueFloor($SkillDamageMaxFreezing * $Parameters['HardMdefReduction']);
		$SkillDamageMaxFreezing = Helper::TrueFloor($SkillDamageMaxFreezing - $Parameters['SoftMdef']);
		$SkillDamageMaxFreezing = Helper::TrueFloor($SkillDamageMaxFreezing * $SkillDamageMultiplier);
		$SkillDamageMaxFreezing = $SkillDamageMaxBounce = Helper::SkillPropertyMultiplier($SkillDamageMaxFreezing, $SkillPropertyBoosted);
		$SkillDamageMaxFreezing = Helper::TrueFloor($SkillDamageMaxFreezing * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMaxFreezing = Helper::SkillHitRounding($SkillDamageMaxFreezing, 5);
		$SkillDamageMaxFreezing = Helper::TrueFloor($SkillDamageMaxFreezing * $Parameters['TotalDamageReduction']);
		$SkillDamageMaxFreezing = Helper::PreventNegativeDamage($SkillDamageMaxFreezing);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
			<dd>' . $SkillDamageMinFreezing . ' &harr; ' . $SkillDamageMaxFreezing . ' when the target is freezing.</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Crimson Rock
	 *
	 * @param	int $Parameters
	 * @return	int $Results
	 * @since	1.0
	 */
	public static function Skill2211($Parameters)
	{
		// Preparation
		global $DamageScale;
		$SkillModifier = Helper::TrueFloor((($Parameters['SkillLevel'] * 300) * ($Parameters['BaseLevel'] / 100)) + 1300) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$SkillProperty = $DamageScale[3] / 100;
		$SkillPropertyBoosted = Helper::ElementalDamageBoost($SkillProperty);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['MATKLow'] * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardMdefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftMdef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::SkillPropertyMultiplier($SkillDamageMin, $SkillPropertyBoosted);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMin = Helper::SkillHitRounding($SkillDamageMin, 7);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['MATK'] * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardMdefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftMdef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = $SkillDamageMaxBounce = Helper::SkillPropertyMultiplier($SkillDamageMax, $SkillPropertyBoosted);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMax = Helper::SkillHitRounding($SkillDamageMax, 7);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Chain Lightning
	 *
	 * @param	int $Parameters
	 * @return	int $Results
	 * @since	1.0
	 */
	public static function Skill2214($Parameters)
	{
		// Preparation
		global $DamageScale;
		$SkillModifier = Helper::TrueFloor((500 + ($Parameters['SkillLevel'] * 100)) * ($Parameters['BaseLevel'] / 100)) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$SkillProperty = $DamageScale[4] / 100;
		$SkillPropertyBoosted = Helper::ElementalDamageBoost($SkillProperty);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['MATKLow'] * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardMdefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftMdef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::SkillPropertyMultiplier($SkillDamageMin, $SkillPropertyBoosted);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['MATK'] * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardMdefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftMdef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = $SkillDamageMaxBounce = Helper::SkillPropertyMultiplier($SkillDamageMax, $SkillPropertyBoosted);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		// Max Damage (when bouncing)
		$SkillDamageMaxBounce = Helper::TrueFloor($SkillDamageMaxBounce + (($Parameters['MATK'] * $SkillDamageMultiplier) * (9 - 1)));
		$SkillDamageMaxBounce = Helper::TrueFloor($SkillDamageMaxBounce * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMaxBounce = Helper::TrueFloor($SkillDamageMaxBounce * $Parameters['TotalDamageReduction']);
		$SkillDamageMaxBounce = Helper::PreventNegativeDamage($SkillDamageMaxBounce);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMaxBounce . ' when bouncing.</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Earth Strain
	 *
	 * @param	int $Parameters
	 * @return	int $Results
	 * @since	1.0
	 */
	public static function Skill2216($Parameters)
	{
		// Preparation
		global $DamageScale;
		$SkillModifier = Helper::TrueFloor((2000 + ($Parameters['SkillLevel'] * 100)) * ($Parameters['BaseLevel'] / 100)) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$SkillProperty = $DamageScale[2] / 100;
		$SkillPropertyBoosted = Helper::ElementalDamageBoost($SkillProperty);
		$NumberOfHits = 5 + $Parameters['SkillLevel'];
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['MATKLow'] * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardMdefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftMdef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::SkillPropertyMultiplier($SkillDamageMin, $SkillPropertyBoosted);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMin = Helper::SkillHitRounding($SkillDamageMin, $NumberOfHits);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['MATK'] * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardMdefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftMdef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = $SkillDamageMaxBounce = Helper::SkillPropertyMultiplier($SkillDamageMax, $SkillPropertyBoosted);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMax = Helper::SkillHitRounding($SkillDamageMax, $NumberOfHits);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Arrow Storm
	 *
	 * @param	int $Parameters
	 * @return	int $SkillDetails
	 * @since	1.0
	 */
	public static function Skill2233($Parameters)
	{
		// Preparation
		$SkillModifier = (Helper::TrueFloor((1000 + ($Parameters['SkillLevel'] * 80)) * ($Parameters['BaseLevel'] / 100)) + $Parameters['AdditionalSkillDamage']) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['ATKLow'] * $Parameters['RangedMultiplier']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['RangedDamageReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardDefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftDef']);
		$SkillDamageMin = Helper::SkillHitRounding($SkillDamageMin, 3);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['ATK'] * $Parameters['RangedMultiplier']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['RangedDamageReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardDefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftDef']);
		$SkillDamageMax = Helper::SkillHitRounding($SkillDamageMax, 3);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Aimed Bolt
	 *
	 * @param	int $Parameters
	 * @return	int $SkillDetails
	 * @since	1.0
	 */
	public static function Skill2236($Parameters)
	{
		// Preparation
		global $TargetSize;
		$SkillModifier = (Helper::TrueFloor((500 + ($Parameters['SkillLevel'] * 50)) * ($Parameters['BaseLevel'] / 100)) + $Parameters['AdditionalSkillDamage']) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$NumberOfHitsSnared = array(array('minhits' => 2, 'maxhits' => 3), array('minhits' => 3, 'maxhits' => 4), array('minhits' => 4, 'maxhits' => 5));
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['ATKLow'] * $Parameters['RangedMultiplier']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['RangedDamageReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardDefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftDef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['ATK'] * $Parameters['RangedMultiplier']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['RangedDamageReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardDefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftDef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		// Min Damage (when the target is immobilized)
		$SkillDamageMinSnared = $SkillDamageMin * $NumberOfHitsSnared[$TargetSize]['minhits'];
		// Max Damage (when the target is immobilized)
		$SkillDamageMaxSnared = $SkillDamageMax * $NumberOfHitsSnared[$TargetSize]['maxhits'];
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
			<dd>' . $SkillDamageMinSnared . ' &harr; ' . $SkillDamageMaxSnared . ' when the target is immobilized.</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Bomb Cluster
	 *
	 * @param	int $Parameters
	 * @return	int $SkillDetails
	 * @since	1.0
	 */
	public static function Skill2239($Parameters)
	{
		// Preparation
		global $INT;
		global $DEX;
		global $DamageScale;
		
		$SkillModifier = ((200 + ($Parameters['SkillLevel'] * 100)) + $Parameters['AdditionalSkillDamage']) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$SkillProperty = $DamageScale[0] / 100;
		$SkillPropertyBoosted = Helper::ElementalDamageBoost($SkillProperty);
		$TrapDamageBonus = Helper::TrueFloor((($Parameters['SkillLevel'] * $DEX) + ($INT * 5)) * (1.5 + ($Parameters['BaseLevel'] / 100))) * (($Parameters['Extra1'] * 20) / 50) + ($Parameters['Extra1'] * 40);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['ATKLow'] * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardDefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin + $TrapDamageBonus);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftDef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::SkillPropertyMultiplier($SkillDamageMin, $SkillPropertyBoosted);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['ATK'] * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardDefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax + $TrapDamageBonus);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftDef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::SkillPropertyMultiplier($SkillDamageMax, $SkillPropertyBoosted);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Warg Strike
	 *
	 * @param	int $Parameters
	 * @return	int $SkillDetails
	 * @since	1.0
	 */
	public static function Skill2243($Parameters)
	{
		// Preparation
		global $WargATK;
		global $WargATKLow;
		$SkillModifier = (($Parameters['SkillLevel'] * 200) + $Parameters['AdditionalSkillDamage']) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($WargATKLow * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardDefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftDef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($WargATK * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardDefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftDef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Warg Bite
	 *
	 * @param	int $Parameters
	 * @return	int $SkillDetails
	 * @since	1.0
	 */
	public static function Skill2244($Parameters)
	{
		// Preparation
		global $WargATK;
		global $WargATKLow;
		// adds an extra 100% base damage if the skill level is five
		$SkillBaseDamage = $Parameters['SkillLevel'] !== 5 ? 400 : 500;
		$SkillModifier = ($SkillBaseDamage + (($Parameters['SkillLevel'] * 200) + $Parameters['AdditionalSkillDamage'])) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($WargATKLow * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardDefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftDef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($WargATK * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardDefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftDef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Fire Trap
	 *
	 * @param	int $Parameters
	 * @return	int $SkillDetails
	 * @since	1.0
	 */
	public static function Skill2253($Parameters)
	{
		// Preparation
		global $INT;
		global $DEX;
		global $DamageScale;
		$SkillModifier = 1 + ($Parameters['AdditionalSkillDamage']) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$SkillProperty = $DamageScale[3] / 100;
		$SkillPropertyBoosted = Helper::ElementalDamageBoost($SkillProperty);
		$TrapDamageBonus = Helper::TrueFloor((($Parameters['SkillLevel'] * $DEX) + ($INT * 5)) * (1.5 + ($Parameters['BaseLevel'] / 100))) * (($Parameters['Extra1'] * 20) / 100) + ($Parameters['Extra1'] * 40);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['ATKLow'] * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardDefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin + $TrapDamageBonus);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftDef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::SkillPropertyMultiplier($SkillDamageMin, $SkillPropertyBoosted);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['ATK'] * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardDefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax + $TrapDamageBonus);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftDef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::SkillPropertyMultiplier($SkillDamageMax, $SkillPropertyBoosted);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Ice Trap
	 *
	 * @param	int $Parameters
	 * @return	int $SkillDetails
	 * @since	1.0
	 */
	public static function Skill2254($Parameters)
	{
		// Preparation
		global $INT;
		global $DEX;
		global $DamageScale;
		
		$SkillModifier = 1 + ($Parameters['AdditionalSkillDamage']) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$SkillProperty = $DamageScale[1] / 100;
		$SkillPropertyBoosted = Helper::ElementalDamageBoost($SkillProperty);
		$TrapDamageBonus = Helper::TrueFloor((($Parameters['SkillLevel'] * $DEX) + ($INT * 5)) * (1.5 + ($Parameters['BaseLevel'] / 100))) * (($Parameters['Extra1'] * 20) / 100) + ($Parameters['Extra1'] * 40);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['ATKLow'] * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardDefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin + $TrapDamageBonus);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftDef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::SkillPropertyMultiplier($SkillDamageMin, $SkillPropertyBoosted);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['ATK'] * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardDefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax + $TrapDamageBonus);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftDef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::SkillPropertyMultiplier($SkillDamageMax, $SkillPropertyBoosted);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Fire Walk
	 *
	 * @param	int $Parameters
	 * @return	int $Results
	 * @since	1.0
	 */
	public static function Skill2443($Parameters)
	{
		// Preparation
		global $DamageScale;
		$SkillModifier = Helper::TrueFloor(($Parameters['SkillLevel'] * 60) * ($Parameters['BaseLevel'] / 100)) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$SkillProperty = $DamageScale[3] / 100;
		$SkillPropertyBoosted = Helper::ElementalDamageBoost($SkillProperty);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['MATKLow'] * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardMdefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftMdef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::SkillPropertyMultiplier($SkillDamageMin, $SkillPropertyBoosted);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['MATK'] * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardMdefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftMdef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::SkillPropertyMultiplier($SkillDamageMax, $SkillPropertyBoosted);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Lightning Walk
	 *
	 * @param	int $Parameters
	 * @return	int $Results
	 * @since	1.0
	 */
	public static function Skill2444($Parameters)
	{
		// Preparation
		global $DamageScale;
		$SkillModifier = Helper::TrueFloor(($Parameters['SkillLevel'] * 60) * ($Parameters['BaseLevel'] / 100)) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$SkillProperty = $DamageScale[1] / 100;
		$SkillPropertyBoosted = Helper::ElementalDamageBoost($SkillProperty);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['MATKLow'] * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardMdefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftMdef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::SkillPropertyMultiplier($SkillDamageMin, $SkillPropertyBoosted);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['MATK'] * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardMdefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftMdef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::SkillPropertyMultiplier($SkillDamageMax, $SkillPropertyBoosted);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Spell Fist Bolt Template
	 *
	 * @param	int $Parameters
	 * @param	int $Property
	 * @return	int $Results
	 * @since	1.0
	 */
	public static function Skill2445Template($Parameters, $Property)
	{
		// Preparation
		global $DamageScale;
		$SkillModifier = 100 / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$SkillProperty = $DamageScale[$Property] / 100;
		$SkillPropertyBoosted = Helper::ElementalDamageBoost($SkillProperty);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['MATKLow'] * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardMdefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftMdef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::SkillPropertyMultiplier($SkillDamageMin, $SkillPropertyBoosted);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['MATK'] * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardMdefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftMdef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::SkillPropertyMultiplier($SkillDamageMax, $SkillPropertyBoosted);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Spell Fist
	 *
	 * @param	int $Parameters
	 * @return	int $Results
	 * @since	1.0
	 */
	public static function Skill2445($Parameters)
	{
		// Preparation
		$Parameters['SkillDamageBonus'] = $Parameters['Extra2'];
		$ColdBolt = self::Skill2445Template($Parameters, 1);
		$FireBolt = self::Skill2445Template($Parameters, 3);
		$LightningBolt = self::Skill2445Template($Parameters, 4);
		$SkillModifier = (($Parameters['SkillLevel'] * 50) + ($Parameters['Extra1'] * 100)) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		
		// Water
		// Min Damage
		$SkillDamageMinColdBolt = Helper::TrueFloor($ColdBolt['API']['Min'] * $SkillModifier);
		#$SkillDamageMinColdBolt = Helper::TrueFloor($SkillDamageMinColdBolt * $SkillDamageMultiplier);
		$SkillDamageMinColdBolt = Helper::TrueFloor($SkillDamageMinColdBolt * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMinColdBolt = Helper::TrueFloor($SkillDamageMinColdBolt * $Parameters['TotalDamageReduction']);
		$SkillDamageMinColdBolt = Helper::PreventNegativeDamage($SkillDamageMinColdBolt);
		// Max Damage
		$SkillDamageMaxColdBolt = Helper::TrueFloor($ColdBolt['API']['Max'] * $SkillModifier);
		#$SkillDamageMaxColdBolt = Helper::TrueFloor($SkillDamageMaxColdBolt * $SkillDamageMultiplier);
		$SkillDamageMaxColdBolt = Helper::TrueFloor($SkillDamageMaxColdBolt * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMaxColdBolt = Helper::TrueFloor($SkillDamageMaxColdBolt * $Parameters['TotalDamageReduction']);
		$SkillDamageMaxColdBolt = Helper::PreventNegativeDamage($SkillDamageMaxColdBolt);
		
		// Fire
		// Min Damage
		$SkillDamageMinFireBolt = Helper::TrueFloor($FireBolt['API']['Min'] * $SkillModifier);
		#$SkillDamageMinFireBolt = Helper::TrueFloor($SkillDamageMinFireBolt * $SkillDamageMultiplier);
		$SkillDamageMinFireBolt = Helper::TrueFloor($SkillDamageMinFireBolt * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMinFireBolt = Helper::TrueFloor($SkillDamageMinFireBolt * $Parameters['TotalDamageReduction']);
		$SkillDamageMinFireBolt = Helper::PreventNegativeDamage($SkillDamageMinFireBolt);
		// Max Damage
		$SkillDamageMaxFireBolt = Helper::TrueFloor($FireBolt['API']['Max'] * $SkillModifier);
		#$SkillDamageMaxFireBolt = Helper::TrueFloor($SkillDamageMaxFireBolt * $SkillDamageMultiplier);
		$SkillDamageMaxFireBolt = Helper::TrueFloor($SkillDamageMaxFireBolt * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMaxFireBolt = Helper::TrueFloor($SkillDamageMaxFireBolt * $Parameters['TotalDamageReduction']);
		$SkillDamageMaxFireBolt = Helper::PreventNegativeDamage($SkillDamageMaxFireBolt);
		
		// Wind
		// Min Damage
		$SkillDamageMinLightningBolt = Helper::TrueFloor($LightningBolt['API']['Min'] * $SkillModifier);
		#$SkillDamageMinLightningBolt = Helper::TrueFloor($SkillDamageMinLightningBolt * $SkillDamageMultiplier);
		$SkillDamageMinLightningBolt = Helper::TrueFloor($SkillDamageMinLightningBolt * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMinLightningBolt = Helper::TrueFloor($SkillDamageMinLightningBolt * $Parameters['TotalDamageReduction']);
		$SkillDamageMinLightningBolt = Helper::PreventNegativeDamage($SkillDamageMinLightningBolt);
		// Max Damage
		$SkillDamageMaxLightningBolt = Helper::TrueFloor($LightningBolt['API']['Max'] * $SkillModifier);
		#$SkillDamageMaxLightningBolt = Helper::TrueFloor($SkillDamageMaxLightningBolt * $SkillDamageMultiplier);
		$SkillDamageMaxLightningBolt = Helper::TrueFloor($SkillDamageMaxLightningBolt * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMaxLightningBolt = Helper::TrueFloor($SkillDamageMaxLightningBolt * $Parameters['TotalDamageReduction']);
		$SkillDamageMaxLightningBolt = Helper::PreventNegativeDamage($SkillDamageMaxLightningBolt);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMinColdBolt . ' &harr; ' . $SkillDamageMaxColdBolt . ' per hit when casted on cold bolt.</dd>
			<dd>' . $SkillDamageMinFireBolt . ' &harr; ' . $SkillDamageMaxFireBolt . ' per hit when casted on fire bolt.</dd>
			<dd>' . $SkillDamageMinLightningBolt . ' &harr; ' . $SkillDamageMaxLightningBolt . ' per hit when casted on lightning bolt.</dd>
		';
		$API = array('Min' => $SkillDamageMinColdBolt, 'Max' => $SkillDamageMaxColdBolt);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Earth Grave
	 *
	 * @param	int $Parameters
	 * @return	int $Results
	 * @since	1.0
	 */
	public static function Skill2446($Parameters)
	{
		// Preparation
		global $INT;
		global $DamageScale;
		$SkillModifier = Helper::TrueFloor((($Parameters['SkillLevel'] * $INT) + ($Parameters['Extra1'] * 200)) * ($Parameters['BaseLevel'] / 100)) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$SkillProperty = $DamageScale[2] / 100;
		$SkillPropertyBoosted = Helper::ElementalDamageBoost($SkillProperty);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['MATKLow'] * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardMdefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftMdef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::SkillPropertyMultiplier($SkillDamageMin, $SkillPropertyBoosted);
		$SkillDamageMin = Helper::SkillHitRounding($SkillDamageMin, 3);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['MATK'] * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardMdefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftMdef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::SkillPropertyMultiplier($SkillDamageMax, $SkillPropertyBoosted);
		$SkillDamageMax = Helper::SkillHitRounding($SkillDamageMax, 3);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Diamond Dust
	 *
	 * @param	int $Parameters
	 * @return	int $Results
	 * @since	1.0
	 */
	public static function Skill2447($Parameters)
	{
		// Preparation
		global $INT;
		global $DamageScale;
		$SkillModifier = Helper::TrueFloor((($Parameters['SkillLevel'] * $INT) + ($Parameters['Extra1'] * 200)) * ($Parameters['BaseLevel'] / 100)) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$SkillProperty = $DamageScale[1] / 100;
		$SkillPropertyBoosted = Helper::ElementalDamageBoost($SkillProperty);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['MATKLow'] * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardMdefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftMdef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::SkillPropertyMultiplier($SkillDamageMin, $SkillPropertyBoosted);
		$SkillDamageMin = Helper::SkillHitRounding($SkillDamageMin, 5);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['MATK'] * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardMdefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftMdef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::SkillPropertyMultiplier($SkillDamageMax, $SkillPropertyBoosted);
		$SkillDamageMax = Helper::SkillHitRounding($SkillDamageMax, 5);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Poison Burst
	 *
	 * @param	int $Parameters
	 * @return	int $Results
	 * @since	1.0
	 */
	public static function Skill2448($Parameters)
	{
		// Preparation
		global $INT;
		global $DamageScale;
		$SkillModifier = Helper::TrueFloor((1000 + ($Parameters['SkillLevel'] * 300)) * ($Parameters['BaseLevel'] / 120)) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$SkillProperty = $DamageScale[5] / 100;
		$SkillPropertyBoosted = Helper::ElementalDamageBoost($SkillProperty);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['MATKLow'] * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardMdefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftMdef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::SkillPropertyMultiplier($SkillDamageMin, $SkillPropertyBoosted);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['MATK'] * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardMdefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftMdef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::SkillPropertyMultiplier($SkillDamageMax, $SkillPropertyBoosted);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Psychic Wave Template
	 *
	 * @param	int $Parameters
	 * @param	int $Property
	 * @return	int $Results
	 * @since	1.0
	 */
	public static function Skill2449Template($Parameters, $Property)
	{
		// Preparation
		global $INT;
		global $DamageScale;
		$SkillModifier = Helper::TrueFloor((($Parameters['SkillLevel'] * 70) + ($INT * 3)) * ($Parameters['BaseLevel'] / 100)) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$SkillProperty = $DamageScale[$Property] / 100;
		$SkillPropertyBoosted = Helper::ElementalDamageBoost($SkillProperty);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['MATKLow'] * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardMdefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftMdef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::SkillPropertyMultiplier($SkillDamageMin, $SkillPropertyBoosted);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['MATK'] * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardMdefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftMdef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::SkillPropertyMultiplier($SkillDamageMax, $SkillPropertyBoosted);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . ' per hit.</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Psychic Wave
	 *
	 * @param	int $Parameters
	 * @return	int $Results
	 * @since	1.0
	 */
	public static function Skill2449($Parameters)
	{
		// Preparation
		$PsychicWaveNeutral = self::Skill2449Template($Parameters, 0);
		$PsychicWaveEarth = self::Skill2449Template($Parameters, 2);
		$PsychicWaveFire = self::Skill2449Template($Parameters, 3);
		$PsychicWaveWater = self::Skill2449Template($Parameters, 1);
		$PsychicWaveWind = self::Skill2449Template($Parameters, 4);
		
		// Views
		$PublicHTML = '
			<dd>' . $PsychicWaveNeutral['API']['Min'] . ' &harr; ' . $PsychicWaveNeutral['API']['Max'] . ' per hit.</dd>
			<dd>' . $PsychicWaveEarth['API']['Min'] . ' &harr; ' . $PsychicWaveEarth['API']['Max'] . ' per hit when using level 2 Tera\'s passive.</dd>
			<dd>' . $PsychicWaveFire['API']['Min'] . ' &harr; ' . $PsychicWaveFire['API']['Max'] . ' per hit when using level 2 Agni\'s passive.</dd>
			<dd>' . $PsychicWaveWater['API']['Min'] . ' &harr; ' . $PsychicWaveWater['API']['Max'] . ' per hit when using level 2 Aqua\'s passive.</dd>
			<dd>' . $PsychicWaveWind['API']['Min'] . ' &harr; ' . $PsychicWaveWind['API']['Max'] . ' per hit when using level 2 Ventus\'s passive.</dd>
		';
		$API = array('Min' => $PsychicWaveNeutral['API']['Min'], 'Max' => $PsychicWaveNeutral['API']['Max']);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Killing Cloud
	 *
	 * @param	int $Parameters
	 * @return	int $Results
	 * @since	1.0
	 */
	public static function Skill2450($Parameters)
	{
		// Preparation
		global $DamageScale;
		$SkillModifier = Helper::TrueFloor(($Parameters['SkillLevel'] * 40) * ($Parameters['BaseLevel'] / 100)) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$SkillProperty = $DamageScale[5] / 100;
		$SkillPropertyBoosted = Helper::ElementalDamageBoost($SkillProperty);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['MATKLow'] * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardMdefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftMdef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::SkillPropertyMultiplier($SkillDamageMin, $SkillPropertyBoosted);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['MATK'] * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardMdefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftMdef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::SkillPropertyMultiplier($SkillDamageMax, $SkillPropertyBoosted);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . ' per hit.</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Varetyr Spear
	 *
	 * @param	int $Parameters
	 * @return	int $Results
	 * @since	1.0
	 */
	public static function Skill2454($Parameters)
	{
		// Preparation
		global $INT;
		global $DamageScale;
		$SkillModifierATK = Helper::TrueFloor((($Parameters['SkillLevel'] * 50) + ($Parameters['Extra1'] * 50)) * ($Parameters['BaseLevel'] / 100)) / 100;
		$SkillModifierMATK = Helper::TrueFloor((($Parameters['SkillLevel'] * $INT) + ($Parameters['Extra2'] * 50)) * ($Parameters['BaseLevel'] / 100)) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$SkillProperty = $DamageScale[4] / 100;
		$SkillPropertyBoosted = Helper::ElementalDamageBoost($SkillProperty);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['ATKLow'] * $SkillModifierATK);
		$SkillDamageMin = Helper::TrueFloor($Parameters['MATKLow'] * $SkillModifierMATK) + $SkillDamageMin;
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - ($Parameters['HardDef'] + $Parameters['SoftDef'] + $Parameters['HardMdef'] + $Parameters['SoftMdef']));
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::SkillPropertyMultiplier($SkillDamageMin, $SkillPropertyBoosted);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['ATK'] * $SkillModifierATK);
		$SkillDamageMax = Helper::TrueFloor($Parameters['MATK'] * $SkillModifierMATK) + $SkillDamageMax;
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - ($Parameters['HardDef'] + $Parameters['SoftDef'] + $Parameters['HardMdef'] + $Parameters['SoftMdef']));
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::SkillPropertyMultiplier($SkillDamageMax, $SkillPropertyBoosted);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Cart Cannon
	 *
	 * @param	int $Parameters
	 * @return	int $SkillDetails
	 * @since	1.0
	 */
	public static function Skill2477($Parameters)
	{
		// Preparation
		global $AmmunitionATK2;
		global $AttackingProperty;
		global $INT;
		global $PropertyMultiplierplier;
		$SkillModifier = ((($Parameters['SkillLevel'] * 60) + Helper::TrueFloor(($Parameters['Extra1'] * 50) * ($INT / 40))) + $Parameters['AdditionalSkillDamage']) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor(($Parameters['ATKLow'] + $AmmunitionATK2) * $Parameters['RangedMultiplier']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['RangedDamageReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['HardDef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftDef']);
		if($AttackingProperty == 26 || $AttackingProperty == 27 || $AttackingProperty == 28)
		{
			$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $PropertyMultiplierplier);
		}
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor(($Parameters['ATK'] + $AmmunitionATK2) * $Parameters['RangedMultiplier']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['RangedDamageReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['HardDef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftDef']);
		if($AttackingProperty == 26 || $AttackingProperty == 27 || $AttackingProperty == 28)
		{
			$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $PropertyMultiplierplier);
		}
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Round Trip
	 *
	 * @param	int $Parameters
	 * @return	int $SkillDetails
	 * @since	1.0
	 */
	public static function Skill2565($Parameters)
	{
		// Preparation
		$SkillModifier = ((1000 + ($Parameters['SkillLevel'] * 300)) + $Parameters['AdditionalSkillDamage']) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['ATKLow'] * $Parameters['RangedMultiplier']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['RangedDamageReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardDefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftDef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['ATK'] * $Parameters['RangedMultiplier']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['RangedDamageReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardDefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftDef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Fire Rain
	 *
	 * @param	int $Parameters
	 * @return	int $SkillDetails
	 * @since	1.0
	 */
	public static function Skill2567($Parameters)
	{
		// Preparation
		$SkillModifier = ((2500 + ($Parameters['SkillLevel'] * 1300)) + $Parameters['AdditionalSkillDamage']) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['ATKLow'] * $Parameters['RangedMultiplier']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['RangedDamageReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardDefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftDef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['ATK'] * $Parameters['RangedMultiplier']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['RangedDamageReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardDefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftDef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Slug Shot
	 *
	 * @param	int $Parameters
	 * @return	int $SkillDetails
	 * @since	1.0
	 */
	public static function Skill2570($Parameters)
	{
		// Preparation
		global $isPlayer;
		global $TargetSize;
		// uses a different base damage modifier depending on whether the target is a player or a monster
		$BaseDamage = $isPlayer ? 2000 : 1200;
		// Multiplierplies the base damage depending on the size of the target
		$BaseDamageTargetSizeMultiplier = array(2, 3, 4);
		$SkillModifier = ((($Parameters['SkillLevel'] * $BaseDamage) * $BaseDamageTargetSizeMultiplier[$TargetSize]) + $Parameters['AdditionalSkillDamage']) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['ATKLow'] * $Parameters['RangedMultiplier']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['RangedDamageReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardDefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftDef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['ATK'] * $Parameters['RangedMultiplier']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['RangedDamageReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardDefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftDef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Silvervine Stem Spear Template
	 *
	 * @param	int $Parameters
	 * @param	int $Property
	 * @return	int $Results
	 * @since	1.0
	 */
	public static function Skill5026Template($Parameters, $Property)
	{
		// Preparation
		global $DamageScale;
		$SkillModifier = (700 * $Parameters['SkillLevel']) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$SkillProperty = $DamageScale[$Property] / 100;
		$SkillPropertyBoosted = Helper::ElementalDamageBoost($SkillProperty);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['MATKLow'] * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardMdefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftMdef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::SkillPropertyMultiplier($SkillDamageMin, $SkillPropertyBoosted);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['MATK'] * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardMdefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftMdef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::SkillPropertyMultiplier($SkillDamageMax, $SkillPropertyBoosted);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageMultiplier']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . ' when using level 1 (Earth)</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Silvervine Stem Spear
	 *
	 * @param	int $Parameters
	 * @return	int $Results
	 * @since	1.0
	 */
	public static function Skill5026($Parameters)
	{
		// Preparation
		$SilvervineStemSpearEarth = self::Skill5026Template($Parameters, 2);
		$SilvervineStemSpearFire = self::Skill5026Template($Parameters, 3);
		$SilvervineStemSpearWater = self::Skill5026Template($Parameters, 1);
		$SilvervineStemSpearWind = self::Skill5026Template($Parameters, 4);
		$SilvervineStemSpearGhost = self::Skill5026Template($Parameters, 8);
		
		// Views
		$PublicHTML = '
			<dd>' . $SilvervineStemSpearEarth['API']['Min'] . ' &harr; ' . $SilvervineStemSpearEarth['API']['Max'] . ' when using level 1 (Earth)</dd>
			<dd>' . $SilvervineStemSpearFire['API']['Min'] . ' &harr; ' . $SilvervineStemSpearFire['API']['Max'] . ' when using level 2 (Fire)</dd>
			<dd>' . $SilvervineStemSpearWater['API']['Min'] . ' &harr; ' . $SilvervineStemSpearWater['API']['Max'] . ' when using level 3 (Water)</dd>
			<dd>' . $SilvervineStemSpearWind['API']['Min'] . ' &harr; ' . $SilvervineStemSpearWind['API']['Max'] . ' when using level 4 (Wind)</dd>
			<dd>' . $SilvervineStemSpearGhost['API']['Min'] . ' &harr; ' . $SilvervineStemSpearGhost['API']['Max'] . ' when using level 5 (Ghost)</dd>
		';
		$API = array('Min' => $SilvervineStemSpearEarth['API']['Min'], 'Max' => $SilvervineStemSpearEarth['API']['Max']);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Catnip Meteor
	 *
	 * @param	int $Parameters
	 * @return	int $Results
	 * @since	1.0
	 */
	public static function Skill5028($Parameters)
	{
		// Preparation
		global $DamageScale;
		$SkillModifier = (200 + (100 * $Parameters['SkillLevel'])) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$SkillProperty = $DamageScale[0] / 100;
		$SkillPropertyBoosted = Helper::ElementalDamageBoost($SkillProperty);
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['MATKLow'] * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardMdefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftMdef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::SkillPropertyMultiplier($SkillDamageMin, $SkillPropertyBoosted);
		$SkillDamageMin = Helper::SkillHitRounding($SkillDamageMin, 5);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['MATK'] * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardMdefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftMdef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::SkillPropertyMultiplier($SkillDamageMax, $SkillPropertyBoosted);
		$SkillDamageMax = Helper::SkillHitRounding($SkillDamageMax, 5);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . ' per hit.</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Picky Peck
	 *
	 * @param	int $Parameters
	 * @return	int $Results
	 * @since	1.0
	 */
	public static function Skill5033($Parameters)
	{
		// Preparation
		$SkillModifier = (200 + (100 * $Parameters['SkillLevel'])) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$HalfLifeBonus = 2;
		$SpiritOfLifeBonus = (100 + Helper::TrueFloor(120 * ($Parameters['Extra1'] / 100))) / 100;
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['ATKLow'] * $Parameters['RangedMultiplier']);
		$SkillDamageMin = $SkillDamageMinHalfLife = Helper::TrueFloor($SkillDamageMin * $Parameters['RangedDamageReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SpiritOfLifeBonus);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardDefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftDef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::SkillHitRounding($SkillDamageMin, 5);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['ATK'] * $Parameters['RangedMultiplier']);
		$SkillDamageMax = $SkillDamageMaxHalfLife = Helper::TrueFloor($SkillDamageMax * $Parameters['RangedDamageReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SpiritOfLifeBonus);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardDefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftDef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::SkillHitRounding($SkillDamageMax, 5);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		// Min Damage (if the target is under 50% of its max hp)
		$SkillDamageMinHalfLife = Helper::TrueFloor($SkillDamageMinHalfLife * ($SkillModifier * $HalfLifeBonus));
		$SkillDamageMinHalfLife = Helper::TrueFloor($SkillDamageMinHalfLife * $SpiritOfLifeBonus);
		$SkillDamageMinHalfLife = Helper::TrueFloor($SkillDamageMinHalfLife * $Parameters['HardDefReduction']);
		$SkillDamageMinHalfLife = Helper::TrueFloor($SkillDamageMinHalfLife - $Parameters['SoftDef']);
		$SkillDamageMinHalfLife = Helper::TrueFloor($SkillDamageMinHalfLife * $SkillDamageMultiplier);
		$SkillDamageMinHalfLife = Helper::SkillHitRounding($SkillDamageMinHalfLife, 5);
		$SkillDamageMinHalfLife = Helper::TrueFloor($SkillDamageMinHalfLife * $Parameters['TotalDamageReduction']);
		$SkillDamageMinHalfLife = Helper::PreventNegativeDamage($SkillDamageMinHalfLife);
		// Max Damage (if the target is under 50% of its max hp)
		$SkillDamageMaxHalfLife = Helper::TrueFloor($SkillDamageMaxHalfLife * ($SkillModifier * $HalfLifeBonus));
		$SkillDamageMaxHalfLife = Helper::TrueFloor($SkillDamageMaxHalfLife * $SpiritOfLifeBonus);
		$SkillDamageMaxHalfLife = Helper::TrueFloor($SkillDamageMaxHalfLife * $Parameters['HardDefReduction']);
		$SkillDamageMaxHalfLife = Helper::TrueFloor($SkillDamageMaxHalfLife - $Parameters['SoftDef']);
		$SkillDamageMaxHalfLife = Helper::TrueFloor($SkillDamageMaxHalfLife * $SkillDamageMultiplier);
		$SkillDamageMaxHalfLife = Helper::SkillHitRounding($SkillDamageMaxHalfLife, 5);
		$SkillDamageMaxHalfLife = Helper::TrueFloor($SkillDamageMaxHalfLife * $Parameters['TotalDamageReduction']);
		$SkillDamageMaxHalfLife = Helper::PreventNegativeDamage($SkillDamageMaxHalfLife);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
			<dd>' . $SkillDamageMinHalfLife . ' &harr; ' . $SkillDamageMaxHalfLife . ' if the target is under 50% of its max hp.</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Lunatic Carrot Beat
	 *
	 * @param	int $Parameters
	 * @return	int $Results
	 * @since	1.0
	 */
	public static function Skill5036($Parameters)
	{
		// Preparation
		$SkillModifier = (200 + (100 * $Parameters['SkillLevel'])) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$SpiritOfLifeBonus = (100 + Helper::TrueFloor(120 * ($Parameters['Extra1'] / 100))) / 100;
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['ATKLow'] * $Parameters['RangedMultiplier']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['RangedDamageReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SpiritOfLifeBonus);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardDefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftDef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::SkillHitRounding($SkillDamageMin, 3);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['ATK'] * $Parameters['RangedMultiplier']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['RangedDamageReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SpiritOfLifeBonus);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardDefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftDef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::SkillHitRounding($SkillDamageMax, 3);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
	/**
	 * Spirit of Savage
	 *
	 * @param	int $Parameters
	 * @return	int $Results
	 * @since	1.0
	 */
	public static function Skill5046($Parameters)
	{
		// Preparation
		$SkillModifier = (250 + (150 * $Parameters['SkillLevel'])) / 100;
		$SkillDamageMultiplier = 1 + ($Parameters['SkillDamageBonus'] / 100);
		$SpiritOfLifeBonus = (100 + Helper::TrueFloor(120 * ($Parameters['Extra1'] / 100))) / 100;
		
		// Min Damage
		$SkillDamageMin = Helper::TrueFloor($Parameters['ATKLow'] * $Parameters['RangedMultiplier']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['RangedDamageReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillModifier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SpiritOfLifeBonus);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['HardDefReduction']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin - $Parameters['SoftDef']);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $SkillDamageMultiplier);
		$SkillDamageMin = Helper::TrueFloor($SkillDamageMin * $Parameters['TotalDamageReduction']);
		$SkillDamageMin = Helper::PreventNegativeDamage($SkillDamageMin);
		// Max Damage
		$SkillDamageMax = Helper::TrueFloor($Parameters['ATK'] * $Parameters['RangedMultiplier']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['RangedDamageReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillModifier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SpiritOfLifeBonus);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['HardDefReduction']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax - $Parameters['SoftDef']);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $SkillDamageMultiplier);
		$SkillDamageMax = Helper::TrueFloor($SkillDamageMax * $Parameters['TotalDamageReduction']);
		$SkillDamageMax = Helper::PreventNegativeDamage($SkillDamageMax);
		
		// Views
		$PublicHTML = '
			<dd>' . $SkillDamageMin . ' &harr; ' . $SkillDamageMax . '</dd>
		';
		$API = array('Min' => $SkillDamageMin, 'Max' => $SkillDamageMax);
		$SkillDetails = array('PublicHTML' => $PublicHTML, 'API' => $API);
		return $SkillDetails;
	}
}
?>