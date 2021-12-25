<?php
//
//namespace App\Tests;
//
//use PHPUnit\Framework\TestCase;
//use App\Repository\CustomerRepository;
//use Doctrine\ORM\EntityManagerInterface;
//use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
//
//class PostRepositoryTest extends KernelTestCase
//{
//
//    private EntityManagerInterface $entityManager;
//
//    private CustomerRepository $customerRepository;
//
//    protected function setUp(): void
//    {
//        //(1) boot the Symfony kernel
//        $kernel = self::bootKernel();
//        $this->assertSame('test', $kernel->getEnvironment());
//        $this->entityManager = $kernel->getContainer()
//            ->get('doctrine')
//            ->getManager();
//
//        //(2) use static::getContainer() to access the service container
//        $container = static::getContainer();
//
//        //(3) get CustomerRepository from container.
//        $this->postRepository = $container->get(CustomerRepository::class);
//    }
//
//    protected function tearDown(): void
//    {
//        parent::tearDown();
//        $this->entityManager->close();
//    }
//
//    public function testCreateCustomer(): void
//    {
//        $entity = CustomerFactory::create("test post", "test content");
//        $this->entityManager->persist($entity);
//        $this->entityManager->flush();
//        $this->assertNotNull($entity->getId());
//
//        $byId = $this->customerRepository->findOneBy(["id" => $entity->getId()]);
//        $this->assertEquals("test post", $byId->getTitle());
//        $this->assertEquals("test content", $byId->getContent());
//    }
//
//}