<?php

namespace App\Presenters;

class UserPresenter extends CommonPresenter
{
	public function showIsSuperAdminFormat($is_super_admin)
	{
		if ($is_super_admin) {
			return "是";
		} else {
			return "否";
		}
	}
	
    public function getHandle()
    {
        return [
            [
                'icon'  => 'plus',
                'class' => 'success',
                'title' => '新增',
                'route' => 'backend.user.create',
            ],
        ];
    }
}