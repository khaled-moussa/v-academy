<?php

namespace App\App\Web\Controllers\Auth;

use App\Domain\Auth\Actions\AttemptToLoginWithProviderAction;
use App\Domain\Panel\Actions\PanelResolverAction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Domain\Auth\Exceptions\FailedToLoginException;
use Filament\Facades\Filament;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to the provider's authentication page.
     */
    public function redirect(string $provider, array $meta = [])
    {
        $meta = request()->input('meta', []);

        session()->put('socialite_meta', $meta);

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle callback from the provider.
     */
    public function callback(string $provider)
    {
        try {
            // Get & remove meta (important)
            $meta = session()->pull('socialite_meta');

            $isAuthenticated = $meta['authenticated'] ?? false;
            $redirectUrl     = $meta['redirect'] ?? null;

            // Get user info from provider
            $userProvider = Socialite::driver($provider)->user();

            // Attempt login / register / link
            $user = app(AttemptToLoginWithProviderAction::class)
                ->execute(
                    userProvider: $userProvider,
                    provider: $provider,
                    isAuthenticated: $isAuthenticated
                );

            if ($isAuthenticated && $redirectUrl && Str::startsWith($redirectUrl, config('app.url'))) {
                return redirect($redirectUrl);
            }

            Auth::login($user);

            return redirect(PanelResolverAction::panelRoute($user));
        } catch (FailedToLoginException $e) {
            return redirect(Filament::getPanel('auth')->getLoginUrl())
                ->with('failed_login_message', $e->getMessage());
        } catch (\Exception $e) {
            return redirect(Filament::getPanel('auth')->getLoginUrl())
                ->with('failed_login_message', 'An unexpected error occurred. Please try again.');
        }
    }
}
