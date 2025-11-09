<?php

namespace Sapak\Sms\Laravel;

use Illuminate\Support\Facades\Facade;
use Sapak\Sms\Resources\AccountResource;
use Sapak\Sms\Resources\MessageResource;
use Sapak\Sms\SapakClient;

/**
 * @see SapakClient
 *
 * @method static AccountResource account()
 * @method static MessageResource messages()
 */
class SapakFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * This tells Laravel which service in the container
     * this Facade should resolve to.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        // This must match the binding in our ServiceProvider
        return SapakClient::class;
    }
}
