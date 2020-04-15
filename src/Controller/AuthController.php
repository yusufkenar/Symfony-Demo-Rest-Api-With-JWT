<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthController extends ApiController
{
    /**
     * @param  Request  $request
     * @param  UserPasswordEncoderInterface  $encoder
     * @return mixed
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->transformJsonBody($request);
        $username = $request->get('username');
        $password = $request->get('password');
        $email = $request->get('email');

        if (empty($username) || empty($password) || empty($email)) {
            $this->setStatusCode(422);

            return $this->responseWithError("Invalid Username or Password or Email");
        }

        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $hasUser = $userRepository
            ->userHasRegistered($username, $email);

        if ($hasUser) {
            $this->setStatusCode(422);

            return $this->responseWithError("This user already registered.");
        }

        $user = new User($username);
        $user->setPassword($encoder->encodePassword($user, $password));
        $user->setEmail($email);
        $user->setUsername($username);
        $em->persist($user);
        $em->flush();

        return $this->responseWithSuccess(sprintf('Successfully registered.'));
    }
}
