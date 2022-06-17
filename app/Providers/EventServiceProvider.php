<?php

namespace App\Providers;

//use Illuminate\Auth\Events\Registered;
//use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use App\Events\BlogAddedEvent;
use App\Listeners\SendBlogAddedNotificationListener;
use App\Listeners\SendProductAddedNotificationListener;
use App\Listeners\SetDefaultRoleForNewlyRegisteredUserListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Events\PasswordChangedEvent;
use App\Listeners\NotifyPasswordChangeListener;

use App\Events\ProductAddedEvent;
use App\Listeners\SendProductAddedNotification;

use App\Events\UserRegisteredEvent;
use App\Listeners\SendUserWelcomeEmailListener;
use App\Listeners\SendUserEmailConfirmationListener;

use App\Events\EmailVerifiedEvent;
use App\Listeners\MoveVerifiedUserIntoSubscribersListener;
use App\Listeners\RemoveUserFromSubscribersTableListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        PasswordChangedEvent::class => [
            NotifyPasswordChangeListener::class,
        ],
        ProductAddedEvent::class => [
            SendProductAddedNotificationListener::class,
        ],
        UserRegisteredEvent::class => [
            RemoveUserFromSubscribersTableListener::class,
            SendUserWelcomeEmailListener::class,
            SendUserEmailConfirmationListener::class,
            SetDefaultRoleForNewlyRegisteredUserListener::class,
        ],
        EmailVerifiedEvent::class => [
            MoveVerifiedUserIntoSubscribersListener::class,
        ],
        BlogAddedEvent::class => [
            SendBlogAddedNotificationListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
