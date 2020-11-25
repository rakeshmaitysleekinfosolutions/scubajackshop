<?php
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;
use PayPal\Rest\ApiContext;
use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\ShippingAddress;
use PayPal\Exception\PayPalConnectionException;
/**
 * Class PaymentDefinition
 *
 * Resource representing payment definition scheduling information.
 *
 * @package PayPal\Api
 *
 * @property string name
 * @property string type
 * @property string frequency_interval
 * @property string frequency
 * @property string cycles
 * @property \PayPal\Api\Currency amount
 */
class Paypal {
    public $plan;
    public $paymentDefinition;
    /**
     * @var MerchantPreferences
     */
    public $MerchantPreferences;
    /**
     * @var ChargeModel
     */
    public $chargeModel;
    /**
     * @var Patch
     */
    public $patch;
    /**
     * @var PayPalModel
     */
    public $payPalModel;
    /**
     * @var PatchRequest
     */
    public $patchRequest;
    /**
     * @var PayPalConnectionException
     */
    public $payPalConnectionException;
    /**
     * @var Payer
     */
    public $payer;
    /**
     * @var ShippingAddress
     */
    public $shippingAddress;
    /**
     * @var Agreement
     */
    public $agreement;
    /**
     * @var ApiContext
     */
    public $apiContext;
    /**
     * @var MerchantPreferences
     */
    public $merchantPreferences;
    /**
     * @var Currency
     */
    public $currency;
    public $paypalCurrency;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $paymentDefinitionName;
    /**
     * @var string
     */
    private $paymentDefinitionType;
    private $frequencyInterval;
    /**
     * @var string
     */
    private $chargeModelType;

    private $jsonArray = array();
    private $planName;
    private $planDescription;
    private $state;
    /**
     * @var string
     */
    private $planId;
    /**
     * @var Plan
     */
    private $patchedPlan;
    private $date;

    public function __construct() {
        $this->plan                         = new Plan();
        $this->paymentDefinition            = new PaymentDefinition();
        $this->chargeModel                  = new ChargeModel();
        $this->merchantPreferences          = new MerchantPreferences();
        $this->patch                        = new Patch();
        //$this->payPalModel                  = new PayPalModel();
        $this->patchRequest                 = new PatchRequest();
        $this->payer                        = new Payer();
        $this->shippingAddress              = new ShippingAddress();
        $this->agreement                    = new Agreement();
        $this->apiContext                   = new ApiContext();
        $this->currency                     = new Currency();

        //Locale Api Key
        /*
        $this->apiContext = new ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AcAd2GLtMixowVxgyKC9m4k2UJLW7xviVtVtPP2-AsM9XBdfA0cnQyW8JRLkIa5-ZPkSL51IUjk4ARKb',
                'EHc_fc822fUDKIZUGiODxT5q4f_L5I1C6inGzBuSPxXVPi4ikQJ7SeQ40qnQQVL3B23ciUJEYlDQjITM'
            )
        );
        */

        // Live
        $this->apiContext = new ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                'AR1l6f9ecIIU5E_YeQOdTtEBOSQeu-65XaRlb94EHMY8lQumwf1a1BYRR7G-LxfQebEpR68dz5aAG268',
                'EKLxtyKqPmM51u4ZJMrELSW6n1Br99zvqr8CGAkJnYrwkTLS-Yy7Ln5adKpjNhHqMiyvEVM-wggk_VZe'
            )
        );

        // Live
        $this->apiContext->setConfig([
            'mode' => 'live',
            //'log.LogEnabled' => true,
            //'log.FileName' => '../../PayPal.log',
            //'log.LogLevel' => 'DEBUG', // PLEASE USE `INFO` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
            //'cache.enabled' => true,
            //'cache.FileName' => '/PaypalCache' // for determining paypal cache directory
            // 'http.CURLOPT_CONNECTTIMEOUT' => 30
            // 'http.headers.PayPal-Partner-Attribution-Id' => '123123123'
            //'log.AdapterFactory' => '\PayPal\Log\DefaultLogFactory' // Factory class implementing \PayPal\Log\PayPalLogFactory
        ]);
    }
    public static function factory() {
        return new Paypal();
    }

    public function setCurrency($currency) {
        $this->paypalCurrency = $currency;
        return $this;
    }
    public function setApiContext($clientId, $clientSecret) {
        $this->apiContext = new ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $clientId,
                $clientSecret
            )
        );
        return $this;
    }
    public function setPaymentModel($str) {
        $this->payPalModel = new PayPalModel($str);
        return $this;
    }
    public function getPlan() {
        return $this->plan;
    }
    public function getPaymentDefinition() {
        return $this->paymentDefinition;
    }
    public function getChargeModel() {
        return $this->chargeModel;
    }
    public function getMerchantPreferences() {
        return $this->merchantPreferences;
    }
    public function getPatch() {
        return $this->patch;
    }
    public function getPyPalModel() {
        return $this->payPalModel;
    }
    public function getPatchRequest() {
        return $this->patchRequest;
    }
    public function getPayer() {
        return $this->payer;
    }
    public function getShippingAddress() {
        return $this->shippingAddress;
    }
    public function getAgreement() {
        return $this->agreement;
    }
    public function getApiContext() {
        return $this->apiContext;
    }
    public function getCurrency() {
        return $this->currency->getCurrency();
    }
    /**
     * Name of the billing plan. 128 characters max.
     *
     * @param string $name
     *
     * @return $this
     */
    public function setPlanName($planName) {
        $this->planName = $planName;
        return $this;
    }
    /**
     * Name of the billing plan. 128 characters max.
     *
     * @param string $name
     *
     * @return $this
     */
    public function setPlanDescription($planDescription) {
        $this->planDescription = $planDescription;
        return $this;
    }
    /**
     * Name of the billing plan. 128 characters max.
     *
     * @param string $name
     *
     * @return $this
     */
    public function setPlanId($planId) {
        $this->planId = $planId;
        return $this;
    }
    /**
     * Name of the billing plan. 128 characters max.
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }
    /**
     * Name of the payment definition. 128 characters max.
     *
     * @param string $name
     *
     * @return $this
     */
    public function setPaymentDefinitionName($name) {
        $this->paymentDefinitionName = $name;
        return $this;
    }
    /**
     * Type of the payment definition. Allowed values: `TRIAL`, `REGULAR`.
     *
     * @param string $type
     *
     * @return $this
     */
    public function setPaymentDefinitionType($type) {
        $this->paymentDefinitionType = $type;
        return $this;
    }
    /**
     * Description of the billing plan. 128 characters max.
     *
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * Description of the billing plan. 128 characters max.
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Type of the billing plan. Allowed values: `FIXED`, `INFINITE`.
     *
     * @param string $type
     *
     * @return $this
     */
    public function setType($type) {
        $this->type = $type;
        return $this;
    }


    /**
     * Name of the payment definition. 128 characters max.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Type of the payment definition. Allowed values: `TRIAL`, `REGULAR`.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * How frequently the customer should be charged.
     *
     * @param string $frequency_interval
     *
     * @return $this
     */
    public function setFrequencyInterval($frequencyInterval)
    {
        $this->frequencyInterval = $frequencyInterval;
        return $this;
    }

    /**
     * How frequently the customer should be charged.
     *
     * @return string
     */
    public function getFrequencyInterval()
    {
        return $this->frequencyInterval;
    }

    /**
     * Frequency of the payment definition offered. Allowed values: `WEEK`, `DAY`, `YEAR`, `MONTH`.
     *
     * @param string $frequency
     *
     * @return $this
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;
        return $this;
    }

    /**
     * Frequency of the payment definition offered. Allowed values: `WEEK`, `DAY`, `YEAR`, `MONTH`.
     *
     * @return string
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * Number of cycles in this payment definition.
     *
     * @param string $cycles
     *
     * @return $this
     */
    public function setCycles($cycles)
    {
        $this->cycles = $cycles;
        return $this;
    }

    /**
     * Number of cycles in this payment definition.
     *
     * @return string
     */
    public function getCycles()
    {
        return $this->cycles;
    }

    /**
     * Amount that will be charged at the end of each cycle for this payment definition.
     *
     * @param \PayPal\Api\Currency $amount
     *
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * Amount that will be charged at the end of each cycle for this payment definition.
     *
     * @return \PayPal\Api\Currency
     */
    public function getAmount()
    {
        return $this->amount;
    }
    /**
     * Type of charge model. Allowed values: `SHIPPING`, `TAX`.
     *
     * @param string $type
     *
     * @return $this
     */
    public function setChargeModelType($type)
    {
        $this->chargeModelType = $type;
        return $this;
    }

    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }
    public function createOrUpdatePlan() {

        $this->plan->setName($this->plan->getName())
            ->setDescription($this->plan->getDescription())
            ->settype('FIXED');

        $this->paymentDefinition->setName($this->paymentDefinition->getName())
            ->setType($this->paymentDefinition->getType())
            ->setFrequency($this->paymentDefinition->getFrequency())
            ->setFrequencyInterval($this->paymentDefinition->getFrequencyInterval())
            ->setCycles($this->paymentDefinition->getCycles())
            ->setAmount($this->paymentDefinition->getAmount());

        //dd($this->paymentDefinition);
        $this->chargeModel->setType($this->chargeModel->getType())
             ->setAmount($this->chargeModel->getAmount());

        $this->paymentDefinition->setChargeModels(array(
            $this->getChargeModel()
        ));

        $this->merchantPreferences->setReturnUrl(base_url('pl?payment='.encodeUrl(true)))
            ->setCancelUrl(base_url('pl?payment='.decodeUrl(false)))
            ->setAutoBillAmount('yes')
            ->setInitialFailAmountAction('CONTINUE')
            ->setMaxFailAttempts('0')
            ->setSetupFee($this->paymentDefinition->getAmount());

        $this->plan->setPaymentDefinitions(array($this->getPaymentDefinition()))
            ->setMerchantPreferences($this->getMerchantPreferences());

        //dd($this->paymentDefinition);
        try {
            $this->plan->create($this->getApiContext());
            $this->patch->setOp('replace')
                ->setPath('/')
                ->setValue($this->getPyPalModel());

            $this->patchRequest->addPatch($this->getPatch());
            $this->plan->update($this->patchRequest, $this->apiContext);
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            $this->jsonArray['code'] = $ex->getCode();
            $this->jsonArray['data'] = $ex->getData();
            return $this->jsonArray;
        } catch (Exception $ex) {
            die($ex);
        }
    }
    public function getPlanId() {
        return $this->plan->getId();
    }

    public function deletePlan() {
        try {
            $this->plan->delete($this->getApiContext());
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            $this->jsonArray['code'] = $ex->getCode();
            $this->jsonArray['data'] = $ex->getData();
            return $this->jsonArray;
        } catch (Exception $ex) {
            die($ex);
        }
    }
    public function setStartDate($date) {
        $this->date = $date;
        return $this;
    }
    public function setPatchPlan($id) {
        $this->patchedPlan = Plan::get($id, $this->getApiContext());
        return $this;
    }
    public function getPatchPlanId() {
        return $this->patchedPlan->getId();
    }
    public function agreement() {

        // Create new agreement
        $this->setStartDate(date('c', time() + 3600));
        $this->agreement
            ->setName($this->planName)
            ->setDescription($this->planDescription)
            ->setStartDate($this->date);
        // Get Plan
        $this->plan = new Plan();
        $this->plan->setId($this->planId);
        $this->setPatchPlan($this->getPlanId());
        $this->plan->setId($this->getPatchPlanId());

        $this->agreement->setPlan($this->plan);

        // Add payer type
        $this->payer->setPaymentMethod('paypal');

        $this->agreement->setPayer($this->getPayer());

        // Adding shipping details
//        $this->shippingAddress->setLine1('111 First Street')
//            ->setCity('Saratoga')
//            ->setState('CA')
//            ->setPostalCode('95070')
//            ->setCountryCode('US');

        $this->agreement->setShippingAddress($this->getShippingAddress());
        // Create agreement
        $this->agreement->create($this->apiContext);

        // Extract approval URL to redirect user
        //$approvalUrl = $agreement->getApprovalLink();
    }
    public function getApprovalLink() {
        return $this->agreement->getApprovalLink();
    }

    /**
     * @param Plan $plan
     */
    public function setPlan($plan)
    {
        $this->plan = $plan;
    }
    public function getAllPlan() {
        $params = array('page_size' => 10);
        $planlist =  $this->plan->all($params, $this->getApiContext());
        dd($planlist);
        return $planlist;

    }
}

