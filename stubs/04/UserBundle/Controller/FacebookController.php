<?php

namespace SfDay\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FacebookController extends Controller
{
    /**
     * Redirects to Facebook for authentication
     */
    public function loginAction()
    {
        $facebook = $this->get('fos_facebook.api');
        $permissions = $this->container->getParameter('fos_facebook.permissions');

        $redirectUrl = $this->generateUrl('_facebook_security_check', array(), true);

        $loginUrl = $facebook->getLoginUrl(array(
            'display'       => 'page',
            'scope'         => implode(',', $permissions),
            'redirect_uri'  => $redirectUrl,
        ));

        return $this->redirect($loginUrl);
    }
}