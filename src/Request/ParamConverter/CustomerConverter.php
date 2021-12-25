<?php
//
//namespace App\Request\ParamConverter;
//
//use App\Entity\Customer;
//use App\Repository\CustomerRepository;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
//use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Serializer\SerializerInterface;
//
//final class CustomerConverter implements ParamConverterInterface
//{
//    private SerializerInterface $serializer;
//
//    public function __construct(SerializerInterface $serializer)
//    {
//        $this->serializer = $serializer;
//    }
//
//    /**
//     * @param Request $request
//     * @param ParamConverter $configuration
//     * @return bool|void
//     */
//    public function apply(Request $request, ParamConverter $configuration)
//    {
//        $customer = $this->serializer->deserialize($request->getContent(), $configuration->getClass(), 'json');
//        $request->attributes->set('customer', $customer);
//    }
//
//    /**
//     * @param ParamConverter $configuration
//     * @return bool|void
//     */
//    public function supports(ParamConverter $configuration)
//    {
//        return $configuration->getName() === "customer";
//    }
//}