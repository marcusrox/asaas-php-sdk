<?php

namespace Adrianovcar\Asaas\Entity;

/**
 * Subscription Entity
 *
 * @author Adriano Carrijo <adrianovieirac@gmail.com>
 * @author Agência Softr <agencia.softr@gmail.com>
 */
final class Subscription extends AbstractEntity
{
    public ?int $id;
    /**
     * @var string Required field
     */
    public string $customer;
    /**
     * Required field
     * @var string "UNDEFINED", "BOLETO", "CREDIT_CARD" or "PIX"
     */
    public string $billingType;
    /**
     * @var float Required field
     */
    public float $value;
    /**
     * First installment due date
     * @var string Required field
     */
    public string $nextDueDate;
    public Discount $discount;
    public Interest $interest;
    public Fine $fine;
    /**
     * Required field
     * @var string "WEEKLY", "BIWEEKLY", "MONTHLY", "BIMONTHLY", "QUARTERLY", "SEMIANNUALLY" or "YEARLY"
     */
    public string $cycle;
    public string $description;
    /**
     * @var string Installments should be paid until this date
     */
    public string $endDate;
    /**
     * @var int Maximum number of payments to be created for this subscription
     */
    public int $maxPayments;
    public string $externalReference;
    public array $split; // Todo: Implement split feature
    public array $callback; // Todo: Implement callback feature
    /**
     * @var CreditCard Required if billingType is CREDIT_CARD
     */
    public CreditCard $creditCard;
    /**
     * @var CreditCardHolderInfo Required if billingType is CREDIT_CARD
     */
    public CreditCardHolderInfo $creditCardHolderInfo;
    public string $creditCardToken;
    /**
     * IP from where the customer is making the purchase. It should not be the IP of your server.
     * @var string Required
     */
    public string $remoteIp;
    /**
     * @var Payment[]
     */
    protected array $payments = [];
    protected string $dateCreated;
    protected string $paymentLink;
    protected string $deleted;

    /**
     * @param  string  $nextDueDate
     */
    public function setNextDueDate(string $nextDueDate)
    {
        $this->nextDueDate = Subscription::convertDateTime($nextDueDate);
    }

    /**
     * @param  string  $endDate
     */
    public function setEndDate(string $endDate)
    {
        $this->endDate = Subscription::convertDateTime($endDate);
    }
}
