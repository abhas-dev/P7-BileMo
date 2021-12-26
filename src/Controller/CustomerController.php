<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Exception\CustomerNotFoundException;
use App\Repository\ClientRepository;
use App\Repository\CustomerRepository;
use App\Service\CustomerPaginator;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Response;
use Knp\Component\Pager\PaginatorInterface;
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
    private CustomerPaginator $paginator;

    public function __construct(
        CustomerPaginator $paginator,
        CustomerRepository $customerRepository,
        EntityManagerInterface $manager,
        SerializerInterface $serializer,
        UrlGeneratorInterface $urlGenerator,
        ValidatorInterface $validator,
    )
    {
        $this->paginator = $paginator;
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
    public function index(int $clientId, Request $request, PaginatorInterface $paginator): JsonResponse
    {
        $limit = 10;
        $data = $this->paginator->paginate($clientId, $limit);
        [
            'nextPage' => $nextPage,
            'page' => $page,
            'pagination' => $pagination,
            'totalCustomers' => $totalCustomers,
            'totalPages' => $totalPages
        ] = $data;

        if($page <= $totalPages)
        {
            $nextPageUrl = $this->generateUrl('index_customer', ['clientId' => $clientId, 'page' => $nextPage], UrlGeneratorInterface::ABSOLUTE_URL);
            $data = [
                'status' => 'success',
                'total' => $totalCustomers,
                'page_actuelle' =>  $page,
                "nombre_d'utilisateur_par_page" => $limit,
                "nombre_de_pages" => $totalPages,
                "page_suivante" => $nextPage ? $nextPageUrl : '',
                "données" => $pagination
            ];

            return $this->json($data, 200, [],['groups' => 'customer_read']);
        }
        return $this->json([
            'status' => 'erreur',
            'message' => "Cette page n'existe pas"
        ], 404);
    }

    /**
     * @param int $id
     * @param Customer|null $customer
     * @return JsonResponse
     */
    #[Route('/customers/{id<\d+>}', name: 'get_one_customer', methods: 'GET')]
    public function getOne(int $id, Customer $customer = null): JsonResponse
    {
        if ($customer) {
            return $this->json($customer, 200, [], ['groups' => 'customer_read']);
        }
        throw new CustomerNotFoundException($id);
    }

    /**
     * @param Request $request
     * @param ClientRepository $clientRepository
     * @return JsonResponse
     */
    #[Route('/customers', name: 'store_customer', methods: 'POST')]
    public function store(Request $request, ClientRepository $clientRepository): JsonResponse
    {
        try {
//            $customer->setClient($clientRepository->find($data['clientId']));
            $customer = $this->serializer->deserialize($request->getContent(), Customer::class, 'json');
            $customer->setClient($clientRepository->find(1));
            $customer->setCreatedAt(new \DateTime());

            $errors = $this->validator->validate($customer);
            if(count($errors) > 0)
            {
                return $this->json($errors[0]->getMessage(), 400);
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
     * @param Request $request
     * @param int $id
     * @param Customer|null $customer
     * @return JsonResponse
     */
    #[Route('/customers/{id<\d+>}', name: 'edit_customer', methods: 'PUT')]
    public function edit(Request $request, int $id, Customer $customer =null): JsonResponse
    {
        if($customer)
        {
            $this->serializer->deserialize(
                $request->getContent(),
                Customer::class,
                'json',
                [AbstractNormalizer::OBJECT_TO_POPULATE => $customer]
            );

            $this->manager->flush();

            return $this->json(null,204);
        }
        throw new CustomerNotFoundException($id);
    }

    /**
     * @param int $id
     * @param Customer|null $customer
     * @return JsonResponse
     */
    #[Route('/customers/{id<\d+>}', name: 'remove_customer', methods: 'DELETE')]
    public function remove(int $id, Customer $customer = null): JsonResponse
    {
        if($customer)
        {
            $this->manager->remove($customer);
            $this->manager->flush();

            return $this->json(null);
        }
        throw new CustomerNotFoundException($id);
    }

}
