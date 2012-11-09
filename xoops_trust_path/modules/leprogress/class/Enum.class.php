<?php
/**
 * @file
 * @package leprogress
 * @version $Id$
**/

if(!defined('XOOPS_ROOT_PATH'))
{
    exit;
}

/**
 * Leprogress_Result
**/
class Leprogress_Result
{
    const HOLD = 0;
    const REJECT = 1;
    const APPROVE = 9;
}

class Leprogress_RevertTo
{
    const ZERO = 0; // revert to the poster
    const FORMER = 1;   // revert to the former approval
}

?>
