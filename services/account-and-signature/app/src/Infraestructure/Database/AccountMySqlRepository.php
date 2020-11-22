<?php

namespace App\Infraestructure\Database;

use App\Domain\IAccountRepository;
use App\Domain\Entity\Account;
use App\Domain\Entity\AccountFind;
use App\Domain\ValueObject\AccountId;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\FirstName;
use App\Domain\ValueObject\LastName;
use App\Domain\ValueObject\SignatureId;
use App\Domain\ValueObject\EnterpriseAccount;

use function PHPSTORM_META\type;

class AccountMySqlRepository extends MySqlRepository implements IAccountRepository
{
  private string $TABLE_NAME = 'user_credentials';

  public function update(Account $account): bool
  {
    $connection = $this->getConnection();
    $sql = 'UPDATE ' . $this->TABLE_NAME . ' SET email=:email, firstName=:firstName, lastName=:lastName';
    if ($account->getPassword() != null)
      $sql .= ', user_password=:password';
    if ($account->getSignatureId() != null)
      $sql .= ', user_signature=:signature';
    $sql .= ' WHERE id = :id';

    $query = $connection->prepare($sql);

    $query->bindParam(':id', $account->getAccountId()->toString());
    $query->bindParam(':email', $account->getEmail()->toString());
    $query->bindParam(':firstName', $account->getFirstName()->toString());
    $query->bindParam(':lastName', $account->getLastName()->toString());
    if ($account->getPassword() != null)
      $query->bindParam(':password', $account->getPassword()->toString());
    if ($account->getSignatureId() != null)
      $query->bindParam(':signature', $account->getSignatureId()->toString());

    $response = $query->execute();

    if ($query->rowCount() < 1)
      throw new \Exception('Invalid accout_id, or user data has not changed');

    return true;
  }

  public function find(AccountId $id): ?AccountFind
  {
    $connection = $this->getConnection();
    $sql = 'SELECT * FROM ' . $this->TABLE_NAME . ' WHERE id = :id';
    $query = $connection->prepare($sql);
    $query->bindParam(':id', $id->toString());
    $query->execute();
    $account = $query->fetchAll(\PDO::FETCH_OBJ);
    
    if (\is_array($account) && sizeof($account) < 1)
      return null;

    $account = $account[0];
    var_dump($account->isEnterpriseAccount != NULL);
    return new AccountFind(
      new AccountId($account->id),
      new FirstName($account->firstName),
      new LastName($account->lastName),
      new Email($account->email),
      new SignatureId($account->user_signature),
      new EnterpriseAccount($account->isEnterpriseAccount != 'NULL')
    );
  }
}
