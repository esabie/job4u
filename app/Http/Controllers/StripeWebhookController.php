<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                $secret
            );
        } catch (SignatureVerificationException $e) {
            Log::error('Stripe webhook signature verification failed.');
            return response('Invalid signature', 400);
        } catch (\Exception $e) {
            Log::error('Stripe webhook error: ' . $e->getMessage());
            return response('Webhook error', 400);
        }

        // Handle successful checkout
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            // Only handle job posting payments
            if (
                isset($session->metadata->type) &&
                $session->metadata->type === 'job_post'
            ) {
                $jobId = $session->metadata->job_id;

                $job = Job::find($jobId);

                if ($job && !$job->is_paid) {
                    $job->update([
                        'is_paid' => true,
                        'is_active' => true,
                        'paid_at' => now(),
                    ]);
                }
            }
        }

        return response('Webhook handled', 200);
    }
}
