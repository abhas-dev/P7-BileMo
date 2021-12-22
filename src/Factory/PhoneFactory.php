<?php

namespace App\Factory;

use App\Entity\Phone;
use App\Repository\PhoneRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Phone>
 *
 * @method static Phone|Proxy createOne(array $attributes = [])
 * @method static Phone[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Phone|Proxy find(object|array|mixed $criteria)
 * @method static Phone|Proxy findOrCreate(array $attributes)
 * @method static Phone|Proxy first(string $sortedField = 'id')
 * @method static Phone|Proxy last(string $sortedField = 'id')
 * @method static Phone|Proxy random(array $attributes = [])
 * @method static Phone|Proxy randomOrCreate(array $attributes = [])
 * @method static Phone[]|Proxy[] all()
 * @method static Phone[]|Proxy[] findBy(array $attributes)
 * @method static Phone[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Phone[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static PhoneRepository|RepositoryProxy repository()
 * @method Phone|Proxy create(array|callable $attributes = [])
 */
final class PhoneFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'name' => self::faker()->word(),
            'display' => self::faker()->randomFloat(1, 5, 6),
            'processor' => self::faker()->word(),
            'batteryCapacity' => self::faker()->randomNumber(),
            'price' => mt_rand(250, 599),
            'quantity' => self::faker()->randomFloat(0, 0, 500),
            'createdAt' => self::faker()->dateTimeBetween('-3 month', 'now'),

        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Phone $phone): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Phone::class;
    }
}
