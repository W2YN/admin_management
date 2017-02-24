<?php

namespace App\Repositories\WaterPurifier;

use App\Repositories\CommonRepository;
use App\Facades\HelpFacades;

class ChannelRepository extends CommonRepository
{
	public static $accessor = 'channel_repository';
	
	/**
	 * 
	 * @return ChannelRepository
	 */
	public static function getInstance()
	{
		return HelpFacades::getFacadeRootByAccessor( self::$accessor );
	}
	
}


























