<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * User controller.
 * @Route("/api", name="api_")
 */
class UserController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/users", name="new_user", methods={"POST"})
     */
    public function postUser(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $firstName = $data['firstName'];
        $lastName = $data['lastName'];
        $email = $data['email'];
        $username = $data['username'];
        $password = $data['password'];        
        $number = $data['number'];        

        if (empty($firstName) || empty($lastName) || empty($email) || empty($username) || empty($password) || empty($number)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }
        
        $this->userRepository->insertUser($firstName, $lastName, $email, $username, $password, $number);

        return new JsonResponse(['status' => 'User created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/users/{id}", name="get_user", methods={"GET"})
     */
    public function getUsers($id): JsonResponse
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $user->getId(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'email' => $user->getEmail(),
            'number' => $user->getNumber(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/users", name="get_users", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $users = $this->userRepository->findAll();
        $data = [];

        foreach ($users as $user) {
            $data[] = [
                'id' => $user->getId(),
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'email' => $user->getEmail(),
                'number' => $user->getNumber(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/users/{id}", name="edit_user", methods={"PUT"})
     */
    public function putUser($id, Request $request): JsonResponse
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        if (!$user) {
            throw new NotFoundHttpException('User does not exist!');
        }

        empty($data['firstName']) ? true : $user->setFirstName($data['firstName']);
        empty($data['lastName']) ? true : $user->setLastName($data['lastName']);
        empty($data['email']) ? true : $user->setEmail($data['email']);
        empty($data['number']) ? true : $user->setNumber($data['number']);

        $updateUser = $this->userRepository->updateUser($user);

        return new JsonResponse(['status' => 'User updated!', 'data' => $updateUser->toArray()], Response::HTTP_OK);
    }

    /**
     * @Route("/users/{id}", name="delete_user", methods={"DELETE"})
     */
    public function deleteUser($id, Request $request): JsonResponse
    {
        $user = $this->userRepository->findOneBy(['id' => $id]);
        
        if (!$user) {
            throw new NotFoundHttpException('User does not exist!');
        }

        $this->userRepository->removeUser($user);

        return new JsonResponse(['status' => 'User deleted!'], Response::HTTP_OK);
    }

}