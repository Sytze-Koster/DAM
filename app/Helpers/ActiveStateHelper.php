<?php
namespace App\Helpers;

use Route;

class ActiveStateHelper
{

    function isController($controller, $return = 'active')
    {
        $activeController = basename(str_replace('\\', '/', Route::getCurrentRoute()->getActionName()));
        $activeController = explode('@', $activeController)[0];

        if($activeController == $controller)
        {
            return $return;
        }
    }

    function isControllerAction($controller, $action = 'index', $return = 'active')
    {
        $activeController = basename(str_replace('\\', '/', Route::getCurrentRoute()->getActionName()));
        $activeController = explode('@', $activeController);
        $activeAction = $activeController[1];
        $activeController = $activeController[0];

        if($activeController == $controller && $activeAction == $action)
        {
            return $return;
        }
    }

}
