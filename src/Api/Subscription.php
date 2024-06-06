<?php

namespace Adrianovcar\Asaas\Api;

use Adrianovcar\Asaas\Entity\Subscription as SubscriptionEntity;
use DateTime;
use Exception;

/**
 * Subscription API Endpoint
 *
 * @author Adriano Carrijo <adrianovieirac@gmail.com>
 * @author Agência Softr <agencia.softr@gmail.com>
 */
class Subscription extends AbstractApi
{
    /**
     * Get all subscriptions
     *
     * @param  array  $filters  (optional) Filters Array
     * @return  array  Subscriptions Array
     */
    public function getAll(array $filters = []): array
    {
        $subscriptions = $this->adapter->get(sprintf('%s/subscriptions?%s', $this->endpoint, http_build_query($filters)));
        $subscriptions = json_decode($subscriptions);
        $this->extractMeta($subscriptions);

        return array_map(function ($subscription) {
            return new SubscriptionEntity($subscription);
        }, $subscriptions->data);
    }

    /**
     * Get Subscriptions By Customer Id
     *
     * @param  string  $customerId  Customer Id
     * @return  SubscriptionEntity[]
     */
    public function getByCustomer(string $customerId): array
    {
        $subscriptions = $this->adapter->get(sprintf('%s/customers/%s/subscriptions?%s', $this->endpoint, $customerId));
        $subscriptions = json_decode($subscriptions);
        $this->extractMeta($subscriptions);

        return array_map(function ($subscription) {
            return new SubscriptionEntity($subscription->subscription);
        }, $subscriptions->data);
    }

    /**
     * Create new subscription
     *
     * @param  SubscriptionEntity  $subscription_entity
     * @return  SubscriptionEntity
     */
    public function create(SubscriptionEntity $subscription_entity): SubscriptionEntity
    {
        $subscription = $this->adapter->post(sprintf('%s/subscriptions', $this->endpoint), $subscription_entity->toArray());
        $subscription = json_decode($subscription);

        return new SubscriptionEntity($subscription);
    }

    /**
     * Update Subscription By Id
     *
     * @param  string  $id  Subscription Id
     * @param  SubscriptionEntity  $subscription_entity
     * @return  SubscriptionEntity
     */
    public function update(string $id, SubscriptionEntity $subscription_entity): SubscriptionEntity
    {
        $subscription = $this->adapter->post(sprintf('%s/subscriptions/%s', $this->endpoint, $id), $subscription_entity->toArray());
        $subscription = json_decode($subscription);

        return new SubscriptionEntity($subscription);
    }

    /**
     * Delete Subscription By Id
     *
     * @param  string|int  $id  Subscription Id
     */
    public function delete($id)
    {
        $this->adapter->delete(sprintf('%s/subscriptions/%s', $this->endpoint, $id));
    }

    /**
     * Evaluate the possible pro-rata value when pretend to change a plan (upgrade or downgrade)
     *
     * ASAAS doesn't have a "change plan" endpoint, so we have to create a new subscription
     * To do it, we have to delete the old one and create a new one
     * If there is a pro rata balance, will be firstly credited on a separate payment (new_price - pro_rata)
     *
     * Scenario:
     * Current plan (lite) = $100.00 / month
     * New plan (premium) = $200.00 / month
     *
     * Upgrade Scenario:
     * Current: Lite, subscription at 2024-05-01
     * New: Premium, subscription at 2024-06-05
     * Used: 5 days ($17.00)
     * Pro-rata: 25 days ($83.00)
     * New due date (based on pro-rata balance) = '2024-05-18' (13 days from $83.00)
     *
     * Downgrade Scenario:
     * Current: Premium, subscription at 2024-05-01
     * New: Lite, subscription at 2024-06-05
     * Used: 5 days ($33.00)
     * Pro-rata: 25 days ($167.00)
     * New due date (based on pro-rata balance) = '2024-07-26' (51 days from $167.00)
     *
     * Formula:
     * var current_plan = 100;
     * var new_plan = 200;
     * var current_due_date = '2024-05-01';
     * var new_due_date = '2024-06-05';
     * var used_days = today - current_due_date;
     * var current_plan_daily_value = current_plan / 30;
     * var new_plan_daily_value = new_plan / 30;
     * var used_value = floor(current_plan_daily_value * used_days);
     * var unused_value = ceil(current_plan_daily_value * (30 - used_days));
     *
     * new_subscription_due_date = ceil(unused_value / new_plan_daily_value)
     *
     * @param  SubscriptionEntity  $current_subscription
     * @param  SubscriptionEntity  $new_subscription
     * @return SubscriptionEntity
     * @throws Exception
     */
    public function evaluateProRata(SubscriptionEntity $current_subscription, SubscriptionEntity $new_subscription): SubscriptionEntity
    {
        // create the next due date object from asaas's payment schedule
        $next_due_date = (new DateTime($current_subscription->nextDueDate ?? 'now'))->setTime(0, 0);
        // need to reset time due to next calc (diff)
        $today = (new DateTime())->setTime(0, 0);
        // the difference between the next due date and today
        $days_left = $next_due_date->diff($today)->days;

        // avoid create pro-rata formula if the next due date is today
        if ($days_left !== 0) {
            // respecting the number of days for each month
            $days_in_month = $today->format('t');
            // the daily value of the current plan
            $current_plan_daily_value = $current_subscription->value / $days_in_month;
            // the remaining amount to be used on current cycle
            $positive_balance = ($days_in_month - $days_left) * $current_plan_daily_value;
            // the daily value of the new plan
            $new_plan_daily_value = $new_subscription->value / $days_in_month;
            // the number of days that can be 'bought' using the remaining balance
            $days_paid_with_balance = ceil($positive_balance / $new_plan_daily_value);
            // update the next due date considering the number of days paid with balance
            $next_due_date->modify("+{$days_paid_with_balance} days");
        }

        // update the new subscription due date
        $new_subscription->nextDueDate = $next_due_date->format('Y-m-d');

        return $new_subscription;
    }

    /**
     * Get Subscription By Id
     *
     * @param  string  $id  Subscription Id
     * @return  SubscriptionEntity
     */
    public function getById(string $id): SubscriptionEntity
    {
        $subscription = $this->adapter->get(sprintf('%s/subscriptions/%s', $this->endpoint, $id));
        $subscription = json_decode($subscription);

        return new SubscriptionEntity($subscription);
    }
}
