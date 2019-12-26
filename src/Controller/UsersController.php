<?php

namespace App\Controller;

use App\Entity\Users;
use App\Controller\TokenAuthenticatedController;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class UsersController extends AbstractController implements TokenAuthenticatedController
{
    /**
     * @Route("/users", name="users_list", methods={"GET"})
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Users::class);
        $users = $repository->findAll();

        $userData = [];
        foreach ($users as $key => $dataObj) {
            //var_dump($dataObj);
            $temp['name'] = $dataObj->getName();
            $temp['email'] = $dataObj->getEmail();
            $temp['password'] = $dataObj->getPassword();
            $temp['created_ts'] = $dataObj->getCreatedTs();
            $userData[] = $temp;
        }
        //var_dump($userData);
        $responseData['users'] = ($userData);
        $responseData['type'] = 'LIST';
        $responseData['status'] = 'SUCCESS';
        $response = new Response(
            json_encode($responseData),
            Response::HTTP_OK,
            ['content-type' => 'application/json']
        );
        return $response;
    }
    /**
     * @Route("/user/add", name="user_add", methods={"POST"})
     */
    public function add()
    {
        $request = Request::createFromGlobals();
        $user = new Users();
        $entityManager = $this->getDoctrine()->getManager();
        $user->setName($request->request->get('name'));
        $user->setEmail($request->request->get('email'));
        $user->setPassword($request->request->get('password'));
        $user->setCreatedBy(1000);
        $user->setCreatedTs(new DateTime(date("Y-m-d H:i:s")));
        $user->setUpdatedBy(1000);
        $user->setUpdatedTs(new DateTime(date("Y-m-d H:i:s")));

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $responseData['status'] = 'SUCCESS';
        $responseData['message'] = 'User added successfully';

        return new Response(
            json_encode($responseData),
            Response::HTTP_OK,
            ['content-type' => 'applicaton/json']
        );
    }
    /**
     * @Route("/user/edit/{id}", name="user_edit", methods={"POST"}, requirements={"id"="\d+"})
     */
    public function edit($id)
    {
        $request = Request::createFromGlobals();
        $user = new Users();
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(Users::class)->find($id);

        if (!$user) {
            $responseData['status'] = 'FAIL';
            $responseData['message'] = 'User not found';
    
            return new Response(
                json_encode($responseData),
                Response::HTTP_OK,
                ['content-type' => 'applicaton/json']
            );
        }

        $user->setName($request->request->get('name'));
        $user->setEmail($request->request->get('email'));
        $user->setPassword($request->request->get('password'));
        $user->setUpdatedBy(1000);
        $user->setUpdatedTs(new DateTime(date("Y-m-d H:i:s")));

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        $responseData['status'] = 'SUCCESS';
        $responseData['message'] = 'User updated successfully';

        return new Response(
            json_encode($responseData),
            Response::HTTP_OK,
            ['content-type' => 'applicaton/json']
        );
    }
    /**
     * @Route("/user/{id}", name="user_details", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show($id)
    {
        $repository = $this->getDoctrine()->getRepository(Users::class);
        $users = $repository->findById($id);

        if (!$users) {
            $responseData['status'] = 'FAIL';
            $responseData['message'] = 'User not found';
    
            return new Response(
                json_encode($responseData),
                Response::HTTP_OK,
                ['content-type' => 'applicaton/json']
            );
        }

        $userData['name'] = $users->getName();
        $userData['email'] = $users->getEmail();
        $userData['password'] = $users->getPassword();
        $userData['created_ts'] = $users->getCreatedTs();

        $responseData['users'] = $userData;
        $responseData['type'] = 'LIST';
        $responseData['status'] = 'SUCCESS';
        $response = new Response(
            json_encode($responseData),
            Response::HTTP_OK,
            ['content-type' => 'application/json']
        );
        return $response;
    }

    /**
     * @Route("/user/delete/{id}", name="user_delete", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function delete($id)
    {
        $repository = $this->getDoctrine()->getRepository(Users::class);
        $users = $repository->findById($id);

        if (!$users) {
            $responseData['status'] = 'FAIL';
            $responseData['message'] = 'User not found';
    
            return new Response(
                json_encode($responseData),
                Response::HTTP_OK,
                ['content-type' => 'applicaton/json']
            );
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($users);
        $entityManager->flush();

        $responseData['message'] = 'User details deleted successfully';
        $responseData['status'] = 'SUCCESS';
        $response = new Response(
            json_encode($responseData),
            Response::HTTP_OK,
            ['content-type' => 'application/json']
        );
        return $response;        
    }
}
