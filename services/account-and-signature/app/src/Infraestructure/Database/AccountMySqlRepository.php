<?php
namespace App\Infraestructure\Database;

use App\Domain\IAccountRepository;
use App\Domain\Entity\Account;
use App\Domain\ValueObject\AccountId;

class AccountMySqlRepository extends MySqlRepository implements IAccountRepository {
  private string $TABLE_NAME = 'user_credentials';

  public function update(Account $account): bool {
    $connection = $this->getConnection();
    $sql = 'UPDATE '.$this->TABLE_NAME.' SET email=:email, firstName=:firstName, lastName=:lastName';
    if($account->getPassword()!=null)
        $sql.=', user_password=:password';
    if($account->getSignatureId()!=null)
        $sql.=', user_signature=:signature';
    $sql.=' WHERE id = :id';

    $query = $connection->prepare($sql);

    $query->bindParam(':id', $account->getAccountId()->toString());
    $query->bindParam(':email', $account->getEmail()->toString());
    $query->bindParam(':firstName', $account->getFirstName()->toString());
    $query->bindParam(':lastName', $account->getLastName()->toString());
    if($account->getPassword()!=null)
        $query->bindParam(':password', $account->getPassword()->toString());
    if($account->getSignatureId()!=null)
        $query->bindParam(':signature', $account->getSignatureId()->toString());

    $response = $query->execute();

    if($query->rowCount() < 1)
      throw new \Exception('Invalid accout_id, or user data has not changed');

    return true;
  }

}
