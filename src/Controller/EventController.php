<?php

namespace EventRegistration\Controller;

use EventRegistration\Entity\Voucher;
use EventRegistration\Manager\RegistrationRequestManager;
use Spot\Locator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EventRegistration\RequestValidator;
use Twig_Environment;
use EventRegistration\RequestValidator\RegistrationRequestValidator;

class EventController
{
    /**
     * @var Twig_Environment $twig
     */
    private $twig;

    /**
     * @var Locator $spot
     */
    private $spot;

    /**
     * @var RequestValidator $requestValidator
     */
    private $requestValidator;

    /**
     * @var RegistrationManager $registrationManager
     */
    private $registrationManager;

    public function __construct(
        Twig_Environment $twig,
        Locator $spot,
        RegistrationRequestValidator $requestValidator,
        RegistrationRequestManager $registrationManager
    ) {
        $this->twig = $twig;
        $this->spot = $spot;
        $this->requestValidator = $requestValidator;
        $this->registrationManager = $registrationManager;
    }

    /**
     * Rendering registration form template
     * @return Response
     */
    public function registrationAction() : Response
    {
        return new Response($this->twig->render('event/registration.html.twig'));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function handleRegistrationAction(Request $request) : Response
    {
        try {
            if ($this->requestValidator->validate($request)) {
                $voucher = $this->registrationManager->manage(array_merge(
                    $this->requestValidator->getValidatedData(),
                    ['visitor_ip' => $request->getClientIp()]
                ));

                return new RedirectResponse(sprintf('voucher/%s', $voucher->voucher));
            }
        } catch (\Exception $e) {
            return new Response('Something went wrong during handling request form.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new Response($this->twig->render(
            'event/registration.html.twig',
            ['validationErrors' => $this->requestValidator->getValidationErrors()]
        ));
    }

    /**
     * @param Request $request
     * @param $routeParams
     * @return Response
     */
    public function printVoucherAction(Request $request, $routeParams) : Response
    {
        $voucherRepo = $this->spot->mapper(Voucher::class);
        return new Response(
            $this->twig->render('event/voucher.html.twig', ['voucher' => $voucherRepo->get($routeParams['voucher'])])
        );
    }
}
