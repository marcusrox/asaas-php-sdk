<?php

namespace Adrianovcar\Asaas\Entity;

use PaymentStatus;

/**
 * Subscription Entity
 *
 * @author Adriano Carrijo <adrianovieirac@gmail.com>
 * @author Agência Softr <agencia.softr@gmail.com>
 */
final class Subscription extends AbstractEntity
{
    const IN_DEBT = [
        PaymentStatus::OVERDUE,
        PaymentStatus::CHARGEBACK_DISPUTE,
        PaymentStatus::AWAITING_CHARGEBACK_REVERSAL
    ];

    public ?string $id;
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
     * @var string|null Required field
     */
    public ?string $nextDueDate;
    public ?Discount $discount;
    public ?Interest $interest;
    public ?Fine $fine;
    /**
     * Required field
     * @var string "WEEKLY", "BIWEEKLY", "MONTHLY", "BIMONTHLY", "QUARTERLY", "SEMIANNUALLY" or "YEARLY"
     */
    public string $cycle;
    public string $description;
    /**
     * @var string Installments should be paid until this date
     */
    public ?string $endDate;
    /**
     * @var int Maximum number of payments to be created for this subscription
     */
    public ?int $maxPayments;
    public ?string $externalReference;
    public ?array $split; // Todo: Implement split feature
    public ?array $callback; // Todo: Implement callback feature
    /**
     * @var CreditCard Required if billingType is CREDIT_CARD
     */
    public ?CreditCard $creditCard;
    /**
     * @var CreditCardHolderInfo Required if billingType is CREDIT_CARD
     */
    public ?CreditCardHolderInfo $creditCardHolderInfo;
    /**
     * If this property is sent, the creditcard and creditcardholderinfo will not be required
     * @var string|null Send the credit card token previously stored
     */
    public ?string $creditCardToken;
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
    protected bool $deleted;

    public function __construct($parameters = null)
    {
        parent::__construct($parameters);

        $this->nextDueDate = $this->nextDueDate ?? date('Y-m-d');
        $this->remoteIp = $this->remoteIp ??
            $_SERVER['REMOTE_ADDR'] ??
            $_SERVER['HTTP_CLIENT_IP'] ??
            $_SERVER['HTTP_X_FORWARDED_FOR'] ??
            $_SERVER['HTTP_X_FORWARDED'] ??
            '0.0.0.0.';
    }

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
