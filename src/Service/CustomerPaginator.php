<?php

namespace App\Service;

use App\Repository\CustomerRepository;

class CustomerPaginator
{
    private CustomerRepository $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function paginate(int $currentPage = 1, int $limit = 10): ?array
    {
        $totalPages = ceil($this->customerRepository->getCount() / $limit);

        $offset = ($currentPage - 1) * $limit;
        if(!is_int($currentPage) && $currentPage < 1 || $currentPage > $totalPages)
        {
            return null;
        }
        $customers = $this->customerRepository->findBy([], ['createdAt' => 'ASC'], $limit, $offset);

        return [$customers, $totalPages, $currentPage];
    }
}