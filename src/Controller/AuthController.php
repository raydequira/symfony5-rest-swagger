<?php
 /**
  * Created by PhpStorm.
  * User: hicham benkachoud
  * Date: 06/01/2020
  * Time: 20:39
  */

namespace App\Controller;


use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\UserRepository;

class AuthController extends ApiController
{

  private $userRepository;

  public function __construct(UserRepository $userRepository)
  {
      $this->userRepository = $userRepository;
  }

  public function register(Request $request, UserPasswordEncoderInterface $encoder)
  {
    $em = $this->getDoctrine()->getManager();
    $request = $this->transformJsonBody($request);
    $firstname = $request->get('firstname');
    $username = $request->get('username');
    $password = $request->get('password');
    $email = $request->get('email');

    if (empty($username) || empty($password) || empty($email) || empty($firstname)){
      return $this->respondValidationError("Invalid Username or Password or Email");
    }


    $user = new User($username);
    $user->setPassword($encoder->encodePassword($user, $password));
    $user->setFirstname($firstname);
    $user->setEmail($email);
    $user->setUsername($username);
    $user->setRoles(array("ROLE_USER"));
    $em->persist($user);
    $em->flush();
    return $this->respondWithSuccess(sprintf('User %s successfully created', $user->getUsername()));
  }

  /**
   * @param UserInterface $user
   * @param JWTTokenManagerInterface $JWTManager
   * @return JsonResponse
   */
  public function getToken(Request $request,JWTTokenManagerInterface $JWTManager,UserPasswordEncoderInterface $encoder)
  {
    header('Access-Control-Allow-Origin: ');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

    $request = $this->transformJsonBody($request);
    $username = $request->get('username','');
    $password = $request->get('password','');
    
    $user = $this->userRepository->findByUsernameAndPassword($username,$password);

    if($user && $encoder->isPasswordValid($user, $password)){
      return new JsonResponse(['token' => $JWTManager->create($user)]);  
    }
    
    return $this->setStatusCode(401)->respondWithErrors("Invalid Credentials");
    
   
    
  }

}