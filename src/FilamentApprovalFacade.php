<?php

namespace AymanAlhattami\FilamentApproval;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Aymanalhattami\FilamentApproval\Skeleton\SkeletonClass
 */
class FilamentApprovalFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'filament-approval';
    }
}
