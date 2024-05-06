<?php

namespace Repository;

require_once(__DIR__ . '/AbstractRepository.php');

class UserRepository extends AbstractRepository
{
    public static function addOne($name, $email): bool
    {
         return self::add('users', ['name' => $name, 'email' => $email]);
    }

    public static function getAll(): array
    {
        return self::selectAll('SELECT * FROM `users`');
    }

    /**
     * @param $id
     * @param array $data ['columnUsersTable' => 'value']
     * @return bool
     */
    public static function updateById($id, array $data): bool
    {
        return self::set('users', $data, ['id' => $id]);
    }

    public static function getAllWithoutSanta($santaEmail): array
    {
        return self::selectAll("SELECT * FROM `users` WHERE NOT `email` = '$santaEmail'");
    }
}