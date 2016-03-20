<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Payment;
use AppBundle\Service\PaymentGatewayServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use \RuntimeException;

class PaymentController extends Controller
{

    /**
     * @var PaymentGatewayServiceInterface
     */
    protected $paymentGateway;

    /**
     * @return PaymentGatewayServiceInterface
     */
    protected function getPaymentGateway(): PaymentGatewayServiceInterface
    {
        return $this->paymentGateway;
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

        $em = $this->getDoctrine()->getManager();
        $payment = new Payment();
        $payment->setUser($user);
        $payment->setSuccess(true);
        $payment->setDate(new \DateTime());
        $payment->setIntegration('stripe');
        $payment->setAmount(round($request->request->get('amount') * 100));
        $payment->setReference($result->id);
        $em->persist($payment);
        $em->flush();

        $em = $this->getDoctrine()->getManager();
        $payment = new Payment();
        $payment->setUser($user);
        $payment->setSuccess(true);
        $payment->setDate(new \DateTime());
        $payment->setIntegration('braintree');
        $payment->setAmount(round($request->request->get('amount') * 100));
        $payment->setReference($result->transaction->id);
        $em->persist($payment);
        $em->flush();

        if ($result->success !== true) {
            throw new \Exception("braintree payment failed");
        }

        return $this->redirect($this->generateUrl('billing'));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
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
     * @param int $invoiceId
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
