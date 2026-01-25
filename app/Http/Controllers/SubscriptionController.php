<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    // /**
    //  * Start Premium Employer subscription
    //  */
    // public function subscribe()
    // {
    //     $user = Auth::user();

    //     // Only employers can subscribe
    //     abort_if($user->role !== 'employer', 403);

    //     // Already subscribed?
    //     if ($user->subscribed('premium')) {
    //         return redirect()
    //             ->route('employer.dashboard')
    //             ->with('info', 'You are already subscribed.');
    //     }

    //     // Ensure Stripe customer exists
    //     $user->createOrGetStripeCustomer();

    //     return $user
    //         ->newSubscription(
    //             'premium',
    //             config('services.stripe.premium_plan_price_id')
    //         )
    //         ->checkout([
    //             'success_url' => route('subscription.success'),
    //             'cancel_url'  => route('subscription.cancelled'),
    //             'metadata' => [
    //                 'user_id' => $user->id,
    //                 'type'    => 'premium_employer',
    //             ],
    //         ]);
    // }

    // /**
    //  * Stripe success redirect
    //  */
    // public function success()
    // {
    //     return redirect()
    //         ->route('employer.dashboard')
    //         ->with('success', 'Premium Employer subscription activated 🎉');
    // }

    // /**
    //  * Stripe cancel redirect
    //  */
    // public function cancelled()
    // {
    //     return redirect()
    //         ->route('employer.dashboard')
    //         ->with('warning', 'Subscription process cancelled.');
    // }

    // /**
    //  * Cancel subscription at period end
    //  */
    // public function cancel()
    // {
    //     $user = Auth::user();

    //     abort_if($user->role !== 'employer', 403);

    //     if ($user->subscribed('premium')) {
    //         $user->subscription('premium')->cancel();
    //     }

    //     return back()->with(
    //         'success',
    //         'Subscription will end at the end of the billing cycle.'
    //     );
    // }

    // /**
    //  * Resume cancelled subscription
    //  */
    // public function resume()
    // {
    //     $user = Auth::user();

    //     abort_if($user->role !== 'employer', 403);

    //     if ($user->subscription('premium')->onGracePeriod()) {
    //         $user->subscription('premium')->resume();
    //     }

    //     return back()->with(
    //         'success',
    //         'Subscription resumed successfully.'
    //     );
    // }
}
