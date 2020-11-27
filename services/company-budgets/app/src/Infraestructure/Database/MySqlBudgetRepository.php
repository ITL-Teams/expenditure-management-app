<?php
namespace App\Infraestructure\Database;

use App\Domain\IBudgetRepository;
use App\Domain\Entity\CompanyBudget;
use App\Domain\Entity\Budget;
use App\Domain\Entity\Collaborator;
use App\Domain\ValueObject\BudgetId;
use App\Domain\ValueObject\CollaboratorId;
use App\Domain\ValueObject\CollaboratorName;
use App\Domain\ValueObject\BudgetName;
use App\Domain\ValueObject\OwnerId;
use App\Domain\ValueObject\BudgetLimit;
use App\Domain\ValueObject\BudgetPercentage;

class MySqlBudgetRepository extends MySqlRepository implements IBudgetRepository {
  private string $TABLE_NAME = 'company_budgets';

  public function budgetCreator(CompanyBudget $companyBudget): void {
    $connection = $this->getConnection();
    $sql = 'INSERT INTO '.$this->TABLE_NAME.' (id,owner_id,budget_name,budget_limit) VALUES (:id,:owner_id,:budget_name,:budget_limit)';
    $query = $connection->prepare($sql);
    $query->bindParam(':id', $companyBudget->getId()->toString());
    $query->bindParam(':owner_id', $companyBudget->getOwnerId()->toString());
    $query->bindParam(':budget_name', $companyBudget->getName()->toString());
    $query->bindParam(':budget_limit', $companyBudget->getBudgetLimit()->toInt());
    $query->execute();
  }

  public function budgetFinderName(BudgetName $budgetName,OwnerId $ownerId): bool {
    $connection = $this->getConnection();
    $sql = 'SELECT * FROM '.$this->TABLE_NAME.' WHERE budget_name = :budget_name AND owner_id = :owner_id';
    $query = $connection->prepare($sql);
    $query->bindParam(':budget_name', $budgetName->toString());
    $query->bindParam(':owner_id', $ownerId->toString());
    $query->execute();    
    $result = $query->fetchAll(\PDO::FETCH_OBJ);
    if(\is_array($result) && sizeof($result) < 1)
      return false;
    else
      return true;
  }

  public function budgetFinderId(BudgetId $budgetId): bool {
    $connection = $this->getConnection();
    $sql = 'SELECT * FROM '.$this->TABLE_NAME.' WHERE id = :id';
    $query = $connection->prepare($sql);
    $query->bindParam(':id', $budgetId->toString());
    $query->execute();    
    $result = $query->fetchAll(\PDO::FETCH_OBJ);
    if(\is_array($result) && sizeof($result) < 1)
      return false;
    else
      return true;
  }
  
  public function budgetValidatePercentage(BudgetId $budgetId): int {
    $connection = $this->getConnection();
    $sql = 'SELECT budget_percentage FROM '.$this->TABLE_NAME.' WHERE budget_id = :budget_id';
    $query = $connection->prepare($sql);
    $query->bindParam(':budget_id', $budgetId->toString());
    $query->execute();    
    $result = $query->fetchAll(\PDO::FETCH_OBJ);
    if(\is_array($result) && sizeof($result) < 1)
      return 0;
    else
      return intval($result[0]);
  }
  
  public function budgetUpdater(Budget $budget): bool {
    $connection = $this->getConnection();
    $sql = 'UPDATE '.$this->TABLE_NAME.' SET budget_name = :budget_name , budget_limit = :budget_limit WHERE id = :budget_id';
    $query = $connection->prepare($sql);
    $query->bindParam(':budget_name', $budget->getName()->toString());
    $query->bindParam(':budget_limit',$budget->getBudgetLimit()->toInt());
    $query->bindParam(':budget_id',$budget->getId()->toString());
    $query->execute();    
    return true;
  }

  public function updatedBudgetPercentage(BudgetId $budgetid,BudgetPercentage $budgetPercentage): bool {
    $connection = $this->getConnection();
    $percentage = budgetValidatePercentage($budgetid);
    $total = $percentage - $budgetPercentage;
    $sql = 'UPDATE '.$this->TABLE_NAME.' SET budget_percentage = :budget_percentage WHERE budget_id = :budget_id';
    $query = $connection->prepare($sql);
    $query->bindParam(':budget_percentage',$total);
    $query->bindParam(':budget_id',$budgetid->toString());
    $query->execute();    
    if($query->rowCount()>0)
      return true;
    else
      return false;
  }

  public function budgetDeleter(BudgetId $budgetId): bool {
    $connection = $this->getConnection();
    $sql = 'UPDATE '.$this->TABLE_NAME.' SET active_budget = 0 WHERE budget_id = :budget_id';
    $query = $connection->prepare($sql);
    $query->bindParam(':budget_id',$Budget->getId()->toString());
    $query->execute();    
    if($query->rowCount()>0)
      return true;
    else
      return false;
  }

  public function budgetFinder(BudgetId $budgetId): CompanyBudget {
    $connection = $this->getConnection();
    $sql = 'SELECT * FROM '.$this->TABLE_NAME.' WHERE budget_id = :budget_id';
    $query = $connection->prepare($sql);
    $query->bindParam(':budget_id', $budgetId->toString());
    $query->execute();    
    $result = $query->fetchAll(\PDO::FETCH_OBJ);
    
    if(\is_array($result) && sizeof($result) < 1)
      return null;
    else
      return new CompanyBuget(new BudgetName($result->budget_name),
                                new OwnerId($result->owner_id),new BudgetLimit($result->budget_limit),
                                new BudgetId($budgetId));
    }

    public function budgetCollaboratorAdder(Collaborator $collaborator): void {
      $connection = $this->getConnection();
      $sql = 'INSERT INTO collaborators (collaborator_id,budget_id,collaborator_name,budget_percentage) VALUES (:collaborator_id,:budget_id,:collaborator_name,:budget_percentage)';
      $query = $connection->prepare($sql);
      $query->bindParam(':collaborator_id', $collaborator->getIdCollaborator()->toString());
      $query->bindParam(':budget_id', $collaborator->getId()->toString());
      $query->bindParam(':collaborator_name', $collaborator->getName()->toString());
      $query->bindParam(':budget_percentage', $collaborator->getBudgetPercentage()->toInt());
      $query->execute();
    }

  // public function get(UserId $id): ?User {
  //   $connection = $this->getConnection();
  //   $sql = 'SELECT * FROM '.$this->TABLE_NAME.' WHERE id = :id';
  //   $query = $connection->prepare($sql);
  //   $query->bindParam(':id', $id->toString());
  //   $query->execute();
  //   $user = $query -> fetchAll(\PDO::FETCH_OBJ);

  //   if($user == null)
  //     return null;
    
  //   $user = $user[0];
  //   $user_name = explode(" ", $user->client_name);

  //   return new User(
  //     new UserName($user_name[0], $user_name[1]),
  //     new UserId($user->id)
  //   );
  // }

  // public function update(User $user): bool {
  //   return false;
  // }

  // public function delete(UserId $id): bool {
  //   return false;
  // }

}

//     const userName = users[0].client_name.split(' ')
//     return new User(
//       new UserName(userName[0], userName[1]),
//       new UserId(users[0].id)
//     )
//   }

//   public async update(user: User): Promise<boolean> {
//     const connection = await this.getConnection()
//     const sql = `UPDATE ${this.TABLE_NAME} SET client_name = ? WHERE id = ?`

//     const response = await connection
//       .query(sql, [user.getName().toString(), user.getId().toString()])
//       .catch((err) => Promise.reject(err))

//     const userUpdated = response.affectedRows !== 0
//     return userUpdated
//   }

//   public async delete(id: UserId): Promise<boolean> {
//     const connection = await this.getConnection()
//     const sql = `DELETE FROM ${this.TABLE_NAME} WHERE id = ?`

//     const response = await connection
//       .query(sql, [id.toString()])
//       .catch((err) => Promise.reject(err))

//     const userDeleted = response.affectedRows !== 0
//     return userDeleted
//   }
// }
