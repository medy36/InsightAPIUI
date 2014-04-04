<?php

namespace Projects\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ProjectsUserBundle extends Bundle
{

	 public function getParent()
    {
        return 'FOSUserBundle';
    }
}
