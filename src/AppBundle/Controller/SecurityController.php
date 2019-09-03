<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     *
     * @Route("/error403", name="error403")
     */

    public function error403(Request $request)
    {
        $error = $request->attributes->get(Security::ACCESS_DENIED_ERROR);
        $route = $error->getSubject()->attributes->get('_route');
        $errorUrl = $this->generateUrl(
            $error->getSubject()->attributes->get('_route'),
            ['num' => $error->getSubject()->attributes->get('num')]
        );
        return $this->render('security/error403.html.twig', [
            'errorUrl' => $errorUrl,
        ]);
    }
}
