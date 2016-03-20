<?php

namespace AppBundle\Service;

use AppBundle\Entity\User;

interface PaymentGatewayServiceInterface
{
    public function getCustomerId(User $user);

    public function addCustomer(User $user, $request);

    public function getCustomerPaymentMethods(User $user);

    public function initIntegration();

    public function addCard(User $user, $request);

    public function getAddCardTemplate();

    public function chargeUser(User $user, float $amount, $description);
}
