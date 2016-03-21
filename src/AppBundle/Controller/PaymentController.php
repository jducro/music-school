<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Payment;
use AppBundle\Service\PaymentGatewayServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use \RuntimeException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PaymentController extends Controller
{

    /**
     * @var PaymentGatewayServiceInterface
     */
    protected $paymentGateway;

    /**
     * @return PaymentGatewayServiceInterface
     */
    public function getPaymentGateway(): PaymentGatewayServiceInterface
    {
        return $this->get('app.service_stripe_payment_gateway');
    }

    /**
     * @param PaymentGatewayServiceInterface $paymentGateway
     */
    public function setPaymentGateway(PaymentGatewayServiceInterface $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function createPaymentAction(Request $request)
    {
        $user = $this->getUser();
        $customerId = $this->getPaymentGateway()->getCustomerId($user->getAccount());

        if (!$customerId) {
            throw new \Exception("Customer id missing");
        }

        $this->getPaymentGateway()->initIntegration();

        $result = $this->getPaymentGateway()->chargeUser(
            $this->getUser(),
            $request->request->get('amount'),
            ''
        );

        if ($result->success !== true) {
            throw new \Exception("braintree payment failed");
        }

        return $this->redirect($this->generateUrl('billing'));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/payment/add_card", name="payment_add_card")
     * @Template()
     * @throws \Exception
     */
    public function addCardAction(Request $request)
    {
        if ($request->getMethod() != 'POST') {
            return $this->render($this->getPaymentGateway()->getAddCardTemplate());
        }

        $user = $this->getUser();
        $this->getPaymentGateway()->initIntegration();
        $em = $this->getDoctrine()->getManager();

        if (!$this->getPaymentGateway()->getCustomerId($user->getAccount())) {
            $result = $this->getPaymentGateway()->addCustomer($user->getAccount(), $request);
            $em->persist($user->getAccount());
            $em->flush();
        } else {
            $result = $this->getPaymentGateway()->addCard($user->getAccount(), $request);
        }

        if ($result) {
            $this->addFlash('success', 'card added');
            return $this->redirect($this->generateUrl('profile_credit_cards'));
        }
        return $this->render($this->getPaymentGateway()->getAddCardTemplate());
    }

    /**
     * @throws HttpException|RuntimeException
     * @Template()
     *
     * @return array
     */
    public function payAction()
    {
        return [];
    }
}
