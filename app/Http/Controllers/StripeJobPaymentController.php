<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Checkout;

class StripeJobPaymentController extends Controller
{
    public function checkout(Job $job)
    {
        // Ensure employer owns the job
        abort_if($job->user_id !== Auth::id(), 403);

        // Prevent paying twice
        abort_if($job->is_paid, 403, 'Job already paid for.');

        /** @var User $user */
        $user = Auth::user();

        return $user->checkout(
            [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Job Posting Fee',
                        ],
                        'unit_amount' => 100, // $1.00 in cents
                    ],
                    'quantity' => 1,
                ],
            ],
            [
                'mode' => 'payment',
                'success_url' => route('employer.jobs.success', $job),
                'cancel_url' => route('employer.jobs.create'),
                'metadata' => [
                    'job_id' => $job->id,
                    'type' => 'job_post',
                ],
            ]
        );
    }
}
