<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     compiler.ascii_logo.php
 * Type:     compiler
 * Name:     ascii_logo
 * Purpose:  ASCII Logo of the developer.
 * -------------------------------------------------------------
 */
function smarty_compiler_ascii_logo($tag_arg, $smarty)
{
	$ascii_logo = "
  .sss.   .aaaaaaa.  nnn.     nnn  jjjjjjj .aaaaaaa.  .aaaaaaa.  lll
 .sssss.  aaa   aaa  nnnn\\    nnn    jjj   aaa   aaa  aaa   aaa  lll
 sss  ss  aaa   aaa  nnn n\\   nnn    jjj   aaa   aaa  aaa   aaa  lll
 sss      aaa   aaa  nnn nn\\  nnn    jjj   aaa   aaa  aaa   aaa  lll
  sss     aaa   aaa  nnn  nn  nnn    jjj   aaa   aaa  aaa   aaa  lll
   sss    >aaaaaaa<  nnn  nn  nnn    jjj   >aaaaaaa<  >aaaaaaa<  lll
    sss   aaa   aaa  nnn  nn  nnn    jjj   aaa   aaa  aaa   aaa  lll
     sss  aaa   aaa  nnn  \\n  nnn    jjj   aaa   aaa  aaa   aaa  lll
 ss  sss  aaa   aaa  nnn   \\n nnn jj jjj   aaa   aaa  aaa   aaa  lll
 .sssss.  aaa   aaa  nnn    \\nnnn jjjjj.   aaa   aaa  aaa   aaa  lll    ll
  .sss.   aaa   aaa  nnn     .nnn  .j.     aaa   aaa  aaa   aaa  .lllllll.
";

	return $ascii_logo;
}