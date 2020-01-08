<?php
/**
 * This file contains common functions used to by the damage calculator.
 *
 * @package		DamageCALC
 * @author		Michael McStay <XYZ>
 * @license		https://opensource.org/licenses/GPL-3.0 GNU General Public License 3
 * @version		1.0
 * @since		1.0
 */
/**
 * Helper class
 *
 * The class is used to call common functions used to by the damage calculator.
 *
 * @package		DamageCALC
 * @author		Michael McStay <XYZ>
 * @version		1.0
 * @since		1.0
 */
class Helper {
	/**
	 * calculates the attack value required for the final stages of the damage formula
	 *
	 * @param	int $WeaponATK
	 * @return	int $ATK
	 * @since	1.0
	 */
	public static function CalculateATK($WeaponATK)
	{
		global $AttackMultiplier;
		global $BuffAttack;
		global $EDPBonus;
		global $EnchantDeadlyPoison;
		global $ExtraATK;
		global $isBoss;
		global $isMagnumBreak;
		global $MasteryAttack;
		global $MonsterFamilyMultiplier;
		global $TargetPropertyMultiplier;
		global $PropertyMultiplier;
		global $RaceMultiplier;
		global $SizeMultiplier;
		global $SizePenaltyMultiplier;
		global $StatusATK;
		global $PureAttackMultiplier;

		$WeaponATK = self::TrueFloor($WeaponATK * $PureAttackMultiplier);
		if($EnchantDeadlyPoison > 0)
		{
			// this seems to be a conditional that varies on a monster to monster basis, for example it works on a fabre, but not a poring or a peco peco egg, but does work on a peco peco etc etc
			$ATK = Helper::TrueFloor((($WeaponATK * $SizePenaltyMultiplier) * $EDPBonus['Multiplier1']) * $EDPBonus['Multiplier2']);
			$ATK = ($ATK * $RaceMultiplier);
			$ATK = ($ATK * $SizeMultiplier);
			$ATK = ($ATK * $MonsterFamilyMultiplier);
			$ATK = ($ATK * $TargetPropertyMultiplier);
			$ATK = ($ATK * $EDPBonus['Multiplier3']);
			$ATK = ($ATK * $AttackMultiplier);
			$ATK2 = ($ExtraATK);
			$ATK2 = ($ATK2 * $RaceMultiplier);
			$ATK2 = ($ATK2 * $SizeMultiplier);
			$ATK2 = ($ATK2 * $MonsterFamilyMultiplier);
			$ATK2 = ($ATK2 * $TargetPropertyMultiplier);
			$ATK2 = ($ATK2 * $EDPBonus['Multiplier4']);
			$ATK2 = ($ATK2 * $AttackMultiplier);
			$ATK = Helper::TrueFloor($ATK + $ATK2);
		}
		else
		{
			$ATK = Helper::TrueFloor(Helper::TrueFloor($WeaponATK * $SizePenaltyMultiplier) + $ExtraATK);
			$ATK = Helper::TrueFloor($ATK * $RaceMultiplier);
			$ATK = Helper::TrueFloor($ATK * $SizeMultiplier);
			$ATK = Helper::TrueFloor($ATK * $MonsterFamilyMultiplier);
			$ATK = Helper::TrueFloor($ATK * $TargetPropertyMultiplier);
			$ATK = Helper::TrueFloor($ATK * $AttackMultiplier);
		}

		if($isMagnumBreak)
		{
			$MagnumBreakBonus = (Helper::TrueFloor($ATK * 1.2) - $ATK);
			if($SkillPropertyMultiplierMagnumBreak >= 1)
			{
				$MagnumBreakBonus = Helper::TrueFloor($MagnumBreakBonus * $SkillPropertyMultiplierMagnumBreak);
			}
			else
			{
				$MagnumBreakBonus = ceil($MagnumBreakBonus * $SkillPropertyMultiplierMagnumBreak);
			}
			$ATK = $ATK + $MagnumBreakBonus;
		}

		$ATK = Helper::Reductions($ATK);
		$StatusATK = Helper::Reductions($StatusATK);
		// applies the property Multiplierplier which is based on the enemies defending property versus the users attacking property
		if($PropertyMultiplier >= 1)
		{
			$ATK = Helper::TrueFloor($ATK * $PropertyMultiplier);
		}
		else
		{
			$ATK = ceil($ATK * $PropertyMultiplier);
		}
		$ATK = (self::TrueFloor($StatusATK * $PureAttackMultiplier) * 2) + $ATK + $MasteryAttack + $BuffAttack;
		return $ATK;
	}

	/**
	 * calculates the magic attack value required for the final stages of the damage formula
	 *
	 * @param	int $WeaponMATK
	 * @return	int $MATK
	 * @since	1.0
	 */
	public static function CalculateMATK($WeaponMATK)
	{
		global $MagicAttackMultiplier;
		global $BuffMagicAttack;
		global $ExtraMATK;
		global $MagicElementMultiplier;
		global $MonsterFamilyMagicMultiplier;
		global $RaceMagicMultiplier;
		global $SizeMagicMultiplier;
		global $StatusMATK;
		global $TargetPropertyMagicMultiplier;
		global $PureMagicAttackMultiplier;

		$WeaponMATK = self::TrueFloor($WeaponMATK * $PureMagicAttackMultiplier);
		$MATK = $WeaponMATK + self::TrueFloor($StatusMATK * $PureMagicAttackMultiplier) + $ExtraMATK + $BuffMagicAttack;
		$MATK = Helper::TrueFloor($MATK * $RaceMagicMultiplier);
		$MATK = Helper::TrueFloor($MATK * $SizeMagicMultiplier);
		$MATK = Helper::TrueFloor($MATK * $TargetPropertyMagicMultiplier);
		$MATK = Helper::TrueFloor($MATK * $MonsterFamilyMagicMultiplier);
		$MATK = Helper::TrueFloor($MATK * $MagicElementMultiplier);
		$MATK = Helper::TrueFloor($MATK * $MagicAttackMultiplier);
		$MATK = Helper::Reductions($MATK);
		return $MATK;
	}

	/**
	 * creates a text input with appended text
	 *
	 * @param	string $Name
	 * @param	string $Id
	 * @param	string $Value
	 * @param	string $Append
	 * @param	string $Title
	 * @return	string $String
	 * @since	1.0
	 */
	public static function CreateAppendedTextInput($Name, $Id, $Value, $Append, $Title = '')
	{
		$String = '';

		$String .= '
			<div class="col-md-2">
			<!-- Text Input Appended -->
			<div class="form-group">
			';

			$String .= !empty($Title) ? '<label class="control-label text-primary" data-toggle="tooltip" for="' . $Id . '" title="' . $Title . '">' : '<label class="control-label" for="' . $Id . '">';

			$String .= '
			' . $Name . '</label>
			<div class="input-group">
			<input id="' . $Id . '" name="' . $Id . '" placeholder="' . $Name . '" class="form-control input-md" type="text" value="' . $Value . '">
			<span class="input-group-addon">' . $Append . '</span>
			</div>
			</div>
			</div>
		';

		return $String;
	}

	/**
	 * creates a hidden text input
	 *
	 * @param	string $Name
	 * @param	string $Id
	 * @param	string $Value
	 * @param	string $Title
	 * @return	string $String
	 * @since	1.0
	 */
	public static function CreateHiddenTextInput($Name, $Id, $Value, $Title = '')
	{
		$String = '';

		$String .= '
			<div class="col-md-2 sr-only">
			<!-- Text Input -->
			<div class="form-group">
			';

			$String .= !empty($Title) ? '<label class="control-label text-primary" data-toggle="tooltip" for="' . $Id . '" title="' . $Title . '">' : '<label class="control-label" for="' . $Id . '">';

			$String .= '
			' . $Name . '</label>
			<div>
			<input id="' . $Id . '" name="' . $Id . '" placeholder="' . $Name . '" class="form-control input-md" type="text" value="' . $Value . '">
			</div>
			</div>
			</div>
		';

		return $String;
	}

	/**
	 * creates a select which runs a list from an array
	 *
	 * @param	string $Name
	 * @param	string $Id
	 * @param	string $Selected
	 * @param	int $Array
	 * @param	string $Title
	 * @return	string $String
	 * @since	1.0
	 */
	public static function CreateSelectArray($Name, $Id, $Selected, $Array, $Title = '')
	{
		$String = '';

		$String .= '
			<div class="col-md-2">
			<!-- Select Basic -->
			<div class="form-group">
			';

			$String .= !empty($Title) ? '<label class="control-label text-primary" data-toggle="tooltip" for="' . $Id . '" title="' . $Title . '">' : '<label class="control-label" for="' . $Id . '">';

			$String .= '
			' . $Name . '</label>
			<div>
			<select id="' . $Id . '" name="' . $Id . '" class="form-control">
		';

		foreach($Array as $Value)
		{
			if($i == $Selected)
			{
				$String .= '
					<option selected value="' . $Value . '">' . $Value . '</option>
				';
			}
			else
			{
				$String .= '
					<option value="' . $Value . '">' . $Value . '</option>
				';
			}
		}

		$String .= '
			</select>
			</div>
			</div>
			</div>
		';

		return $String;
	}

	/**
	 * creates a select which runs a list from an associative array
	 *
	 * @param	string $Name
	 * @param	string $Id
	 * @param	string $Selected
	 * @param	int $Array
	 * @param	string $Title
	 * @return	string $String
	 * @since	1.0
	 */
	public static function CreateSelectArrayAssociative($Name, $Id, $Selected, $Array, $Title = '')
	{
		$String = '';
		$String .= '
			<div class="col-md-2">
			<!-- Select Basic -->
			<div class="form-group">
			';

			$String .= !empty($Title) ? '<label class="control-label text-primary" data-toggle="tooltip" for="' . $Id . '" title="' . $Title . '">' : '<label class="control-label" for="' . $Id . '">';

			$String .= '
			' . $Name . '</label>
			<div>
			<select id="' . $Id . '" name="' . $Id . '" class="form-control">
		';

		foreach($Array as $object)
		{
			if($object['value'] == $Selected)
			{
				$String .= '
					<option selected value="' . $object['value'] . '">' . $object['name'] . '</option>
				';
			}
			else
			{
				$String .= '
					<option value="' . $object['value'] . '">' . $object['name'] . '</option>
				';
			}
		}

		$String .= '
			</select>
			</div>
			</div>
			</div>
		';

		return $String;
	}

	/**
	 * creates a select which runs a boolean list
	 *
	 * @param	string $Name
	 * @param	string $Id
	 * @param	string $Selected
	 * @param	string $Title
	 * @return	string $String
	 * @since	1.0
	 */
	public static function CreateSelectBoolean($Name, $Id, $Selected, $Title = '')
	{
		$String = '';

		$String .= '
			<div class="col-md-2">
			<!-- Select Basic -->
			<div class="form-group">
			';

			$String .= !empty($Title) ? '<label class="control-label text-primary" data-toggle="tooltip" for="' . $Id . '" title="' . $Title . '">' : '<label class="control-label" for="' . $Id . '">';

			$String .= '
			' . $Name . '</label>
			<div>
			<select id="' . $Id . '" name="' . $Id . '" class="form-control">
		';

		if($Selected == 1)
		{
			$String .= '
				<option selected value="1">Yes</option>
				<option value="0">No</option>
			';
		}
		else
		{
			$String .= '
				<option value="1">Yes</option>
				<option selected value="0">No</option>
			';
		}

		$String .= '
			</select>
			</div>
			</div>
			</div>
		';

		return $String;
	}

	/**
	 * creates a select which runs from a number range
	 *
	 * @param	string $Name
	 * @param	string $Id
	 * @param	string $Selected
	 * @param	int $From
	 * @param	int $To
	 * @param	string $Title
	 * @return	string $String
	 * @since	1.0
	 */
	public static function CreateSelectCounter($Name, $Id, $Selected, $From, $To, $Title = '')
	{
		$String = '';

		$String .= '
			<div class="col-md-2">
			<!-- Select Basic -->
			<div class="form-group">
			';

			$String .= !empty($Title) ? '<label class="control-label text-primary" data-toggle="tooltip" for="' . $Id . '" title="' . $Title . '">' : '<label class="control-label" for="' . $Id . '">';

			$String .= '
			' . $Name . '</label>
			<div>
			<select id="' . $Id . '" name="' . $Id . '" class="form-control">
		';

		for($i = $From; $i <= $To; $i += 1)
		{
			if($i == $Selected)
			{
				$String .= '
					<option selected value="' . $i . '">' . $i . '</option>
				';
			}
			else
			{
				$String .= '
					<option value="' . $i . '">' . $i . '</option>
				';
			}
		}

		$String .= '
			</select>
			</div>
			</div>
			</div>
		';

		return $String;
	}

	/**
	 * creates a text input
	 *
	 * @param	string $Name
	 * @param	string $Id
	 * @param	string $Value
	 * @param	string $Title
	 * @return	string $String
	 * @since	1.0
	 */
	public static function CreateTextInput($Name, $Id, $Value, $Title = '')
	{
		$String = '';

		$String .= '
			<div class="col-md-2">
			<!-- Text Input -->
			<div class="form-group">
			';

			$String .= !empty($Title) ? '<label class="control-label text-primary" data-toggle="tooltip" for="' . $Id . '" title="' . $Title . '">' : '<label class="control-label" for="' . $Id . '">';

			$String .= '
			' . $Name . '</label>
			<div>
			<input id="' . $Id . '" name="' . $Id . '" placeholder="' . $Name . '" class="form-control input-md" type="text" value="' . $Value . '">
			</div>
			</div>
			</div>
		';

		return $String;
	}

	/**
	 * creates a text input that can be copied
	 *
	 * @param	string $Name
	 * @param	string $Id
	 * @param	string $Value
	 * @param	string $Title
	 * @return	string $String
	 * @since	1.0
	 */
	public static function CreateTextInputCopyMode($Name, $Value, $Title = '')
	{
		$String = '';

		$String .= '
			<div class="col-md-2">
			<!-- Text Input -->
			<div class="form-group">
			';

			$String .= !empty($Title) ? '<label class="control-label text-primary" data-toggle="tooltip" title="' . $Title . '">' : '<label class="control-label" for="surl">';

			$String .= '
			' . $Name . '</label>
			<div>
			<input placeholder="' . $Name . '" class="form-control input-md copyme" type="text" value="' . $Value . '" readonly>
			</div>
			</div>
			</div>
		';

		return $String;
	}

	/**
	 * grabs the variables required for the enchant deadly poison calculation
	 *
	 * @param	int $EnchantDeadlyPoison
	 * @return	array $EDPBonus
	 * @since	1.0
	 */
	public static function EDPBonus($EnchantDeadlyPoison)
	{
		// this dictates the fourth Multiplierplier and the position depends on the level of enchant deadly poison
		$EDPTable = array(1, 1.3, 1.9, 2.6, 3.2, 4);

		// adds a special modifier for boss only targets
		$SpecialBonusDamage = 1.05;

		// obtains the enchant deadly poison Multiplierplicative values if the skill is active
		$EDPBonus = $EnchantDeadlyPoison > 0 ? array('Multiplier1' => 1.25, 'Multiplier2' => $SpecialBonusDamage, 'Multiplier3' => (150 + ($EnchantDeadlyPoison * 50)) / 100, 'Multiplier4' => $EDPTable[$EnchantDeadlyPoison]) : array('Multiplier1' => 1, 'Multiplier2' => 1, 'Multiplier3' => 1, 'Multiplier4' => 1);

		return $EDPBonus;
	}

	/**
	 * grabs the information relating to a defending property
	 *
	 * @param	int $PropertyId
	 * @return	array $Array
	 * @since	1.0
	 */
	public static function GetProperty($PropertyId)
	{
		global $PropertyList;

		// go through each possible property variation in the list
		foreach($PropertyList as $Property)
		{
			// if the current property matches the property given by the users target store the information in an array for later use
			if($Property['id'] == $PropertyId)
			{
				$Array = array('id' => $Property['id'], 'name' => $Property['name'], 'damagescale' => $Property['damagescale']);
				return $Array;
			}
		}
	}

	/**
	 * grabs and calculates any boost in damage from a weapons upgrade details
	 *
	 * @param	int $WeaponLevel
	 * @param	int $WeaponRefinement
	 * @return	array $Array
	 * @since	1.0
	 */
	public static function GetRefinementBonus($WeaponLevel, $WeaponRefinement)
	{
		global $RefinementBonusList;
		$Bonus = $OverUpgradeBonus = 0;

		// gets the table bonus that matches the users weapon level
		$RefinementTable = $RefinementBonusList[$WeaponLevel - 1];

		// grabs the bonus attack
		$Bonus = $WeaponRefinement * $RefinementTable['bonus'];

		// grabs the high bonus attack and adds it to the bonus attack if the weapons upgrade level is sixteen or higher
		$Bonus += $WeaponRefinement >= 16 ? ($WeaponRefinement - 15) * $RefinementTable['high'] : 0;

		// grabs the overupgrade bonus attack if the weapons upgrade level is higher than its safe upgrade limit.
		$OverUpgradeBonus = $WeaponRefinement > $RefinementTable['limit'] ? ($WeaponRefinement - $RefinementTable['limit']) * $RefinementTable['overupgrade'] : 0;

		$Array = array('bonus' => $Bonus, 'overupgrade' => $OverUpgradeBonus);
		return $Array;
	}

	/**
	 * checks to see if a weapon is ranged or not
	 *
	 * @param	int $WeaponType
	 * @return	boolean
	 * @since	1.0
	 */
	public static function RangedWeapon($WeaponType)
	{
		$WeaponTypeList = array(10,14,15,16);

		return in_array($WeaponType, $WeaponTypeList);
	}

	/**
	 * prevents damage from going below zero
	 *
	 * @param	int $Damage
	 * @return	int $Damage
	 * @since	1.0
	 */
	public static function PreventNegativeDamage($Damage)
	{
		// prevents negative damage values from appearing if the damage is less than one
		$Damage = $Damage < 1 ? 0 : $Damage;
		return $Damage;
	}

	/**
	 * adds additional damage to a property Multiplierplier, for example something with 0 Multiplierplier could have 20 added, thus making it 0.2 damage dealt rather than 0
	 *
	 * @param	int $SkillProperty
	 * @param	int $ElementalDamageBoost
	 * @return	int $SkillProperty
	 * @since	1.0
	 */
	public static function ElementalDamageBoost($SkillProperty)
	{
		global $ElementalDamageBoost;
		return $SkillProperty + ($ElementalDamageBoost / 100);
	}

	/**
	 * applies the property Multiplier and floors or ceils depending on the Multiplier value of the variable
	 *
	 * @param	int $Variable
	 * @param	int $SkillPropertyMultiplier
	 * @return	int $Variable
	 * @since	1.0
	 */
	public static function SkillPropertyMultiplier($Variable, $SkillPropertyMultiplier)
	{
		// positive Multiplierpliers are floored where as negative Multiplierpliers are ceiled
		return $SkillPropertyMultiplier >= 1 ? self::TrueFloor($Variable * $SkillPropertyMultiplier) : ceil($Variable * $SkillPropertyMultiplier);
	}

	/**
	 * applies Reductions as part of the attack calculation
	 *
	 * @param	int $ATK
	 * @return	int $ATK
	 * @since	1.0
	 */
	public static function Reductions($ATK)
	{
		global $isPlayer;
		global $PropertyReduction;
		global $RaceReduction;
		global $SizeReduction;
		global $TargetPropertyReduction;

		// only applies Reductions if the target is a player
		if($isPlayer)
		{
			$ATK = $RaceReduction < 1 ? ceil($ATK * $RaceReduction) : $ATK;
			$ATK = $SizeReduction < 1 ? ceil($ATK * $SizeReduction) : $ATK;
			$ATK = $PropertyReduction < 1 ? ceil($ATK * $PropertyReduction) : $ATK;
			$ATK = $TargetPropertyReduction < 1 ? ceil($ATK * $TargetPropertyReduction) : $ATK;
		}

		return $ATK;
	}

	/**
	 * apples the formula that occurs when a skill is divided into Multiplierple hits
	 *
	 * @param	int $Damage
	 * @param	int $NumberOfHits
	 * @return	int $Damage
	 * @since	1.0
	 */
	public static function SkillHitRounding($Damage, $NumberOfHits)
	{
		// divides the damage by the number of visible screen hits and floors the result, then Multiplierplies the result again for the final damage
		return self::TrueFloor($Damage / $NumberOfHits) * $NumberOfHits;
	}

	/**
	 * solves the PHP rounding error that is occured when flooring numbers
	 *
	 * @param	int $Integer
	 * @return	int $NewInteger
	 * @since	1.0
	 */
	public static function TrueFloor($Integer)
	{
		// convert the int to a string
		$Integer = (string)$Integer;

		// convert the string back to an int
		$NewInteger = (int)$Integer;

		// return the int, flooring its current value which has been prepared to for clean and precise flooring
		return floor($NewInteger);
	}
}
?>