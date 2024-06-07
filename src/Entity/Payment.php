<?php

namespace Adrianovcar\Asaas\Entity;

/**
 * Payment Entity
 *
 * @author Adriano Carrijo <adrianovieirac@gmail.com>
 * @author Agência Softr <agencia.softr@gmail.com>
 */
final class Payment extends AbstractEntity
{
    const IN_DEBT = [
        PaymentStatus::OVERDUE,
        PaymentStatus::PENDING,
        PaymentStatus::CHARGEBACK_DISPUTE,
        PaymentStatus::AWAITING_CHARGEBACK_REVERSAL,
    ];

    public ?string $id;
    /**
     * @var string Required field
     */
    public string $customer;
    /**
     * Required field
     * @var string BillingType "UNDEFINED", "BOLETO", "CREDIT_CARD" or "PIX"
     */
    public string $billingType;
    /**
     * @var float Required field
     */
    public float $value;
    /**
     * @var string|null Required field
     */
    public ?string $dueDate;
    public string $description;
    /**
     * Valid only for "BOLETO"
     * @var string Days after due date to registration cancellation
     */
    public string $daysAfterDueDateToRegistrationCancellation;
    public string $externalReference;
    public int $installmentCount;
    /**
     *
     * @var float Value for a payment that will be paid in installments (only in the case of installment payment). If this field is sent, the installmentValue field is not necessary, the calculation by installment will be automatic.
     */
    public float $totalValue;
    /**
     * @var float Value of each installment (only in the case of installment payment). Send this field in case you want to define the value of each installment.
     */
    public float $installmentValue;
    public Discount $discount;
    public Interest $interest;
    public Fine $fine;
    public bool $postalService;
    /**
     * If the billing mode is "CREDIT_CARD", this field will be required
     * @var string
     */
    public string $remoteIp;
    /**
     * A pre-authorization works as a reserve balance card client, as a guarantee that the expected value will be available.
     *
     * A Pre-Authorized charge will be automatically reversed after 3 days in the absence of its capture.
     * To cancel the Pre-Authorization before 3 days, the Charge Reversal feature must be used.
     * The Pre-Authorized charge will be created with the status "AUTHORIZED" if successful.
     * In Sandbox, captures are automatically approved. If you want to simulate an error, simply use a charge that was not created using Pre-Authorization or with a status other than Authorized.
     *
     * @var bool
     */
    public bool $authorizeOnly = false;
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
    public array $split;
    public array $callback; // Todo: Implement split feature

    protected string $dateCreated;
    /**
     * @var string Identificador único da assinatura (quando cobrança recorrente)
     */
    protected string $subscription;
    /**
     * @var string Identificador único do link de pagamentos ao qual a cobrança pertence
     */
    protected string $paymentLink;
    /**
     * @var float Valor líquido da cobrança após desconto da tarifa do Asaas
     */
    protected float $netValue;
    /**
     * Status da cobrança
     * @var string PENDING | RECEIVED | CONFIRMED | OVERDUE | REFUNDED | RECEIVED_IN_CASH | REFUND_REQUESTED | REFUND_IN_PROGRESS | CHARGEBACK_REQUESTED | CHARGEBACK_DISPUTE | AWAITING_CHARGEBACK_REVERSAL | DUNNING_REQUESTED | DUNNING_RECEIVED | AWAITING_RISK_ANALYSIS
     */
    protected string $status;
    /**
     * @var string Informa se a cobrança pode ser paga após o vencimento (Somente para boleto)
     */
    protected string $canBePaidAfterDueDate;
    /**
     * @var string Identificador único da transação Pix à qual a cobrança pertence
     */
    protected string $pixTransaction;
    /**
     * @var string Identificador único do QrCode estático gerado para determinada chave Pix
     */
    protected string $pixQrCodeId;
    /**
     * @var float Valor original da cobrança (preenchido quando paga com juros e multa)
     */
    protected float $originalValue;
    /**
     * @var float Valor calculado de juros e multa que deve ser pago após o vencimento da cobrança
     */
    protected float $interestValue;
    /**
     * @var string Vencimento original no ato da criação da cobrança
     */
    protected string $originalDueDate;
    /**
     * @var string Data de liquidação da cobrança no Asaas
     */
    protected string $paymentDate;
    /**
     * @var string Data em que o cliente efetuou o pagamento do boleto
     */
    protected string $clientPaymentDate;
    /**
     * @var string Número da parcela
     */
    protected string $installmentNumber;
    /**
     * @var string URL do comprovante de confirmação, recebimento, estorno ou remoção.
     */
    protected string $transactionReceiptUrl;
    /**
     * @var string Identificação única do boleto
     */
    protected string $nossoNumero;
    /**
     * @var string Identificador de cobrança duplicada (caso verdadeiro)
     */
    protected string $duplicatedPayment;
    /**
     * @var string URL da fatura
     */
    protected string $invoiceUrl;
    /**
     * @var string URL para download do boleto
     */
    protected string $bankSlipUrl;
    /**
     * @var string Número da fatura
     */
    protected string $invoiceNumber;
    /**
     * @var bool Determina se a cobrança foi removida
     */
    protected bool $deleted;
    /**
     * @var bool Define se a cobrança foi antecipada ou está em processo de antecipação
     */
    protected bool $anticipated;
    /**
     * @var bool Determina se a cobrança é antecipável
     */
    protected bool $anticipable;
    protected string $refunds; // Todo: Implement refunds feature
    protected string $chargeback; // Todo: Implement chargeback feature

    /**
     * @param  string  $dueDate
     */
    public function setDueDate(string $dueDate): void
    {
        $this->dueDate = Payment::convertDateTime($dueDate);
    }
}
