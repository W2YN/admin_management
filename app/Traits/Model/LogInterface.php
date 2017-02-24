<?php
/**
 * LogInterface.php
 * Date: 2017/1/4
 */

namespace App\Traits\Model;


interface LogInterface
{
    function getLogger();

    function getFreeze();

    function errorCount();

    function getProjectNo();

    function getPreFreezeUrl();

    function getChargeUrl();

    function getCancelUrl();

    function isTest();

    function isInstallmentTest();

    function markError($errorCode);

    function expiredInstallments();

    function expiredInstallmentById($id);
    //function clearFreeze();
}