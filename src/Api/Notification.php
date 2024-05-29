<?php

namespace Adrianovcar\Asaas\Api;

use Adrianovcar\Asaas\Entity\Notification as NotificationEntity;

/**
 * Notification API Endpoint
 *
 * @author Adriano Carrijo <adrianovieirac@gmail.com>
 * @author Agência Softr <agencia.softr@gmail.com>
 */
class Notification extends AbstractApi
{
    /**
     * Get all notifications
     *
     * @param  array  $filters  (optional) Filters Array
     * @return  array
     */
    public function getAll(array $filters = []): array
    {
        $notifications = $this->adapter->get(sprintf('%s/notifications?%s', $this->endpoint, http_build_query($filters)));
        $notifications = json_decode($notifications);
        $this->extractMeta($notifications);

        return array_map(function ($notification) {
            return new NotificationEntity($notification);
        }, $notifications->data);
    }

    /**
     * Get Notification By Id
     *
     * @param  int  $id  Notification's Id
     * @return  NotificationEntity
     */
    public function getById(int $id): NotificationEntity
    {
        $notification = $this->adapter->get(sprintf('%s/notifications/%s', $this->endpoint, $id));
        $notification = json_decode($notification);

        return new NotificationEntity($notification->customer);
    }

    /**
     * Get Notifications By Customer Id
     *
     * @param  string  $customerId  Customer Id
     * @param  array  $filters  (optional) Filters Array
     * @return  array
     */
    public function getByCustomer(string $customerId, array $filters = []): array
    {
        $notifications = $this->adapter->get(sprintf('%s/customers/%s/notifications?%s', $this->endpoint, $customerId, http_build_query($filters)));
        $notifications = json_decode($notifications);
        $this->extractMeta($notifications);

        return array_map(function ($notification) {
            return new NotificationEntity($notification->notification);
        }, $notifications->data);
    }

    /**
     * Create New Notification
     *
     * @param  array  $data  Notification's Data
     * @return  NotificationEntity
     */
    public function create(array $data): NotificationEntity
    {
        $notification = $this->adapter->post(sprintf('%s/notifications', $this->endpoint), $data);
        $notification = json_decode($notification);

        return new NotificationEntity($notification);
    }

    /**
     * Update Notification By Id
     *
     * @param  string  $id  Notification's Id
     * @param  array  $data  Notification's Data
     * @return  NotificationEntity
     */
    public function update(string $id, array $data): NotificationEntity
    {
        $notification = $this->adapter->post(sprintf('%s/notifications/%s', $this->endpoint, $id), $data);
        $notification = json_decode($notification);

        return new NotificationEntity($notification);
    }

    /**
     * Delete Notification By Id
     *
     * @param  string|int  $id  Notification's Id
     */
    public function delete($id)
    {
        $this->adapter->delete(sprintf('%s/notifications/%s', $this->endpoint, $id));
    }
}
