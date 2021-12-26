<?php

namespace App\Service;

use App\Repository\CustomerRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CustomerPaginator
{
    private CustomerRepository $customerRepository;
    private PaginatorInterface $paginator;
    private RequestStack $requestStack;

    public function __construct(CustomerRepository $customerRepository, PaginatorInterface $paginator, RequestStack $requestStack)
    {
        $this->customerRepository = $customerRepository;
        $this->paginator = $paginator;
        $this->requestStack = $requestStack;
    }

    public function paginate(int $clientId, int $limit = 10): ?array
    {
        $query = $this->customerRepository->findBy(['client' => $clientId]);
        $page = $this->requestStack->getCurrentRequest()->query->getInt('page', 1);
        $page = $page <= 0 ? 1 : $page;
        $pagination = $this->paginator->paginate($query, $page, $limit);
        $totalCustomers = $pagination->getTotalItemCount();
        $totalPages = ceil($totalCustomers / $limit);
        $nextPage = $page < $totalPages ? $page + 1 : '';

        return compact('page', 'pagination', 'totalCustomers', 'totalPages', 'nextPage');
    }

//    public function paginate(int $currentPage = 1, int $limit = 10): ?array
//    {
//        $totalPages = ceil($this->customerRepository->getCount() / $limit);
//
//        $offset = ($currentPage - 1) * $limit;
//        if(!is_int($currentPage) && $currentPage < 1 || $currentPage > $totalPages)
//        {
//            return null;
//        }
//        $customers = $this->customerRepository->findBy([], ['createdAt' => 'ASC'], $limit, $offset);
//
//        return [$customers, $totalPages, $currentPage];
//    }
}