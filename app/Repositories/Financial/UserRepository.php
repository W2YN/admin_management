<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/16
 * Time: 13:39
 */

namespace App\Repositories\Financial;


use App\Facades\HelpFacades;
use App\Repositories\CommonRepository;


class UserRepository extends CommonRepository
{
    public static $accessor = 'user_repository';

    /**
     *
     * @return UserRepository
     */
    public static function getInstance()
    {
        return HelpFacades::getFacadeRootByAccessor( self::$accessor );
    }

    /**
     * 获取用户列表
     * @param unknown $where
     * @param unknown $page_limti
     * @return Ambigous <\Illuminate\Http\$this, boolean, \Illuminate\Http\RedirectResponse>
     */
	public function getUserList($where, $page_limti)
	{
		return $this->paginateWhere($where, $page_limti);
	}
    
    
}