<?php

namespace Controllers;

use Service\Auth\AuthInterface;
use Service\Auth\AuthSessionService;

abstract class BaseController
{
    protected AuthInterface $authInterface;
    public function __construct()
    {
        $this->authInterface = new AuthSessionService();
    }


}