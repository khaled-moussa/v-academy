<?php

namespace App\Domain\Auth\Actions;

use App\Domain\SocialAccount\Dtos\SocialAccountDto;
use App\Domain\User\Models\User;
use App\Domain\Auth\Exceptions\FailedToLoginException;
use App\Domain\SocialAccount\Actions\CreateSocialAccountAction;
use App\Domain\SocialAccount\Actions\GetSocialAccountBySocialIdAction;
use App\Domain\User\Actions\GetUserByEmailAction;
use App\Support\Enums\SocialiteProviderEnum;
use Laravel\Socialite\Contracts\User as UserProvider;

class AttemptToLoginWithProviderAction
{
    /**
     * Attempt login via social provider.
     */
    public function execute(UserProvider $userProvider, string $provider, bool $isAuthenticated = false): User
    {
        if (! $userProvider || ! $provider) {
            throw new FailedToLoginException();
        }

        $user = app(GetUserByEmailAction::class)
            ->execute(email: $userProvider->getEmail());

        $socialAccount = app(GetSocialAccountBySocialIdAction::class)
            ->execute($userProvider->getId());

        /*
        |-----------------------------------
        | LINK FLOW (user already logged in)
        |-----------------------------------
        */

        if ($isAuthenticated && !$socialAccount) {

            // Create new social account
            $socialAccountDto = new SocialAccountDto(
                provider: SocialiteProviderEnum::from($provider),
                linked: false,
                socialId: $userProvider->getId(),
                userId: $user->getId(),
            );

            app(CreateSocialAccountAction::class)->execute($socialAccountDto);

            return $user;
        }

        /*
        |-----------------------------------
        | LOGIN FLOW
        |-----------------------------------
        */

        if (! $socialAccount) {
            throw new FailedToLoginException();
        }

        return $user;
    }
}
