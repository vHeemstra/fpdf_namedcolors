<?php

require_once('fpdf.php');


/*

	Author: Philip van Heemstra - https://github.com/vHeemstra
	License: Same as FPDF - Free for all! (Would appreciate the mention however)


	NAME COLORS
	-----------
	
		$pdf->NameColor('name_of_color', [255,0,0]);

		- The name will be used as an array key, so some restrictions apply. Also don't start it with a '#', this is reserved for hex values.
		- The color definition can be one of these:
			Single integer --> Grayscale color [0-255]
			Array of 3 integers --> RGB color values [0-255]
			Hex string --> Hex color value '#' + (6, 3 or 1 character(s)) [0-F]
	

	USE NAMED COLORS AND BROADER DEFINITION SUPPORT
	-----------------------------------------------
	After defining the color, you can use the name as $r in the original Set[..]Color methods.
	Additionally, the above described ways of defining colors can also be used as the $r value in the Set[..]Color methods, like so:

		$pdf->SetDrawColor('name_of_color');
		$pdf->SetDrawColor(255);
		$pdf->SetDrawColor(255, 255, 255);
		$pdf->SetDrawColor([255, 255, 255]);
		$pdf->SetDrawColor('#f');
		$pdf->SetDrawColor('#fff');
		$pdf->SetDrawColor('#ffffff');


 */


class FPDF_NamedColors extends FPDF
{
	/**
	 * Array to store the defined colors
	 */
	protected $namedColors = [];

	/**
	 * Translate named colors, hex values, rgb strings and arrays to RGB array
	 *
	 * @param mixed $color Integer --> Value for red (or greyscale) channel [0-255]
	 *                     Hex string --> Hex color value of length 6, 3 or 1
	 *                     String --> Assumed defined color name
	 * @param [int]  $g    Value for green channel [0-255]
	 * @param [int]  $b    Value for blue channel [0-255]
	 *
	 * @return array [$red, $green, $blue] Returns corrected array with RGB values [0-255].
	 */
	function CorrectColor($color=0, $g=null, $b=null)
	{
		$rgb = [0, 0, 0];
		if (is_integer($color) && is_integer($g) && is_integer($b)) {
			$rgb = [$color, $g, $b];
		} else if (is_integer($color)) {
			$rgb = [$color, $color, $color];
		} else if (is_array($color) && count($color)==3) {
			$rgb = [$color[0], $color[1], $color[2]];
		} else if (is_string($color) && 0 === strpos($color, '#')) {
			$color = substr($color, 1);
			if (6==count($color)) {
				$rgb = [hexdec(substr($color,0,2)), hexdec(substr($color,2,2)), hexdec(substr($color,4,2))];
			} else if (3==count($color)) {
				$rgb = [hexdec(substr($color,0,1).substr($color,0,1)), hexdec(substr($color,1,1).substr($color,1,1)), hexdec(substr($color,2,1).substr($color,2,1))];
			} else if (1==count($color)) {
				$rgb = [hexdec(substr($color,0,1).substr($color,0,1)), hexdec(substr($color,0,1).substr($color,0,1)), hexdec(substr($color,0,1).substr($color,0,1))];
			}
		} else if (is_string($color) && 0 !== strpos($color, '#') && isset($this->namedColors[ $color ])) {
			$rgb = $this->namedColors[ $color ];
		}
		return [
			max(0, min(255, $rgb[0])),
			max(0, min(255, $rgb[1])),
			max(0, min(255, $rgb[2])),
		];
	}
	
	/**
	 * Define/name a color
	 *
	 * @param string  $name  Name of the color, NOT starting with '#', used as array key
	 * @param mixed $color The color in either a single integer (grayscale), hex value or array of 3 integers (rgb).
	 */
	function NameColor($name, $color=0)
	{
		$this->namedColors[ $name ] = $this->CorrectColor($color);
	}
	

	function SetDrawColor($r, $g=null, $b=null)
	{
		$rgb = $this->CorrectColor($r, $g, $b);
		parent::SetDrawColor($rgb[0], $rgb[1], $rgb[2]);
	}
	
	function SetFillColor($r, $g=null, $b=null)
	{
		$rgb = $this->CorrectColor($r, $g, $b);
		parent::SetFillColor($rgb[0], $rgb[1], $rgb[2]);
	}
	
	function SetTextColor($r, $g=null, $b=null)
	{
		$rgb = $this->CorrectColor($r, $g, $b);
		parent::SetTextColor($rgb[0], $rgb[1], $rgb[2]);
	}
}

?>
