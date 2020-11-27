<?php

namespace App\Infraestructure\Database;

use App\Domain\IAccountRepository;
use App\Domain\Entity\Account;
use App\Domain\Entity\AccountFind;
use App\Domain\Entity\ArrayOfEnterpriseAccountEntities;
use App\Domain\Entity\EnterpriseAccountEntity;
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
      throw new \Exception('Invalid account_id, or user data has not changed');

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
    return new AccountFind(
      new AccountId($account->id),
      new FirstName($account->firstName),
      new LastName($account->lastName),
      new Email($account->email),
      new SignatureId($account->user_signature),
      new EnterpriseAccount(!is_null($account->isEnterpriseAccount))
    );
  }

  public function enterpriseFinder(): ArrayOfEnterpriseAccountEntities {
    $accounts = new ArrayOfEnterpriseAccountEntities;

    $connection = $this->getConnection();
    $sql = 'SELECT * FROM ' . $this->TABLE_NAME . ' WHERE accountVerified IS NULL';

    $query = $connection->prepare($sql);    
    $query->execute();

    $result = $query->fetchAll(\PDO::FETCH_OBJ);    
    
    if ($result == null)
      return $accounts;

    foreach($result as $account) {      
      $accounts->addAccount(new EnterpriseAccountEntity(
        new AccountId($account->id),
        new Email($account->email),
        new FirstName($account->firstName),
        new LastName($account->lastName),
        new SignatureId($account->user_signature),
        new EnterpriseAccount(!is_null($account->isEnterpriseAccount))
      ));
     }    

    return $accounts;
  }

  public function verifyAccount(AccountId $accountId, bool $verify): void {
    $connection = $this->getConnection();

    if($verify)
      $sql = 'UPDATE ' . $this->TABLE_NAME . " SET accountVerified = ''";
    else
      $sql = 'DELETE FROM ' . $this->TABLE_NAME;

    $sql .= " WHERE id = :id and accountVerified IS NULL";

    $query = $connection->prepare($sql);
    $query->bindParam(':id', $accountId->toString());
    $query->execute();

    if ($query->rowCount() < 1)
      throw new \Exception('Invalid account_id or account is already verified');
  }
}
