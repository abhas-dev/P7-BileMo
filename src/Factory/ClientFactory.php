<?php

namespace App\Factory;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Client>
 *
 * @method static Client|Proxy createOne(array $attributes = [])
 * @method static Client[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Client|Proxy find(object|array|mixed $criteria)
 * @method static Client|Proxy findOrCreate(array $attributes)
 * @method static Client|Proxy first(string $sortedField = 'id')
 * @method static Client|Proxy last(string $sortedField = 'id')
 * @method static Client|Proxy random(array $attributes = [])
 * @method static Client|Proxy randomOrCreate(array $attributes = [])
 * @method static Client[]|Proxy[] all()
 * @method static Client[]|Proxy[] findBy(array $attributes)
 * @method static Client[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Client[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static ClientRepository|RepositoryProxy repository()
 * @method Client|Proxy create(array|callable $attributes = [])
 */
final class ClientFactory extends ModelFactory
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        parent::__construct();
        $this->hasher = $hasher;

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'username' => self::faker()->userName(),
            'email' => self::faker()->email(),
            'password' => self::faker()->text(),
            'companyName' => self::faker()->words(2, true),
            'roles' => ['ROLE_USER'],
            'createdAt' => self::faker()->dateTimeBetween('-3 month', 'now'),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
             ->afterInstantiate(function(Client $client): void {
                 $client->setPassword($this->hasher->hashPassword($client,$client->getPassword()));
             })
        ;
    }

    protected static function getClass(): string
    {
        return Client::class;
    }
}
