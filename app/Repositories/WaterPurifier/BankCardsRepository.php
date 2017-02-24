<?php

namespace App\Repositories\WaterPurifier;


use App\Facades\HelpFacades;
use App\Repositories\CommonRepository;

class BankCardsRepository extends CommonRepository
{
    public static $accessor = 'bank_cards_repository';

    /**
     *
     * @return BankCardsRepository
     */
    public static function getInstance()
    {
        return HelpFacades::getFacadeRootByAccessor( self::$accessor );
    }

}
