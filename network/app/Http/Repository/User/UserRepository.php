<?php

namespace App\Http\Repository\User;

use App\Exceptions\RepositoryException;
use App\Http\Entities\User\User;
use App\Http\Repository\MainRepository;
use Exception;

class UserRepository extends MainRepository
{
    /**
     * Finds a user by ID.
     *
     * @param int $id
     * @return User|null
     * @throws RepositoryException
     */
    public function find(int $id): ?User
    {
        try {
            $result = DB::connection($this->readConnection)
                ->table(Schema:: . 'user')
                ->where('id', $id)
                ->first();

            return $result ? new User((array)$result) : null;
        } catch (Exception $exception) {
            throw new RepositoryException(
                'Erreur lors de la récupération de l\'utilisateur.',
                500,
                $exception
            );
        }
    }

    /**
     * Finds a user by email.
     *
     * @param string $email
     * @return User|null
     * @throws RepositoryException
     */
    public function findByEmail(string $email): ?User
    {
        try {
            $result = DB::connection($this->readConnection)
                ->table(Schema:: . 'user')
                ->where('email', $email)
                ->first();

            return $result ? new User((array)$result) : null;
        } catch (Exception $exception) {
            throw new RepositoryException(
                'Erreur lors de la récupération de l\'utilisateur par email.',
                500,
                $exception
            );
        }
    }

    /**
     * Check if a user exists.
     *
     * @param int $idUser The user ID.
     * @return bool True if the user exists.
     * @throws RepositoryException
     */
    public function checkIfUserExists(int $idUser): bool
    {
        try {
            return DB::connection($this->readConnection)
                ->table(Schema:: . 'user')
                ->where('id', $idUser)
                ->exists();
        } catch (Exception $exception) {
            throw new RepositoryException(
                __('messages.repository_data_retriaval_error'),
                500,
                $exception
            );
        }
    }

    public function checkIfEntityExists(int $tableId, ?string $tableName = null): bool
    {
        if ($tableName) {
            // Vérifier avec le tableName spécifique
            return DB::connection($this->readConnection)
                ->table(Schema:: . $tableName)
                ->where('id', $tableId)
                ->exists();
        } else {
            // Vérifier dans company ET training_organization
            return DB::connection($this->readConnection)
                ->table(Schema:: . 'company')
                ->where('id', $tableId)
                ->exists() ||
                DB::connection($this->readConnection)
                ->table(Schema:: . 'training_organization')
                ->where('id', $tableId)
                ->exists();
        }
    }

    public function getUserIdByTableInfo(int $tableId, ?string $tableName): ?int
{
    return DB::connection($this->readConnection)
        ->table(Schema::. $tableName)
        ->join(
            Schema:: . 'user', 
            $tableName . '.idUser', 
            '=', 
            'user.id'
        )
        ->where($tableName . '.id', $tableId)
        ->value('user.id');
}
}
