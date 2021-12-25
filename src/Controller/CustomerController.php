<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Repository\ClientRepository;
use App\Repository\CustomerRepository;
use App\Request\ParamConverter\CustomerConverter;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CustomerController extends AbstractController
{
    private CustomerRepository $customerRepository;
    private SerializerInterface $serializer;
    private EntityManagerInterface $manager;
    private UrlGeneratorInterface $urlGenerator;
    private ValidatorInterface $validator;

    public function __construct(
        CustomerRepository $customerRepository,
        EntityManagerInterface $manager,
        SerializerInterface $serializer,
        UrlGeneratorInterface $urlGenerator,
        ValidatorInterface $validator
    )
    {
        $this->customerRepository = $customerRepository;
        $this->manager = $manager;
        $this->serializer = $serializer;
        $this->urlGenerator = $urlGenerator;
        $this->validator = $validator;
    }

    /**
     * @param int $clientId
     * @return JsonResponse
     */
    #[Route('/client/{clientId<\d+>}/customers', name: 'index_customer', methods: 'GET')]
    public function index(int $clientId): JsonResponse
    {
        $customers = $this->customerRepository->findBy(['client' => $clientId]);

        return $this->json($customers, 200, [],['groups' => 'customer_read']);

    }

    #[Route('/customers/{id<\d+>}', name: 'get_one_customer', methods: 'GET')]
    public function getOne(Customer $customer): JsonResponse
    {
        return
            $customer ?
                $this->json($customer, 200, [],['groups' => 'customer_read']) :
                $this->json(['status' => 400, 'message' => "Cet utilisateur n'existe pas"], 400);
    }
    
    /**
     * @param Request $request
     * @param Customer $customer
     * @param ClientRepository $clientRepository
     * @return JsonResponse
     */
    #[Route('/customers', name: 'store_customer', methods: 'POST')]
    public function store(Request $request, Customer $customer, ClientRepository $clientRepository): JsonResponse
    {
        try {
//            $customer->setClient($clientRepository->find($data['clientId']));
            $customer = $this->serializer->deserialize($request->getContent(), Customer::class, 'json');
            $customer->setClient($clientRepository->find(1));
            $customer->setCreatedAt(new \DateTime());

            $errors = $this->validator->validate($customer);
            if(count($errors) > 0)
            {
                return $this->json($errors, 400);
            }

            $this->manager->persist($customer);
            $this->manager->flush();

            return $this->json(
                $customer,
                201,
                ["Location" => $this->urlGenerator->generate("get_one_customer", ["id" => $customer->getId()])],
                ['groups' => 'customer_read']);
        } catch (NotEncodableValueException $exception){
            return $this->json([
                'status' => 400,
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    /**
     * @param Customer $customer
     * @param Request $request
     * @return JsonResponse
      */
    #[Route('/customers/{id<\d+>}', name: 'edit_customer', methods: 'PUT')]
    public function edit(Customer $customer, Request $request): JsonResponse
    {
        try {
            $this->serializer->deserialize(
                $request->getContent(),
                Customer::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $customer]
            );

            $this->manager->flush();

            return $this->json(null,204);
        } catch (NotEncodableValueException $exception){
            return $this->json([
                'status' => 400,
                'message' => $exception->getMessage()
            ], 400);
        }
    }

    /**
     * @param Customer $customer
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/customers/{id<\d+>}', name: 'remove_customer', methods: 'DELETE')]
    public function remove(Customer $customer, Request $request): JsonResponse
    {
        try {
            $this->manager->remove($customer);
            $this->manager->flush();

            return $this->json(null,200);
        } catch (NotEncodableValueException $exception){
            return $this->json([
                'status' => 400,
                'message' => $exception->getMessage()
            ], 400);
        }
    }

}
