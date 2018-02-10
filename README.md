About fpdf_namedcolors
------------------------
Extension for the FPDF class (www.fpdf.org) providing broader color definition support and named colors.

Author: @vHeemstra

License: Same as FPDF - Free for all! (Would appreciate the mention however)


Installation
------------
Simply download the PHP file and use the code to extend the FPDF class (or your own class definition).


Name colors
-----------
To use named colors, first define them by calling the NameColor method providing a name and a color definition, like so:

  `$pdf->NameColor('name_of_color', [255,0,0]);`

  - The name will be used as an array key, so some restrictions apply. Also don't start it with a '#', this is reserved for hex values.
  - The color definition can be one of these:
    * Single integer --> Grayscale color [0-255]
    * Array of 3 integers --> RGB color values [0-255]
    * Hex string --> Hex color value '#' + (6, 3 or 1 character(s)) [0-F]


Use named colors and broader definition support
-----------------------------------------------
After defining the color, you can use the name as $r in the original Set[..]Color methods.
Additionally, the above described ways of defining colors can also be used as the $r value in the Set[..]Color methods, like so:

  - `$pdf->SetDrawColor('name_of_color');`
  - `$pdf->SetDrawColor(255);`
  - `$pdf->SetDrawColor(255, 255, 255);`
  - `$pdf->SetDrawColor([255, 255, 255]);`
  - `$pdf->SetDrawColor('#f');`
  - `$pdf->SetDrawColor('#fff');`
  - `$pdf->SetDrawColor('#ffffff');`
  
  NB: The same works for `SetTextColor` and `SetFillColor`.
