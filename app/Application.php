<?php
declare(strict_types = 1);

namespace App;


class Application extends \Illuminate\Foundation\Application
{
    /**
     * Override the maintenance mode detection..
     * Please note this is only used for the queue worker
     * @return bool
     * @throws \Exception
     */
    public function isDownForMaintenance() : bool
    {
        
    }

    
}
